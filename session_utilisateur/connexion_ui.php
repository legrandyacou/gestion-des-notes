<?php 
    session_start();
    try {
       $connexion = new PDO("mysql:host=localhost;dbname=lesnotes;charset=utf8","root","");

    } catch (PDOException $e) {
        die("erreur".$e->getmessage());
    }
    if($_SERVER['REQUEST_METHOD']=="POST"){
        if(!empty($_POST['pseudo']) && !empty($_POST['mdp'])){
            $pseudo =htmlspecialchars($_POST['pseudo']);
            $mdp_saisi =$_POST['mdp'];
           
            $recuperuser = $connexion->prepare("SELECT * FROM utilisateur WHERE pseudo=?");
            $recuperuser->execute(array($pseudo));
            $utilisateur= $recuperuser->fetch();
            if($utilisateur && password_verify($mdp_saisi,$utilisateur['mdp'])){
                $_SESSION['pseudo']=$pseudo;
                $_SESSION['id']=$utilisateur['id'];
                 header("Location: ../index.php");
                 exit();   
            }else{
                echo "mot de passe ou pseudo incorrect";
            }
             
           
                           
               
           
        }else{
            echo "veuillez renseigner tous les champs";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
</head>
<body>
    <form action="#" method="post" align="center">
    <input type="text" name="pseudo" placeholder="pseudo..."><br>
    <input type="password" name="mdp" id="mdp" placeholder="mot de passe"><br>
    <input type="submit" name="Envoyer">
    </form>
</body>
</html>