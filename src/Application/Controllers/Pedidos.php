<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Helpers\Sanitize;
use App\Application\Models\Pedidos as PedidosModel;
use App\Application\Models\Viagens as ViagensModel;
use App\Application\Models\Clientes as ClientesModel;
use App\Application\Models\Localidades as LocalidadesModel;
use App\Application\Models\LocalidadesLog as LocalidadesLogModel;
use DateTimeZone;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Valitron\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class Pedidos extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    /**
     * Localiza e retorna um pedidos passando 'pedidos' por json request.
     *
     * @return string json
     */
    public function list(Request $request, Response $response)
    {
        $pedidosArr = [];
        $viagensArr = [];
        $requests = $this->getRequests($request);//postt

        $apiResult = $this->api->post('pedidos/listar', $requests);
        $pedidos = $apiResult;
        // var_dump($pedidos);exit;

        $apiResult = $this->api->post('pedidos/listStatus', $requests);
        $dados['listStatus'] = $apiResult;


        $apiResult = $this->api->post('pessoas/listar', $requests);
        $dados['pessoas'] = $apiResult;

        $apiResult = $this->api->post('viagens/listar');
        $viagens = $apiResult;
        # indexar viagens pelo id
        foreach($viagens->data as $viagem){
            $viagensArr[$viagem->id] = $viagem;
        }
        $dados['viagens'] = $viagensArr;

        # agrupar pedidos por viagem
        foreach($pedidos->data as $pedido){
            $pedidosArr[$pedido->viagens_id][$pedido->id] = $pedido;
        }
        $dados['pedidosViagens'] = $pedidosArr;


        //usando $this->view setado em BaseController
        if ( ($requests['modo']??false) == 'lista') {
            return $response->withJson($pedidos->data, $pedidos->status, $pedidos->count . ($pedidos->count > 1 ? ' pedidos encontrados' : ' pedido encontrado'));
        } else {
            $this->views->render($response, 'header.php', $dados);
            $this->views->render($response, 'left.php', $dados);
            $this->views->render($response, 'right_top.php', $dados);
            $this->views->render($response, 'pedidos.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
        }
    }


    /**
     * Localiza e retorna um pedidos passando 'pedidos' por json request.
     *
     * @return string json
     */
    public function download(Request $request, Response $response)
    {

        $requests = $this->getRequests($request);//post

        $apiResult = $this->api->post('pedidos/listar', $requests);
        $pedidos = $apiResult;
        

        $apiResult = $this->api->post('pessoas/listar', $requests);
        $dados['pessoas'] = $apiResult;

        $apiResult = $this->api->post('viagens/listar', ['codigo'=>$requests['viagens_codigo']]);
        $viagens = $apiResult;

        $viagemData_saida = new \DateTime($viagens->data[0]->data_saida);

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            // 'borders' => [
            //     'allBorders' => [
            //         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            //         //'color' => ['argb' => 'FFFF0000'],
            //     ],
            // ],
        ];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
      
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue('A1', 'Viagem ' . $viagens->data[0]->codigo .' '. $viagens->data[0]->descricao );
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16
            ],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ]);

        $sheet->setCellValue('F1', 'Data viagem:');
        $sheet->setCellValue('G1', \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($viagemData_saida))->getStyle('G1')
            ->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->getStyle('G1')->getFont()->setBold(true);
        $sheet->getRowDimension(1)->setRowHeight(21);
        ;
    
      
        $data = new \DateTime('now', new DateTimeZone('America/Sao_Paulo') );
        $sheet->setCellValue('J1', 'Emissão');
        $sheet->setCellValue('K1', \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($data))->getStyle('K1')
        ->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DATETIME);
    

        $current_row = 3;
        $current_col = 1;
        $sheet->setCellValueByColumnAndRow($current_col, $current_row, 'Código pedido'); $current_col++;
        $sheet->setCellValueByColumnAndRow($current_col, $current_row, 'Origem'); $current_col++;
        $sheet->setCellValueByColumnAndRow($current_col, $current_row, 'Destino'); $current_col++;
        $sheet->setCellValueByColumnAndRow($current_col, $current_row, 'Valor'); $current_col++;
        $sheet->setCellValueByColumnAndRow($current_col, $current_row, 'Status'); $current_col++;
        $sheet->setCellValueByColumnAndRow($current_col, $current_row, 'Data'); $current_col++;
        $sheet->setCellValueByColumnAndRow($current_col, $current_row, 'Nome'); $current_col++;
        $sheet->setCellValueByColumnAndRow($current_col, $current_row, 'CPF'); $current_col++;
        $sheet->setCellValueByColumnAndRow($current_col, $current_row, 'RG'); $current_col++;
        $sheet->setCellValueByColumnAndRow($current_col, $current_row, 'Celular'); $current_col++;
        $sheet->setCellValueByColumnAndRow($current_col, $current_row, 'E-mail'); $current_col++;
       
        $sheet->getStyle('A3:K3')->applyFromArray($styleArray);

        $current_row++;
        $current_col = 1;

        foreach($pedidos->data as $pedido){
            $data = new \DateTime( $pedido->data_insert);
            $sheet->setCellValueByColumnAndRow($current_col, $current_row, $pedido->codigo); $current_col++;
            $sheet->setCellValueByColumnAndRow($current_col, $current_row, $pedido->origem_cidade .' - '. $pedido->origem_uf); $current_col++;
            $sheet->setCellValueByColumnAndRow($current_col, $current_row, $pedido->destino_cidade .' - '. $pedido->destino_uf); $current_col++;
            
            $cellValor = $sheet->setCellValueByColumnAndRow($current_col, $current_row, $pedido->valor)->getCellByColumnAndRow($current_col, $current_row);; $current_col++;
            $sheet->getStyle($cellValor->getCoordinate() )->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
            
            $sheet->setCellValueByColumnAndRow($current_col, $current_row, $pedido->status.': '. $pedido->status_descricao); $current_col++;
            $cellData = $sheet->setCellValueByColumnAndRow($current_col, $current_row, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($data->format('Y-m-d')))->getCellByColumnAndRow($current_col, $current_row); $current_col++;
            $sheet->getStyle( $cellData->getCoordinate() )->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
            
            $sheet->setCellValueByColumnAndRow($current_col, $current_row, $pedido->pessoas_nome); $current_col++;
            $sheet->setCellValueByColumnAndRow($current_col, $current_row, $pedido->pessoas_cpf); $current_col++;
            $sheet->setCellValueByColumnAndRow($current_col, $current_row, $pedido->pessoas_rg); $current_col++;
            $sheet->setCellValueByColumnAndRow($current_col, $current_row, $pedido->pessoas_celular); $current_col++;
            $sheet->setCellValueByColumnAndRow($current_col, $current_row, $pedido->pessoas_email); $current_col++;

            $current_col = 1;
            $current_row++;
        }

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
         }
        
        $writer = new Xlsx($spreadsheet);
        $filename = ("Viagem ". $viagens->data[0]->codigo .".xlsx");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
        header('Content-Disposition: attachment;filename=' . $filename); // specify the download file name
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;

            // Creates a writer to output the $objPHPExcel's content
            // $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $writer->save('php://output');
        

        //usando $this->view setado em BaseController
        if ( ($requests['modo']??false) == 'lista') {
            return $response->withJson($pedidos->data, $pedidos->status, $pedidos->count . ($pedidos->count > 1 ? ' pedidos encontrados' : ' pedido encontrado'));
        } else {
            $this->views->render($response, 'header.php', $dados);
            $this->views->render($response, 'left.php', $dados);
            $this->views->render($response, 'right_top.php', $dados);
            $this->views->render($response, 'pedidos.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
        }
    }

    /**
     * Salva um pedidos.
     *
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {
        $id = $args['id'] ?? null;
        $requests = $this->getRequests($request);
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }
        $apiResult = $this->api->post('pedidos/salvar/'.$id, $requests);
        return $response->withJson($apiResult->data, $apiResult->status, $apiResult->msg);

    }

    /**
     * Lista os status de pedidos.
     *
     * @return string json
     */
    public function listStatus(Request $request, Response $response, array $args)
    {
        $id = $args['id'] ?? null;
        $requests = $this->getRequests($request);
        
        $apiResult = $this->api->post('pedidos/listStatus', $requests);
        return $response->withJson($apiResult->data, $apiResult->status, $apiResult->msg);

    }
}
