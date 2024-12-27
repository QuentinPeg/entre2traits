
// Vérification si l'utilisateur est connecté et s'il est admin avec onAuthStateChange
supabaseClient.auth.onAuthStateChange(async (event, session) => {
    const user = session?.user;  // Récupérer l'utilisateur connecté à partir de la session

    if (!user) {
        window.location.href = './unauthorized.php';  // Page d'accès non autorisé
    }
});

// Fonction de déconnexion
document.getElementById('logout-button').addEventListener('click', async () => {
    const { error } = await supabaseClient.auth.signOut();

    if (error) {
        console.error('Erreur de déconnexion:', error.message);
    } else {
        window.location.href = './login.php';  // Rediriger vers la page de connexion
    }
});
