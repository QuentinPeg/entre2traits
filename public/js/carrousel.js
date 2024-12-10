            // Fonction pour changer l'image principale de manière fluide
            function changeImage(carrouselId, images) {
                const carrousel = document.getElementById(carrouselId);
                const largeImage = carrousel.querySelector('.carrousel-large img');
                const thumbnails = carrousel.querySelectorAll('.carrousel-small .thumbnail');
                let currentIndex = 0;

                function updateCarrousel() {
                    // Appliquer une animation de fondu à l'image principale
                    largeImage.classList.add('fade-out');

                    // Attendre que l'animation soit terminée avant de changer l'image
                    setTimeout(() => {
                        // Mettre à jour l'image principale
                        currentIndex = (currentIndex + 1) % images.length;
                        largeImage.src = images[currentIndex].trim();
                        largeImage.classList.remove('fade-out');

                        // Mettre à jour les miniatures
                        thumbnails.forEach((thumbnail, index) => {
                            const thumbnailIndex = (currentIndex + index + 1) % images.length;
                            thumbnail.src = images[thumbnailIndex].trim();
                        });
                    }, 500); // Temps de l'animation (0.5s)
                }

                // Défilement automatique toutes les 5 secondes
                setInterval(updateCarrousel, 5000);
            }
            // Appliquer le défilement fluide aux deux carrousels
