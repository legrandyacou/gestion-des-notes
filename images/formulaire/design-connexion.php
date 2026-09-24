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
                $_SESSION['gmail']=$gmail;
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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="shortcut icon" href="../images/icons8-edit-property-96.png" type="image/x-icon">
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
            border: none;
            border-radius: 25px; /* Pour l'effet très arrondi */
            padding: 12px 30px;
            font-family: 'Poppins', sans-serif;
            margin-top: 10px;
            
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
            .fa-envelope{
                
                width: 38vw;
                bottom: 230px;
            }
            .fa-lock{
                
                width: 38vw;
                bottom: 183px;
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
        <form action="#" id="connexion" method="post">
                
                <h1 class="titre-conxion" >Bienvenue</h1>
            
            <div class="box-input">
                 <input type="email" id="email" name="gmail" placeholder="mail"><i class="fa-solid fa-envelope"></i><br>
                </div>
                 <div class="box-input">
             <input type="password" id="mdp" name="mdp" placeholder="mot de passe"> <i class="fa-solid fa-lock"></i><br>
                </div>
                    <input  type="submit" id="submit1" value="connexion"><br>
                    <span style="color: black; margin-top: 20px;"> pas encore de compte</span> 
                    <a href="design-Inscription.php" target="_blank" style="color: black; margin-top: 20px;">Inscription</a> 
            </form>
        </div>
            </div>
                <p id="message"></p>
                <p id="succes"></p>
            <script>
                
                    
            </script>
</body>
</html>