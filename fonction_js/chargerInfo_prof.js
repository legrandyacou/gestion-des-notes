const cardInfo = document.getElementById("info_prof");
const messageVide = document.getElementById("messageVide");
const infoNom = document.getElementById("infoNom");
const infoPrenom = document.getElementById("infoPreNom");
const infoTel = document.getElementById("infoTel");
const infoMatiere = document.getElementById("infoMatiere");
const infoDispo = document.getElementById("infoDispo");
const actionsProfesseur = document.getElementById("professeur-actions");
const notesProfesseur = document.getElementById("notesProfesseur");
const notesProfesseur2emep = document.getElementById("notesProfesseur_2emep");
const notesProfesseur3emep = document.getElementById("notesProfesseur_3emep");
const moyenneMatiere = document.getElementById("moyenneMatiere");
const boutonCalculMoyenne = document.getElementById("btnCalculMoy1");
let requeteProfesseur = null;
let moyennesProfesseur = [];

document.querySelectorAll(".item-prof").forEach((item) => {
    item.addEventListener("click", (event) => {
        if (event.target.closest("form, a, button")) {
            return;
        }

        chargerInfoProf(item.dataset.id, item);
    });
});

boutonCalculMoyenne?.addEventListener("click", () => {
    if (!moyenneMatiere) {
        return;
    }

    moyenneMatiere.replaceChildren();
    if (moyennesProfesseur.length === 0) {
        const message = document.createElement("p");
        message.textContent = "Aucune moyenne calculée.";
        moyenneMatiere.appendChild(message);
        return;
    }

    moyennesProfesseur.forEach((moyenne) => {
        const element = document.createElement("div");
        element.className = "boxMoy";
        element.textContent =
            `${moyenne.libelle_mat} : ${Number(moyenne.moyenne).toFixed(2)}`;
        moyenneMatiere.appendChild(element);
    });
});

function afficherNotes(conteneur, notes) {
    if (!conteneur) {
        return;
    }

    conteneur.replaceChildren();
    if (!Array.isArray(notes) || notes.length === 0) {
        const message = document.createElement("p");
        message.textContent = "Aucune note enregistrée.";
        conteneur.appendChild(message);
        return;
    }

    notes.forEach((note) => {
        const element = document.createElement("div");
        element.className = "boxNote styleNote";
        element.dataset.id = note.id_note;
        const details = document.createElement("span");
        details.textContent =
            `${note.libelle_mat} - ${note.date_note} - ${note.note}/20`;
        const actions = document.createElement("span");
        actions.className = "crud-actions";

        const edit = document.createElement("a");
        edit.href = `modifier_note.php?id_note=${encodeURIComponent(note.id_note)}`;
        edit.textContent = "Modifier";
        actions.appendChild(edit);

        const deleteForm = document.createElement("form");
        deleteForm.action = "suppnNote.php";
        deleteForm.method = "post";
        deleteForm.addEventListener("submit", (event) => {
            if (!window.confirm("Supprimer cette note ?")) {
                event.preventDefault();
            }
        });
        const id = document.createElement("input");
        id.type = "hidden";
        id.name = "id_note";
        id.value = note.id_note;
        const remove = document.createElement("button");
        remove.type = "submit";
        remove.textContent = "Supprimer";
        deleteForm.append(id, remove);
        actions.appendChild(deleteForm);

        element.append(details, actions);
        conteneur.appendChild(element);
    });
}

function chargerInfoProf(id, elementClique) {
    if (
        !cardInfo || !messageVide || !infoNom || !infoPrenom || !infoTel ||
        !infoMatiere || !infoDispo || !notesProfesseur || !notesProfesseur2emep
    ) {
        return;
    }

    requeteProfesseur?.abort();
    messageVide.textContent = "Chargement des informations du professeur…";
    messageVide.style.display = "block";
    const xhr = new XMLHttpRequest();
    requeteProfesseur = xhr;
    xhr.open("GET", `get_profs.php?id=${encodeURIComponent(id)}`, true);
    xhr.responseType = "json";

    xhr.onload = () => {
        if (requeteProfesseur !== xhr) {
            return;
        }

        const reponse = xhr.response;
        if (xhr.status !== 200 || !reponse || reponse.erreur) {
            messageVide.textContent = reponse?.erreur ||
                `Impossible de charger le professeur (erreur ${xhr.status}).`;
            return;
        }

        infoNom.textContent = reponse.nom || "";
        infoPrenom.textContent = reponse.prenom || "";
        infoTel.textContent = reponse.tel || "";
        infoMatiere.textContent = reponse.matiere_libelle || "Aucune matière associée";
        infoDispo.textContent = reponse.jcours || "";

        if (actionsProfesseur) {
            actionsProfesseur.replaceChildren();
            const edit = document.createElement("a");
            edit.href = `filtre.php?id_prof=${encodeURIComponent(reponse.id_prof)}`;
            edit.textContent = "Modifier le professeur";
            actionsProfesseur.appendChild(edit);
            actionsProfesseur.hidden = false;
        }

        afficherNotes(notesProfesseur, reponse.notesP1);
        afficherNotes(notesProfesseur2emep, reponse.notesP2);
        afficherNotes(notesProfesseur3emep, reponse.notesP3);
        moyennesProfesseur = Array.isArray(reponse.moyennes) ? reponse.moyennes : [];
        if (moyenneMatiere) {
            moyenneMatiere.replaceChildren();
            if (moyennesProfesseur.length === 0) {
                const message = document.createElement("p");
                message.textContent = "Aucune moyenne calculée.";
                moyenneMatiere.appendChild(message);
            } else {
                const aide = document.createElement("p");
                aide.textContent = "Cliquez sur « calculer » pour afficher les moyennes.";
                moyenneMatiere.appendChild(aide);
            }
        }

        messageVide.style.display = "none";
        document.querySelectorAll(".item-prof").forEach((element) => {
            element.classList.toggle("actif", element === elementClique);
        });
    };

    xhr.onerror = () => {
        if (requeteProfesseur === xhr) {
            messageVide.textContent = "Erreur réseau lors du chargement du professeur.";
        }
    };
    xhr.onabort = () => {};
    xhr.send();
}
