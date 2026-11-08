const panelInfoMatiere = document.getElementById("info_matiere");
const messageMatiere = document.getElementById("messagEvide");
const libelleMatiere = document.getElementById("infoLib");
const coefficientMatiere = document.getElementById("infocoeff");
const heuresMatiere = document.getElementById("infoHeure");
const professeurMatiere = document.getElementById("infoProfesseur");
const actionsMatiere = document.getElementById("matiere-actions");
let requeteMatiere = null;

document.querySelectorAll(".item-matiere").forEach((item) => {
    item.addEventListener("click", () => {
        chargerInfoMatiere(item.dataset.id, item);
    });
});

function chargerInfoMatiere(id, elementClique) {
    if (
        !panelInfoMatiere || !messageMatiere || !libelleMatiere ||
        !coefficientMatiere || !heuresMatiere || !professeurMatiere
    ) {
        return;
    }

    requeteMatiere?.abort();
    messageMatiere.textContent = "Chargement des informations de la matière…";
    messageMatiere.style.display = "block";

    const xhr = new XMLHttpRequest();
    requeteMatiere = xhr;
    xhr.open("GET", `get_matiere.php?id=${encodeURIComponent(id)}`, true);
    xhr.responseType = "json";

    xhr.onload = () => {
        if (requeteMatiere !== xhr) {
            return;
        }

        const reponse = xhr.response;
        if (xhr.status !== 200 || !reponse || reponse.erreur) {
            messageMatiere.textContent = reponse?.erreur ||
                `Impossible de charger la matière (erreur ${xhr.status}).`;
            return;
        }

        libelleMatiere.textContent = reponse.libelle_mat || "";
        coefficientMatiere.textContent = reponse.coefficient ?? "";
        heuresMatiere.textContent = reponse.heure ?? "";
        professeurMatiere.textContent = reponse.professeur || "Aucun professeur associé";

        if (actionsMatiere) {
            actionsMatiere.replaceChildren();
            const edit = document.createElement("a");
            edit.href = `modifier_matiere.php?id_matiere=${encodeURIComponent(reponse.id_matiere)}`;
            edit.textContent = "Modifier la matière";
            actionsMatiere.appendChild(edit);

            const deleteForm = document.createElement("form");
            deleteForm.action = "suppMati.php";
            deleteForm.method = "post";
            deleteForm.addEventListener("submit", (event) => {
                if (!window.confirm("Supprimer cette matière ? Les matières utilisées par des notes ne peuvent pas être supprimées.")) {
                    event.preventDefault();
                }
            });
            const id = document.createElement("input");
            id.type = "hidden";
            id.name = "id_matiere";
            id.value = reponse.id_matiere;
            const remove = document.createElement("button");
            remove.type = "submit";
            remove.textContent = "Supprimer";
            deleteForm.append(id, remove);
            actionsMatiere.appendChild(deleteForm);
            actionsMatiere.hidden = false;
        }

        messageMatiere.style.display = "none";
        document.querySelectorAll(".item-matiere").forEach((element) => {
            element.classList.toggle("actif", element === elementClique);
        });
    };

    xhr.onerror = () => {
        if (requeteMatiere === xhr) {
            messageMatiere.textContent = "Erreur réseau lors du chargement de la matière.";
        }
    };
    xhr.onabort = () => {};
    xhr.send();
}
