const emailInput = document.getElementById("emailInput");
const passwordInput = document.getElementById("passwordInput");
const btnLogin = document.getElementById("btnLogin");

btnLogin.addEventListener("click", checkCredentials);

function checkCredentials(){
    // Ici il faudra appeler l'API pour vérifier les credentials en BDD

    if(emailInput.value == "test@mail.fr" && passwordInput.value === "123"){
        // Il faudra récupérer le vrai token
        const token = "dqjsbdhqsbdjkbqsjwbdcbqhdvhqsdhsgdhqsg";
        setToken(token);

        setCookie(roleCookieName, "admin", 7);

        window.location.replace("/");
    }
    else{
        emailInput.classList.add("is-invalid");
        passwordInput.classList.add("is-invalid");
    }
}