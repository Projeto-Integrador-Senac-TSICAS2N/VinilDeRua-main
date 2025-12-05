const profileMenu = document.querySelector('.profile-menu');
    const profileBtn  = document.querySelector('.profile-btn');

    if (profileMenu && profileBtn) {
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileMenu.classList.toggle('open');
        });

        // Fecha ao clicar fora
        document.addEventListener('click', () => {
            profileMenu.classList.remove('open');
        });
    }
