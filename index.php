<?php
                    session_start();    
                    if(!isset($_SESSION['connecte']) || $_SESSION['connecte'] !==true){
                        header('Location: formulaire/design-connexion.php');
                        exit();
                    }              
                        require_once "db_connexion.php";
                       $sql = "SELECT COUNT(*) FROM note ";
                  $query = $PDO->query($sql);
                  $noteTotal = $query->fetchColumn();
                  //comptage 
                   $sql = "SELECT COUNT(*) FROM professeurs ";
                  $query = $PDO->query($sql);
                  $profTotal = $query->fetchColumn();
                   //comptage 
                   $sql = "SELECT COUNT(*) FROM matieres ";
                  $query = $PDO->query($sql);
                  $matiTotal = $query->fetchColumn();
               //professeur                                           
           $smt = $PDO->query("SELECT id_prof,nom,prenom,tel,jcours,id_matiere FROM professeurs");
          $professeur = $smt->fetchAll(PDO::FETCH_ASSOC);
          //matiere
          $stmMati = $PDO->query("SELECT id_matiere,libelle_mat,coefficient,heure,id_prof FROM matieres");
          $LesMatiere = $stmMati->fetchAll(PDO::FETCH_ASSOC);
          //NOTES
          $stmNotes = $PDO->query("SELECT id_note,libelle_mat,date_note,note,id_prof,id_matiere FROM note");
          $LesNote = $stmNotes->fetchAll(PDO::FETCH_ASSOC);
          //Periode
          $stmNotes = $PDO->query("SELECT id_periodeNote,periode FROM periodenotes");
          $LesPriodes = $stmNotes->fetchAll(PDO::FETCH_ASSOC);
 ?> 
                                        
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link rel="shortcut icon" href="images/icons8-edit-property-96.png" type="image/x-icon">
    <link rel="stylesheet" href="style-index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
   <div class="side-baar">
       
        <div class="list-side">
            <template>
                 <i class="fa-solid fa-chart-bar"></i>
            </template>
           
            <ul>
                <li  id="active" class="active" data-anim="1"> <i class="fa-solid fa-house"></i> <span class="hidden">Acceuil</span> </li>
                <li data-anim="2"> <i class="fa-solid fa-book"></i> <span class="hidden">Ajoute</span> </li>
                <li data-anim="3"> <i class="fa-solid fa-pen-ruler"></i> <span class="hidden">Matiere</span> </li>
                <li data-anim="6">  <i class="fa-solid fa-circle-user"></i> <span class="hidden">profile</span> </li>
                <li data-anim="4"><i class="fa-solid fa-chalkboard-user"></i> <span class="hidden">Proffesseur</span> </li>
                <?php if(isset($_SESSION['connecte']) && $_SESSION['connecte'] == true): ?>
                    <li class="bottoM" data-anim="5"><a href="deconnection.php" ><i class="fa-solid fa-right-to-bracket"></i> <span class="hidden">deconnexion</span> </a></li>  
                 <?php  else: ?>
                        <li class="bottoM" data-anim="5"><a href="formulaire/design-connexion.php" target="_blank" id="lien_connexion" ><i class="fa-solid fa-right-to-bracket"></i> <span class="hidden">connexion</span> </a></li>   
                 <?php endif;?>    


            </ul>
        </div>
        
   </div>
   <section class="contenu activecontenu contenu1" data-anim="1">

        <div class="home">
            <div class="welcom"><h2>bienvenue</h2></div>
                
        </div>
        <h3 class="title-stat">Statistique</h3>
        <div class="stat"> 

            <div class="box-element-stat">
                    <div class="libelle-stat note">
                        <i class="fa-solid fa-book"></i>
                        <h3> <?= "$noteTotal"?></h3>
                        <h3 class="title-lib">nombre de note</h3>
                    </div>

                    <div class="libelle-stat matiere">
                        <i class="fa-solid fa-pen-ruler"></i>
                        <h3><?= "$matiTotal"?></h3>
                        <h3 class="title-lib">nombre de matiere</h3>
                    </div>

                    <div class="libelle-stat proffesseur">
                            <i class="fa-solid fa-chalkboard-user"></i>
                            <h3><?= "$profTotal"?></h3>
                        <h3 class="title-lib">nombre de proffesseur</h3>
                    </div>
                        
                </div>
                
            <div class="evenement">
                        <h1 class="title-lib-event">evenement</h1>
                    </div>
        </div>
