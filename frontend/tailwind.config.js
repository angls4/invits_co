/** @type {import('tailwindcss').Config} */
const defaultTheme = require("tailwindcss/defaultTheme");

export default {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    theme: {
        extend: {
            colors: {
                brand: {
                    purple: {
                        100: "#E1D5F9",
                        200: "#C3AAF3",
                        300: "#A580EE",
                        400: "#8755E8",
                        500: "#692BE2",
                        600: "#5422B5",
                        700: "#3F1A88",
                        800: "#2A115A",
                        900: "#15092D",
                    },
                    yellow: {
                        100: "#F9F2D5",
                        200: "#F3E5AA",
                        300: "#EED980",
                        400: "#E8CC55",
                        500: "#E2BF2B",
                        600: "#B59922",
                        700: "#88731A",
                        800: "#5A4C11",
                        900: "#2D2609",
                    },
                    pink: "#9E1E9C",
                    red: "#EA4134",
                },
            },
        },
        screens: {
            xs: "475px",
            ...defaultTheme.screens,
        },
        container: {
            center: true,
            padding: {
                DEFAULT: "1rem",
                sm: "2rem",
                md: "3rem",
                lg: "4rem",
                xl: "5rem",
            },
        },
    },
    plugins: [],
};
