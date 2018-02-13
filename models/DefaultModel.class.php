<?php
namespace MyFramework;
 class DefaultModel extends Core
 {
 public function getLogin()
 {
   if(isset($_POST['password']) && isset($_POST['login']))
   {
     $password = $_POST['password'];
     $login = $_POST['login'];

   $req = self::$_pdo->prepare('SELECT * FROM membres WHERE login = :login AND pw = :pw');
   $req->execute(array(
       'login' => $login,
       'pw' => $password));
   $resultat = $req->fetch();
   if(!$resultat)
   {
     return "Indentifiant ou mot de passe incorrect";
   }
   else
   {
    $_SESSION['id'] = $resultat['id'];
    $_SESSION['login'] = $resultat['login'];
    $_SESSION['pw'] = $resultat['pw'];
    return "Bienvenue ".$login;
    }
   }
   else
   {
     return "Vous n'etes pas connecté";
   }
  }
}
?>
