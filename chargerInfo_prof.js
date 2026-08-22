const cardInfo= document.getElementById("info_prof");
const messageVide = document.getElementById("messageVide");
const infoNom = document.getElementById("infoNom");
const infoPrenom = document.getElementById("infoPrenom");
const infoTel = document.getElementById("infoTel");
const infoMatiere = document.getElementById("infoMatiere");
const infoDispo = document.getElementById("infoDispo");

document.querySelectorAll(".item-prof").forEach(item => {
    item.addEventListener("click",()=>{
        const id = item.dataset.id;
        chargerInfoProf(id ,item);
    });
});

function chargerInfoProf(id ,elementClique){
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
            infoNom.innerHTML = profs.nom;
            infoPrenom.innerHTML = profs.prenom; 
            infoTel.innerHTML= profs.tel;
           // infoMatiere.innerHTML = profs.id_matiere;
            infoDispo.innerHTML = profs.jcours
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