<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>formulaire de recette </title>
</head>
<body>
    <h2>CREATION DE RECETTE</h2>
    <form action="#" method="POST">
        <!-- <input type="file" name="img_recette" placeholder="Entrer votre image" > -->
        <P>titre: <input type="text" name="titre"></P>
        <P>auteur : <input type="text" name="auteur"></P>
        <P>Recette : <textarea name="recette"></textarea></P>
        <P><input type="submit" name="Enregistrer" value="Enregistre"></P>
    </form>
</body>
</html>
<?php 
    try {      //etape 1
            $PDO  = new PDO("mysql:host=localhost;dbname=restaurant;charset=utf8","root","");
            } catch (Exception $e){
            die("Erreur ".$e->getMessage());
            } 
            if($_SERVER['REQUEST_METHOD']=='POST'){
                $titre= $_POST['titre'];
                $auteur= $_POST['auteur'];
                $recette= $_POST['recette'];
                $sqlquery = "INSERT INTO recette(titre,auteur,recette) VALUES (:titre,:auteur,:recette)";
                $insertion = $PDO->prepare($sqlquery);
                $insertion->execute([
                'titre'=>$titre,
                'auteur'=>$auteur,
                'recette'=>$recette, ]);
            
            }
?>