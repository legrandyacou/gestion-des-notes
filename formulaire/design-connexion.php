<?php
require_once __DIR__ . '/../db_connexion.php';
require_once __DIR__ . '/../session_config.php';


$erreur ="";
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $gmail = trim($_POST['gmail']?? '');
    $mdp_saisi = $_POST['mdp']?? '';
 
    if ($gmail !== '' && $mdp_saisi !== '') {
        $recuperuser = $PDO->prepare("SELECT id_user, nom, prenom, gmail, mdp FROM utilisateur WHERE gmail = ?");
        $recuperuser->execute([$gmail]);
        $utilisateur = $recuperuser->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($mdp_saisi, $utilisateur['mdp'])) {
            session_regenerate_id(true);
            $_SESSION['gmail'] = $utilisateur['gmail'];
            $_SESSION['nom'] = $utilisateur['nom'];
            $_SESSION['prenom'] = $utilisateur['prenom'];
            $_SESSION['id_user'] = $utilisateur['id_user'];
            $_SESSION['connecte'] = true;

            header('Location: ../index.php');
            exit;
        }else{
            $erreur ="mot de passe ou gmail incorrecte !";
        }

        
    } else {
        echo "Veuillez renseigner tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="shortcut icon" href="../images/icons8-school-96.png" type="image/x-icon">
    <link rel="stylesheet" href="../doc css/connexion.css">
    <link rel="stylesheet" href="../doc css/responsive.css">

</head>
<body class="auth-page">
            <div class="parent">
                <div class="enfant1">
                    <div class="design3"></div> 
                    <div class="design1"></div>
                    <div class="design2"></div>
                </div>
        <div class="enfant2">
            
        <form action="#" id="connexion" method="post" >
            <div class="boximg">
                <img src="../images/ecole-192x192.png" alt="">
            </div>
                
                <h1 class="titre-conxion" >Bienvenue</h1>
            
            <div class="box-input">
                 <input type="email" id="email" name="gmail" placeholder="mail"><i class="fa-solid fa-envelope"></i><br>
                </div>
                 <div class="box-input">
             <input type="password" id="mdp" name="mdp" placeholder="mot de passe"><i class="fa-solid fa-lock"></i><br>
                </div>
                    <input  type="submit" id="submit1" class="subConnect" value="connexion"><br>
                    <div>
                        <span style="color: black; margin-top: 20px;"> pas encore de compte</span> 
                    <a href="design-Inscription.php"  style="color: black; margin-top: 20px;">Inscription</a> 
                    </div>
                    
                    <p id="message"></p>
                <p id="succes"></p>
            </form>
        </div>
            </div>
                
           
</body>
</html>