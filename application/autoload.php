<?php
spl_autoload_register(function ($class) {
    $class = explode("\\", $class);
    $paths = array(
      "application/" . $class[1] . '.class.php',
      "controllers/" . $class[1] . '.class.php',
      "models/" . $class[1] . '.class.php');
    foreach($paths as $path){
      if(file_exists($path))
      {
        include $path;
      }
    }
});
?>
