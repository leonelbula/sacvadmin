/* =====================================================
   SACVAdmin Dashboard JS
===================================================== */

import "bootstrap";

// =====================================================
// SIDEBAR ELEMENTS
// =====================================================

const menuToggle = document.getElementById("menuToggle");

const sidebar = document.getElementById("sidebar");

const main = document.querySelector(".main");

const navbar = document.querySelector(".top-navbar");

const overlay = document.getElementById("sidebarOverlay");

const menuIcon = document.getElementById("menuIcon");

// =====================================================
// SIDEBAR DESKTOP COLLAPSE + MOBILE SLIDE
// =====================================================

if (menuToggle) {
    menuToggle.addEventListener("click", () => {
        /*
        Detectar tamaño pantalla
        */

        if (window.innerWidth <= 992) {
            // MOBILE

            sidebar.classList.toggle("show");

            if (overlay) {
                overlay.classList.toggle("show");
            }

            cambiarIcono();
        } else {
            // DESKTOP

            sidebar.classList.toggle("collapsed");

            if (main) {
                main.classList.toggle("expanded");
            }

            if (navbar) {
                navbar.classList.toggle("expanded");
            }
        }
    });
}

// =====================================================
// CERRAR SIDEBAR AL TOCAR OVERLAY
// =====================================================

if (overlay) {
    overlay.addEventListener("click", () => {
        sidebar.classList.remove("show");

        overlay.classList.remove("show");

        cambiarIcono(false);
    });
}

// =====================================================
// CAMBIO ICONO MENU
// =====================================================

function cambiarIcono(open = null) {
    if (!menuIcon) return;

    if (open === null) {
        open = sidebar.classList.contains("show");
    }

    if (open) {
        menuIcon.classList.remove("bi-list");

        menuIcon.classList.add("bi-x");
    } else {
        menuIcon.classList.remove("bi-x");

        menuIcon.classList.add("bi-list");
    }
}

// =====================================================
// SUBMENUS SIDEBAR
// =====================================================

const submenuButtons = document.querySelectorAll(".menu-toggle-item");

submenuButtons.forEach((button) => {
    button.addEventListener("click", () => {
        const parent = button.closest(".menu-group");

        parent.classList.toggle("active");
    });
});

// =====================================================
// GUARDAR ESTADO SIDEBAR DESKTOP
// =====================================================

const savedSidebar = localStorage.getItem("sidebarState");

if (savedSidebar === "collapsed" && window.innerWidth > 992) {
    sidebar.classList.add("collapsed");

    if (main) {
        main.classList.add("expanded");
    }

    if (navbar) {
        navbar.classList.add("expanded");
    }
}

// =====================================================
// GUARDAR ESTADO AL CAMBIAR
// =====================================================

if (menuToggle) {
    menuToggle.addEventListener("click", () => {
        if (window.innerWidth > 992) {
            if (sidebar.classList.contains("collapsed")) {
                localStorage.setItem("sidebarState", "collapsed");
            } else {
                localStorage.setItem("sidebarState", "normal");
            }
        }
    });
}

// =====================================================
// AJUSTAR AL CAMBIAR TAMAÑO
// =====================================================

window.addEventListener("resize", () => {
    if (window.innerWidth > 992) {
        sidebar.classList.remove("show");

        if (overlay) {
            overlay.classList.remove("show");
        }
    }
});
