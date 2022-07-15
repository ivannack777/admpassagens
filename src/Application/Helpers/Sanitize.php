<?php

namespace App\Application\Helpers;



class Sanitize
{
	/**
	*	Sanitiza como string
	*	@var $this->input string que sera samotizada
	*	@var $modo string
	*	  inner: para limpar caracteres espaços em branco do inicio, final e interior da string
	*	  doubles: para limpar caracteres espaços em branco do inicio e final e espaços caractes duplicados no interior da string
	*	  celar: para limpar caracteres que não são letras ou numeros da string
	*	  regex: para limpar caracteres usando um regex customizado na string
	*	@var $regex string um regex customizado
	*/
	private $input;
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


	/**
	 * Limpa espaços tab no inicio e final
	 * */
	public function outer(){
		$this->input = trim($this->input);
		return $this;
	}
	/**
	 * Limpa espaços tab e quebra de linhas
	 * */
	public function inner(){
		$this->input = preg_replace('/[\s\t\r\n]+/', '', $this->input);
	}
	/**
	 * Limpa espaços tab e quebra de linhas duplicados
	 * */
	public function doubles(){
		$this->input = preg_replace('/[\s\t\r\n]+/', ' ', $this->input);
	}
	/**
	 * Limpa tudo que não for letras ou números
	 * */
	public function clear(){
		$this->input = preg_replace('/[^\d\w]+/', '', $this->input);
	}

	/**
	 * Limpa utilizando regex
	 * */
	public function regex($regex, $replace=''){
		$this->input = preg_replace($regex, $replace, $this->input);
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
	 * transforma caracteres 
	 * */
	public function name($modo='ucwords'){
		if(!empty($this->input)){
			$this->input = preg_replace('/[\s\t\r\n]+/', ' ', $this->input);
			$this->input = mb_convert_case($this->input,  MB_CASE_TITLE); //para resolver problemas com caracteres acentuados
			switch ($modo) {
				case 'ucfirst':
					$this->input = strtolower($this->input);
					$this->input = ucfirst($this->input);
					break;
				case 'ucwords':
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



	public function tolow(){
		$this->input = strtolower($this->input);
		return $this;
	}
	public function toup(){
		return $this;
	}
	

	public function string():string{
		return $this;
	}


	public function date(){
		if(!empty($this->input)){
			$this->input = preg_replace('/[^\d]+/', '-', $this->input);
			// $this->input = str_replace(['/','.',' '], '-', $this->input);
		}
		return $this;
	}

	public function email(){
		if(!empty($this->input)){
			$this->input = preg_replace('/\s+/', '', $this->input);
		}
		return $this;
	}

	public function password(){
		if(!empty($this->input)){
			$this->input = preg_replace('/\s+/', '', $this->input);
		}
		return $this;
	}

	/**
	 * Limpa tudo que não for letras ou .
	 * */
	public function username(){
		if(!empty($this->input)){
			$this->input = preg_replace('/[^\w.]+/', '', $this->input);
		}
		return $this;
	}

	public function phone(){
		if(!empty($this->input)){
			$this->input = preg_replace('/[^0-9+]+/', '', $this->input);
		}
		return $this;
	}

	public function integer(){
		$this->input = preg_replace('/[^0-9]+/', '', $this->input);
		if(!empty($this->input)){
			return intval($this->input);
		}
		return $this;
	}

	public function number($modo=null, $regex=null){
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

	public function decimal($round=false, $toString=false){
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
