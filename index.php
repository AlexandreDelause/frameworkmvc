<?php
// var_dump($_SERVER['REQUEST_URI']);
//var_dump($_POST['login']) ;
//var_dump($_POST['password']);
define('BASE_URI', substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT'])));
require_once(implode(DIRECTORY_SEPARATOR,['application', 'autoload.php']));
$app = new MyFramework\Core();
$app->run();
?>
