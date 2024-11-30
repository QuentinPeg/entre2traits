// Fonction pour récupérer les articles depuis Supabase
async function fetchArticles() {
    const { data: articles, error } = await supabaseClient
        .from('articles')  // Vérifiez que la table est bien nommée "articles"
        .select('*');

    if (error) {
        console.error('Erreur lors de la récupération des articles:', error);
        return;
    }

    // Appel de la fonction pour afficher les articles
    displayArticles(articles);
}

// Fonction pour afficher les articles avec les images
async function displayArticles(articles) {
    const main = document.querySelector('main'); // Sélectionner la balise <main> pour y ajouter les divs

    for (const article of articles) {
        // Vérifiez que l'article a bien une URL d'image
        if (!article.image_url) {
            console.warn('Aucune image URL pour cet article:', article);
            continue;
        }

        // Formatage de la date
        const dateObj = new Date(article.date);
        const formattedDate = dateObj.toLocaleDateString('fr-FR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        const articlephp = `
    <div class="atelier">
        <div>
            <img src="${article.image_url}" class="img-atelier" alt="Image de l'atelier">
            <div class="date-atelier">${formattedDate}</div>
        </div>
        <div>
            <h2 class="titre-atelier">${article.titre}</h2>
            <p class="description-atelier">${article.description.replace(/\n/g, '<br>')}</p>
            <a href="${article.lien}" class="lien_atelier"><button>Dossier de présentation</button></a>
        </div>
    </div>
`;

        // Ajouter chaque article dans le main
        main.insertAdjacentphp('beforeend', articlephp);
    }
}


// Charger les articles dès que la page est prête
document.addEventListener('DOMContentLoaded', fetchArticles);