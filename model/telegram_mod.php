<?php

/**
 * Created by PhpStorm.
 * User: 1-PC
 * Date: 15.06.2017
 * Time: 16:23
 */
class telegram extends controller{
    private $TOKEN= '423290403:AAGcmHGsk7QBQQ5wP2FmzijLDWt79xqTiZo';
    private $URL;
    private $USER_ID = '288466603';

    function __construct(){
        $this->URL = "https://api.telegram.org/bot".$this->TOKEN."/";
    }

    public function send($msg){
        file_get_contents($this->URL.'sendMessage?chat_id='.$this->USER_ID.'&text='.$msg);
    }
    public function getUpdates($limit=5){
        $ret = file_get_contents($this->URL.'getUpdates?chat_id='.$this->USER_ID.'allowed_updates=message&limit='.$limit);
        $ret = json_decode($ret);
        return $ret;
    }
}