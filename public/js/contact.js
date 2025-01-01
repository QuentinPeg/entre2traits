async function loadContactContent() {
    try {
        const { data, error } = await supabaseClient
            .from('atelier_content')
            .select('adresse, contact')
            .single();

        if (error) {
            console.error("Erreur lors du chargement des données :", error);
            return;
        }

        // Injecter les données dans les éléments HTML
        document.getElementById('contact-address').innerHTML = data.adresse.replace(/,/g, "<br>");
        document.getElementById('contact-info').textContent = data.contact.replace(/(\d{2})(?=\d)/g, '$1 ');

    } catch (error) {
        console.error("Une erreur s'est produite :", error);
    }
}

document.addEventListener('DOMContentLoaded', loadContactContent);