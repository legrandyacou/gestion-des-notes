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
          $stmNotes = $PDO->query("SELECT id_note,libelle_mat,date_note,note,id_prof,id_matiere FROM note ORDER BY date_note DESC, id_note DESC LIMIT 5");
          $LesNote = $stmNotes->fetchAll(PDO::FETCH_ASSOC);
          $moyennesPeriodes = [1 => null, 2 => null, 3 => null];
          $stmMoyennes = $PDO->query(
              "SELECT notes_par_matiere.id_periodeNote,
                      SUM(notes_par_matiere.moyenne * matieres.coefficient)
                          / NULLIF(SUM(matieres.coefficient), 0) AS moyenne
               FROM (
                   SELECT id_periodeNote, id_matiere, AVG(note) AS moyenne
                   FROM note
                   WHERE id_periodeNote IN (1, 2, 3)
                   GROUP BY id_periodeNote, id_matiere
               ) AS notes_par_matiere
               INNER JOIN matieres ON matieres.id_matiere = notes_par_matiere.id_matiere
               GROUP BY notes_par_matiere.id_periodeNote"
          );
          foreach ($stmMoyennes->fetchAll(PDO::FETCH_ASSOC) as $moyennePeriode) {
              if ($moyennePeriode['moyenne'] !== null) {
                  $moyennesPeriodes[(int) $moyennePeriode['id_periodeNote']] = (float) $moyennePeriode['moyenne'];
              }
          }
          $periodesRenseignees = array_filter($moyennesPeriodes, static fn($moyenne) => $moyenne !== null);
          $moyenneAnnuelle = $periodesRenseignees
              ? array_sum($periodesRenseignees) / count($periodesRenseignees)
              : null;
          //Periode
          $stmNotes = $PDO->query("SELECT id_periodeNote,periode FROM periodenotes");
          $LesPriodes = $stmNotes->fetchAll(PDO::FETCH_ASSOC);
 ?> 
                                        
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord | Gestion des notes</title>
    <link rel="shortcut icon" href="images/icons8-edit-property-96.png" type="image/x-icon">
    <link rel="stylesheet" href="style-index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<!--ligne de tailwind css-->
 <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
