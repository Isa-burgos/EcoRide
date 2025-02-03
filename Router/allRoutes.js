import Route from "./Route.js";

//Définir ici vos routes
export const allRoutes = [
    new Route("/", "Accueil", "/pages/home.html", []),
    new Route("/login", "Se connecter", "/pages/auth/login.html", ["disconnected"], "/js/auth/login.js"),
    new Route("/register", "Créer un compte", "/pages/auth/register.html", ["disconnected"], "/js/auth/register.js"),
    new Route("/contact", "Contact", "/pages/contact.html", []), 
    new Route("/dashboard", "Mon compte", "/pages/auth/dashboard.html", ["user", "admin", "employe"]),
    new Route("/account", "Mon compte", "/pages/auth/account.html", ["user", "admin", "employe"]),
    new Route("/covoiturages", "Covoiturages", "/pages/covoiturages.html", []),
    new Route("/results", "Covoiturages", "/pages/results-covoiturages.html", []),
    new Route("/trip", "Trajet", "/pages/vue-covoiturage.html", []),
];

//Le titre s'affiche comme ceci : Route.titre - websitename
export const websiteName = "Quai Antique";