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
        console.warn(`Bouton "Suivant" non trouvé pour l'étape ${currentStep + 1}`);
    }
    
    if (currentSubmitBtn) {
        if (currentStep === steps.length - 1) {
            currentSubmitBtn.style.display = "inline-block";
        } else {
            currentSubmitBtn.style.display = "none";
        }
    } else if (currentStep === steps.length - 1) {
        console.warn(`Bouton "Soumettre" non trouvé pour l'étape ${currentStep + 1}`);
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
const apiKey = "5b3ce3597851110001cf624894e6d5ed94c843baa9d0888a16c6e6a7";

async function getAdressFromCoordinates(latitude, longitude) {
    const url = `https://api.openrouteservice.org/geocode/reverse?api_key=${apiKey}&point.lat=${latitude}&point.lon=${longitude}&size=1`;

    try{
        const response = await fetch(url);
        const data = await response.json();

        if(data.features.length > 0){
            return data.features[0].properties.label;
        } else{
            console.error("Adresse introuvable");
            return null;
        }
    } catch(error){
        console.error("Erreur de géocodage inversé :", error);
        return null;
    }
}

async function getGeolocation(inputField) {
    if(!navigator.geolocation){
        alert("La géolocalisation n'est pas supportée par votre navigateur");
        return;
    }

    navigator.geolocation.getCurrentPosition(
        async (position) =>{
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            const adress = await getAdressFromCoordinates(latitude, longitude);

            if(adress){
                inputField.value = adress;
                inputField.dispatchEvent(new Event('input', {bubbles: true}));
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
let debounceTimer = null;

async function getAdressSuggestions(query, containerId, inputId) {
    if(query.length < 3) return;

    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(async() =>{
        const url = `https://api.openrouteservice.org/geocode/search?api_key=${apiKey}&text=${encodeURIComponent(query)}&boundary.country=FR&size=5`;

        try{
            const response = await fetch(url);
            const data = await response.json();
        
            const container = document.getElementById(containerId);
            container.innerHTML = "";
            container.style.display = "block";
        
            if (!data.features || data.features.length === 0) {
                container.style.display = "none";
                console.warn("Aucun résultat trouvé !");
                return;
            }
        
            data.features.forEach(place =>{
                let div = document.createElement("div");
                div.classList.add("suggestion-item");
                div.textContent = place.properties.label;
                div.addEventListener("click", () =>{
                    document.getElementById(inputId).value = place.properties.label;
                    container.innerHTML = "";
                    container.style.display = "none";
                    getSelectedAdress();
                })
                container.appendChild(div);
            });
            }catch (error) {
                console.error("Erreur lors de la récupération des adresses :", error);
            }
        }, 300);
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

// Distance entre 2 points
async function getCoordinates(query) {
    try{
        const url = `https://api.openrouteservice.org/geocode/search?api_key=${apiKey}&text=${encodeURIComponent(query)}&boundary.country=FR&size=1`;
        const response = await fetch(url);
        const data = await response.json();

        if(data.features && data.features.length > 0){
            return{
                lon: data.features[0].geometry.coordinates[0],
                lat: data.features[0].geometry.coordinates[1]
            };
        }else {
            console.error("Aucune coordonnée trouvée pour cette adresse :", query);
            return null;
        }
    } catch (error){
        console.error("Erreur lors de la récupération des coordonnées :", error);
        return null;
    }
}

async function getDistance(depart, arrivee) {
    
    try {
        const url = "https://api.openrouteservice.org/v2/directions/driving-car";
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": apiKey
            },
            body: JSON.stringify({
                coordinates: [
                    [depart.lon, depart.lat], 
                    [arrivee.lon, arrivee.lat]
                ]
            })
        });

        const data = await response.json();
        if (data.routes && data.routes.length > 0) {
            const distanceKm = data.routes[0].summary.distance / 1000;
            const durationSec = data.routes[0].summary.duration;

            return {distanceKm, durationSec};
        } else {
            console.error("Impossible de récupérer la distance et la durée.");
            return null;
        }
    } catch (error) {
        console.error("Erreur de calcul de distance :", error);
        return null;
    }
}

document.addEventListener("DOMContentLoaded", async () => {
    const departInput = document.getElementById("departAdress");
    const arriveeInput = document.getElementById("arrivalAdress");
    const distanceSpan = document.getElementById("tripDistance");

    async function updateDistance() {
        if (departInput.value.trim() && arriveeInput.value.trim()) {
            const depart = await getCoordinates(departInput.value);
            const arrivee = await getCoordinates(arriveeInput.value);

            if (depart && arrivee) {
                const routeData = await getDistance(depart, arrivee);
                if (routeData) {
                    distanceSpan.textContent = `${routeData.distanceKm.toFixed(1)} km`;
                }
            }
        }
    }

    departInput.addEventListener("change", updateDistance);
    arriveeInput.addEventListener("change", updateDistance);
});

// Affichage de la carte dans le modal
document.addEventListener('DOMContentLoaded', () =>{
    let map;
    let routeLayer;

    document.getElementById("mapModal").addEventListener("shown.bs.modal", async () =>{
        if(!map){
            map = L.map("map").setView([46.603354, 1.888334], 6);

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
        }
        await displayRoute();
    });

    async function displayRoute() {
        if (routeLayer) {
            map.removeLayer(routeLayer);
        }

        const depart = await getCoordinates(document.getElementById("departAdress").value);
        const arrivee = await getCoordinates(document.getElementById("arrivalAdress").value);

        if (!depart || !arrivee) {
            alert("Veuillez entrer des adresses valides !");
            return;
        }

        try {
            const apiUrl = "https://api.openrouteservice.org/v2/directions/driving-car/geojson";
            const body = {
                coordinates: [[depart.lon, depart.lat], [arrivee.lon, arrivee.lat]]
            };

            const response = await fetch(apiUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": apiKey
                },
                body: JSON.stringify(body)
            });

            const data = await response.json();

            if (!data.features || data.features.length < 1) {
                alert("Impossible de récupérer l'itinéraire !");
                return;
            }

            const route = data.features[0];

            routeLayer = L.geoJSON(route.geometry, { style: { color: "blue", weight: 4 } }).addTo(map);
            map.fitBounds(routeLayer.getBounds());

            const distance = (route.properties.summary.distance / 1000).toFixed(1);
            const duration = Math.round(route.properties.summary.duration / 60);

            document.getElementById("tripDistance").textContent = `${distance} km`;
            document.getElementById("tripDistanceModal").textContent = `${distance} km`;
            document.getElementById("tripDistanceRecap").textContent = `${distance} km`;
            document.getElementById("tripDurationModal").textContent = `${duration} min`;
            document.getElementById("tripDurationRecap").textContent = `${duration} min`;

        } catch (error) {
            console.error("Erreur lors du chargement de l'itinéraire", error);
        }
    }
});

document.addEventListener("DOMContentLoaded", () =>{
    const hourSelect = document.getElementById("hour");
    const minuteSelect = document.getElementById("minute");
    const hiddenDepartInput = document.getElementById("depart_time");
    const hiddenArrivalInput = document.getElementById("arrival_time");
    const departInput = document.getElementById("departAdress");
    const arrivalInput = document.getElementById("arrivalAdress");

    function updateDepartTime(){
        const hour = String(hourSelect.value).padStart(2, "0");
        const minute = String(minuteSelect.value).padStart(2, "0");
        hiddenDepartInput.value = `${hour}:${minute}:00`;
    }

    async function updateArrivalTime() {

        try {
            const depart = await getCoordinates(departInput.value);
            const arrivee = await getCoordinates(arrivalInput.value);
            const routeData = await getDistance(depart, arrivee);
            const durationMin = Math.round(routeData.durationSec / 60);

            const departTime = hiddenDepartInput.value.split(":");
            let arrivalHour = parseInt(departTime[0], 10);
            let arrivalMinute = parseInt(departTime[1], 10);

            arrivalMinute += durationMin;
            arrivalHour += Math.floor(arrivalMinute / 60);
            arrivalMinute %= 60;
            arrivalHour %= 24;

            hiddenArrivalInput.value = `${String(arrivalHour).padStart(2, "0")}:${String(arrivalMinute).padStart(2, "0")}:00`;
        } catch (error) {
            console.error("Erreur lors du calcul de l'heure d'arrivée :", error);
        }
    }

    hourSelect.addEventListener("change", () => {
        updateDepartTime();
        updateArrivalTime();
    });

    minuteSelect.addEventListener("change", () => {
        updateDepartTime();
        updateArrivalTime();
    });

    departInput.addEventListener("change", updateArrivalTime);
    arrivalInput.addEventListener("change", updateArrivalTime);

    updateDepartTime();
    updateArrivalTime();
});