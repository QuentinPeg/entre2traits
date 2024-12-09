<?php include "./header.php"; ?>
<link rel="stylesheet" href="../css/atelier.css">

<main>
    <h4 id="atelier-title">Chargement...</h4>
    <h2>L'atelier, les horaires et les tarifs.</h2>
    <section class="atelier-info">
        <div class="atelier-left">
            <article class="carr">
                <div id="carrousel3" class="carrousel index-page">
                    <div class="carrousel-large">
                        <img id="large-image-3" src="../img/picto_inscription.webp" alt="Grande Image Carrousel 3">
                    </div>
                    <div class="carrousel-small" id="carrousel-small-3">
                        <!-- Les miniatures seront injectées ici -->
                    </div>
                </div>
            </article>

            <h2>L'atelier :</h2>
            <p id="atelier-description">Chargement...</p>
            <ul id="atelier-ul">
                <!-- Les points seront injectés ici -->
            </ul>
            <p id="atelier-location">Chargement...</p>
        </div>

        <div class="atelier-right">
            <div class="horaires">
                <h2>Les horaires :</h2>
                <ul id="horaires-list">
                    <!-- Les horaires seront injectés ici -->
                </ul>
            </div>
            <div class="tarifs">
                <h2>Tarifs septembre 2024 :</h2>
                <img src="../img/2-euros-E2T-2016 copie.webp" alt="Médaille tarif" id="tarifs-img">
                <ul id="tarifs-list">
                    <!-- Les tarifs seront injectés ici -->
                </ul>
            </div>
        </div>
    </section>
</main>

<?php include "./footer.php"; ?>

<script>
    function cleanText(input) {
        // Supprimer les caractères invisibles
        input = input.replace(/&ZeroWidthSpace;/g, '');
        // Remplacer plusieurs <br> consécutifs par un seul
        // Transformer les sauts de ligne en <br>
        input = input.replace(/\n/g, '<br>');
        input = input.replace(/(<br\s*\/?>\s*){2,}/g, '<br>');

        return input.trim();
    }
    async function loadAtelierContent() {
        try {
            const { data, error } = await supabaseClient
                .from('atelier_content') // Modifier le nom de la table selon votre base de données
                .select('*')
                .single();  // Charger un seul enregistrement

            if (error) {
                console.error("Erreur lors du chargement des données :", error);
                return;
            }

            // Injecter les données dans les éléments HTML
            document.getElementById('atelier-title').textContent = data.titre; // Titre de l'atelier



            // Injecter la description
            if (data.description) {
                // Nettoyer et injecter la description
                const atelierDescription = document.getElementById('atelier-description');
                atelierDescription.innerHTML = cleanText(data.description);
            } else {
                console.error("Description non disponible dans les données.");
            }

            data.adresse = data.adresse.replace(/,/g, "<br>");
            document.getElementById('atelier-location').innerHTML = data.adresse;

            // Injecter les horaires - Vérifier si les données existent avant de les traiter
            if (data.horaires) {
                const horairesListHtml = data.horaires.split(';').map(item => `<li>${item}</li>`).join('');
                document.getElementById('horaires-list').innerHTML = horairesListHtml;
            } else {
                document.getElementById('horaires-list').innerHTML = '<li>Aucun horaire disponible</li>';
            }


            if (data.tarifs) {
                data.tarifs = cleanText(data.tarifs);

                let tarifsListHtml = data.tarifs.split(';').map(item => `<li>${item}</li>`).join('');

                // Remplacer <li><br> par <li> si des retours à la ligne existent
                tarifsListHtml = tarifsListHtml.replace(/<li>\s*<br>\s*/g, '<li>');

                document.getElementById('tarifs-list').innerHTML = tarifsListHtml;
            } else {
                document.getElementById('tarifs-list').innerHTML = '<li>Aucun tarif disponible</li>';
            }


            // Carrousels dynamiques
            let carrousel3Images = [];
            try {
                carrousel3Images = JSON.parse(data.carrousel3_images);
            } catch (error) {
                // Si le JSON échoue, on passe à une version simple en séparant les virgules
                carrousel3Images = data.carrousel3_images ? data.carrousel3_images.split(',') : [];
            }

            // Vérification si carrousel3Images contient des éléments avant d'utiliser trim()
            const carrousel3Html = `
            <div class="carrousel-large">
                <img id="large-image-3" src="${carrousel3Images[0] && carrousel3Images[0].trim() ? carrousel3Images[0].trim() : '../img/placeholder.jpg'}" alt="Grande Image Carrousel 3">
            </div>
            <div class="carrousel-small">
                ${carrousel3Images.slice(1).map(img => {
                if (img && img.trim()) {
                    return `<img class="thumbnail" src="${img.trim()}" alt="Miniature Carrousel 3">`;
                }
                return ''; // Si l'image est vide ou undefined, on la saute
            }).join('')}
            </div>
        `;
            document.getElementById('carrousel3').innerHTML = carrousel3Html;
            changeImage('carrousel3', carrousel3Images);


        } catch (error) {
            console.error("Une erreur s'est produite :", error);
        }
    }
    loadAtelierContent();

    // Fonction pour changer l'image principale du carrousel
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('thumbnail')) {
            const largeImage = document.getElementById('large-image-3');
            largeImage.src = e.target.src;
        }
    });
</script>