<?php

/**
 * Created by PhpStorm.
 * User: 2
 * Date: 01.07.2016
 * Time: 13:51
 */
class main_con extends controller{
    function index(){
        $this->tpl->set('editMode',false);
      $this->tpl->set('title', 'Home');
      $this->tpl->show('index.tpl'); 
   }

   function regist(){
      $user = $this->load_model("user");
      if(isset($_POST["user"])){
         $user->add($_POST["name"],$_POST["pass"]);
         $user->get_error_list();
      }
   }

   function login_ajax(){
      $user = $this->load_model("user");
      if(isset($_POST["user"])){
         $user->auth($_POST["user"]["name"],$_POST["user"]["pass"]);
         $user->get_error_list_json();
      }
   }

   function login(){
       $this->tpl->set('title', 'login');
       $user = $this->load_model("user");
       if (!$user->isAuth()){
           $this->tpl->show('login.tpl');
       }else{
           header("location: ./");
       }
   }


   function logout(){
       $user = $this->load_model("user");
       $user->logout();
   }

   function paging($pages = array()){
       $this->show_404();
       header("HTTP/1.0 404 Not Found");
    }
}