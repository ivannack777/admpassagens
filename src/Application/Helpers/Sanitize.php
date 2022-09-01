<?php

namespace App\Application\Helpers;



class Sanitize
{
	/**
	*	Sanitiza como string
	*	@var string $this->input string que será sanitizada
	*	@var string $modo 
	*	  inner: para limpar caracteres espaços em branco do inicio, final e interior da string
	*	  doubles: para limpar caracteres espaços em branco do inicio e final e espaços caractes duplicados no interior da string
	*	  celar: para limpar caracteres que não são letras ou numeros da string
	*	  regex: para limpar caracteres usando um regex customizado na string
	*	@var string $regex um regex customizado
	*   @var string $str valor de entrada
	*/
	private string $input='';

	public function __construct(){
		// $this->input = $str;
	}

	public function set($str){
		$this->input = trim($str);
		return $this;
	}

	public function __toString(){
		return $this->input;
	}

	public function get(): string {
		return (string)$this->input;
	}

	public function tolow(){
		$this->input = strtolower($this->input);
		return $this;
	}
	public function toup(){
		$this->input = strtoupper($this->input);
		return $this;
	}
	public function firstUp(){
		$this->input = ucfirst($this->input);
		return $this;
	}
	
	public function string($str){
		$this->set($str)->outer()->doubles();
		return $this;
	}


	/**
	 * Limpa espaços tab e quebra de linhas
	 * */
	public function outer(){
		$this->input = trim($this->input);
		return $this;
	}

	/**
	 * Limpa espaços tab e quebra de linhas
	 * */
	public function trimInner(){
		$this->input = preg_replace('/[\s\t\r\n]+/', '', $this->input);
		return $this;
	}
	/**
	 * Limpa espaços tab e quebra de linhas duplicados
	 * */
	public function doubles(){
		$this->input = preg_replace('/[\s\t\r\n]+/', ' ', $this->input);
		return $this;
	}
	/**
	 * Limpa tudo que não for letras ou números
	 * */
	public function clear(){
		$this->input = preg_replace('/[^\d\w]+/', '', $this->input);
		return $this;
	}

	/**
	 * Limpa utilizando regex
	 * */
	public function regex($regex, $replace=''){
		$this->input = preg_replace($regex, $replace, $this->input);
		return $this;
	}

	/**
	 * transforma caracteres acentuados em não acentuados e ainda aceita uma string ou lista de string(como array) extras
	 * */
	public function transcode($xtraMatch='', $xtraReplace=''){
		$match = ['à','á','â','ã','ä','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ','À','Á','Â','Ã','Ä','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý'];
		$replace = ['a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','u','y','y','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','U','U','U','U','Y'];

		if(!empty($xtraMatch) && !empty($xtraReplace)){
			if( !is_array($xtraMatch) && !is_array($xtraReplace) ){
				$xtraMatch = [$xtraMatch];
				$xtraReplace = [$xtraReplace];
			}
			$match   =  array_merge($match, $xtraMatch);
			$replace =  array_merge($replace, $xtraReplace);
		}

		$this->input = str_replace($match, $replace, $this->input);
		return $this;
	}


	/**
	 * Limpara e transforma um nome
	 * @param string $str String para ser transformada
	 * @param string $modo ucword|ucfirst
	 * */
	public function name($str, $modo='ucwords'){
		$this->set($str)->outer()->doubles();
		if(!empty($this->input)){
			$this->input = preg_replace('/[\s\t\r\n]+/', ' ', $this->input);
			$this->input = mb_convert_case($this->input,  MB_CASE_TITLE); //para resolver problemas com caracteres acentuados
			switch ($modo) {
				case 'ucfirst': //primeito caracter em maíusculo
					$this->input = strtolower($this->input);
					$this->input = ucfirst($this->input);
					break;
				case 'ucwords': //todos os primeiro caracteres de cada palavra em maíusculo
					$this->input = strtolower($this->input);
					$this->input = ucwords($this->input);
					$this->input = str_replace(' E ', ' e ', $this->input);
					$this->input = str_replace(' Da ', ' da ', $this->input);
					$this->input = str_replace(' Das ', ' das ', $this->input);
					$this->input = str_replace(' De ', ' de ', $this->input);
					$this->input = str_replace(' Do ', ' do ', $this->input);
					$this->input = str_replace(' Dos ', ' dos ', $this->input);
					$this->input = str_replace(' Of ', ' of ', $this->input);
					$this->input = str_replace(' Von ', ' von ', $this->input);
					$this->input = str_replace(' Del ', ' del ', $this->input);
					break;
				default:
					$this->input = $this->input;
					break;
			}
		}
		return $this;
	}

