
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travaux</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../css/travaux.css">
    <script type="module" src="../../js/supabase.js"></script>
</head>

<?php include "./header.php"; ?>

<main>
    <section id="sections_container">
        <!-- Les sections seront chargées ici par JavaScript -->
    </section>
</main>

<?php include "./footer.php"; ?>

<script>
    async function loadCarousels() {
        const { data, error } = await supabaseClient
            .from('travaux')
            .select('*');

        if (error) {
            console.error('Erreur lors du chargement des carrousels:', error);
            return;
        }

        const sectionsContainer = document.getElementById('sections_container');
        sectionsContainer.innerHTML = '';

        // Grouper les carrousels par section
        const groupedBySection = data.reduce((acc, item) => {
            acc[item.section] = acc[item.section] || [];
            acc[item.section].push(item);
            return acc;
        }, {});

        // Créer les sections et leurs contenus
        for (const [section, items] of Object.entries(groupedBySection)) {
            // Ajouter un titre pour chaque section
            const sectionDiv = document.createElement('div');
            sectionDiv.className = 'section';
            const sectionTitle = document.createElement('h2');
            sectionTitle.textContent = section;
            sectionDiv.appendChild(sectionTitle);

            // Ajouter les carrousels et les boutons pour cette section
            items.forEach(item => {
                if (item.type === 'images' || item.type === 'videos') {
                    const carouselDiv = document.createElement('div');
                    carouselDiv.className = 'carousel';

                    const title = document.createElement('h3');
                    title.textContent = item.title;
                    carouselDiv.appendChild(title);

                    const contentDiv = document.createElement('div');
                    contentDiv.className = 'carousel-images';

                    item.content.forEach(contentItem => {
                        if (item.type === 'images') {
                            const imgElement = document.createElement('img');
                            imgElement.src = contentItem;
                            imgElement.alt = 'Image du carrousel';
                            contentDiv.appendChild(imgElement);
                        } else if (item.type === 'videos') {
                            const videoElement = document.createElement('iframe');
                            videoElement.src = contentItem;
                            videoElement.controls = true;
                            contentDiv.appendChild(videoElement);
                        }
                    });

                    const prevButton = document.createElement('button');
                    prevButton.className = 'carousel-prev';
                    prevButton.innerHTML = '&#10094;';
                    prevButton.onclick = () => scrollCarousel(contentDiv, -1);

                    const nextButton = document.createElement('button');
                    nextButton.className = 'carousel-next';
                    nextButton.innerHTML = '&#10095;';
                    nextButton.onclick = () => scrollCarousel(contentDiv, 1);

                    carouselDiv.appendChild(prevButton);
                    carouselDiv.appendChild(contentDiv);
                    carouselDiv.appendChild(nextButton);
                    sectionDiv.appendChild(carouselDiv);
                } else if (item.type === 'buttons') {
                    const title = document.createElement('h3');
                    title.textContent = item.title;
                    sectionDiv.appendChild(title);

                    const buttonsDiv = document.createElement('div');
                    buttonsDiv.className = 'buttons';

                    let buttonContent;
                    try {
                        buttonContent = typeof item.content === 'string' ? JSON.parse(item.content) : item.content;
                    } catch (e) {
                        console.error('Erreur lors de l\'analyse du contenu des boutons:', e);
                        return;
                    }

                    buttonContent.forEach(button => {
                        const divdebuttons = document.createElement('div');
                        const h4debuttons = document.createElement('h4');
                        h4debuttons.textContent = button.text;
                        const imgElement = document.createElement('img');
                        imgElement.className = 'button-image';
                        imgElement.alt = 'Image du bouton';
                        imgElement.src = button.image;
                        const buttonElement = document.createElement('button');
                        buttonElement.textContent = "Lire";
                        buttonElement.onclick = () => window.open(button.file, '_blank');
                        divdebuttons.appendChild(h4debuttons);
                        if (button.image){
                            divdebuttons.appendChild(imgElement);
                        }
                        divdebuttons.appendChild(buttonElement);
                        buttonsDiv.appendChild(divdebuttons);
                    });

                    // Ajouter la classe appropriée en fonction du nombre de boutons
                    if (buttonContent.length % 3 === 0) {
                        buttonsDiv.classList.add('grid-3');
                    } else {
                        buttonsDiv.classList.add('grid-2');
                    }

                    sectionDiv.appendChild(buttonsDiv);
                }
            });

            sectionsContainer.appendChild(sectionDiv);
        }
    }

    function scrollCarousel(carousel, direction) {
        const scrollAmount = carousel.clientWidth;
        carousel.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    }

    document.addEventListener('DOMContentLoaded', loadCarousels);
</script>