// Gestion de la soumission du formulaire de connexion
document.getElementById('login-form').addEventListener('submit', async (event) => {
    event.preventDefault();  // Empêche le formulaire de se soumettre de manière classique

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {

        // Tentative de connexion avec Supabase
        const { data, error } = await supabaseClient.auth.signInWithPassword({
            email: email,
            password: password
        });

        if (error) {
            throw error;  // Si une erreur se produit, elle est lancée
        }

        // Si la connexion réussie, redirection vers la page d'accueil ou page manager
        window.location.href = './manager/manager.php';  // Page manager après connexion réussie

    } catch (error) {
        document.getElementById('error-message').textContent = 'Erreur de connexion: ' + error.message;
        document.getElementById('error-message').style.display = 'block';
    }
});