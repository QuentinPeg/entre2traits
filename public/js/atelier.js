function cleanText(input) {
    input = input.replace(/&ZeroWidthSpace;/g, '');
    input = input.replace(/\n/g, '<br>');
    input = input.replace(/(<br\s*\/?>\s*){2,}/g, '<br>');
    return input.trim();
}

async function loadAtelierContent() {
    try {
        const { data, error } = await supabaseClient
            .from('atelier_content')
            .select('*')
            .single();

        if (error) {
            console.error("Erreur lors du chargement des données :", error);
            return;
        }

        document.getElementById('atelier-title').textContent = data.titre;

        if (data.description) {
            const atelierDescription = document.getElementById('atelier-description');
            atelierDescription.innerHTML = cleanText(data.description);
        } else {
            console.error("Description non disponible dans les données.");
        }

        document.getElementById('atelier-location').innerHTML = data.adresse.replace(/,/g, "<br>");
        document.getElementById('contact-info').textContent = data.contact.replace(/(\d{2})(?=\d)/g, '$1 ');

        if (data.horaires) {
            const horairesListHtml = data.horaires.split(';').map(item => `<li>${item}</li>`).join('');
            document.getElementById('horaires-list').innerHTML = horairesListHtml;
        } else {
            document.getElementById('horaires-list').innerHTML = '<li>Aucun horaire disponible</li>';
        }

        if (data.tarifs) {
            data.tarifs = cleanText(data.tarifs);
            let tarifsListHtml = data.tarifs.split(';').map(item => `<li>${item}</li>`).join('');
            tarifsListHtml = tarifsListHtml.replace(/<li>\s*<br>\s*/g, '<li>');
            document.getElementById('tarifs-list').innerHTML = tarifsListHtml;
        } else {
            document.getElementById('tarifs-list').innerHTML = '<li>Aucun tarif disponible</li>';
        }

        let carrousel3Images = [];
        try {
            carrousel3Images = JSON.parse(data.carrousel3_images);
        } catch (error) {
            carrousel3Images = data.carrousel3_images ? data.carrousel3_images.split(',') : [];
        }

        const carrousel3Html = `
        <div class="carrousel-large">
            <img id="large-image-3" src="${carrousel3Images[0] && carrousel3Images[0].trim() ? carrousel3Images[0].trim() : '../img/placeholder.jpg'}" alt="Grande Image Carrousel 3">
        </div>
        <div class="carrousel-small">
            ${carrousel3Images.slice(1).map(img => {
            if (img && img.trim()) {
                return `<img class="thumbnail" src="${img.trim()}" alt="Miniature Carrousel 3">`;
            }
            return '';
        }).join('')}
        </div>
    `;
        document.getElementById('carrousel3').innerHTML = carrousel3Html;
        changeImage('carrousel3', carrousel3Images);

    } catch (error) {
        console.error("Une erreur s'est produite :", error);
    }
}

document.addEventListener('DOMContentLoaded', loadAtelierContent);

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('thumbnail')) {
        const largeImage = document.getElementById('large-image-3');
        largeImage.src = e.target.src;
    }
});