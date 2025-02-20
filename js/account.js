const brandSelect = document.getElementById("carBrand");
const modelSelect = document.getElementById("carModel");

fetch("https://public.opendatasoft.com/api/records/1.0/search/?dataset=vehicules-commercialises&rows=0&facet=marque")
    .then(response => response.json())
    .then(data => {
        const brands = data.facet_groups[0].facets;

        brands.forEach(brand => {
            let option = document.createElement("option");
            option.value = brand.name;
            option.textContent = brand.name;
            brandSelect.appendChild(option);
        });
    })
    .catch(error => console.error("Erreur lors de la récupération des marques :", error));

brandSelect.addEventListener("change", ()=>{
    const selectedBrand = brandSelect.value;

    if(!selectedBrand){
        modelSelect.innerHTML = '<option value="">Sélectionnez un modèle</option>';
        modelSelect.disabled = true;
        return;
    }

    modelSelect.innerHTML = '<option value="">Chargement...</option>';
    modelSelect.disabled = true;

    const encodedBrand = encodeURIComponent(selectedBrand);
    const url = `https://public.opendatasoft.com/api/records/1.0/search/?dataset=vehicules-commercialises&refine.marque=${encodedBrand}`;

fetch(url)
.then(response => response.json())
.then(data => {
    if (!data.records || data.records.length === 0) {
        modelSelect.innerHTML = '<option value="">Aucun modèle disponible</option>';
        modelSelect.disabled = true;
        return;
    }

            modelSelect.innerHTML = '<option value="">Sélectionnez un modèle</option>';

            const uniqueModels = new Set();

            data.records.forEach(record => {
                if(record.fields && record.fields.modele_dossier && !uniqueModels.has(record.fields.modele_dossier)){
                    uniqueModels.add(record.fields.modele_dossier);
                    let option = document.createElement("option");
                    option.value = record.fields.modele_dossier;
                    option.textContent = record.fields.modele_dossier;
                    modelSelect.appendChild(option);
                }
            });

            modelSelect.disabled = uniqueModels.size === 0;
        })
        .catch(error =>{
            console.error("Erreur lors du chargement des modèles :", error);
            modelSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        })
})

// hidden-content

document.addEventListener('DOMContentLoaded', ()=>{
    const isDriverCheckbox = document.getElementById("isDriver");
    const hiddenContent = document.querySelector(".hidden-content");

    function toggleHiddenContent(){
        if(isDriverCheckbox.checked){
            hiddenContent.style.display = "block";
        } else {
            hiddenContent.style.display = "none";
        }
    }
    toggleHiddenContent();
    isDriverCheckbox.addEventListener("change", toggleHiddenContent);

});