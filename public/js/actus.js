// Fonction pour récupérer les actus depuis Supabase
async function fetchactus() {
    const { data: actus, error } = await supabaseClient
        .from('actus')  // Vérifiez que la table est bien nommée "actus"
        .select('*');

    if (error) {
        console.error('Erreur lors de la récupération des actus:', error);
        return;
    }

    // Appel de la fonction pour afficher les actus
    displayactus(actus);
}

// Fonction pour afficher les actus avec les images
async function displayactus(actus) {
    const main = document.querySelector('main'); // Sélectionner la balise <main> pour y ajouter les divs

    for (const actu of actus) {
        // Vérifiez que l'actu a bien une URL d'image
        if (!actu.image_url) {
            console.warn('Aucune image URL pour cet actu:', actu);
            continue;
        }

        const actuHTML = `
        <div class="atelier">
            <div id="interventions_ordi">
                <img src="${actu.image_url}" class="img-atelier" alt="Image de l'atelier">
            </div>
            <div id="centrer_phone">
                <h2 class="titre-atelier">${actu.titre}</h2>
                <p class="date-atelier">${new Date(actu.date).toLocaleDateString()}</p>
                <div id="interventions_phone">
                    <img src="${actu.image_url}" class="img-atelier" alt="Image de l'atelier">
                </div>
                <p class="description-atelier">${actu.description.replace(/\n/g, '<br>')}</p>
            </div>
        </div>
        `;

        // Ajouter chaque actu dans le main
        main.insertAdjacentHTML('beforeend', actuHTML);
    }
}

// Charger les actus dès que la page est prête
document.addEventListener('DOMContentLoaded', fetchactus);