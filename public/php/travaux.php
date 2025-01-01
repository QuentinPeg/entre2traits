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
        <h1>Travaux d'élèves</h1>
        <div>
            <h3>Des illustrations</h3>
            <div id="carousels_container"></div>
        </div>
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

        const carouselsContainer = document.getElementById('carousels_container');
        carouselsContainer.innerHTML = '';

        data.forEach(carousel => {
            const carouselDiv = document.createElement('div');
            carouselDiv.className = 'carousel';

            const title = document.createElement('h2');
            title.textContent = carousel.title;
            carouselDiv.appendChild(title);

            const imagesDiv = document.createElement('div');
            imagesDiv.className = 'carousel-images';

            carousel.images.forEach(img => {
                const imgElement = document.createElement('img');
                imgElement.src = img;
                imgElement.alt = 'Image du carrousel';
                imagesDiv.appendChild(imgElement);
            });

            const prevButton = document.createElement('button');
            prevButton.className = 'carousel-prev';
            prevButton.innerHTML = '&#10094;';
            prevButton.onclick = () => scrollCarousel(imagesDiv, -1);

            const nextButton = document.createElement('button');
            nextButton.className = 'carousel-next';
            nextButton.innerHTML = '&#10095;';
            nextButton.onclick = () => scrollCarousel(imagesDiv, 1);

            carouselDiv.appendChild(prevButton);
            carouselDiv.appendChild(imagesDiv);
            carouselDiv.appendChild(nextButton);
            carouselsContainer.appendChild(carouselDiv);
        });
    }

    function scrollCarousel(container, direction) {
        const images = container.querySelectorAll('img');
        const scrollAmount = images[0].clientWidth + 16; // 16px is the gap between images

        if (direction === 1) {
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            setTimeout(() => {
                container.style.scrollBehavior = 'auto';
                container.appendChild(images[0]);
                container.scrollLeft -= scrollAmount;
                container.style.scrollBehavior = 'smooth';
            }, 300);
        } else {
            container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            setTimeout(() => {
                container.style.scrollBehavior = 'auto';
                container.prepend(images[images.length - 1]);
                container.scrollLeft += scrollAmount;
                container.style.scrollBehavior = 'smooth';
            }, 300);
        }
    }

    loadCarousels();
</script>