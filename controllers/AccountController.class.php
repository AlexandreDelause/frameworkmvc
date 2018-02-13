<?php
namespace MyFramework;
 class AccountController extends AccountModel
 {
   public function defaultAction()
   {
     $this->render(['default' => $this->getLogin()]);
   }
   public function newAction()
   {
    $this->render(['new' => $this->getLogin()]);
    }
}
 ?>
