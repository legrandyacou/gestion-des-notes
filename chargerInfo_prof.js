const cardInfo= document.getElementById("info_prof");
const messageVide = document.getElementById("messageVide");
const infoNom = document.getElementById("infoNom");
const infoPrenom = document.getElementById("infoPreNom");
const infoTel = document.getElementById("infoTel");
const infoMatiere = document.getElementById("infoMatiere");
const infoDispo = document.getElementById("infoDispo");
const notesProfesseur = document.getElementById("notesProfesseur");
const moyenneMatiere = document.getElementById("moyenneMatiere");


document.querySelectorAll(".item-prof").forEach(item => {
    item.addEventListener("click",()=>{
        const id = item.dataset.id;
        chargerInfoProf(id ,item);
    });
});

function chargerInfoProf(id ,elementClique){
    if (!cardInfo || !messageVide || !notesProfesseur) {
        return;
    }
    messageVide.textContent = "chargement...";
    messageVide.style.display = "block";
    cardInfo.classList.remove("visible");
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const profs = this.response; 
            if(profs.erreur){
                messageVide.textContent = profs.erreur;
                messageVide.style.display = "block";
                cardInfo.classList.remove("visible");
                return;
            }
            //affichage des info prof
            infoNom.textContent = profs.nom;
            infoPrenom.textContent = profs.prenom; 
            infoTel.textContent = profs.tel;
            infoMatiere.textContent = profs.matiere_libelle || profs.libelle_mat || '';
            infoDispo.textContent = profs.jcours;
//affichage des note par prof
            notesProfesseur.replaceChildren();
            if (!Array.isArray(profs.notes) || profs.notes.length === 0) {
                const messageNotes = document.createElement("p");
                messageNotes.textContent = "Aucune note enregistrée.";
                notesProfesseur.appendChild(messageNotes);
            } else {
                profs.notes.forEach(note => {
                    const noteElement = document.createElement("div");
                    noteElement.className = "boxNote";
                    noteElement.dataset.id = note.id_note;
                    noteElement.textContent =
                        `${note.libelle_mat} - ${note.date_note} - ${note.note}/20`;
                    notesProfesseur.appendChild(noteElement);
                });
            }
//calcule de moyennes
            moyenneMatiere.replaceChildren();
            if (Array.isArray(profs.moyennes) && profs.moyennes.length > 0) {
                profs.moyennes.forEach(m => {
                    const moyenneMati = document.createElement("div");
                    moyenneMati.className = "boxMoy";
                    document.getElementById("btnCalculMoy1").addEventListener("click",()=>{
                        moyenneMati.textContent = `${m.libelle_mat} : ${Number(m.moyenne).toFixed(2)}`;
                        moyenneMatiere.appendChild(moyenneMati);
                    });
                    
                });
            } else {
                const messageMoyenne = document.createElement("p");
                messageMoyenne.textContent = "Aucune moyenne calculée.";
                moyenneMatiere.appendChild(messageMoyenne);
            }
            messageVide.style.display = "none";
            cardInfo.classList.add("visible");
            document.querySelectorAll(".item-prof").forEach(el =>{
                el.classList.remove("actif");
            });
            elementClique.classList.add("actif");
        }else if(this.readyState == 4 && this.status == 404){
            messageVide.textContent = "aucune information enregistre";
            messageVide.style.display = "block";
        }
    }
    xhr.open("GET","get_profs.php?id="+ encodeURIComponent(id),true);
    xhr.responseType = "json";
    xhr.send();

}