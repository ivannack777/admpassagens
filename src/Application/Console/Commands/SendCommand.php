<?php

declare(strict_types=1);

namespace Console\Commands;

use App\Application\Providers\Socket\CommSocketService;
use Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Wiring\Traits\ConfigAwareTrait;

class SendCommand extends Command
{
    use ConfigAwareTrait;

    /**
     * Configura a curva de execução do processo.
     *
     * @var boolean
     */
    private $fork = false;

    /**
     * Tempo de execução em segundos.
     *
     * @var int
     */
    private $loopDelay = 30;

    // Define os comandos através do status
    const STATUS_COMMAND = [
        1 => 'normal',
        2 => 'atencao',
        3 => 'emergencia',
        4 => 'teste',
        5 => 'customizado',
    ];

    /**
     * Configure the console command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('command:sendCommand')
            ->setDescription('Envia comando para as estações')
            ->addOption(
                'port', //name
                'p',    //short
                InputOption::VALUE_OPTIONAL, //description
                'Porta',
                35000 //default
            )->addOption(
                'host', //name
                'H',    //short
                InputOption::VALUE_OPTIONAL, //description
                'Host',
                'localhost' //default
            );
    }

    /**
     * Envia o comando para as sirenes.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int 0 if everything went fine, or an exit code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Configuração padrão do processo (sem execução)
        $pid = -1;

        // Carrega configuração de execução do processo
        $this->fork = $this->config('command.daemon.send');

        // Carrega configuração de atraso de verificação
        $this->loopDelay = (int) $this->config('command.daemon.send_delay');

        // Verifica se é para criar um processo filho
        if ($this->fork) {
            // Cria um processo filho que difere do
            // processo pai apenas em seu PID e PPID
            $pid = pcntl_fork();
        }

        // Verifica se o processo não está em execução
        if (($this->fork) && ($pid === -1)) {
            $mesg = 'Não foi possível criar o fork do processo.';
            // Erro
            throw new \RuntimeException($mesg);
            // Verifica se foi criado o processo
        } elseif (($this->fork) && ($pid > 0)) {
            // Destroi o processo pai
            exit(0);
        }

        // Define serviço como o líder da sessão
        posix_setsid();
        usleep(100000);

        // Faz o fork novamente, mas agora como líder da sessão
        if ($this->fork) {
            $pid = pcntl_fork();
        }

        // Verifica se o processo não está em execução
        if (($this->fork) && ($pid === -1)) {
            die('Não foi possível manter o processo rodando.');
        } elseif (($this->fork) && ($pid > 0)) {
            // Destroi o processo pai
            exit(0);
        }

        // Mensagem de inicialização
        $output->writeln('Serviço iniciado com o processo ID: ' . $pid);

        // Salva o ID do processo no arquivo
        file_put_contents(getcwd() . '/command.pid', posix_getpid());

        // Mensagem de execução do monitoramento
        $output->writeln('Monitorando envio de comandos para as estações...');

        // Coloca em loop as rotinas de execução do processo
        while (true) {
            // Executa as rotinas de verificação de envio
            $this->loop($input, $output);
            // Aguarda um pouco antes de verificar novamente
            // para evitar sobrecarga de consultas no banco
            sleep($this->loopDelay);
        }
    }

    /**
     * Rotina de repetição do serviço.
     *
     * @param OutputInterface $output
     *
     * @return void
     */
    private function loop(InputInterface $input,OutputInterface $output)
    {
        $args = $input->getOptions(); 

        $host = $args['host'];
        $porta = $args['port'];

        $comando = bin2hex(date('Y-m-d H:i:s').PHP_EOL);
        $response = (object) [
            'status' => false,
            'message' => 'Aguardando',
            'command' => $comando,
            'current' => date('Y-m-d H:i:s'),
            'mode' => 'Internet',
        ];
        // Cria uma instância de comunicação por socket
        $socket = new CommSocketService($host .":". $porta);

        // Se possuí comunicação por socket
        if ($socket->result()) {
            // Envia o comando
            $response->status = $socket->send($comando);
            // var_dump($response->status, $socket->error());
            if($response->status === false){
                $output->writeln($socket->error());
            } else {
                $output->writeln('Result: '. $socket->recive());
            }
        } else {
            // Falha de envio
            $output->writeln('FALHA NO ENVIO <<<<<');

            // Retorna mensagem de erro
            $response->message = $socket->error();

            // Retorna o resultado do envio
            $output->writeln('RESPOSTA: ' . $socket->error());
        }

        // Fecha a conexão do socket
        $socket->close();
    }
}
