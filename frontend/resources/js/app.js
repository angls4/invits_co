import "./bootstrap";
import Alpine from "alpinejs";
import Splide from "@splidejs/splide";
import jQuery from "jquery";
import "@splidejs/splide/css";
import "flowbite";

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
        this.showMobileNav = !this.showMobileNav;
    },
}));

window.Alpine = Alpine;
window.Splide = Splide;
window.$ = jQuery;

Alpine.start();
