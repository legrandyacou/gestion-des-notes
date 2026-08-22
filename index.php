 <?php
                    session_start();
                        require_once "db_connexion.php";
                                                
                       $sql = "SELECT COUNT(*) FROM note ";
                  $query = $PDO->query($sql);
                  $noteTotal = $query->fetchColumn();
               //professeur                                           
           $smt = $PDO->query("SELECT id_prof,nom,prenom,tel,jcours,id_matiere FROM professeurs");
          $professeur = $smt->fetchAll(PDO::FETCH_ASSOC);
          //matiere
          $stmMati = $PDO->query("SELECT id_matiere,libelle,coefficient,heure FROM matieres");
          $LesMatiere = $stmMati->fetchAll(PDO::FETCH_ASSOC);
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
        <div class="photo"> <i class="fa-solid fa-circle-user"></i></div>
        <div class="list-side">
            <ul>
                <li id="active" class="active" data-anim="1"> <i class="fa-solid fa-house"></i> Acceuil</li>
                <li data-anim="2"> <i class="fa-solid fa-book"></i>Ajoute</li>
                <li data-anim="3"> <i class="fa-solid fa-pen-ruler"></i> Matiere</li>
                <li data-anim="6"> <i class="fa-solid fa-pen-ruler"></i> profile</li>
                <li data-anim="4"><i class="fa-solid fa-chalkboard-user"></i> Proffesseur</li>
                <li class="bottoM" data-anim="5"><i class="fa-solid fa-right-to-bracket"></i> connexion</li>  


            </ul>
        </div>
        
   </div>
   <section class="contenu " data-anim="1">
        <div class="menu">
            <h1>Acceuil</h1> 

            <button class="btn_connexion"><i class="fa-solid fa-right-to-bracket"></i> connexion</button>
        </div>

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
                        <h3>15</h3>
                        <h3 class="title-lib">nombre de matiere</h3>
                    </div>

                    <div class="libelle-stat proffesseur">
                            <i class="fa-solid fa-chalkboard-user"></i>
                            <h3>15</h3>
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
                                <h1 class="btn-ajout"><i class="fa-solid fa-plus"></i> Ajouter note</h1>
                                <h1 class="btnAjoutMati"><i class="fa-solid fa-plus"></i> Ajouter matiere</h1>
                                <h1 class="btnAjoutPro"><i class="fa-solid fa-plus"></i> Ajouter proffesseur</h1>
                      </div>

                      
                      <div class="all_form">
                                <div class="box-form">
                                    <div class="close">
                                            <button hidden class="btn-close">&times;</button>
                                        <h1>ajout de note</h1>
                                    </div>
                                        <div class="formulaire">
                                                    <form action="insertion_note.php" method="post" class="forMuLaire" name="forMuLaire" >
                                                        <input type="text" placeholder="libelle matiere" name="libelle"><br>
                                                        <input type="date" placeholder="date" name="date_note" ><br>
                                                         <input type="number" placeholder="note" name="note" step="0.5" min="0" max="20"> <br>
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
                                                        <input type="text" placeholder="libelle matiere" name="libelle"><br>
                                                        <input type="number" placeholder="coefficient" name="coefficient" ><br>
                                                        <input type="number" placeholder="nombre heure" name="Heure"> <br>
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
                                                        <input type="text" placeholder="jours de cours" name="jcours"> <br>
                                                        <select name="id_matiere" required>
                                                            <option value="">-- Choisir une matiere --</option>
                                                            <?php foreach($LesMatiere as $mati): ?>
                                                                <option value="<?= htmlspecialchars($mati['id_matiere']) ?>">
                                                                    <?= htmlspecialchars($mati['libelle']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
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
                    <h3><?php echo $_SESSION['nom']." ".$_SESSION['prenom'] ?></h3>
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
                        <h3> Gmail</h3><br>
                        <span><?php echo $_SESSION['gmail'] ?></span>
                    </div>
                    <div class="boxE3">
                        <h3>telephone</h3><br>  
                    </div>                                                   
                </div>                                                
            </div>
            <div class="sec-detail">
                        <div class="title_detail_info">
                            <h3>info scolaire</h3>   <button>edit</button>                                               
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
                            <?= htmlspecialchars($matter['libelle'])?>
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
                    <button class="btn_sem1 sem" data-periode="1">Semestre 1</button>
                    <button class="btn_sem2 sem" data-periode="2">Semestre 2</button>
                </div>
                <div class="conteneur_sem1 Cont_periode" data-periode="1"><h1>Semestre 1</h1></div>
                <div class="conteneur_sem2 Cont_periode" data-periode="2"><h1>Semestre 2</h1></div>
            </div>
            <div class="calcule_moy">
                <h1>Calcul de moyenne</h1>
            </div>
        </div>
        </div>

   
        
</section>
   <section class="contenu contenu4 activecontenu" data-anim="4">
    
    <div class="liste_prof" id="liste_prof">
        <h1>Professeur</h1>

        <?php if(empty($professeur)): ?>
            <p>Aucun professeur enregistré</p>
        <?php else: ?>
            <?php foreach($professeur as $prof): ?>
                <div class="item-prof" data-id="<?= htmlspecialchars($prof['id_prof']) ?>">
                    <a href="" onclick="return confirm('voulez vous vraiment modifie cet proffesseur ?');"> <button class="delete modifie"><i class="fa-solid fa-recycle"></i></button></a>
                                <a href="" onclick="return confirm('voulez vous vraiment supprimer cet proffesseur ?');"> <button class="delete"><i class="fa-regular fa-trash-can"></i></button></a>
                              
                    <?= htmlspecialchars($prof['nom']) . " " . htmlspecialchars($prof['prenom']) ?>
                </div>    
            <?php endforeach; ?>
        <?php endif; ?> 
    </div>

    <p id="messageVide" class="messageVide">cliquez sur un professeur pour voir ses informations</p>
<div class="info_prof" id="info_prof">
                
        <div class="info_detail">
            <h1 id="infoNom">Nom</h1>
             <strong>prenom: </strong><span id="infoPrenom"></span> <br>

            <strong>Numéro de téléphone: </strong><span id="infoTel"></span><br>
            <strong>Matière: </strong><span id="infoMatiere"></span><br>
            <strong>Disponibilité: </strong><span id="infoDispo"></span><br>
        </div>
        <div class="info_Note_moy">
            <div class="onglet_periode">
                <div class="box_onglet">
                    <button class="btn_sem1 sem " data-periode="1">Semestre 1</button>
                    <button class="btn_sem2 active_periode sem" data-periode="2">Semestre 2</button>
                </div>
                <div class="conteneur_sem1 Cont_periode" data-periode="1" ><h1>Semestre 1</h1></div>
                <div class="conteneur_sem2 Cont_periode" data-periode="2"><h1>Semestre 2</h1></div>
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