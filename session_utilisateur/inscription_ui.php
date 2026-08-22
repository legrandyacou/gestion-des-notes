<?php
session_start();
try{
    $PDO = new PDO("mysql:host=localhost;dbname=lesnotes;charset=utf8","root","");
    //permet a PDO de lancer des exception en cas d'erreur sql
   $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException  $e){
  die("erreur".$e->getMessage());
}

if($_SERVER['REQUEST_METHOD'] =='POST'){
    if(!empty($_POST["pseudo"]) && !empty($_POST["mdp"]) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['gmail']) && !empty($_POST['date_naiss'])){
        $pseudo =htmlspecialchars($_POST["pseudo"]); 
        $nom =htmlspecialchars($_POST["nom"]); 
        $prenom =htmlspecialchars($_POST["prenom"]);
        $date_naiss = htmlspecialchars($_POST['date_naiss']);
        $gmail =htmlspecialchars($_POST["gmail"]);  
        $mdp=$_POST["mdp"];
        $mdp_comf =$_POST["mdp_conf"];

        if($mdp !== $mdp_comf){
            echo " les deux mots de passe ne sont pas identique";

        }else{  
            $verifypseudo =$PDO->prepare("SELECT * FROM utilisateur WHERE pseudo=?");
            $verifypseudo->execute(array($pseudo));
            $verify =$verifypseudo->fetch();

                if($verifypseudo->rowCount()>0){
            
                echo " ce pseudo existe deja";
                }else{
                $mdp_hash =password_hash($mdp,PASSWORD_DEFAULT);
            // $mdp= password_hash($_POST["mdp"]);
                    $query = "INSERT INTO utilisateur(pseudo,nom,prenom,date_naiss,gmail,mdp) VALUES(:pseudo,:nom,:prenom,:date_naiss,:gmail,:mdp)";
                    $insertion = $PDO->prepare($query);
                    $insertion->execute([
                    'pseudo'=>$pseudo,
                    'nom'=>$nom,
                    'prenom'=>$prenom,
                    'gmail'=>$gmail,
                    'mdp'=>$mdp_hash,
                    'date_naiss'=>$date_naiss,
                        ]);

               $id = $PDO->lastInsertId();// recuper directement ID auto incremente qui vien d'etre genere par mysql
            $_SESSION["pseudo"]=$pseudo;
            $_SESSION["nom"]=$nom;
            $_SESSION["prenom"]=$prenom;
            $_SESSION['date_naiss']=$date_naiss;
            $_SESSION["gmail"]=$gmail;    
             $_SESSION["id"]=$id;

        header("Location: inscription_ui.php");
         exit();
                }
        }
    }else{
        echo "veuillez renseigner tous les champ..";
       
    }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription utilisateur</title>
</head>
<body>
    <form action="#" method="post" align="center">
    <input type="text" name="pseudo" placeholder="pseudo"><br>
    <input type="text" name="nom" placeholder="nom"><br>
    <input type="text" name="prenom" placeholder="prenom"><br>
    <input type="email" name="gmail" placeholder="gmail"><br>
    <input type="date" name="date_naiss" placeholder="date_naiss"><br>
    <input type="password" name="mdp" id="mdp" placeholder="mot de passe" ><br>
    <input type="password" name="mdp_conf" id="mdp_conf" placeholder="comfirmation" ><br>
    <input type="submit" name="Envoyer">
    </form>
</body>
</html>