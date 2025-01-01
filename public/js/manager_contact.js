import { supabaseClient } from "../js/supabase.js";

// Fonction pour charger les données depuis la table `atelier_content`
async function loadAteliers() {
    try {
        const { data, error } = await supabaseClient.from("atelier_content").select("*");
        if (error) throw error;

        const tableBody = document.getElementById("atelier-table-body");
        tableBody.innerHTML = ""; // Réinitialiser le contenu

        // Parcourir les données et les insérer dans le tableau
        data.forEach(atelier => {
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${atelier.id}</td>
                <td>${atelier.titre}</td>
                <td>${atelier.description}</td>
                <td>${formatHoraires(atelier.horaires)}</td>
                <td>${formatTarifs(atelier.tarifs)}</td>
                <td>
                    <button class="delete" onclick="deleteAtelier(${atelier.id})">Supprimer</button>
                </td>
            `;

            tableBody.appendChild(row);
        });
    } catch (error) {
        console.error("Erreur lors du chargement des ateliers :", error.message);
    }
}

// Fonction pour supprimer un atelier
async function deleteAtelier(id) {
    try {
        const { error } = await supabaseClient.from("atelier_content").delete().eq("id", id);
        if (error) throw error;

        alert("Atelier supprimé avec succès !");
        loadAteliers(); // Recharger la liste
    } catch (error) {
        console.error("Erreur lors de la suppression :", error.message);
    }
}

// Fonction utilitaire pour formater les horaires
function formatHoraires(horaires) {
    const parsedHoraires = JSON.parse(horaires);
    return Object.entries(parsedHoraires)
        .map(([jour, plages]) => `${jour} : ${plages.join(", ")}`)
        .join("<br>");
}

// Fonction utilitaire pour formater les tarifs
function formatTarifs(tarifs) {
    const parsedTarifs = JSON.parse(tarifs);
    return Object.entries(parsedTarifs)
        .map(([type, montant]) => `${type} : ${montant} €`)
        .join("<br>");
}

// Charger les ateliers au démarrage
document.addEventListener("DOMContentLoaded", loadAteliers);
