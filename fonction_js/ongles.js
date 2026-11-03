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

document.querySelectorAll('[data-dashboard-tab]').forEach((bouton) => {
    bouton.addEventListener('click', () => {
        const onglet = document.querySelector(`.list-side li[data-anim="${CSS.escape(bouton.dataset.dashboardTab)}"]`);
        onglet?.click();
    });
});

const boutonsAjout = document.querySelectorAll('.navBtn-Ajout[data-form]');
const fondFormulaires = document.querySelector('.all_form');
const formulaires = document.querySelectorAll('.all_form [data-form]');
let declencheurFormulaire = null;

function fermerFormulaires() {
    if (!fondFormulaires) {
        return;
    }

    fondFormulaires.classList.remove('is-open');
    fondFormulaires.setAttribute('aria-hidden', 'true');
    formulaires.forEach((formulaire) => {
        formulaire.classList.remove('is-visible');
        formulaire.setAttribute('aria-hidden', 'true');
    });
    boutonsAjout.forEach((bouton) => {
        bouton.classList.remove('active');
        bouton.setAttribute('aria-expanded', 'false');
    });
    document.body.style.overflow = '';
    declencheurFormulaire?.focus();
    declencheurFormulaire = null;
}

function ouvrirFormulaire(id, declencheur) {
    if (!fondFormulaires) {
        return;
    }

    const formulaire = fondFormulaires.querySelector(`[data-form="${CSS.escape(id)}"]`);
    const bouton = document.querySelector(`.navBtn-Ajout[data-form="${CSS.escape(id)}"]`);
    if (!formulaire || !bouton) {
        return;
    }

    declencheurFormulaire = declencheur;
    formulaires.forEach((element) => {
        element.classList.toggle('is-visible', element === formulaire);
        element.setAttribute('aria-hidden', String(element !== formulaire));
    });
    boutonsAjout.forEach((element) => {
        const estActif = element === bouton;
        element.classList.toggle('active', estActif);
        element.setAttribute('aria-expanded', String(estActif));
    });
    fondFormulaires.classList.add('is-open');
    fondFormulaires.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    formulaire.querySelector('input, select, textarea, button')?.focus();
}

boutonsAjout.forEach((bouton) => {
    bouton.setAttribute('aria-haspopup', 'dialog');
    bouton.setAttribute('aria-expanded', 'false');
    bouton.addEventListener('click', () => {
        ouvrirFormulaire(bouton.dataset.form, bouton);
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

formulaires.forEach((formulaire) => {
    formulaire.addEventListener('keydown', (event) => {
        if (event.key !== 'Tab' || !formulaire.classList.contains('is-visible')) {
            return;
        }

        const focusables = Array.from(
            formulaire.querySelectorAll('button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [href], [tabindex]:not([tabindex="-1"])')
        );
        const premier = focusables[0];
        const dernier = focusables[focusables.length - 1];

        if (event.shiftKey && document.activeElement === premier) {
            event.preventDefault();
            dernier?.focus();
        } else if (!event.shiftKey && document.activeElement === dernier) {
            event.preventDefault();
            premier?.focus();
        }
    });
});

// Onglets des périodes.
const btnPeriode = document.querySelectorAll('.btn_sem');
const contenuPeriode = document.querySelectorAll('.conteneur_sem');

btnPeriode.forEach((periode) => {
    periode.addEventListener('click', () => {
        const index = ongletperiode.dataset.ongletperiode;
        
        btnPeriode.forEach((element) => {
            element.classList.toggle('active_periode', element === periode);
        });
        contenuPeriode.forEach((contenu) => {
            contenu.classList.toggle('conteneur_periode', contenu.dataset.periode === index);
        });
    });
});
