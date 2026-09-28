const listes = document.querySelectorAll('.list-side li[data-anim]');
const contenus = document.querySelectorAll('.contenu[data-anim]');

listes.forEach((liste) => {
    liste.addEventListener('click', () => {
        const index = liste.dataset.anim;

        listes.forEach((element) => {
            element.classList.toggle('active', element === liste);
        });
        contenus.forEach((contenu) => {
            contenu.classList.toggle('activecontenu', contenu.dataset.anim === index);
        });
    });
});

const boutonsAjout = document.querySelectorAll('.navBtn-Ajout[data-form]');
const fondFormulaires = document.querySelector('.all_form');
const formulaires = document.querySelectorAll('.all_form [data-form]');

function fermerFormulaires() {
    if (!fondFormulaires) {
        return;
    }

    fondFormulaires.classList.remove('is-open');
    formulaires.forEach((formulaire) => {
        formulaire.classList.remove('is-visible');
    });
    boutonsAjout.forEach((bouton) => {
        bouton.classList.remove('active');
    });
}

function ouvrirFormulaire(id) {
    if (!fondFormulaires) {
        return;
    }

    const formulaire = fondFormulaires.querySelector(`[data-form="${CSS.escape(id)}"]`);
    const bouton = document.querySelector(`.navBtn-Ajout[data-form="${CSS.escape(id)}"]`);
    if (!formulaire || !bouton) {
        return;
    }

    formulaires.forEach((element) => {
        element.classList.toggle('is-visible', element === formulaire);
    });
    boutonsAjout.forEach((element) => {
        element.classList.toggle('active', element === bouton);
    });
    fondFormulaires.classList.add('is-open');
}

boutonsAjout.forEach((bouton) => {
    bouton.addEventListener('click', () => {
        ouvrirFormulaire(bouton.dataset.form);
    });
});

document.querySelectorAll('.btn-close').forEach((bouton) => {
    bouton.addEventListener('click', fermerFormulaires);
});

fondFormulaires?.addEventListener('click', (event) => {
    if (event.target === fondFormulaires) {
        fermerFormulaires();
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        fermerFormulaires();
    }
});

// Onglets des périodes.
const btnPeriode = document.querySelectorAll('.sem[data-periode]');
const contenuPeriode = document.querySelectorAll('.Cont_periode[data-periode]');

btnPeriode.forEach((periode) => {
    periode.addEventListener('click', () => {
        const index = periode.dataset.periode;

        btnPeriode.forEach((element) => {
            element.classList.toggle('active_periode', element === periode);
        });
        contenuPeriode.forEach((contenu) => {
            contenu.classList.toggle('conteneur_periode', contenu.dataset.periode === index);
        });
    });
});
