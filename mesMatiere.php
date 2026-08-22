<?php 
    require "db_connexion.php";
    $smt = $PDO->query("SELECT id_matiere,libelle,coefficient,Heure FROM matieres ORDER BY libelle");
    $lesMatieres = $smt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes matieres</title>
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
  .item-mati {
    padding: 12px;
    margin-bottom: 8px;
    background: #334155;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s;
  }
  .item-mati:hover { background: #475569; }
  .item-mati.actif { background: #2563eb; }
 
  .panneau { flex: 1; padding: 30px; }
  .cardInfo {
    background: white;
    border-radius: 10px;
    padding: 25px;
    max-width: 500px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: none;
  }
  .cardInfo.visible { display: block; }
  .cardInfo h2 { margin-top: 0; color: #1e293b; }
  .cardInfo p { margin: 6px 0; color: #334155; }
  .cardInfo strong { color: #2563eb; }
  .message_vide { color: #888; font-style: italic; }
</style>
</head>
<body>
    <div class="liste">
        <h1>les matieres</h1>
        <?php if(empty($matiere)):?>
            <p>aucune matiere enregistre</p>
         <?php else: ?>
         <?php foreach($lesMatieres as $matiere): ?>
            <div class="item-mati" id="item-mati" data-id="<?= htmlspecialchars($matiere['id_matiere'])?>">
             <?=  htmlspecialchars($matiere['libelle'])?>
            </div>
            <?php endforeach ;?>
        <?php endif ;?>    
    </div>
    <div class="panneau">
            <p id="messageVide" class="messageVide">cliquez sur une matiere</p>
            <div id="cardInfo" class="cardInfo">
                <h1 id="infoLibele">Libelle</h1>
                <strong>coefficient :</strong><span id="infoCoef"></span>
                <strong>Heure :</strong><span id="infoHeure"></span>
            </div>
    </div>
    <script>
        //const item_mati = document.getElementById("item-mati");
        const messageVide = document.getElementById("messageVide");
        const cardInfo = document.getElementById("cardInfo");
        const  infoLibele = document.getElementById("infoLibele");
        const infoCoef = document.getElementById("infoCoef");
        const infoHeure = document.getElementById("infoHeure");
            document.getElementById("item-mati").foreach(item =>{
                item.addEventListener("click",()=>{
                    const id = item.dataset.id;
                    chargerInfoMatiere(id , item);
                });
            });

            function chargerInfoMatiere(id , elementClique){
                messageVide.textContent = "chargement...";
                messageVide.style.display = "block";
                cardInfo.classList.remove("visible");

                var xhr = new XMLHttpRequest();
                xhr.onReadystatechange = function(){
                    if(this.readystate == 4 && this.status == 200){
                        const matiere = this.response;
                        if(matiere.erreur){
                            messageVide.textContent = matiere.erreur;
                            messageVide.style.display = "block";
                            return;
                        }
                        infoLibele.innerHTML = matiere.libelle;
                        infoCoef.innerHTML = matiere.coefficient;
                        infoHeure.innerHTML = matiere.Heure;
                        messageVide.style.display = "none";
                        cardInfo.classList.add("visible");
                        document.querySelectorAll("item-mati").foreach(el => el.classList.remove("active"));
                        el.elementclique.classList.add("active");

                    }else if(this.readystate == 4 && this.status == 404){
                        messageVide.textContent = "matiere introuvable";
                        messageVide.style.display = "block";
                        cardInfo.classList.remove("visible");
                    }
                }
                xhr.open("GET","get_matiere.php",true);
                xhr.responseType = "json";
                xhr.send();
                
            }

         
    </script>
</body>
</html>