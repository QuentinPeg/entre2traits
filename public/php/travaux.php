<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travaux d'élèves</title>
    <link rel="stylesheet" href="../css/travaux.css">
</head>

<?php include "./header.php"; ?>

<main>
    <section class="student-work">

        <div id="sections_container"></div>
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
        for (const [section, carousels] of Object.entries(groupedBySection)) {
            // Ajouter un titre pour chaque section
            const sectionTitle = document.createElement('h2');
            sectionTitle.textContent = section;
            sectionsContainer.appendChild(sectionTitle);

            // Ajouter les carrousels pour cette section
            carousels.forEach(carousel => {
                const carouselDiv = document.createElement('div');
                carouselDiv.className = 'carousel';

                const title = document.createElement('h3');
                title.textContent = carousel.title;
                carouselDiv.appendChild(title);

                const contentDiv = document.createElement('div');
                contentDiv.className = 'carousel-images';

                carousel.content.forEach(item => {
                    if (carousel.type === 'images') {
                        const imgElement = document.createElement('img');
                        imgElement.src = item;
                        imgElement.alt = 'Image du carrousel';
                        contentDiv.appendChild(imgElement);
                    } else if (carousel.type === 'videos') {
                        const videoElement = document.createElement('iframe');
                        videoElement.src = item;
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
                sectionsContainer.appendChild(carouselDiv);
            });
        }
    }

    function scrollCarousel(container, direction) {
        const items = container.querySelectorAll('img, iframe');
        const scrollAmount = items[0].clientWidth + 16; // 16px is the gap between items

        if (direction === 1) {
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            setTimeout(() => {
                container.style.scrollBehavior = 'auto';
                container.appendChild(items[0]);
                container.scrollLeft -= scrollAmount;
                container.style.scrollBehavior = 'smooth';
            }, 300);
        } else {
            container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            setTimeout(() => {
                container.style.scrollBehavior = 'auto';
                container.prepend(items[items.length - 1]);
                container.scrollLeft += scrollAmount;
                container.style.scrollBehavior = 'smooth';
            }, 300);
        }
    }

    loadCarousels();
</script>