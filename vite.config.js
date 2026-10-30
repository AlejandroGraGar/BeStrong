import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: "0.0.0.0",      // Acepta conexiones desde fuera del contenedor Docker
        port: 5173,
        hmr: {
            host: "localhost", // El navegador se conecta a localhost:5173
        },
    },
});
