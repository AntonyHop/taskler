<?php
/**
 * Created by PhpStorm.
 * User: 2
 * Date: 01.07.2016
 * Time: 12:24
 */
//РИСУЕТ ОКНО ДЕБАГА
function debug($data){
    echo "<pre style='background-color: brown;color: cornsilk;font-weight: 700;padding: 10px;z-index: 100000;'>";
    echo "<h1>Debug!!!</h1>";
    print_r($data);
    echo "</pre>";
}

class God{
    //РОСПАРСЕНЫЕ ПАРАМЕТРЫ КОМАНДНОЙ СТРОКИ ДОСТУПНЫЕ ТОЛЬКО ИЗ КЛАССА
    protected $params = array();
    //ПАРАМЕТРЫ КОМАНДНОЙ СТРОКИ НА ЭКСПОРТ
    public $param = array();
    public $db;

    function __construct($url){
        $this->params = $this->get_params($url);
        $this->param = $this->params;
        $this->dell_empty();
        $this->mvc_realise();
        unset($url);
        unset($CLEAN_url);
    }
    //Расбивает url на массив
    function get_params($url){
        $CLEAN_url = $this->strip_data($url);
        $params = explode("/",$CLEAN_url);
        return $params;
    }
    //чистит url
    public function strip_data($text){
        $quotes = array ("\x27", "\x22", "\x60", "\t", "\n", "\r", "*", "%", "<", ">", "?", "!" );
        $goodquotes = array ("-", "+", "#" );
        $repquotes = array ("\-", "\+", "\#" );
        $text = trim( strip_tags( $text ) );
        $text = str_replace( $quotes, '', $text );
        $text = str_replace( $goodquotes, $repquotes, $text );
        return $text;
    }

    function dell_empty(){
        foreach ($this->params as $key=>$param){
            if(empty($param)){
              unset($this->params[$key]);
              unset($this->param[$key]);
            }
        }
    }

    /**
     * реализует mvс паттерн
     */
    function mvc_realise(){
        include_once CONTROLLER."/controller.php";
        if(isset($this->params[0]) && is_file(CONTROLLER."/".$this->params[0].CONTROLLER_PREFIX.".php")){
            include_once CONTROLLER."/".$this->params[0].CONTROLLER_PREFIX.".php";
            $name_obj = $this->params[0].CONTROLLER_PREFIX;
            $cur_obj = new $name_obj;
            if(isset($this->params[1])){
                $to_method = $this->params;
                $to_method = array_slice($to_method,2);
                $to_method = $this->edit_mode($to_method,$cur_obj);
                if(method_exists($cur_obj,$this->params[1]) && isset($this->params[2])){
                    call_user_func_array(array($cur_obj, $this->params[1]), $to_method);
                }else if(method_exists($cur_obj,$this->params[1]) && !isset($this->params[2])){
                    call_user_func_array(array($cur_obj, $this->params[1]),array());
                } else{
                     header("HTTP/1.0 404 Not Found");
                     echo "<h1>Метода нету (404)</h1>";
                }
                unset($to_method);
            }else{
                $cur_obj->index();
            }
        }else if (is_file(CONTROLLER."/".HOME_CONTROL.".php") && empty($this->params[0])){
            include_once CONTROLLER."/".HOME_CONTROL.".php";
            $name_obj = HOME_CONTROL;
            $cur_obj = new $name_obj;
            $cur_obj->index();
        }else{
            include_once CONTROLLER."/".HOME_CONTROL.".php";
            $name_obj = HOME_CONTROL;
            $cur_obj = new $name_obj;
                if(!$this->re_routing($this->param)){
                    if(method_exists($cur_obj,"paging")){
                        $to_method = $this->params;
                        $cur_obj->paging($to_method);
                    }else{
                        header("HTTP/1.0 404 Not Found");
                        echo "<h1>Контроллера нету (404)</h1>"; 
                        echo "<p>или альтернативного правила маршрутизации</p>";
                    }
                }    
            }
        }

    function edit_mode($serch_edit,$cur_obj){
        if(method_exists($cur_obj,"edit")){
            foreach($serch_edit as $key=>$item){

                if($item == "edit"){
                    if (isset($serch_edit[$key+1]) && isset($serch_edit[$key-1])){
                        $cur_obj->edit($serch_edit[$key+1]);
                        $serch_edit = array_slice($serch_edit,0,$key+1);
                    }elseif(isset($serch_edit[$key-1]) && empty($serch_edit[$key+1])){
                        $cur_obj->edit($serch_edit[$key-1]);
                        $serch_edit = array_slice($serch_edit,0,$key-1);
                    }
                    $serch_edit = array_slice($serch_edit,0,$key);
                };
            }
        }
        return $serch_edit;
    }
    //проверяет правила ремаршрутизации если не найден ни контроллер ни метод (reroute.php)
    function re_routing($params){
        require_once("reroute.php");
        $url = "";
        foreach ($params as $param) {
            $url .= "/".$param;
        }
        if (isset($re_route[$url])){
            $this->params = $this->get_params($re_route[$url]);
            $this->param = $this->params; 
            $this->dell_empty();
            $this->mvc_realise();
            return true;
        }else{
            return false;
        }
        
    }
}?>