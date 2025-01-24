import Route from "./Route.js";

//Définir ici vos routes
export const allRoutes = [
    new Route("/", "Accueil", "/pages/home.html"),
    new Route("/login", "Se connecter", "/pages/login.html"),
    new Route("/register", "Créer un compte", "/pages/register.html"),
    new Route("/contact", "Contact", "/pages/contact.html"),
];

//Le titre s'affiche comme ceci : Route.titre - websitename
export const websiteName = "Quai Antique";