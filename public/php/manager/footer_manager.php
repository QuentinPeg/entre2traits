<footer>
    <p>&copy; 2023 by CREATIVE EVENTS</p>
    <p>Toutes les photos, images, illustrations ou supports visuels sont soumis aux droits d'auteurs.</p>
    <div>
        <a href="https://www.facebook.com/Entre2Traits"><img src="../../img/facebook.webp" alt="Facebook"></a>
        <a href="https://www.youtube.com/channel/UCJcNeqQNF889gndHbw6mXfA"><img src="../../img/youtube.webp"
                alt="YouTube"></a>
    </div>
</footer>

<script src="../../js/carrousel.js" defer></script>
<script src="https://unpkg.com/@supabase/supabase-js"></script>
<script src="../../js/supabase.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuToggle = document.getElementById('menu-toggle');
        const menuItems = document.getElementById('menu-items');
        const menuClose = document.getElementById('menu-close');

        menuToggle.addEventListener('click', () => {
            menuItems.classList.toggle('show');
        });

        menuClose.addEventListener('click', () => {
            menuItems.classList.remove('show');
        });
    });
</script>

</body>

</html>