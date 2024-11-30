function setupAllCarrousels() {
    document.querySelectorAll('.carrousel').forEach(carrousel => {
        setupCarrousel(carrousel);
    });
}

function setupCarrousel(carrousel) {
    const images = carrousel.children;
    const totalImages = images.length;

    // Cloner la première et la dernière image
    const firstClone = images[0].cloneNode(true);
    const lastClone = images[totalImages - 1].cloneNode(true);
    carrousel.appendChild(firstClone);
    carrousel.insertBefore(lastClone, images[0]);

    let currentIndex = 1;
    const scrollTime = 10000; // Temps de défilement automatique
    const updateWidth = () => carrousel.offsetWidth; // Fonction pour obtenir la largeur
    let carrouselWidth = updateWidth();

    // Initialiser la position du carrousel
    carrousel.scrollTo({
        left: carrouselWidth,
        behavior: 'instant',
    });

    // Fonction pour aller à l'image suivante
    function nextImage() {
        currentIndex++;
        carrousel.scrollTo({
            left: currentIndex * carrouselWidth,
            behavior: 'smooth',
        });

        if (currentIndex > totalImages) {
            setTimeout(() => {
                carrousel.scrollTo({
                    left: carrouselWidth,
                    behavior: 'instant',
                });
                currentIndex = 1;
            }, 500);
        }
    }

    // Fonction pour aller à l'image précédente
    function prevImage() {
        currentIndex--;
        carrousel.scrollTo({
            left: currentIndex * carrouselWidth,
            behavior: 'smooth',
        });

        if (currentIndex < 1) {
            setTimeout(() => {
                carrousel.scrollTo({
                    left: totalImages * carrouselWidth,
                    behavior: 'instant',
                });
                currentIndex = totalImages;
            }, 500);
        }
    }

    // Associer les boutons au carrousel
    const parentArticle = carrousel.closest('article');
    const prevButton = parentArticle.querySelector('.prev');
    const nextButton = parentArticle.querySelector('.next');

    if (prevButton && nextButton) {
        prevButton.addEventListener('click', prevImage);
        nextButton.addEventListener('click', nextImage);
    }

    // Défilement automatique
    setInterval(nextImage, scrollTime);

    // Réagir au redimensionnement pour recalculer la largeur
    window.addEventListener('resize', () => {
        carrouselWidth = updateWidth();
        carrousel.scrollTo({
            left: currentIndex * carrouselWidth,
            behavior: 'instant',
        });
    });
}

// Initialiser tous les carrousels au chargement
setupAllCarrousels();
