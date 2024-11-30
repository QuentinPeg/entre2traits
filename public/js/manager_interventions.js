// Fonction pour charger les images et peupler le dropdown
async function loadImages() {
    const bucket = 'images_interventions';

    try {
        // Récupérer les fichiers dans le bucket
        const { data: files, error } = await supabaseClient
            .storage
            .from(bucket)
            .list();

        if (error) throw error;

        if (!files || files.length === 0) {
            console.warn('Aucune image trouvée dans le bucket.');
            return;
        }

        const select = document.getElementById('article-image');
        select.innerHTML = '<option value="">Sélectionner une image</option>'; // Option par défaut

        files.forEach(file => {
            // Vérifier si le fichier est un "emptyFolderPlaceholder" et ignorer
            if (file.name.includes('.emptyFolderPlaceholder')) {
                return;
            }

            // Générer l'URL publique
            const { data: publicUrlResponse, error: publicUrlError } = supabaseClient
                .storage
                .from(bucket)
                .getPublicUrl(file.name);

            if (publicUrlError) {
                console.error(`Erreur lors de la génération de l'URL pour ${file.name}:`, publicUrlError.message);
                return;
            }

            const publicUrl = publicUrlResponse.publicUrl;
            if (!publicUrl) {
                console.warn(`Pas d'URL publique disponible pour ${file.name}`);
                return;
            }

            // Créer l'option dans le select
            const option = document.createElement('option');
            option.value = publicUrl; // L'URL publique comme valeur
            option.textContent = file.name; // Le nom de fichier comme texte visible
            select.appendChild(option);
        });

    } catch (err) {
        console.error('Erreur lors du chargement des images:', err.message);
    }
}

document.getElementById('article-image').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const selectedImageUrl = selectedOption.value;

    if (selectedImageUrl) {
        const selectedImage = document.getElementById('selectedImage');
        selectedImage.src = selectedImageUrl;
        selectedImage.style.display = 'block'; // Afficher l'image sélectionnée
    } else {
        document.getElementById('selectedImage').style.display = 'none'; // Cacher l'image si aucune sélection
    }
});

// Fonction pour ajouter un nouvel article
async function addArticle(title, description, link, date, imageUrl) {
    try {
        const { data, error } = await supabaseClient
            .from('articles')
            .insert([{ image_url: imageUrl, titre: title, description: description, lien: link, date: date }]);

        if (error) throw error;

        document.getElementById('article-status').textContent = 'Article ajouté avec succès.';
        document.getElementById('article-form').reset(); // Réinitialiser le formulaire
        loadArticles(); // Recharger les articles après ajout
    } catch (err) {
        console.error('Erreur lors de l\'ajout de l\'article:', err.message);
        document.getElementById('article-status').textContent = 'Erreur lors de l\'ajout de l\'article.';
    }
}

// Fonction pour charger les articles existants
async function loadArticles() {
    try {
        const { data, error } = await supabaseClient
            .from('articles')
            .select('*');

        if (error) throw error;

        const container = document.getElementById('articles-container');
        container.innerHTML = '';

        data.forEach(article => {
            const listItem = document.createElement('li');
            listItem.innerHTML = `
                <hr>
                <h3>${article.titre}</h3>
                <img src="${article.image_url}" alt="${article.titre}" width="100">
                <p>${article.description}</p>
                <a href="${article.lien}" target="_blank">Lien de l'article</a>
                <button onclick="deleteArticle(${article.id})">Supprimer</button>
                `;
            container.appendChild(listItem);
        });

    } catch (err) {
        console.error('Erreur lors du chargement des articles:', err.message);
    }
}

// Gestion de l'événement de soumission du formulaire
document.getElementById('article-form').addEventListener('submit', async (event) => {
    event.preventDefault();

    const title = document.getElementById('article-title').value;
    const date = document.getElementById('article-date').value;
    const description = document.getElementById('article-description').value;
    const link = document.getElementById('article-link').value;
    const imageSelect = document.getElementById('article-image');
    Array.from(imageSelect.options).forEach((option, index) => {
    });

    const imageUrl = imageSelect.value; // Récupère directement la valeur sélectionnée

    if (title && date && description && link && imageUrl) {
        await addArticle(title, description, link, date, imageUrl);
    } else {
        document.getElementById('article-status').textContent = 'Veuillez remplir tous les champs.';
        console.warn('Tous les champs ne sont pas remplis.');
    }
});
// Fonction pour uploader une image
async function uploadImage(file) {
    const fileName = `${Date.now()}_${file.name}`;  // Générer un nom de fichier unique

    // Upload dans la racine du bucket
    const { data, error } = await supabaseClient
        .storage
        .from('images_interventions')
        .upload(fileName, file);  // Pas de sous-dossier ici, c'est directement à la racine

    if (error) {
        console.error('Erreur lors de l\'upload:', error.message);
        document.getElementById('upload-status').textContent = 'Erreur lors de l\'upload.';
        return;
    }

    await loadImages(); // Recharger les images après l'ajout
    document.getElementById('upload-status').textContent = 'Image ajoutée avec succès.';
}
// Fonction pour supprimer un article
async function deleteArticle(articleId) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
        return; // Annule la suppression si l'utilisateur clique sur "Annuler"
    }

    try {
        const { data, error } = await supabaseClient
            .from('articles')
            .delete()
            .eq('id', articleId); // Filtrer par l'ID de l'article

        if (error) throw error;

        document.getElementById('article-status').textContent = 'Article supprimé avec succès.';
        loadArticles(); // Recharger la liste des articles après suppression
    } catch (err) {
        console.error('Erreur lors de la suppression de l\'article:', err.message);
        document.getElementById('article-status').textContent = 'Erreur lors de la suppression de l\'article.';
    }
}
// Ajouter une nouvelle image
document.getElementById('upload-image-button').addEventListener('click', async () => {
    const fileInput = document.getElementById('image-upload');
    const file = fileInput.files[0];
    if (file) {
        await uploadImage(file);
    }
});

// Charger les images et articles au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    loadImages();
    loadArticles();
});