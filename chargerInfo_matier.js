const panelInfo = document.getElementById("info_matiere");
const libelle = document.getElementById("infoLib");
const coefficient = document.getElementById("infocoeff");
const heure = document.getElementById("infoHeure");
const telephone = document.getElementById("infoTel");
const message = document.querySelector(".messagEvide");
document.querySelectorAll(".item-matiere").forEach(item =>{
    item.addEventListener("click",()=>{
        const id = item.dataset.id;
        chargerInfoMatiere(id ,item);
    });
});

function  chargerInfoMatiere(id ,elementClique){
    if (!panelInfo || !message) {
        return;
    }
    message.textContent  = "chargement...";
    message.style.display = "block";
    panelInfo.classList.remove("visible");
    
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            const Matiere = this.response;
            if(Matiere.erreur){
                message.textContent = Matiere.erreur;
                message.style.display = "block";
                return;
            }
            libelle.textContent = Matiere.libelle_mat;
            coefficient.textContent = Matiere.coefficient;
            heure.textContent = Matiere.heure;
            message.style.display = "none";
            panelInfo.classList.add("visible");
            document.querySelectorAll(".item-matiere").forEach(el =>{
                el.classList.remove("actif");
            });
            elementClique.classList.add("actif");

        }else if(this.readyState == 4 && this.status == 404){
            message.textContent = "information introuvable";
            message.style.display = "block";
        }
    }
    xhr.open("GET","get_matiere.php?id="+encodeURIComponent(id),true);
    xhr.responseType = "json";
    xhr.send();
}