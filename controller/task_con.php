<?php

/**
 * Created by PhpStorm.
 * User: 1-PC
 * Date: 24.06.2017
 * Time: 7:51
 */
class task_con extends controller {


    function index(){
        $u = $this->load_model('user');
        if(!$u->isAuth()){
            header('location: /login');
        }else{
            $tasks_on_page = 3;
            $tasks = $this->load_model('tasks');

            $task_count = $tasks->count();
            $pages_count = ceil($task_count/$tasks_on_page);

            $show_page = 0;
            $show_filtred = "id";

            if (isset($_GET["page"])){
                $show_page = $_GET["page"]*$tasks_on_page;
            }
            if (isset($_GET["filter"])){
                $show_filtred = $_GET["filter"];
            }

            $task_list = $tasks->getAllLimit($show_filtred,"DESC",$show_page,$tasks_on_page);
            $_SESSION["curr_page"] = $_GET["page"];

            $this->tpl->set("task_count",(string) $pages_count);
            $this->tpl->set("title","Tasks");
            $this->tpl->set("tasks",$task_list);
            $this->tpl->show('tasks.tpl');
        }
    }

    function add(){
        if (isset($_POST['login']) && $_POST['email'] && $_POST['text']){

            if (isset($_FILES['uploadfile']) && ($_FILES['uploadfile']['type'] == 'image/jpeg' || $_FILES['uploadfile']['type'] == 'image/png')){
                $im =  imageCreateFromString( file_get_contents($_FILES['uploadfile']['tmp_name']) );
                //Сжимаем картинку
                $width = imagesx($im);
                $height = imagesy($im);
                $prop = $height / $width;
                $width = 320;
                $height = $width * $prop;

                $im1 = imagecreatetruecolor($width,$height);
                imagecopyresampled($im1,$im,0,0,0,0,$width,$height,imagesx($im),imagesy($im));
                imagejpeg($im1,$_FILES['uploadfile']['tmp_name'],75);
                $save_path = 'temp/'.date('y-m-d-h-i-s').'.jpg';
                //Сохраняем картинку
                move_uploaded_file($_FILES['uploadfile']['tmp_name'],$save_path);
                //Добавляем в бд
                $task = $this->load_model('tasks');
                $task->add($_POST['login'],$_POST['email'],$_POST['text'],$save_path);
            }
        }
        header('location: /');
    }

    function complete($id = ''){
        $u =$this->load_model('user');
        if($u->isAuth()){
            $t = $this->load_model('tasks');
            $t->complite($id,$_GET['check']);
        }else{
            header("HTTP/1.0 403 Forbidden");
        }
    }

    function  delete($id = ''){
        $u =$this->load_model('user');
        if($u->isAuth()){
            $t = $this->load_model('tasks');
            $t->delete($id);
        }else{
            header("HTTP/1.0 403 Forbidden");
        }
    }

    function edit($id = ''){
        $u =$this->load_model('user');
        if($u->isAuth()){
            $t = $this->load_model('tasks');
            $this->tpl->set('title','Edit Task');
            $this->tpl->set('editMode',true);

            if($id != ""){
                $task = $t->getOne($id);
                $this->tpl->set('task',$task);
            }
            if (isset($_POST['login']) && $_POST['email'] && $_POST['text']){

                if (isset($_FILES['uploadfile']) && ($_FILES['uploadfile']['type'] == 'image/jpeg' || $_FILES['uploadfile']['type'] == 'image/png')) {

                    $im = imageCreateFromString(file_get_contents($_FILES['uploadfile']['tmp_name']));

                    $width = imagesx($im);
                    $height = imagesy($im);
                    $prop = $height / $width;
                    $width = 320;
                    $height = $width * $prop;

                    $im1 = imagecreatetruecolor($width, $height);
                    imagecopyresampled($im1, $im, 0, 0, 0, 0, $width, $height, imagesx($im), imagesy($im));
                    imagejpeg($im1, $_FILES['uploadfile']['tmp_name'], 75);
                    $save_path = 'temp/' . date('y-m-d-h-i-s') . '.jpg';
                    //Сохраняем картинку
                    move_uploaded_file($_FILES['uploadfile']['tmp_name'], $save_path);
                    $task["Img_url"] = $save_path;
                }
                $t->updateOne($id,$_POST['login'],$_POST['email'],$_POST['text'],$task["Img_url"]);
                $_POST["page"] = $_GET["page"];

                header("Location: ../?page=".$_SESSION["curr_page"]);

            }

            $this->tpl->show('edit.tpl');

        }else{
            header("HTTP/1.0 403 Forbidden");
        }
    }
}