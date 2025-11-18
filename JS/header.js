/** 1. Abre/Fecha o menu principal. (Antiga: toggleProfileMenu) */
    function alternarMenuPerfil() {
        const menu = document.getElementById('menuPerfil');
        menu.classList.toggle('show');
    }

    /** 2. Abre/Fecha o sub-menu. (Antiga: toggleSubMenu) */
    function alternarSubMenu(event) {
        event.preventDefault(); 
        event.stopPropagation(); 
        const submenu = document.getElementById('subMenuConfig');
        submenu.classList.toggle('show');
    }
    
    /** 3. Fecha menus ao clicar fora. */
    document.addEventListener('click', function(event) {
        const icone = document.querySelector('.icone-perfil');
        const menu = document.getElementById('menuPerfil');
        
        if (menu && menu.classList.contains('show')) {
            if (!icone.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.remove('show');
                const submenu = document.getElementById('subMenuConfig');
                if (submenu) { submenu.classList.remove('show'); }
            }
        }
    });