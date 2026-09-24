const listes = document.querySelectorAll('li');
const contenus = document.querySelectorAll('.contenu');

const btnAJOUt= document.querySelector(".barre .btn-ajout");
const btnajoutMati= document.querySelector(".barre .btnAjoutMati");
const btnajoutProf= document.querySelector(".barre .btnAjoutPro");

const forMn = document.querySelector(".box-form");
const forMati = document.querySelector(".form_matiere");
const forMpro = document.querySelector(".form_pro");

const formulaire = document.querySelector(".forMuLaire");
const btnForM =document.querySelector(".btn-subm");

const buttonModif = document.querySelector(".modifie");


    let index=0;
listes.forEach(liste =>{
        liste.addEventListener('click',()=>{
            if(liste.classList.contains('active')){
                return;
            }else{
                liste.classList.add('active');
            }

            index=liste.getAttribute('data-anim');
        for(let i=0;i<listes.length;i++){
            if(listes[i].getAttribute('data-anim')!= index){
                listes[i].classList.remove('active');
            }
        }

        for(let j=0;j<contenus.length;j++){
            if(contenus[j].getAttribute('data-anim') == index){
                    contenus[j].classList.add('activecontenu');
            }else{
                contenus[j].classList.remove('activecontenu');
            }
        }
        });
        

});

btnAJOUt.addEventListener("click",()=>{
    forMn.classList.toggle("show");
});

btnajoutMati.addEventListener("click",()=>{
    forMati.classList.toggle("show");
});
btnajoutProf.addEventListener("click",()=>{
    forMpro.classList.toggle("show");
});


//onglet pour les perioides
const btnPeriode = document.querySelectorAll('.sem');
const contenuPeriode = document.querySelectorAll('.Cont_periode');
let dedex =0;
btnPeriode.forEach(periode =>{
periode.addEventListener("click",()=>{
if(periode.classList.contains('active_periode')){
    return;
}else{
    periode.classList.add("active_periode");
}

dedex= periode.getAttribute("data-periode");
for(let t =0 ; t<btnPeriode.length;t++){
    if(btnPeriode[t].getAttribute('data-periode')!= dedex){
        btnPeriode[t].classList.remove('active_periode');
    }
}

for(let k = 0;k<contenuPeriode.length;k++){
    if(contenuPeriode[k].getAttribute('data-periode') == dedex){
        contenuPeriode[k].classList.add('conteneur_periode');
    }else{
        contenuPeriode[k].classList.remove('conteneur_periode');
    }
}

    
});
});



