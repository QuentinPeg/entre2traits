document.addEventListener("DOMContentLoaded", () => {
    const links = document.querySelectorAll('.copy-link');
    const toast = document.getElementById('toast');

    function showToast(message) {
        toast.textContent = message;
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 2000); // Afficher le toast pendant 2 secondes
    }

    links.forEach(link => {
        link.addEventListener('click', () => {
            const textToCopy = link.getAttribute('data-clipboard');
            navigator.clipboard.writeText(textToCopy)
                .then(() => {
                    showToast(`Lien copié: ${textToCopy}`);
                })
                .catch(err => {
                    console.error('Erreur lors de la copie dans le presse-papiers: ', err);
                    showToast('Échec de la copie dans le presse-papiers.');
                });
        });
    });
});
