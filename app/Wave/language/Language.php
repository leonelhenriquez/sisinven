<?php
namespace Wave\language;
/**
 * 
 */
class Language {
	private $deafaultLang;
	private $language = null;
	private $appLangs;
	private $stringResources;
	function __construct($appLangs,$deafaultLang)
	{
		$this->appLangs = $appLangs;
		//$this->language = $deafaultLang;
		$this->deafaultLang = $deafaultLang;
		//$this->setLanguage($this->getLanguageBrowser());
		//$this->getResources();
	}
	function getDeafaulLanguage(){
		return $this->deafaultLang;
	}
	function getLanguageBrowser(){
		$langs = array();

		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);

			if (count($lang_parse[1])) {
				$langs = array_combine($lang_parse[1], $lang_parse[4]);
				foreach ($langs as $lang => $val) {
					if ($val === '') $langs[$lang] = 1;
				}
				arsort($langs, SORT_NUMERIC);
			}
		}
		$language = $this->deafaultLang;
		$langMaxPriority = -1;
		foreach ($langs as $lang => $val) {
			foreach ($this->appLangs as $lS) {
				if(strrpos($lang, $lS) === 0 && $val>$langMaxPriority){
					$language = $lS;
				}
			}
		}
		return $language;
	}
	function getLanguage(){
		return $this->language;
	}
	function setLanguage($lang){
		$this->language = $lang;
		$this->getResources();
	}
	public function getString($str_key){
		if(isset($this->stringResources[$this->getLanguage()][$str_key])){
			return $this->stringResources[$this->getLanguage()][$str_key];
		}else if(isset($this->stringResources[$this->getDeafaulLanguage()][$str_key])){
			return $this->stringResources[$this->getDeafaulLanguage()][$str_key];
		}else{
			throw new Exception('El recurso de idioma no existe.');
		}
	}

	function getResources(){
		if($this->getDeafaulLanguage()==$this->getLanguage() && file_exists(__PATH_SOURCE__."/langs/".$this->getLanguage().".php")){
			require_once __PATH_SOURCE__."/langs/".$this->getLanguage().".php";

			$this->stringResources = array(
				$this->getLanguage() => call_user_func("getLang".ucwords($this->getLanguage()))
			);
		}else if(
			file_exists(__PATH_SOURCE__."/langs/".$this->getLanguage().".php") && 
			file_exists(__PATH_SOURCE__."/langs/".$this->getDeafaulLanguage().".php")
		){
			require_once __PATH_SOURCE__."/langs/".$this->getLanguage().".php";
			require_once __PATH_SOURCE__."/langs/".$this->getDeafaulLanguage().".php";

			$this->stringResources = array(
				$this->getLanguage() => call_user_func("getLang".ucwords($this->getLanguage())),
				$this->getDeafaulLanguage() => call_user_func("getLang".ucwords($this->getDeafaulLanguage()))
			);

		}else{
			throw new Exception('Los recursos de idiomas no existen.');
		}
	}
}
?>