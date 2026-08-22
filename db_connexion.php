<?php
     try{
    $PDO = new PDO("mysql:host=localhost;dbname=lesnotes;charset=utf8","root","");
    //permet a PDO de lancer des exception en cas d'erreur sql
   $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException  $e){
  die("erreur".$e->getMessage());
}