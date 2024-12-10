<?php include "./header.php"; ?>

<main>
    <section class="main-section">
        <h1 id="title">Chargement...</h1>

        <div class="icons" id="icons">
            <!-- Les icônes seront injectées ici -->
        </div>

        <div class="content">
            <p id="welcome_message">Chargement...</p>
            <hr>
            <h2>Les infos du moment :</h2>
            <p id="current_info">Chargement...</p>
        </div>

        <div id="ndpart">
            <img src="" alt="Message aux utilisateurs" id="img_accueil">
            <div>
                <section>
                    <h5>Inscription et Règlement en ligne</h5>
                    <a id="inscription_link" href="#" class="lien_s">
                        <img src="../img/carte-bleue-webp.webp" alt="Carte de paiement">
                        <img src="../img/picto_inscription.webp" alt="Picto inscription">
                    </a>
                </section>

                <!-- Carrousel de Travaux d'Élèves -->
                <article class="carr">
                    <div id="carrousel1" class="carrousel index-page">
                        <!-- Grande image -->
                        <div class="carrousel-large">
                            <img id="large-image-1" src="../img/picto_inscription.webp" alt="Grande Image Carrousel 1">
                        </div>
                        <!-- Miniatures -->
                        <div class="carrousel-small">
                            <!-- Les miniatures seront injectées ici -->
                        </div>
                    </div>
                </article>

                <article class="carr">
                    <div id="carrousel2" class="carrousel index-page">
                        <!-- Grande image -->
                        <div class="carrousel-large">
                            <img id="large-image-2" src="../img/picto_inscription.webp" alt="Grande Image Carrousel 2">
                        </div>
                        <!-- Miniatures -->
                        <div class="carrousel-small">
                            <!-- Les miniatures seront injectées ici -->
                        </div>
                    </div>

                </article>
            </div>
        </div>
    </section>
</main>

<?php include "./footer.php"; ?>

<script>
    async function loadAccueilContent() {
        try {
            const { data, error } = await supabaseClient
                .from('accueil_content')
                .select('*')
                .single();

            if (error) {
                console.error("Erreur lors du chargement des données :", error);
                return;
            }

            // Injecter les données dynamiques dans la page
            document.getElementById('title').textContent = data.welcome_title;
            document.getElementById('welcome_message').textContent = data.welcome_message;
            document.getElementById('current_info').textContent = data.current_info;
            document.getElementById('img_accueil').src = data.welcome_img;

            // Icônes dynamiques
            const iconsHtml = `  
                <a href="${data.icon1_link}">
                    <img src="${data.icon1_img}" alt="Icone Atelier">
                    <p>${data.icon1_text}</p>
                </a>
                <a href="${data.icon2_link}">
                    <img src="${data.icon2_img}" alt="Icone Actualités">
                    <p>${data.icon2_text}</p>
                </a>
                <a href="${data.icon3_link}">
                    <img src="${data.icon3_img}" alt="Icone Travaux d'élèves">
                    <p>${data.icon3_text}</p>
                </a>
                <a href="${data.icon4_link}">
                    <img src="${data.icon4_img}" alt="Icone Contact">
                    <p>${data.icon4_text}</p>
                </a>
                <a href="${data.icon5_link}">
                    <img src="${data.icon5_img}" alt="Icone Boutique">
                    <p>${data.icon5_text}</p>
                </a>
            `;
            document.getElementById('icons').innerHTML = iconsHtml;

            // Carrousels dynamiques
            let carrousel1Images = [];
            try {
                carrousel1Images = JSON.parse(data.carrousel1_images);
            } catch (error) {
                carrousel1Images = data.carrousel1_images.split(',');
            }

            // Injecter la grande image et les miniatures dans carrousel 1
            const carrousel1Html = `
            <div class="carrousel-large">
                <img id="large-image-1" src="${carrousel1Images[0].trim()}" alt="Grande Image Carrousel 1">
            </div>
            <div class="carrousel-small">
                ${carrousel1Images.slice(1).map(img => `<img class="thumbnail" src="${img.trim()}" alt="Miniature Carrousel 1">`).join('')}
            </div>
        `;
            document.getElementById('carrousel1').innerHTML = carrousel1Html;

            let carrousel2Images = [];
            try {
                carrousel2Images = JSON.parse(data.carrousel2_images);
            } catch (error) {
                carrousel2Images = data.carrousel2_images.split(',');
            }

            // Injecter la grande image et les miniatures dans carrousel 2
            const carrousel2Html = `
            <div class="carrousel-large">
                <img id="large-image-2" src="${carrousel2Images[0].trim()}" alt="Grande Image Carrousel 2">
            </div>
            <div class="carrousel-small">
                ${carrousel2Images.slice(1).map(img => `<img class="thumbnail" src="${img.trim()}" alt="Miniature Carrousel 2">`).join('')}
            </div>
        `;
            document.getElementById('carrousel2').innerHTML = carrousel2Html;

            changeImage('carrousel1', carrousel1Images);
            changeImage('carrousel2', carrousel2Images);

        } catch (error) {
            console.error("Une erreur s'est produite :", error);
        }
    }

    loadAccueilContent();

    // Changer l'image principale du carrousel lorsqu'on clique sur une miniature
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('thumbnail')) {
            const largeImage = e.target.closest('.carrousel').querySelector('.carrousel-large img');
            largeImage.src = e.target.src;
        }
    });


</script>