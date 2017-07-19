<?
/**
* 
*/
class TplMaster{
	
	private $_vars = array();
	private $tpl_folder;

	function __construct($tpl_folder = "tpl"){
		$this->tpl_folder = $tpl_folder;
	}


	public function set($name,$val, $is_html = false){
		if ($is_html){
			$this->_vars[$name] = (string) $val;
		}else{
			$this->_vars[$name] = $this->no_html($val);
		}
		
	}

	public function delete($name){
		if (isset($this->_vars[$name])) unset($this->_vars[$name]);
	}


	public function __get($name){
        if (array_key_exists($name, $this->_vars)) {
            return $this->_vars[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Неопределенное свойство в __get(): ' . $name .
            ' в файле ' . $trace[0]['file'] .
            ' на строке ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }


	public function no_html($val){
		$val = str_replace(array('<','>','"'),array('&lt','&gt','&quot'), $val);
		return $val;
	}


	public function show($tpl){
		$path_to_tpl = $this->tpl_folder."/".$tpl;
		if (is_file($path_to_tpl)){
			ob_start();


		function isAuth(){
			if (isset($_SESSION["user"])) return true; else return false;
		}

		function isAdmin(){
			if (isset($_SESSION["user"])){
				if($_SESSION["user"]["level"] == 1){
					return true;
				}
			}
			return false;
		}

			require $path_to_tpl;
			echo ob_get_clean();
		}else{
			$trace = debug_backtrace();
	        trigger_error(
	            'Нет шаблона: ' . $tpl .
	            ' в файле ' . $trace[0]['file'] .
	            ' на строке ' . $trace[0]['line'],
	            E_USER_NOTICE);
		}

	}


}