</section>
   <section class="contenu activecontenu contenu2" data-anim="2">    

            
                      <div class="barre">
                                <h1 class="btn-ajout navBtn-Ajout"><i class="fa-solid fa-plus"></i> Ajouter note</h1>
                                <h1 class="btnAjoutMati navBtn-Ajout"><i class="fa-solid fa-plus"></i> Ajouter matiere</h1>
                                <h1 class="btnAjoutPro navBtn-Ajout"><i class="fa-solid fa-plus"></i> Ajouter proffesseur</h1>
                                <h1 class="btnAjouteven navBtn-Ajout"><i class="fa-solid fa-plus"></i> Ajouter evenement</h1>
                      </div>

                      
                      <div class="all_form">
                                <div class="box-form">
                                    <div class="close">
                                            <button hidden class="btn-close">&times;</button>
                                        <h1>ajout de note</h1>
                                    </div>
                                        <div class="formulaire">
                                                    <form action="insertion_note.php" method="post" class="forMuLaire" name="forMuLaire" >
                                                        <select name="id_matiere" required>
                                                            <option value="">-- Choisir une matiere --</option>
                                                            <?php foreach($LesMatiere as $mat): ?>
                                                                <option value="<?= htmlspecialchars($mat['id_matiere'])?>">
                                                                    <?= htmlspecialchars($mat['libelle_mat'])?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select><br>
                                                        <select name="id_periodeNote" required> 
                                                            <option value="">-- Choisir la periode --</option>
                                                            <?php foreach($LesPriodes as $Periode): ?>
                                                                <option value="<?= htmlspecialchars($Periode['id_periodeNote'])?>">
                                                                    <?= htmlspecialchars($Periode['periode'])?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select><br>
    
                                                         <select name="id_prof" required>
                                                            <option value="">-- Choisir un prof --</option>
                                                            <?php foreach($professeur as $prof):?>
                                                                <option value="<?= htmlspecialchars($prof['id_prof']) ?>">
                                                                    <?= htmlspecialchars($prof['nom']) . " " . htmlspecialchars($prof['prenom']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select><br>
                                                        <input type="date" placeholder="date" name="date_note" ><br>
                                                         <input type="number" placeholder="note" name="note" step="0.5" min="0" max="20"><br>
                                                        <input type="submit" value="Enregistre" class="btn-subm" name="Enregistre">
                                                    </form>
                                                
                                        </div>   

                            </div>

                            <div class="form_matiere">
                                    <div class="close">
                                            <button hidden class="btn-close">&times;</button>
                                        <h1>ajout de matiere</h1>
                                    </div>
                                        <div class="formulaire">
                                                    <form action="insertion_matiere.php" method="post" class="forMuLaire" name="formu_mati" >
                                                        <input type="text" placeholder="libelle matiere" name="libelle_mat" required><br>
                                                        <input type="number" placeholder="coefficient" name="coefficient" min="0.01" step="0.01" required><br>
                                                        <input type="number" placeholder="nombre heure" name="Heure" min="0" required> <br>
                                                        <select name="id_prof" required>
                                                            <option value="">-- Choisir un professeur --</option>
                                                            <?php foreach($professeur as $prof): ?>
                                                                <option value="<?= htmlspecialchars($prof['id_prof']) ?>">
                                                                    <?= htmlspecialchars($prof['nom']) . " " . htmlspecialchars($prof['prenom']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select><br>
                                                        <input type="submit" value="Enregistre" class="btn-subm" name="Enregistre">
                                                    </form>                    
                                        </div>   

                            </div>
                            <div class=" form_pro">
                                    <div class="close">
                                            <button hidden class="btn-close">&times;</button>
                                        <h1>ajout de proffesseur</h1>
                                    </div>
                                        <div class="formulaire">
                                                    <form action="insertion_proffesseurs.php" method="post" class="forMuLaire" name="forMu_pro" >
                                                        <input type="text" placeholder="nom " name="nom"><br>
                                                        <input type="text" placeholder="prenom" name="prenom"><br>
                                                        <input type="tel" placeholder="0XXXXXXXXX" name="tel" ><br>
                                                        <input type="text" placeholder="jours de cours" name="jcours"><br>
                                                        <select name="id_matiere" required>
                                                            <option value="">-- Choisir une matiere --</option>
                                                            <?php foreach($LesMatiere as $mati): ?>
                                                                <option value="<?= htmlspecialchars($mati['id_matiere']) ?>">
                                                                    <?= htmlspecialchars($mati['libelle_mat']) ?>
                                                                </option>
                                                            <?php endforeach;?>
                                                        </select><br>
                                                        
                                                        <input type="submit" value="Enregistre" class="btn-subm" name="Enregistre" >
                                                    </form>
                                                
                                        </div>   

                            </div>
                      </div>
                                 
                                
</section>
<section class="contenu contenu6 " data-anim="6">
    <h1>profile</h1>
     <div class="box-sesion">
        
         <div class="session_ui">
            <div class="sec-photo">
                <div class="box-photo">
                    <div class="photo_ui"></div>
                </div>
                <div class="action_nom-p">
                    <button>Ajouter une nouvel photo</button>
                    <h3><?php echo htmlspecialchars($_SESSION['nom'] ?? '')." ".htmlspecialchars($_SESSION['prenom'] ?? '')?></h3>
                </div>
             </div>                                                    
                
                <div class="sec-detail">
                        <div class="title_detail_info">
                            <h3>info perso</h3>   <button>edit</button>                                               
                        </div>                                                               
                <div class="box_detail">
                    <div class="boxEl">
                        <h3>date de naissance</h3><br>
                        <span>naissance</span>
                    </div>
                    <div class="boxE2">
                        <h3>Gmail</h3><br>
                        <span><?php echo $_SESSION['gmail'] ?></span>
                    </div>
                    <div class="boxE3">
                        <h3>telephone</h3><br>  
                    </div>                                                   
                </div>                                                
            </div>
            <div class="sec-detail">
                        <div class="title_detail_info">
                            <h3>info scolaire</h3><button>edit</button>                                               
                        </div>                                                               
                <div class="box_detail">
                    <div class="boxEl">
                        <h3>matricule</h3><br>
                        <span>ex:16047685H</span>
                    </div>
                    <div class="boxE2">
                        <h3>filiere</h3><br>
                    </div>
                    <div class="boxE3">
                        <h3>classe</h3><br>  
                    </div>                                                   
                </div>                                                
            </div>
        </div>
          
    </div>
        
</section> 
<!-- page des matiere--> 
   <section class="contenu contenu3 " data-anim="3">
        <div class="liste_matiere">
            <h1>liste des matieres</h1> <br>
               <?php if(empty($LesMatiere)):?>  
                <p>aucune matiere enregistre</p>
                <?php else:?> 
                    <?php foreach($LesMatiere as $matter):?>
                        <div class="item-matiere" data-id="<?= htmlspecialchars($matter['id_matiere'])?>">
                            <?= htmlspecialchars($matter['libelle_mat'])?>
                        </div>     
                    <?php endforeach ;?>
                <?php endif;?>              
        </div>      
                        <p class="messagEvide" id="messagEvide">cliquez sur une matiere pour voir ses informations</p>
        <div class="info_matiere" id="info_matiere">
            
            <div class="info_detail">
            <h1 id="infoLib">libelle</h1>
             <strong>Coefficient: </strong><span id="infocoeff"></span><br>
            <strong>professeur: </strong><span id="infoPrenom"></span> <br>            
            <strong>Heure: </strong><span id="infoHeure"></span><br>
            
         </div>
        <div class="info_Note_moy">
            <div class="onglet_period">
                <div class="box_onglet">
                    <button class="btn_sem1_mat  active_periode sem" data-periode="1">Semestre 1</button>
                    <button class="btn_sem2_mat sem" data-periode="2">Semestre 2</button>
                </div>
                <div class="conteneur_sem1 Cont_periode" data-periode="1">
                    <h1>Semestre 1</h1>
                    
                </div>
                <div class="conteneur_sem2 Cont_periode" data-periode="2"><h1>Semestre 1</h1></div>
            </div>
            <div class="calcule_moy">
                <h1>Calcul de moyenne</h1>
            </div>
        </div>
        </div>

   
        
</section>
   <section class="contenu contenu4 " data-anim="4">
    
    <div class="liste_prof" id="liste_prof">
        <h1>Professeur</h1>

        <?php if(empty($professeur)): ?>
            <p>Aucun professeur enregistré</p>
        <?php else: ?>
            <?php foreach($professeur as $prof): ?>
                <div class="item-prof" data-id="<?= htmlspecialchars($prof['id_prof']) ?>">
                    <a href="filtre.php?id_prof=<?= htmlspecialchars($prof['id_prof']) ?>" onclick="return confirm('voulez vous vraiment modifier ce professeur ?');"> <button type="button" class="delete modifie"><i class="fa-solid fa-recycle"></i></button></a>
                                <a href="suppProf.php?del=<?= htmlspecialchars($prof['id_prof']) ?>" onclick="return confirm('voulez vous vraiment supprimer ce professeur ?');"> <button type="button" class="delete"><i class="fa-regular fa-trash-can"></i></button></a>
                              
                    <?= htmlspecialchars($prof['nom']) . " " . htmlspecialchars($prof['prenom']) ?>
                </div>    
            <?php endforeach; ?>
        <?php endif; ?> 
    </div>

    <p id="messageVide" class="messageVide">cliquez sur un professeur pour voir ses informations</p>
<div class="info_prof" id="info_prof">
                
        <div class="info_detail">
            <h1 id="infoNom">Nom</h1>
             <strong>prenom: </strong><span id="infoPreNom"></span> <br>

            <strong>Numéro de téléphone: </strong><span id="infoTel"></span><br>
            <strong>Matière: </strong><span id="infoMatiere"></span><br>
            <strong>Disponibilité: </strong><span id="infoDispo"></span><br>
        </div>
        <div class="info_Note_moy">
            <div class="onglet_period">
                <div class="box_onglet">
                    <button class="btn_sem1 sem active_periode" data-periode="1">Semestre 1</button>
                    <button class="btn_sem2  sem"  data-periode="2">Semestre 2</button>
                </div>
                <div class="conteneur_sem1 Cont_periode conteneur_periode" data-periode="1" >
                    <h1>Semestre 1</h1>
                    <button id="btnCalculMoy1" type="button">calcule</button>
                    <div id="notesProfesseur">
                        <p>Aucune note enregistré.</p>
                    </div>
                    <div id="moyenneMatiere">

                        <p>Aucune moyenne</p>
                        
                    </div>
                </div>
                <div class="conteneur_sem2 Cont_periode " data-periode="2">
                    <h1>Semestre 2</h1>
                    <button type="button">calcule</button>
            </div>
            </div>
            <div class="calcule_moy">
                <h1>Calcul de moyenne</h1>
            </div>
        </div>
    </div>
</section>
   <section class="contenu " data-anim="5">
        <h1>connexion</h1>
        
</section> 

   <script src="ongles.js"></script>
   <script src="chargerInfo_prof.js"></script>
   <script src="chargerInfo_matier.js"></script>
                            
</body>
</html>