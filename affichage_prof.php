           
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

        :root{
    --couleur-bleu:#B6D8F2;
     --couleur-2nbleu:#5CAFE7;
     --couleur-blanc:#eff2f4;
     --background-transparent: rgba(255, 255, 255, 0.1);
     --colo-text:rgb(111, 107, 107);
     --transition:all 0.3s ease ;
     --color-line: rgb(192, 186, 186);
     --color-pink:pink;
     --color-black:black;
     --color-teal:teal;
}
         .liste_prof{
    background-color: pink;
    width: 28%;
}
 .info_prof{
    width: 72%;
    padding: 10px;
    border: 1px solid teal;
    
    
}
.info_detail{
    background-color: var(--couleur-blanc);
    padding: 10px;
    margin-bottom: 10px;
    width: 100%;
    height: 25%;
    
}
.contenu4 h1{
    font-size: 20px;
    margin-bottom: 20px;
    
}
.info_Note_moy{
    display: flex;
    gap: 10px;
    height: 75%;
}
.onglet_period{
    background-color: var(--couleur-blanc);
    width: 40%;
    position: relative;
    
}
.calcule_moy{
    background-color: var(--couleur-blanc);
    width: 60%;
    
}
.box_onglet{
    display: flex;
    align-items: center;
    
}
.btn_sem1 ,.btn_sem2{
    width: 50%;
    background-color: var(--couleur-2nbleu);
    color: var(--color-black);
    border: none;
    padding: 5px;
    
}
.btn_sem1{
    border-right: 1px solid;
}
.conteneur_sem1,.conteneur_sem2{
    background-color: var(--color-teal);
    height: 95%;
    position: absolute;
    width: 100%;
    padding: 10px;
    
}
.conteneur_sem1{
opacity: 0;
}
.conteneur_sem2{
    opacity: 1;
}




    </style>
</head>
<body>
    <?php  
     /*$sql = "SELECT * FROM proffesseurs";
     $resultat = $PDO ->query($sql);
    if($resultat && $resultat->rowCount() > 0){*/
    ?>
    <div class="Affich_Anote">
    <table class="affichage ">
    <tbody>
                        
         <?php                       
            while($ligne= $resultat->fetch(PDO::FETCH_ASSOC)){
        ?>
                                                 
                            <tr class="Anote ">              
                               <td> 
                                <a href="filtre.php?id_Prof=<?= $ligne['id_Prof'] ?>" onclick="return confirm('voulez vous vraiment modifie cet proffesseur ?');"> <button class="delete modifie"><i class="fa-solid fa-recycle"></i></button></a>
                                <a href="suppProf.php?del=<?= $ligne['id_Prof'] ?>" onclick="return confirm('voulez vous vraiment supprimer cet proffesseur ?');"> <button class="delete"><i class="fa-regular fa-trash-can"></i></button></a>
                              </td>
                                <td><?= htmlspecialchars($ligne['nom'])?></td>
                                <td><?= htmlspecialchars($ligne['prenom'])?></td>
                                <td><?= htmlspecialchars($ligne['tel'])?></td>
                                <td><?=htmlspecialchars($ligne['jcours'])?></td>
                                <td><?=htmlspecialchars($ligne['t_Prof'])?></td
                            </tr>
                            <?php  } ?>                          
                                                        
                     </tbody>   
                    </table>
                     </div>                     
                                    <?php
                                         }
                                            else{
                                               echo "<p class='message_number'> 0 utilisateur present !</p>";
                                        }
                                    ?>

        </div>


        <div class="info_prof">
        <div class="info_detail">
            <h1>Nom</h1>
            <h1>Numéro de téléphone</h1>
            <h1>Matière</h1>
            <h1>Disponibilité</h1>
        </div>
        <div class="info_Note_moy">
            <div class="onglet_period">
                <div class="box_onglet">
                    <button class="btn_sem1">Semestre 1</button>
                    <button class="btn_sem2">Semestre 2</button>
                </div>
                <div class="conteneur_sem1"><h1>Semestre 1</h1></div>
                <div class="conteneur_sem2"><h1>Semestre 2</h1></div>
            </div>
            <div class="calcule_moy">
                <h1>Calcul de moyenne</h1>
            </div>
        </div>
    </div>

    //bloc matieres
    
                    <div class="Affich_Anote">
                                        <table class="affichage">
                                            <tr>
                                                <td><h1>supprimer</h1> </td>
                                                <td><h1>Modifie</h1> </td>
                                                <td><h1>Libelle</h1> </td>
                                                <td><h1>Coefficient</h1> </td>
                                                <td><h1>Heure</h1></td>
                                            </tr>
                                                                 
                                        </table>
                            </div> 
                            <?php  
                                
                                    $sql = "SELECT * FROM matieres";
                                            $resultat = $PDO ->query($sql);
                                            while($ligne= $resultat->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                                
                                                        <table class="Anote">                
                                                                <tr>
                                                                <td> 
                                                                    <a href="modif.php?del=<?= $ligne['id_matiere'] ?>"    onclick="return confirm('voulez vous vraiment modifie cet matiere ?');">  <button class="delete"><i class="fa-solid fa-recycle"></i></button></a>
                                                                    <a href="suppMati.php?del=<?= $ligne['id_matiere'] ?>"    onclick="return confirm('voulez vous vraiment supprimer cet matiere ?');">  <button class="delete"><i class="fa-regular fa-trash-can"></i></button></a>
                                                                </td>
                                                                <td><?= htmlspecialchars($ligne['libelle'])?></td>
                                                                <td><?= htmlspecialchars($ligne['coefficient'])?></td>
                                                                <td><?=htmlspecialchars($ligne['Heure'])?></td>
                                                                </tr>
                                                        </table>
                                                        

                                    <?php
                                            }
                                    ?>
                             </div>

</body>
</html>