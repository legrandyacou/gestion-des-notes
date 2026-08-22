<?php 
    require "db_connexion.php";

    $stmt = $PDO->query("SELECT id, nom, prenom FROM etudiant ORDER BY nom");
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School</title>
    <style>

  * { box-sizing: border-box; font-family: Arial, sans-serif; }
  body { margin: 0; display: flex; min-height: 100vh; background: #f4f4f4; }
 
  .liste {
    width: 280px;
    background: #1e293b;
    color: white;
    padding: 20px;
  }
  .liste h2 { margin-top: 0; font-size: 18px; }
  .item-etud {
    padding: 12px;
    margin-bottom: 8px;
    background: #334155;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s;
  }
  .item-etud:hover { background: #475569; }
  .item-etud.actif { background: #2563eb; }
 
  .panneau { flex: 1; padding: 30px; }
  .card_Info {
    background: white;
    border-radius: 10px;
    padding: 25px;
    max-width: 500px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: none;
  }
  .card_Info.visible { 
    display: block;
 }
  .card_Info h2 { margin-top: 0; color: #1e293b; }
  .card_Info p { margin: 6px 0; color: #334155; }
  .card_Info strong { color: #2563eb; }
  .message_vide { color: #888; font-style: italic; }
</style>

</head>
<body>
    <div class="liste">
        <h1>Liste des etudiant</h1>
        <?php if(empty($etudiants)) :?>
            <p>aucun etudiant enregistre</p>
        <?php else: ?>
        <?php foreach($etudiants as $etud) :?>  
            <div class="item-etud" data-id="<?= htmlspecialchars($etud['id'])?>">
                <?= htmlspecialchars($etud['nom']). " ".htmlspecialchars($etud['prenom']) ?>
            </div>  

           <?php endforeach;?> 

            <?php endif; ?>
    </div>

    <div class="panneau">
            <p class="messageVide" id="message_vide">cliquez sur un etudiant</p>
            <div class="card_Info" id="cardInfo" >
                <h2 id="infoNom">nom: </h2>
                <p><strong >prenom: </strong><span id="infoPrenom"></span></p>
                <p><strong >Email: </strong><span id="infoEmail"></span></p>
            </div>
    </div>
        
    
    <script>
      const cardInfo = document.getElementById("cardInfo");
const messageVide =document.getElementById("message_vide");
const infoNom = document.getElementById("infoNom");
const infoPrenom = document.getElementById("infoPrenom");
const infoEmail = document.getElementById("infoEmail");
 document.querySelectorAll(".item-etud").forEach(item =>{
    item.addEventListener("click",()=>{
        const id = item.dataset.id;
        //puis on charge la fonction suivante
        chargerInfoEtud(id ,item);
    });
 });

 function chargerInfoEtud(id ,elementClique){
    messageVide.textContent ="chargement...";
    messageVide.style.display="block";
    cardInfo.classList.remove("visible");   // visible est une class css 

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const etudiant = this.response;
            if(etudiant.erreur){
                messageVide.textContent=etudiant.erreur;
                messageVide.style.display="block";
                return;
            }

            infoNom.innerHTML = etudiant.nom;
            infoPrenom.innerHTML = etudiant.prenom;
            infoEmail.innerHTML = etudiant.Email;

            messageVide.style.display = "none";
            cardInfo.classList.add("visible");

            document.querySelectorAll(".item-etud").forEach(el => el.classList.remove("actif"));
            elementClique.classList.add("actif"); 


        }else if(this.readyState == 4 && this.status == 404){
                messageVide.textContent = "etudiant introuvable.";
                messageVide.style.display = "block";
        }
        
    }
    xhr.open("GET","get_etudiant.php?id="+ encodeURIComponent(id),true);
        xhr.responseType = "json";
        xhr.send();
 }
    </script>
</body>
</html>