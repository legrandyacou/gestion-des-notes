<?php
require_once __DIR__ . '/../db_connexion.php';
require_once __DIR__ . '/../session_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $gmail = trim($_POST['gmail'] ?? '');
    $mdp = $_POST['mdp'] ?? '';
    $confirmation = $_POST['ConFmdp'] ?? '';

    if ($nom === '' || $prenom === '' || $gmail === '' || $mdp === '' || $confirmation === '') {
        echo "Veuillez renseigner tous les champs.";
    } elseif ($mdp !== $confirmation) {
        echo "Les deux mots de passe ne sont pas identiques.";
    } else {
        $userRecup = $PDO->prepare("SELECT id_user FROM utilisateur WHERE gmail = ?");
        $userRecup->execute([$gmail]);

        if ($userRecup->fetchColumn() !== false) {
            echo "Cette adresse e-mail est déjà utilisée.";
        } else { 
            $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
            $insertion = $PDO->prepare(
                "INSERT INTO utilisateur (nom, prenom, gmail, mdp) VALUES (:nom, :prenom, :gmail, :mdp)"
            );
            $insertion->execute([
                'nom' => $nom,
                'prenom' => $prenom,
                'gmail' => $gmail,
                'mdp' => $mdp_hash,
            ]);

            session_regenerate_id(true);
            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['gmail'] = $gmail;
            $_SESSION['id_user'] = $PDO->lastInsertId();
            $_SESSION['connecte'] = true;

            header('Location: ../index.php');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
        <link rel="shortcut icon" href="../images/icons8-school-96.png" type="image/x-icon">
        <link rel="stylesheet" href="../doc css/connexion.css">
        <link rel="stylesheet" href="../doc css/responsive.css">
        <link rel="stylesheet" href="../doc css/chargement.css">
</head>
<body class="auth-page">
     <div id="loader" class="loader" aria-live="polite" aria-label="Chargement">
    <div class="loader-spinner"></div>
    <p>Chargement…</p>
     </div>
            <div class="parent">
                <div class="enfant1">
                    <div class="design3"></div> 
                    <div class="design1"></div>
                    <div class="design2"></div>
                    
                </div>
        <div class="enfant2">
            <form id="inscription" name="inscription" action="#" method="post">
                <div class="boximg">
                    <img src="../images/ecole-192x192.png" alt="Logo de l’école">
                </div>
                
                <h1 class="titre-conxion" >Bienvenue</h1>
                
                <div class="box-nom">
                     <input type="text" name="nom" placeholder="Nom "><i class="fa-solid fa-user"></i>
                </div>
                <div class="box-nom">
                     <input type="text" name="prenom" placeholder="prenom"><i class="fa-solid fa-user"></i>
                </div>
                <div class="box-input">
                         <input type="email"  name="gmail" placeholder="mail"><i class="fa-solid fa-envelope"></i> <br>
                </div>
                <div class="box-input">
                                <input type="password" name="mdp" placeholder="mot de passe "><i class="fa-solid fa-lock"></i><br>
                </div>
                <div class="box-input">
                                <input type="password" name="ConFmdp" placeholder="comfirmation mot de passe "><i class="fa-solid fa-lock"></i><br>
                </div>
            
                    <input  type="submit" id="submit1" name="submit" value="inscription"> <br>
                    <span style="color: black; margin-top: 20px;">vous avez dejâ un compte</span> 
                    <a href="design-connexion.php" style="color: black; margin-top: 20px;">connexion</a> 
            </form>
        </div>
            </div> 
                <p id="message"></p>
           <script src="fonction_js/chargement.js"></script>
</body>
</html>