	/**
	 * Limpa, verifica e converte data/hora
	 * @param string $str para ser tratada
	 * @param string $formatIn formato de entrada
	 * @param string $formatOut formato de saida
	 */
	public function date($str, $formatIn=null, $formatOut=null){
		$this->set($str)->outer()->doubles();
		if(!empty($this->input)){
			if($formatIn && $formatOut){
				$date = \DateTime::createFromFormat($formatIn, $this->input);
				if($date){
					$this->set($date->format($formatOut));
				}

			} 
			else{
				$this->input = preg_replace('/[^\d]+/', '-', $this->input);
			}
			// $this->input = str_replace(['/','.',' '], '-', $this->input);
		}
		return $this;
	}


	/**
	 * Limpa e verifica e-mail
	 */
	public function email($str){
		$this->set($str)->outer()->trimInner();
		$pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
		if(!empty($this->input)){
			$this->input = preg_replace('/\s+/', '', $this->input);
		}
		return $this;
	}

	public function password($str){
		$this->set($str)->outer();
		if(!empty($this->input)){
			$this->input = preg_replace('/\s+/', '', $this->input);
		}
		return $this;
	}

	/**
	 * Limpa tudo que não for letras ou .
	 * */
	public function username($str){
		$this->set($str)->outer()->trimInner();
		if(!empty($this->input)){
			$this->input = preg_replace('/[^\w.]+/', '', $this->input);
		}
		return $this;
	}

	public function phone($str){
		$this->set($str)->outer()->trimInner();
		if(!empty($this->input)){
			$this->input = preg_replace('/[^0-9+]+/', '', $this->input);
		}
		return $this;
	}


	/**
	 * Limpara e transforma um nome
	 * @param string $str String para ser transformada
	 * @param string $modo ucword|ucfirst
	 * */
	public function integer($str){
		$this->set($str)->outer()->trimInner();
		$this->input = preg_replace('/[^0-9]+/', '', $this->input);
		if(!empty($this->input)){
			$this->input = intval($this->input);
		}
		return $this;
	}


	/**
	 * Limpara e transforma um nome
	 * @param string $str String para ser transformada
	 * @param string $modo inner|outer|clear|regex
	 * */
	public function number($str, $modo=null, $regex=null){
		$this->set($str)->outer()->trimInner();
		if(!empty($this->input)){
			switch ($modo) {
				case 'inner':
					$this->input = trim($this->input);
					$this->input = preg_replace('/[\s\t\r\n]+/', ' ', $this->input);
					break;
				case 'outer':
					$this->input = trim($this->input);
					break;
				case 'clear':
					$this->input = preg_replace('/[^\d\w]+/', '', $this->input);
					
					break;
				case 'regex':
					if($regex) $this->input = preg_replace($regex, '', $this->input);
					else $this->input = false;
					break;
				default:
					$this->input = trim($this->input);
					break;
			}
		}
		return $this;
	}

	public function decimal($str, $round=false, $toString=false){
		$this->set($str)->outer()->trimInner();
		if(!empty($this->input)){
			$this->input = str_replace(',', '.', $this->input);
			$this->input = preg_replace('/[^0-9.]+/', '', $this->input);
			if($round && is_numeric($round)){
				$this->input = round($this->input, intval($round) );
			}
			elseif($round === true){
				$this->input = round($this->input);
			}

			if($toString){
				$this->input = (string)$this->input;
			}

		}

		return $this;
	}

	public function array($array, $method, $param1=null, $param2=null){

		if(is_array($array)){
			foreach ($array as $key => $value) {
				if($param1) $retornoArr[$key] = $this->$method($value, $param1);
				elseif($param2) $retornoArr[$key] = $this->$method($value, $param1, $param2);
				else $retornoArr[$key] = $this->$method($value);

			}
			return $retornoArr;
		}
		return $array;
	}

}