<body>
   <div class="side-baar">
       
        <div class="list-side">
            <a class="sidebar-brand" href="index.php">
                <span class="sidebar-brand-icon"><i class="fa-solid fa-graduation-cap"></i></span>
                <span class="sidebar-brand-name">Note<span>Flow</span><small>GESTION SCOLAIRE</small></span>
            </a>
           
            <ul>
                <li id="active" class="active" data-anim="1"> <i class="fa-solid fa-house"></i> <span class="">Accueil</span> </li>
                <li data-anim="2"> <i class="fa-solid fa-book"></i> <span >Ajouter</span> </li>
                <li data-anim="3"> <i class="fa-solid fa-pen-ruler"></i> <span >Matières</span> </li>
                <li data-anim="6">  <i class="fa-solid fa-circle-user"></i> <span >Profil</span> </li>
                <li data-anim="4"><i class="fa-solid fa-chalkboard-user"></i> <span >Professeurs</span> </li>
                <?php if(isset($_SESSION['connecte']) && $_SESSION['connecte'] == true): ?>
                    <h4 style="position: absolute;
                    bottom: 70px;width: 130px; color:#fff;margin-bottom: 10px;
                   "><?php echo htmlspecialchars($_SESSION['nom']?? '')?></h4>
                    <li class="bottoM" data-anim="5"><a href="deconnection.php" ><i class="fa-solid fa-right-from-bracket"></i> <span >Déconnexion</span> </a></li>
                 <?php  else: ?>
                        <li class="bottoM" data-anim="5"><a href="formulaire/design-connexion.php" target="_blank" id="lien_connexion" ><i class="fa-solid fa-right-to-bracket"></i> <span class="hidden">connexion</span> </a></li>   
                 <?php endif;?>    


            </ul>
        </div>
        
   </div>
   <section class="contenu activecontenu contenu1 dashboard" data-anim="1">
        <header class="dashboard-hero">
            <div class="dashboard-hero-top">
                <span class="dashboard-eyebrow">ESPACE DE GESTION</span>
                <span class="dashboard-date"><i class="fa-regular fa-calendar"></i> <?= htmlspecialchars(date('d/m/Y'), ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="dashboard-hero-content">
                <div>
                    <p class="dashboard-greeting">Bonjour,</p>
                    <h1><?= htmlspecialchars($_SESSION['nom'] ?? 'Bienvenue', ENT_QUOTES, 'UTF-8') ?></h1>
                    <p class="dashboard-subtitle">Retrouvez en un coup d’œil le suivi de vos notes et de votre équipe pédagogique.</p>
                </div>
                <button type="button" class="dashboard-action navBtn-Ajout" data-form="1">
                    <i class="fa-solid fa-plus"></i> Ajouter une note
                </button>
            </div>
        </header>

        <section class="dashboard-section" aria-labelledby="stats-title">
            <div class="dashboard-section-heading">
                <div>
                    <p class="dashboard-kicker">VOTRE ACTIVITÉ</p>
                    <h2 id="stats-title">Vue d’ensemble</h2>
                </div>
                <span class="dashboard-caption">Les données de votre espace</span>
            </div>
            <div class="dashboard-stats">
                <article class="dashboard-stat dashboard-stat-notes">
                    <span class="dashboard-stat-icon"><i class="fa-solid fa-book-open"></i></span>
                    <div>
                        <p>Notes enregistrées</p>
                        <strong><?= (int) $noteTotal ?></strong>
                    </div>
                    <span class="dashboard-stat-mark"><i class="fa-solid fa-arrow-trend-up"></i></span>
                </article>
                <article class="dashboard-stat dashboard-stat-subjects">
                    <span class="dashboard-stat-icon"><i class="fa-solid fa-book"></i></span>
                    <div>
                        <p>Matières</p>
                        <strong><?= (int) $matiTotal ?></strong>
                    </div>
                    <span class="dashboard-stat-mark"><i class="fa-solid fa-layer-group"></i></span>
                </article>
                <article class="dashboard-stat dashboard-stat-teachers">
                    <span class="dashboard-stat-icon"><i class="fa-solid fa-chalkboard-user"></i></span>
                    <div>
                        <p>Professeurs</p>
                        <strong><?= (int) $profTotal ?></strong>
                    </div>
                    <span class="dashboard-stat-mark"><i class="fa-solid fa-users"></i></span>
                </article>
            </div>
        </section>

        <section class="dashboard-lower">
            <div class="dashboard-panel dashboard-averages">
                <div class="dashboard-panel-heading">
                    <div>
                        <p class="dashboard-kicker">RÉSULTATS SCOLAIRES</p>
                        <h2>Moyennes des périodes</h2>
                    </div>
                    <span class="dashboard-panel-icon dashboard-average-icon"><i class="fa-solid fa-chart-line"></i></span>
                </div>
                <div class="dashboard-average-grid">
                    <?php foreach ($moyennesPeriodes as $numeroPeriode => $moyennePeriode): ?>
                        <article class="dashboard-average-card">
                            <div class="dashboard-average-label">
                                <span>Période <?= (int) $numeroPeriode ?></span>
                                <i class="fa-regular fa-circle-check"></i>
                            </div>
                            <?php if ($moyennePeriode !== null): ?>
                                <strong><?= number_format($moyennePeriode, 2, ',', ' ') ?><span>/20</span></strong>
                                <div class="dashboard-average-track" role="progressbar" aria-label="Moyenne de la période <?= (int) $numeroPeriode ?>" aria-valuemin="0" aria-valuemax="20" aria-valuenow="<?= number_format($moyennePeriode, 2, '.', '') ?>">
                                    <span style="width: <?= number_format(min(100, max(0, $moyennePeriode / 20 * 100)), 2, '.', '') ?>%"></span>
                                </div>
                            <?php else: ?>
                                <strong class="dashboard-average-missing">—<span>/20</span></strong>
                                <p class="dashboard-average-hint">Aucune note enregistrée</p>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                    <article class="dashboard-average-card dashboard-average-annual">
                        <div class="dashboard-average-label">
                            <span>Moyenne annuelle</span>
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <?php if ($moyenneAnnuelle !== null): ?>
                            <strong><?= number_format($moyenneAnnuelle, 2, ',', ' ') ?><span>/20</span></strong>
                            <div class="dashboard-average-track" role="progressbar" aria-label="Moyenne annuelle" aria-valuemin="0" aria-valuemax="20" aria-valuenow="<?= number_format($moyenneAnnuelle, 2, '.', '') ?>">
                                <span style="width: <?= number_format(min(100, max(0, $moyenneAnnuelle / 20 * 100)), 2, '.', '') ?>%"></span>
                            </div>
                        <?php else: ?>
                            <strong class="dashboard-average-missing">—<span>/20</span></strong>
                            <p class="dashboard-average-hint">En attente des premières notes</p>
                        <?php endif; ?>
                    </article>
                </div>
                <p class="dashboard-average-footnote">Moyennes pondérées par coefficient. La moyenne annuelle est calculée à partir des périodes renseignées.</p>
            </div>

            <div class="dashboard-panel dashboard-recent hidden"> 
                <div class="dashboard-panel-heading " >
                    <div>
                        <p class="dashboard-kicker">SUIVI SCOLAIRE</p>
                        <h2>Notes récentes</h2>
                    </div>
                    <span class="dashboard-panel-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
                </div>
                <?php if (empty($LesNote)): ?>
                    <div class="dashboard-empty">
                        <span><i class="fa-solid fa-clipboard-list"></i></span>
                        <p>Aucune note pour le moment.</p>
                        <button type="button" class="dashboard-text-action navBtn-Ajout" data-form="1">Enregistrer votre première note <i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                <?php else: ?>
                    <div class="dashboard-note-list">
                        <?php foreach ($LesNote as $note): ?>
                            <article class="dashboard-note">
                                <span class="dashboard-note-icon"><i class="fa-solid fa-file-lines"></i></span>
                                <div class="dashboard-note-info">
                                    <h3><?= htmlspecialchars($note['libelle_mat'], ENT_QUOTES, 'UTF-8') ?></h3>
                                    <time datetime="<?= htmlspecialchars($note['date_note'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(date('d/m/Y', strtotime($note['date_note'])), ENT_QUOTES, 'UTF-8') ?></time>
                                </div>
                                <strong class="dashboard-grade"><?= htmlspecialchars((string) $note['note'], ENT_QUOTES, 'UTF-8') ?><span>/20</span></strong>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <aside class="dashboard-panel dashboard-shortcuts">
                <div class="dashboard-panel-heading">
                    <div>
                        <p class="dashboard-kicker">ACCÈS RAPIDE</p>
                        <h2>Que souhaitez-vous faire ?</h2>
                    </div>
                </div>
                <button type="button" class="dashboard-shortcut navBtn-Ajout" data-form="1">
                    <span class="shortcut-icon"><i class="fa-solid fa-square-plus"></i></span>
                    <span><strong>Ajouter une note</strong><small>Enregistrer une nouvelle évaluation</small></span>
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
                <button type="button" class="dashboard-shortcut" data-dashboard-tab="3">
                    <span class="shortcut-icon shortcut-icon-blue"><i class="fa-solid fa-book-open"></i></span>
                    <span><strong>Consulter les matières</strong><small>Voir les matières et coefficients</small></span>
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
                <button type="button" class="dashboard-shortcut" data-dashboard-tab="4">
                    <span class="shortcut-icon shortcut-icon-purple"><i class="fa-solid fa-user-group"></i></span>
                    <span><strong>Gérer les professeurs</strong><small>Consulter l’équipe pédagogique</small></span>
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
                <div class="dashboard-tip">
                    <i class="fa-regular fa-lightbulb"></i>
                    <p><strong>Astuce</strong><br>Enregistrez régulièrement les notes pour garder un suivi à jour.</p>
                </div>
            </aside>
        </section>
   </section>
   <section class="contenu contenu2 " data-anim="2">

            
                      <div class="barre">
                                <button type="button" class="active navBtn-Ajout" data-form="1"><i class="fa-solid fa-plus"></i> Ajouter note</button>
                                <button type="button" class="navBtn-Ajout" data-form="2"><i class="fa-solid fa-plus"></i> Ajouter matiere</button>
                                <button type="button" class="navBtn-Ajout" data-form="3"><i class="fa-solid fa-plus"></i> Ajouter professeur</button>
                      </div>

                      
                      <div class="all_form" aria-hidden="true">
                                <div class="box-form form-dialog" data-form="1" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="form-note-title" tabindex="-1">
                                    <div class="close">
                                        <div>
                                            
                                            <h1 id="form-note-title">Ajouter une note</h1>
                                            <p class="form-description">Renseignez les informations de l’évaluation.</p>
                                        </div>
                                        <button type="button" class="btn-close" aria-label="Fermer le formulaire">&times;</button>
                                    </div>
                                        <div class="formulaire">
                                                    <form action="insertion_note.php" method="post" class="forMuLaire" name="forMuLaire" >
                                                        <div class="form-field">
                                                            <label for="note-matiere">Matière </label>
                                                            <select id="note-matiere" name="id_matiere" required>
                                                                <option value="">Choisir une matière</option>
                                                                <?php foreach($LesMatiere as $mat): ?>
                                                                    <option value="<?= htmlspecialchars($mat['id_matiere'])?>">
                                                                        <?= htmlspecialchars($mat['libelle_mat'])?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-field">
                                                            <label for="note-periode">Période scolaire </label>
                                                            <select id="note-periode" name="id_periodeNote" required>
                                                                <option value="">Choisir une période</option>
                                                                <?php foreach($LesPriodes as $Periode): ?>
                                                                    <option value="<?= htmlspecialchars($Periode['id_periodeNote'])?>">
                                                                        <?= htmlspecialchars($Periode['periode'])?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-field">
                                                            <label for="note-professeur">Professeur </label>
                                                            <select id="note-professeur" name="id_prof" required>
                                                                <option value="">Choisir un professeur</option>
                                                                <?php foreach($professeur as $prof):?>
                                                                    <option value="<?= htmlspecialchars($prof['id_prof']) ?>">
                                                                        <?= htmlspecialchars($prof['nom']) . " " . htmlspecialchars($prof['prenom']) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-field">
                                                            <label for="note-date">Date de l’évaluation </label>
                                                            <input id="note-date" type="date" name="date_note" required>
                                                        </div>
                                                        <div class="form-field">
                                                            <label for="note-valeur">Note sur 20 </label>
                                                            <input id="note-valeur" type="number" name="note" step="0.5" min="0" max="20" placeholder="Ex. 15,5" required aria-describedby="note-hint">
                                                            <small id="note-hint">Valeur comprise entre 0 et 20.</small>
                                                        </div>
                                                        <button type="submit" class="btn-subm" name="Enregistre"><i class="fa-solid fa-check"></i> Enregistrer la note</button>
                                                    </form>
                                                
                                        </div>   

                            </div>

                            <div class="form_matiere form-dialog" data-form="2" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="form-matiere-title" tabindex="-1">
                                    <div class="close">
                                        <div>
                                            <p class="form-eyebrow">CATALOGUE SCOLAIRE</p>
                                            <h1 id="form-matiere-title">Ajouter une matière</h1>
                                            <p class="form-description">Définissez la matière et son organisation.</p>
                                        </div>
                                        <button type="button" class="btn-close" aria-label="Fermer le formulaire">&times;</button>
                                    </div>
                                        <div class="formulaire">
                                                    <form action="insertion_matiere.php" method="post" class="forMuLaire" name="formu_mati" >
                                                        <div class="form-field">
                                                            <label for="matiere-libelle">Nom de la matière </label>
                                                            <input id="matiere-libelle" type="text" placeholder="Ex. Mathématiques" name="libelle_mat" required>
                                                        </div>
                                                        <div class="form-field">
                                                            <label for="matiere-coefficient">Coefficient </label>
                                                            <input id="matiere-coefficient" type="number" placeholder="Ex. 2" name="coefficient" min="0.01" step="0.01" required>
                                                        </div>
                                                        <div class="form-field">
                                                            <label for="matiere-heures">Nombre d’heures </label>
                                                            <input id="matiere-heures" type="number" placeholder="Ex. 4" name="Heure" min="0" required>
                                                        </div>
                                                        <div class="form-field">
                                                            <label for="matiere-professeur">Professeur référent </label>
                                                            <select id="matiere-professeur" name="id_prof" required>
                                                                <option value="">Choisir un professeur</option>
                                                                <?php foreach($professeur as $prof): ?>
                                                                    <option value="<?= htmlspecialchars($prof['id_prof']) ?>">
                                                                        <?= htmlspecialchars($prof['nom']) . " " . htmlspecialchars($prof['prenom']) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn-subm" name="Enregistre"><i class="fa-solid fa-check"></i> Enregistrer la matière</button>
                                                    </form>                    
                                        </div>   

                            </div>
                            <div class="box-form form_pro form-dialog" data-form="3" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="form-prof-title" tabindex="-1">
                                    <div class="close">
                                        <div>
                                            <p class="form-eyebrow">ÉQUIPE PÉDAGOGIQUE</p>
                                            <h1 id="form-prof-title">Ajouter un professeur</h1>
                                            <p class="form-description">Ajoutez les coordonnées et la matière enseignée.</p>
                                        </div>
                                        <button type="button" class="btn-close" aria-label="Fermer le formulaire">&times;</button>
                                    </div>
                                        <div class="formulaire">
                                                    <form action="insertion_proffesseurs.php" method="post" class="forMuLaire" name="forMu_pro" >
                                                        <div class="form-field">
                                                            <label for="prof-nom">Nom </label>
                                                            <input id="prof-nom" type="text" placeholder="Nom de famille" name="nom" autocomplete="family-name" required>
                                                        </div>
                                                        <div class="form-field">
                                                            <label for="prof-prenom">Prénom </label>
                                                            <input id="prof-prenom" type="text" placeholder="Prénom" name="prenom" autocomplete="given-name" required>
                                                        </div>
                                                        <div class="form-field">
                                                            <label for="prof-telephone">Téléphone </label>
                                                            <input id="prof-telephone" type="tel" placeholder="Ex. 05 00 00 00 00" name="tel" autocomplete="tel" required>
                                                        </div>
                                                        <div class="form-field">
                                                            <label for="prof-jours">Jours de cours </label>
                                                            <input id="prof-jours" type="text" placeholder="Ex. Lundi et jeudi" name="jcours" required>
                                                        </div>
                                                        <div class="form-field">
                                                            <label for="prof-matiere">Matière enseignée </label>
                                                            <select id="prof-matiere" name="id_matiere" required>
                                                                <option value="">Choisir une matière</option>
                                                                <?php foreach($LesMatiere as $mati): ?>
                                                                    <option value="<?= htmlspecialchars($mati['id_matiere']) ?>">
                                                                        <?= htmlspecialchars($mati['libelle_mat']) ?>
                                                                    </option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                        
                                                        <button type="submit" class="btn-subm" name="Enregistre"><i class="fa-solid fa-check"></i> Enregistrer le professeur</button>
                                                    </form>
                                                
                                        </div>   

                            </div>
                      </div>
                                 
                                
</section>
<section class="contenu contenu_profile " data-anim="6">
    
     <div class="h-[70vh] w-[50%] rounded-[10px] p-[10px] text-white shadow-md bg-[#17233b]">
            <div class="cteneurPhoto_nom ">
                <div>
                    <div class="imgProfile"></div>
                </div>
                    <div>
                        <button class="photo_Ajout">Ajouter une photo</button>
                    
                    <h3 class="nom_u"><?php echo htmlspecialchars($_SESSION['nom'] ?? '')." ".htmlspecialchars($_SESSION['prenom'] ?? '')?></h3>
                    
                    </div>
                    
            </div>
            <div class="infoPerso">
                    <h2>Information Personnel</h2>
                    <div class="info_Personnel">
                        <div>
                            <h3>Date de naissance</h3>
                            <span></span>
                        </div>
                        <div>
                            <h3>Gmail</h3>
                            <span><?php echo htmlspecialchars( $_SESSION['gmail']??'')?></span>
                        </div>
                        <div>
                            <h3>Telephone</h3>
                            <span>05 96 04 86 85</span>
                        </div>
                        
                    </div>
            </div>
            <div class="infoScolaire">
                    <h2>Information scolaire</h2>
                    <div class="info_Scolaire">
                        <div>
                            <h3>Matricule</h3>
                            <span>16 047 151 H</span>
                        </div>
                        <div><h3>Filiere</h3> <span></span></div>
                        <div><h3>Classe</h3> <span></span></div>
                    </div>
            </div>
        </div>
        
</section> 
<!-- page des matiere--> 
   <section class="contenu contenu3 flex justify-end " data-anim="3">
    
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
                        
        <div class="w-full  p-[8px] " id="info_matiere">
           
             <div class="dashboard-section-heading ">
                <div>
                    <p class="dashboard-kicker">Vue d’ensemble</p>
                    <h2 id="infoLib" ><strong></strong></h2>
                </div>
                <span class="dashboard-caption">Les données de votre espace</span>
            </div>
                <div class="flex w-3/4  justify-around -ml-px">
                        <article class="dashboard-stat dashboard-stat-notes">
                            <span class="dashboard-stat-icon"><i class="fa-solid fa-book-open"></i></span>
                            <div>
                                <p>Coefficient</p>
                                <strong><span id="infocoeff"></span></strong>
                            </div>
                            <span class="dashboard-stat-mark"><i class="fa-solid fa-arrow-trend-up"></i></span>
                        </article>
                        <article class="dashboard-stat dashboard-stat-subjects">
                            <span class="dashboard-stat-icon"><i class="fa-solid fa-book"></i></span>
                            <div>
                                <p>Nombre d'heure</p>
                                <strong><span id="infoHeure"></span></strong>
                            </div>
                            <span class="dashboard-stat-mark"><i class="fa-solid fa-layer-group"></i></span>
                        </article>
                        <article class="dashboard-stat dashboard-stat-teachers">
                            <span class="dashboard-stat-icon"><i class="fa-solid fa-chalkboard-user"></i></span>
                            <div>
                                <p>Professeur</p>
                                <strong><span id="infoPrenom"></span></strong>
                            </div>
                            <span class="dashboard-stat-mark"><i class="fa-solid fa-users"></i></span>
                        </article>
                </div>
             <p class="messagEvide" id="messagEvide">cliquez sur une matiere pour voir ses informations</p>
         </div>
         
        
       

   
        
</section>

   <section class="contenu contenu4 " id="contenu4" data-anim="4">
       
                 <div class="flex justify-end h-full">
            <div class="liste_prof" id="liste_prof">
            <h1>Professeur</h1>

            <?php if(empty($professeur)): ?>
                <p>Aucun professeur enregistré</p>
            <?php else: ?>
                <?php foreach($professeur as $prof): ?>
                    <!--item-prof-->
                    <div class="item-prof  text-white mb-[5px] flex " data-id="<?= htmlspecialchars($prof['id_prof']) ?>">
                        <a href="filtre.php?id_prof=<?= htmlspecialchars($prof['id_prof']) ?>" onclick="return confirm('voulez vous vraiment modifier ce professeur ?');"> <button type="button" class="delete modifie"><i class="fa-solid fa-recycle"></i></button></a>
                                    <a href="suppProf.php?del=<?= htmlspecialchars($prof['id_prof']) ?>" onclick="return confirm('voulez vous vraiment supprimer ce professeur ?');"> <button type="button" class="delete"><i class="fa-regular fa-trash-can"></i></button></a>
                                
                        <?= htmlspecialchars($prof['nom']) . " " . htmlspecialchars($prof['prenom']) ?>
                    </div>    
                <?php endforeach; ?>
            <?php endif; ?> 
        </div>
       <!--Global cardInfo-->
        <div class="flex w-[100%] p-[5px] ">
             
            <div class="w-[52%]  ">
                
                    <div class=" mb-[10px] " id="info_prof">
                        <div class=" rounded-md bg-white p-4  shadow-lg">
                            <h1 id="infoNom"><strong>Nom</strong></h1>
                            <strong>prenom: </strong><span id="infoPreNom"></span> <br>

                            <strong>Numéro de téléphone: </strong><span id="infoTel"></span><br>
                            <strong>Matière: </strong><span id="infoMatiere"></span><br>
                            <strong>Disponibilité: </strong><span id="infoDispo"></span><br>
                        </div>
                                    
                    </div>
                                <!--Onglet des periodes-->
                      <div class=" h-[75vh]  ">
            <div class="shadow-md rounded-md bg-white p-4 h-[75vh] ">
                <div class="box_onglet  w-[100%] "><!--peiodes-->
                    <button   class="ongletSem is-active_onglet w-[50%]  bg-[#17233b] text-white rounded-md mb-[3px]" data-ongsem="1">Semestre 1</button>
                    <button class="ongletSem w-[50%] bg-[#17233b] text-white rounded-md"  data-ongsem="2">Semestre 2</button>
                </div>
                    <div class="relative border-8 h-[66vh]">
                        <div class="boxSem is-active_conteneur h-[60vh] w-[100%] p-[5px] py-4 pacity-[0] absolute "  data-ongsem="1" >
                            <h1 hidden>Semestre 1</h1>
                            <button id="btnCalculMoy1"  type="button">calcule</button>
                            <div id="notesProfesseur">
                                <p>Aucune note enregistré.</p>
                            </div>
                            <p id="messageVide" class="messageVide">cliquez sur un professeur pour voir ses informations</p>
                        </div>
                        <div class="boxSem h-[60vh] w-[100%] p-[5px] py-4 absolute opacity-[0]" data-ongsem="2">
                            <h1 hidden >Semestre 2</h1>
                            <button type="button">calcule</button>
                        </div>
                    </div>
                       
            </div>
    
        </div>      

            </div>
                    <div class="h-[97vh] w-[30%] ml-[5px]  shadow-md rounded-md bg-white p-4 " >
                             <h1  class="text-black" >Calcul de moyenne</h1>
                        <div id="moyenneMatiere">
                            <p>Aucune moyenne</p>
                        </div>
            </div>

        </div>
</div>
           
        
    </section>
   <section class="contenu " data-anim="5">
        
        
</section> 

   <script src="fonction_js/ongles.js"></script>
   <script src="fonction_js/chargerInfo_prof.js"></script>
   <script src="fonction_js/chargerInfo_matier.js"></script>
   <script src="fonction_js/btn-submite.js"></script>
   <script src="fonction_js/ongletPeriode.js"></script>
   
                            
</body> 
</html>