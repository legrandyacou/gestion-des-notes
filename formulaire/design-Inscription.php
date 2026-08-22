<?php 
session_start();
 //require "gestion_note\db_connexion.php";
 try{
    $PDO = new PDO("mysql:host=localhost;dbname=lesnotes;charset=utf8","root","");
    //permet a PDO de lancer des exception en cas d'erreur sql
   $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException  $e){
  die("erreur".$e->getMessage());
}
if($_SERVER['REQUEST_METHOD']=="POST"){
    $pseudo =htmlspecialchars($_POST['pseudo']);
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $gmail = htmlspecialchars($_POST['gmail']);
    $mdp =$_POST['mdp'];
    $ConFmdp =$_POST['ConFmdp'];

    
    if(!empty($_POST['pseudo']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['gmail']) && !empty($_POST['mdp']) && !empty($_POST['ConFmdp'])){
        
        if($mdp !== $ConFmdp){
            echo "les deux ne pas identique";
        }else{
            
        $userRecup = $PDO->prepare("SELECT * FROM utilisateur WHERE pseudo=? AND nom=? AND prenom=? AND gmail=? AND mdp=?");
        $userRecup->execute(array($pseudo,$nom,$prenom,$gmail,$mdp));
        //$verify =$userRecup->fetch();
        
        if($userRecup->rowCount()>0){
            echo " ce pseudo existe deja";           
        }else{
            $mdp_hash =password_hash($mdp,PASSWORD_DEFAULT);
            $query ="INSERT INTO utilisateur(pseudo,nom,prenom,gmail,mdp) VALUES(:pseudo,:nom,:prenom,:gmail,:mdp)";
            $insertion = $PDO->prepare($query);
            $insertion->execute([
            'pseudo'=>$pseudo,
            'nom'=>$nom,
            'prenom'=>$prenom,
            'gmail'=>$gmail,
            'mdp'=>$mdp_hash,
                ]);
            $id = $PDO->lastInsertId();// recuper directement ID auto incremente qui vien d'etre genere par mysql
            $_SESSION['pseudo']=$pseudo;
            $_SESSION['nom']=$nom;
            $_SESSION['prenom']=$prenom;
            $_SESSION['gmail']=$gmail;
            $_SESSION['id']=$id;
             header("Location: design-Inscription.php");
            exit();
        }
        }

    }else{
        echo "veuillez renseigner tous les champs";
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
    <style>
        body{
            background: linear-gradient(to right, #ff8a65, #7b1fa2);
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        input{
            background-color: #e0d5d5e8;
            /*border: 1px solid pink;*/
            border:none;
            border-radius: 25px; /* Pour l'effet très arrondi */
            padding: 12px 30px;
            font-family: 'Poppins', sans-serif;
    
            
        }
        .parent{
            border: none;
            border-radius: 12px;
            height: 70vh;
            width: 65vw;
            background-color: #ffff;
            display: flex;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .enfant1{
                width: 50%;
                border: none;                
            }
            .enfant2{
                width: 50%;
                border: none;
                display: flex;
                justify-content: center;
                align-items: center ;
            }
            .titre-conxion{
                border: none;
                width: 229px;
                text-align: center;
            }
            #submit1{
                border: none ;
                padding: 12px 0;
                width: 229px;
                height: 39px;
                font-size: 16px;
                background: linear-gradient(to right, #ff8a65, #7b1fa2);
                font-family: 'Poppins', sans-serif;
                
            }
            .fa-user {              
                width: 38vw;
                bottom: 220px;
            }
            .box-nom,.box-input{
                
                /*border:1px solid;*/
                width: 250px;
                height:6vh;
                margin: 0 0 5px 0;
                display: flex;
                justify-content: start;
                align-items: center ;
            }
            .fa-envelope{
               
                width: 38vw;
                bottom: 206px;
            }
            .fa-lock{
                
                width: 38vw;
                bottom: 156px;
            }
            .design1{
                width: 400px;
                height: 150px;
                background: linear-gradient(to right, #ff8a65, #7b1fa2);
                border-radius: 0 80px 80px 0;
                margin: 20px 20px 20px 0;
                /* transform:translateX(-40px)  rotate(45deg); */
                position: absolute;
                translate:-120px 0;
                rotate: 50deg;
            
                /* bottom: 190px; */
            }
            .design2{
                width: 200px;
                height: 80px;
                background: linear-gradient(to right, #ff8a65, #7b1fa2);
                border-radius: 0 80px 80px 0;
                position: absolute;
                translate:-100px 230px ;
                rotate: 50deg;
                }
            .design3{
                width: 300px;
                height: 80px;
                background: linear-gradient(to right, #ff8a65, #7b1fa2);
                border-radius: 0 80px 80px 0;
                rotate: 50deg;
                z-index: 1;
                
            }
            
    </style>
</head>
<body>
            <div class="parent">
                <div class="enfant1">
                    <div class="design3"></div> 
                    <div class="design1"></div>
                    <div class="design2"></div>
                    
                </div>
        <div class="enfant2">
            <form id="inscription" name="inscription" action="#" method="post">
                
                <h1 class="titre-conxion" >Bienvenue</h1>
                <div class="box-nom">
                     <input type="text" name="pseudo" placeholder="pseudo"><i class="fa-solid fa-user"></i>
                </div>
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
            <script>
                    
                    
                
                
            </script>
</body>
</html>