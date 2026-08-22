<?php 
$utilisateur ="";
session_start();
$_SESSION["utilisateur"]="yacouba";
echo "Bienvenue"." ".$_SESSION["utilisateur"];
?>