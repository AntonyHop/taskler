<?php

/**
 * Created by PhpStorm.
 * User: 1-PC
 * Date: 23.06.2017
 * Time: 17:23
 */
class tasks extends controller{

    function add($username,$e_mail,$text,$img_url){
        if (isset($username) && isset($e_mail) && isset($text) &&isset($img_url) ){
            $this->db->query("INSERT INTO Tasks (`Username`, `E-mail`, `Text`, `Img_url`) VALUES (?s, ?s, ?s, ?s)", $username, $e_mail, $text, $img_url);
            return true;
        }
        return false;
    }

    function getAll($order_by = "id",$param = "DESC"){
        $res = $this->db->getAll("SELECT * FROM Tasks ORDER BY ".$order_by." ".$param);
        return (isset($res))?$res:false;
    }
    function getAllLimit($order_by = "id",$param = "DESC",$offset=0,$after=3){
        $res = $this->db->getAll("SELECT * FROM Tasks ORDER BY ".$order_by." ".$param." LIMIT ".$offset.", ".$after);
        return (isset($res))?$res:false;
    }

    function getOne($id){
        $res = $this->db->getAll("SELECT * FROM Tasks WHERE id = ?i",$id);
        return (isset($res[0]))?$res[0]:false;
    }

    function updateOne($id,$username,$e_mail,$text,$img_url){
        $this->db->query("UPDATE Tasks SET `Username`=?s , `E-mail` = ?s, `Text` = ?s, `Img_url`= ?s WHERE `id`=?s;" ,$username,$e_mail,$text,$img_url,$id);
    }

    function complite($id,$state=1){
        $this->db->query("UPDATE Tasks SET `sucess` = ?i WHERE id=?s;" ,$state,$id);
    }

    function delete($id){
        $this->db->query("DELETE FROM Tasks WHERE id=?i",$id);
    }
    function count(){
        $res = $this->db->getAll("SELECT COUNT(*) FROM Tasks");
        return (isset($res[0]["COUNT(*)"]))?$res[0]["COUNT(*)"]:false;
    }
}