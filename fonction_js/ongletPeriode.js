const navSem =document.querySelectorAll(".ongletSem[data-ongsem]");
    const conteneurSem = document.querySelectorAll(".boxSem[data-ongsem]");
   navSem.forEach((naVe)=>{
        naVe.addEventListener("click",()=>{
            const index =naVe.dataset.ongsem;
            navSem.forEach((element)=>{
                element.classList.toggle("is-active_onglet",element === naVe);
            });
           
            conteneurSem.forEach((contenus)=>{
                contenus.classList.toggle("is-active_conteneur", contenus.dataset.ongsem === index);
            });

        });
   });