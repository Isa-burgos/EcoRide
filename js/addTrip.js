
const steps = document.querySelectorAll(".step");
const prevBtn = document.querySelector(".btn-prev");
const nextBtn = document.querySelector(".btn-next");
const submitBtn = document.querySelector(".btn-submit");
let currentStep = 0;

function validateRequired(input){
    if(input.value.trim() !== ''){
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
    else{
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}

function checkInputs() {
    const currentStepInputs = steps[currentStep].querySelectorAll("input[required]");
    let allFilled = true;

    currentStepInputs.forEach(input =>{
        if(!validateRequired(input)){
            allFilled = false;
        }
    });

    const currentNextBtn = steps[currentStep].querySelector(".btn-next");
    if (currentNextBtn) {
        currentNextBtn.disabled = !allFilled;
    }
}

function updateSteps(){
    steps.forEach((step, index) =>{
        const stepContent = step.querySelector(".step-content");
        const stepButtons = step.querySelector(".step-buttons")
        if(stepContent){
            if(index === currentStep){
                stepContent.style.display = "block";
            }
            else{
                stepContent.style.display = "none";
            }
        }
        else{
            console.warn(`⚠ Pas de .step-content trouvé pour l'étape ${index + 1}`);
        }

        if(stepButtons){
            if(index ===currentStep){
                stepButtons.style.display = "flex";
            }
            else{
                stepButtons.style.display = "none";
            }
        }else {
            console.warn(`⚠ Pas de .step-buttons trouvé pour l'étape ${index + 1}`);
        }
    });

    const currentStepElement = steps[currentStep];
    if (!currentStepElement) {
        console.error(`⚠ Erreur : Aucune étape trouvée pour index ${currentStep}`);
        return;
    }

    const currentPrevBtn = steps[currentStep].querySelector(".btn-prev");
    const currentNextBtn = steps[currentStep].querySelector(".btn-next");
    const currentSubmitBtn = steps[currentStep].querySelector(".btn-submit");
    
    if (currentPrevBtn) {
        if (currentStep === 0) {
            currentPrevBtn.style.display = "none";
        } else {
            currentPrevBtn.style.display = "inline-block";
        }
    } else if (currentStep !== 0) {
        console.warn(`⚠ Bouton "Précédent" non trouvé pour l'étape ${currentStep + 1}`);
    }
    
    if (currentNextBtn) {
        if (currentStep === steps.length - 1) {
            currentNextBtn.style.display = "none";
        } else {
            currentNextBtn.style.display = "inline-block";
        }
    } else if (currentStep !== steps.length - 1) {
        console.warn(`⚠ Bouton "Suivant" non trouvé pour l'étape ${currentStep + 1}`);
    }
    
    if (currentSubmitBtn) {
        if (currentStep === steps.length - 1) {
            currentSubmitBtn.style.display = "inline-block";
        } else {
            currentSubmitBtn.style.display = "none";
        }
    } else if (currentStep === steps.length - 1) {
        console.warn(`⚠ Bouton "Soumettre" non trouvé pour l'étape ${currentStep + 1}`);
    }

    checkInputs();
}

steps.forEach(step => {
    step.addEventListener("input", checkInputs);
});

document.addEventListener("click", (event)=>{
    if(event.target.classList.contains("btn-next")){
        if(currentStep < steps.length -1){
            currentStep++;
            updateSteps();
        }
    }
});

document.addEventListener("click", (event)=>{
    if(event.target.classList.contains("btn-prev")){
        if(currentStep > 0){
            currentStep--;
            updateSteps();
        }
    }
});

updateSteps();


// Géolocalisation
async function getAdressFromCoordonates(latitude, longitude) {
    try{
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`);
        const data = await response.json();
        console.log(data)

        if(data && data.display_name){
            return data.display_name;
        } else{
            console.error("Impossible de récupérer l'adresse");
        }
    } catch(error){
        console.error("Erreur lors de la récupération de l'adresse :", error);
        return null;
    }
}

async function getGeolocation(inputFields) {
    if(!navigator.geolocation){
        alert("La géolocalisation n'est pas supportée par votre navigateur");
        return;
    }

    navigator.geolocation.getCurrentPosition(
        async (position) =>{
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            console.log(`Position détectée : ${latitude}, ${longitude}`);

            const adress = await getAdressFromCoordonates(latitude, longitude);

            if(adress){
                inputFields.value = adress;
                inputFields.dispatchEvent(new Event('input', {bubbles: true}));
            }
        },
        (error)=>{
            console.error("Erreur de géolocalisation", error);
            alert("Impossible d'obtenir votre position")
            
        }
    );
}

document.getElementById("geolocDepart").addEventListener("click", ()=>{
    getGeolocation(document.getElementById("departAdress"));
});

document.getElementById("geolocArrival").addEventListener("click", ()=>{
    getGeolocation(document.getElementById("arrivalAdress"));
})

// Autocomplétion
async function getAdressSuggestions(query, containerId, inputId) {
    if(query.length < 3) return;

try{
    const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&addressdetails=1&limit=5&countrycodes=fr`);
    const data = await response.json();

    const container = document.getElementById(containerId);

    container.innerHTML = "";
    container.style.display = "block";

    if (!data.length) {
        container.style.display = "none";
        console.warn("⚠️ Aucun résultat trouvé !");
        return;
    }

    data.forEach(place =>{
        let div = document.createElement("div");
        div.classList.add("suggestion-item");
        div.textContent = place.display_name;
        div.addEventListener("click", () =>{
            document.getElementById(inputId).value = place.display_name;
            container.innerHTML = "";
            container.style.display = "none";
        })
        container.appendChild(div);
    });
    }catch (error) {
        console.error("Erreur lors de la récupération des adresses :", error);
    }
}

document.getElementById("departAdress").addEventListener("input", (e)=>{
    getAdressSuggestions(e.target.value, "suggestionsDepart", "departAdress");
});

document.getElementById("arrivalAdress").addEventListener("input", (e)=>{
    getAdressSuggestions(e.target.value, "suggestionsArrival", "arrivalAdress");
});

document.addEventListener("click", (e) =>{
    if(!e.target.closest(".input-container")){
        document.getElementById("suggestionsDepart").style.display = "none";
        document.getElementById("suggestionsArrival").style.display = "none";
    }
})

function getSelectedAdress(){
    const departAdress = document.getElementById("departAdress");
    const arrivalAdress = document.getElementById("arrivalAdress");
    const selectedAdressDepart = document.getElementById("selectedAdressDepart");
    const selectedAdressArrival = document.getElementById("selectedAdressArrival");

    if(departAdress.value.trim() !==""){
        selectedAdressDepart.textContent = departAdress.value;
    } else{
        selectedAdressDepart.textContent = "Aucune adresse sélectionnée";
    }
    if(arrivalAdress.value.trim() !==""){
        selectedAdressArrival.textContent = arrivalAdress.value;
    } else{
        selectedAdressArrival.textContent = "Aucune adresse sélectionnée";
    }
}

document.getElementById("departAdress").addEventListener("input", getSelectedAdress);
document.getElementById("arrivalAdress").addEventListener("input", getSelectedAdress);