import "./bootstrap";
import Alpine from "alpinejs";

Alpine.data("navState", () => ({
    navTheme: "",
    showMobileNav: false,
    isUserMenuOpen: false,

    initState() {
        if (window.pageYOffset > 0) {
            this.navTheme = "nav-dark";
        } else {
            this.navTheme = "nav-light";
        }
    },

    toggleMobileNav() {
        this.showMobileNav = !this.showMobileNav
    }
}));

Alpine.start();
