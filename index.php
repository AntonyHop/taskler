<?
    require_once ("config.php");

    spl_autoload_register(function ($class) {
        include 'lib/' . $class . '.class.php';
    }); 
 
    session_start();

    if (!isset($_GET["url"])) $_GET["url"] = "/";
    //Set Up Global object data
    $god = new God($_GET["url"]);

?>