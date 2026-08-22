<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>modif</title><link rel="stylesheet" href="gestion_note/stile_modf_mati.css">
</head>
<body>
<?php
        require_once "db_connexion.php";
 $sql = "SELECT * FROM proffesseur";
 $query = $PDO->query($sql);
   
    while($ligne=$query->fetch(PDO::FETCH_ASSOC)){ 
?>
<form action="insertion_proffesseurs.php" method="post" class="forMuLaire" name="forMu_pro" >
        <input type="text" placeholder="nom " name="nom" value="<?=$ligne['nom'] ?>" ><br>
        <input type="text" placeholder="prenom" name="prenom" value="<?=$ligne['prenom'] ?>"><br>
        <input type="tel" placeholder="0XXXXXXXXX" name="tel" value="<?=$ligne['tel'] ?>"><br>
        <input type="text" placeholder="jours de cours" name="jcours" value="<?=$ligne['Jcours'] ?>"> <br>
        <input type="text" placeholder="jours de cours" name="t_Prof" value="<?=$ligne['t_prof'] ?>"> <br>
        <input type="submit" value="Enregistre" class="btn-subm" name="Modifie" >
        <a href="#" class="link_annuler">Annuler</a>
</form>
<?php
    }
?>  


</body>
</html>