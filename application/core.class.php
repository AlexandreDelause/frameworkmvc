<?php
namespace MyFramework;
class Core
 {
 static protected $_routing = [];
 static private $_render;
 static protected $_pdo;

 function __construct() {
  		$user = 'root';
  		$password = "";
  		$database = 'my_framework';
  		$host = 'localhost';
  		self::$_pdo = new \PDO('mysql:host=' . $host . ";dbname=" . $database, $user, $password);
 }
 private function routing()
 {
   $ctrlaction = explode("/", $_SERVER['REQUEST_URI']);
   $sql = "SELECT * FROM `routing`";
   $query = self::$_pdo->prepare($sql);
   $query->execute();
   $urlRs = $query->fetchObject();
   var_dump($urlRs);
   if($ctrlaction[4] === $urlRs->url)
   {
      $urlRs = explode('/',$urlRs->real_path);
      self::$_routing = [
      'controller' => $urlRs[0],
      'action' => $urlRs[1]
    ];
  }
  else
  {
   if(!empty($ctrlaction[4]) && empty($ctrlaction[5]))
      {
          self::$_routing = [
          'controller' => $ctrlaction[4],
          'action' =>  'default'
        ];
      }
      elseif(!empty($ctrlaction[4]) && !empty($ctrlaction[5]))
      {
          self::$_routing = [
          'controller' => $ctrlaction[4],
          'action' =>  $ctrlaction[5]
        ];
      }
      else
      {
        self::$_routing = [
          'controller' => 'default',
          'action' =>  'default'
        ];
      }
    }//var_dump($action);

 }
 protected function render($params = [])
  {
    $f = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'views',
    self::$_routing['controller'], self::$_routing['action']]) . '.html';
    if (file_exists($f)) {
      $c = file_get_contents($f);
      foreach ($params as $k => $v) {
        $c = preg_replace("/\{\{\s*$k\s*\}\}/", $v, $c);
      }
      self::$_render = $c;
    }
  }
  public function run()
  {
    $this->routing();
    $c = __NAMESPACE__ . '\\' . ucfirst(self::$_routing['controller']) .'Controller';
    $a = self::$_routing['action'] . 'Action';
    //var_dump($a);
    if(!class_exists($c))
    {
      self::$_routing['controller'] = 'Default';
      $c = __NAMESPACE__ . '\\' . 'DefaultController';
    }
    $o = new $c();
    if(!method_exists($o, $a))
    {
      self::$_routing['action'] = 'default';
      $a = 'defaultAction';
    }
    //var_dump($o);
    //var_dump($a);
    $o->$a();
    echo self::$_render;
  }
}
?>
