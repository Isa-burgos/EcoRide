
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

function checkInputs(input) {
    const currentStepInputs = steps[currentStep].querySelectorAll("input[required]");
    let allFilled = true;

    currentStepInputs.forEach(input =>{
        if(!validateRequired(input)){
            allFilled = false;
        }
    });
    nextBtn.disabled = !allFilled;
}

function updateSteps(){
    steps.forEach((step, index) =>{
        if(index === currentStep){
        step.style.display = "block";
        }
        else{
            step.style.display = "none";
        }
    });

    if(currentStep === 0){
        prevBtn.style.display = "none";
    }
    else{
        prevBtn.style.display = "block";
    }

    if(currentStep === steps.length -1){
        nextBtn.style.display = "none";
    }
    else{
        nextBtn.style.display = "inline-block";
    }
    if(currentStep === steps.length -1){
        submitBtn.style.display = "inline-block";
    }
    else{
        submitBtn.style.display = "none";
    }

    checkInputs();
}

steps.forEach(step => {
    step.addEventListener("input", checkInputs);
});

nextBtn.addEventListener("click", ()=>{
    if(currentStep < steps.length -1){
        currentStep++;
        updateSteps();
    }
});

prevBtn.addEventListener("click", ()=>{
    if(currentStep > 0){
        currentStep--;
        updateSteps();
    }
});

updateSteps();






