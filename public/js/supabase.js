// Initialisation de Supabase
const SUPABASE_URL = 'https://dquhqpoitxwaahkdrkfy.supabase.co';
const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImRxdWhxcG9pdHh3YWFoa2Rya2Z5Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjYzMTc3NTcsImV4cCI6MjA0MTg5Mzc1N30.ayeOG1udDkkBM0yPNI1v9F8Eox_0s7ja-6UVtSgj1KE';
const supabaseClient = supabase.createClient(SUPABASE_URL, SUPABASE_KEY);

// Vérification si l'utilisateur est connecté et s'il est admin avec onAuthStateChange
supabaseClient.auth.onAuthStateChange(async (event, session) => {
    const user = session?.user;  // Récupérer l'utilisateur connecté à partir de la session

    if (user) {
        document.getElementById('manager-link').style.display = 'inline-block';
    }
});
