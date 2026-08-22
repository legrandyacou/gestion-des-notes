<?php
    require_once "db_connexion.php";
    $error = "";
    $reponse = "";
    
    $id_Prof = $_GET['id_Prof'] ?? null;
    if(isset($_POST['Enregistre'])){
        if(!empty($_POST['nom']) && !empty($_POST['prenom']) 
            && !empty($_POST['tel'])
             && !empty($_POST['jcours']) 
            && !empty($_POST['t_Prof']) ){
                            $reponse = "ok VARIable";
                            $nom =htmlspecialchars($_POST['nom']);
                            $prenom =htmlspecialchars($_POST['prenom']);
                            $tel =htmlspecialchars($_POST['tel']);
                            $Jcours =htmlspecialchars($_POST['jcours']);
                            $t_prof =htmlspecialchars($_POST['t_Prof']);
                            $req = $PDO->prepare("UPDATE proffesseurs SET nom=? ,prenom=?,tel=? ,jcours=?,t_Prof=? WHERE id_Prof=? ");
                            $req-> execute(array($nom ,$prenom,$tel ,$Jcours,$t_prof,$_POST['id_Prof']));
                            
                            $error = "Modification effectue .";
            }else{
                $error = "Vous devez rempli tous les champ.";
            }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>double filter</title>
    <link rel="stylesheet" href="css_fitre.css">
        

</head>
<body>
                            <div class=" filtre_prof">
                                    <div class="close_modProf">
                                            <button hidden class="btn-close">&times;</button>
                                            <?php if(!empty($error)):?>
                                            <p style="color: blue; font-weight: bold;"> <?php echo $error ;?></p>
                                            <?php 
                                                
                                        endif; ?>
                                        <h1 style="color: blue; font-weight: bold;">Modifie proffesseur <?php echo $reponse ?> </h1>
                                    </div>
                                        <div class="formulaire_mod ">
                                            
    <?php
            //require_once "db_connexion.php";

    $sql = "SELECT * FROM proffesseurs WHERE id_Prof = ?";
  $query = $PDO->prepare($sql);
   $query->execute([$id_Prof]);
        while($ligne=$query->fetch(PDO::FETCH_ASSOC)){ 
    ?>
     <form action="index.php" method="post" class="forMuLaire" name="forMu_pro" >
        <input type="hidden" name="id_Prof" value="<?= $ligne['id_Prof'] ?>">
         <input type="text" placeholder="nom " name="nom" value="<?=htmlspecialchars($ligne['nom']) ?>"><br>
          <input type="text" placeholder="prenom" name="prenom" value="<?=htmlspecialchars($ligne['prenom'] )?>"><br>
          <input type="tel" placeholder="0XXXXXXXXX" name="tel" value="<?=htmlspecialchars($ligne['tel'] )?>"><br>
         <input type="text" placeholder="jours de cours" name="jcours" value="<?=htmlspecialchars($ligne['jcours'] )?>"> <br>
        <input type="text" placeholder="cours" name="t_Prof" value="<?=htmlspecialchars($ligne['t_Prof']) ?>"> <br>
         <input type="submit" value="Enregistre" class="btn-subm" name="Enregistre" >
    </form>
 <?php
    }
?>  
                                        </div>   

                            </div>
</body>
</html>