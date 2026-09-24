<?php 
    session_start();
    try {
       $connexion = new PDO("mysql:host=localhost;dbname=lesnotes;charset=utf8","root","");

    } catch (PDOException $e) {
        die("erreur".$e->getmessage());
    }
    if($_SERVER['REQUEST_METHOD']=="POST"){
        if(!empty($_POST['gmail']) && !empty($_POST['mdp'])){
            $gmail =htmlspecialchars($_POST['gmail']);
            $mdp_saisi =$_POST['mdp'];
           
            $recuperuser = $connexion->prepare("SELECT * FROM utilisateur WHERE gmail=?");
            $recuperuser->execute(array($gmail));
            $utilisateur= $recuperuser->fetch();
            if($utilisateur && password_verify($mdp_saisi,$utilisateur['mdp'])){
                session_regenerate_id(true);
                $_SESSION['gmail']=$gmail;
                $_SESSION['connecte']=true;
                $_SESSION['nom']=$utilisateur['nom'];
                $_SESSION['prenom']=$utilisateur['prenom'];
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
    <input type="email" name="gmail" placeholder="email..."><br>
    <input type="password" name="mdp" id="mdp" placeholder="mot de passe"><br>
    <input type="submit" name="Envoyer">
    </form>
</body>
</html>