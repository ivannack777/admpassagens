<?php

/**
 * Slim Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/PHP-View/blob/3.x/LICENSE.md (MIT License)
 */

declare(strict_types=1);

namespace Slim\Views;

use Exception;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Exception\PhpTemplateNotFoundException;
use Throwable;

class PhpRenderer
{
    protected string $templatePath;

    protected array $attributes;

    protected string $layout;

    /**
     * @param string $templatePath
     * @param array  $attributes
     * @param string $layout
     */
    public function __construct(string $templatePath = '', array $attributes = [], string $layout = '')
    {
        $this->templatePath = rtrim($templatePath, '/\\') . '/';
        $this->attributes = $attributes;
        $this->setLayout($layout);
    }

    /**
     * @param ResponseInterface $response
     * @param string            $template
     * @param array             $data
     *
     * @return ResponseInterface
     *
     * @throws Throwable
     */
    public function render(ResponseInterface $response, string $template, array $data = []): ResponseInterface
    {
        $output = $this->fetch($template, $data, true);
        $response->getBody()->write($output);
        return $response;
    }

    /**
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     */

    /**
     * @param string $layout
     *
     * @return void
     *
     * @throws PhpTemplateNotFoundException
     */
    public function setLayout(string $layout): void
    {
        if ($layout && !$this->templateExists($layout)) {
            throw new PhpTemplateNotFoundException('Layout template "' . $layout . '" does not exist');
        }

        $this->layout = $layout;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * @param string $key
     * @param        $value
     *
     * @return void
     */
    public function addAttribute(string $key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    /**
     * @param string $key
     *
     * @return bool|mixed
     */
    public function getAttribute(string $key)
    {
        if (!isset($this->attributes[$key])) {
            return false;
        }

        return $this->attributes[$key];
    }

    /**
     * @return string
     */
    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    /**
     * @param string $templatePath
     */
    public function setTemplatePath(string $templatePath): void
    {
        $this->templatePath = rtrim($templatePath, '/\\') . '/';
    }

    /**
     * @param string $template
     * @param array  $data
     * @param bool   $useLayout
     *
     * @return string
     *
     * @throws Throwable
     */
    public function fetch(string $template, array $data = [], bool $useLayout = false): string
    {
        $output = $this->fetchTemplate($template, $data);
        if ($this->layout && $useLayout) {
            $data['content'] = $output;
            $output = $this->fetchTemplate($this->layout, $data);
        }

        return $output;
    }

    /**
     * @param string $template
     * @param array  $data
     *
     * @return string
     *
     * @throws Throwable
     */
    public function fetchTemplate(string $template, array $data = []): string
    {
        if (isset($data['template'])) {
            throw new InvalidArgumentException('Duplicate template key found');
        }

        if (!$this->templateExists($template)) {
            throw new PhpTemplateNotFoundException('View cannot render "' . $template
                . '" because the template does not exist');
        }

        $data = array_merge($this->attributes, $data);
        try {
            ob_start();
            $this->protectedIncludeScope($this->templatePath . $template, $data);
            $output = ob_get_clean();
        } catch (Throwable $e) {
            ob_end_clean();
            throw $e;
        }

        return $output;
    }

    /**
     * Returns true is template exists, false if not
     *
     * @param string $template
     *
     * @return bool
     */
    public function templateExists(string $template): bool
    {
        $path = $this->templatePath . $template;
        return is_file($path) && is_readable($path);
    }

    /**
     * @param string $template
     * @param array  $data
     *
     * @return void
     */
    protected function protectedIncludeScope(string $template, array $data): void
    {
        extract($data);
        include func_get_arg(0);
    }


    /**
     * parse a url contenando SITE_URL do .env com uri 
     * @param string $uri
     * @return string $url
     */
    public function siteUrl($uri = '', $returnArray = false)
    {
        //retirar / repetidas, exeto as // depois do :
        $url =  $_ENV['SITE_URL'] . $uri;
        $url = preg_replace('/([^:]\/)(\/+)/', "$1", $url);

        if ($returnArray) {
            return parse_url($url);
        }

        return $url;
    }

    /**
     * Converte dada
     * @param string $date
     * @return string $format
     */
    public function dateFormat($date, $format = '')
    {

        $dt = '';
        if (!empty($date)) {
            $dt = new \DateTime($date);
            if($dt instanceof \DateTime){
                if (!empty($format)) {
                    return $dt->format($format);
                } else {
                    return $dt->format('d/m/Y H:i');
                }
            }
        }

        return $dt;
    }

    /**
     * Retorna meses por extenso
     * Retorna um mes se idx for passado como representação numérica de um mes (1 a 12)
     * Retorna um array com os meses se idx não for passada ou for false
     * Retorna um array com os meses se idx for um array de meses ex: [1,3,8]
     * @param mixed int|string|bool|array $idx
     * @param bool $brev para retornar mes abreviado
     * @return mixed string|array
     */
    public function meses($idx=false, $brev=false, $includeYear=false){

        try{
            $date = new \DateTime($idx??'');
        } catch(Exception $e){
            //
        }
        if($date instanceof \DateTime){
            $idx = $date->format('n'); // n 	Numeric representation of a month, without leading zeros 	1 through 12
        } else {
            //se primeiro paramentro não for uma data ISO, força $includeYear para false
            $includeYear = false;
        }
        $meses = [
            1=> "Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro",
        ];
        
        if($brev){
            foreach($meses as $k=>$v){
                $meses[$k] = mb_substr($v, 0, 3) . ($includeYear ? '/'.$date->format('Y'):'' );
            }
        }
        if(is_array($idx )){
            foreach($idx as $i){
                $meses2[] = $meses[$i];
            }
            return $meses2;
        }
        return $idx !== false ? $meses[$idx] : $meses;
    }

     /**
     * Retorna semana por extenso
     * Retorna um dia da semana se idx for passado como representação numérica de dia da semana (0 a 6)
     * Retorna um array com os dia da semana se idx não for passada ou for false
     * Retorna um array com os dia da semana se idx for um array de meses ex: [1,3,8]
     * @param mixed int|string|bool|array $idx
     * @param bool $brev para retornar dia da semana abreviado
     * @return mixed string|array
     */
    public function diasSemana($idx=false, $brev=false){

        try{
            $date = new \DateTime($idx??'');
        } catch(\Exception $e){
            //
        }
        catch (\Throwable $e) {
            //do something when Throwable is thrown
        }

        if($date instanceof \DateTime){
            $idx = $date->format('w'); // w	Numeric representation of the day of the week	0 (for Sunday) through 6 (for Saturday)
        } 

        $dias = [
            "Domingo",
            "Segunda-feira",
            "Terça-feira",
            "Quarta-feira",
            "Quinta-feira",
            "Sexta-feira",
            "Sábado",
        ];
        
        if($brev){
            foreach($dias as $k=>$v){
                $dias[$k] = mb_substr($v, 0, 3);
            }
        }
        if(is_array($idx )){
            foreach($idx as $i){
                $dias2[] = $dias[$i];
            }
            return $dias2;
        }
        return $idx !== false ? $dias[$idx] : $dias;
    }
}
