function cleanText(input) {
    input = input.replace(/&ZeroWidthSpace;/g, '');
    input = input.replace(/\n/g, '<br>');
    input = input.replace(/(<br\s*\/?>\s*){2,}/g, '<br>');
    return input.trim();
}

async function loadParcoursContent() {
    try {
        const { data, error } = await supabaseClient
            .from('parcours')
            .select('*')
            .single();

        if (error) {
            console.error("Erreur lors du chargement des données :", error);
            return;
        }

        document.getElementById('parcours-titre').textContent = data.titre;

        if (data.description) {
            const atelierDescription = document.getElementById('parcours-description');
            console.log(data.description);
            atelierDescription.innerHTML = cleanText(data.description).replace(/(\r\n|\n|\r)/gm, "<br>");
        } else {
            console.error("Description non disponible dans les données.");
        }

        document.getElementById('parcours-image').src = data.image_url;

        const parcoursLink = document.getElementById('parcours-lien');
        parcoursLink.href = data.destination_url;

    } catch (error) {
        console.error("Une erreur s'est produite :", error);
    }
}

document.addEventListener('DOMContentLoaded', loadParcoursContent);

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('thumbnail')) {
        const image = document.getElementById('parcours-image');
        image.src = e.target.src;
    }
});