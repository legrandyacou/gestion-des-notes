<?php 
session_start();
$_SESSION= array();
session_destroy();
header('Location:  formulaire/design-connexion.php');
?>