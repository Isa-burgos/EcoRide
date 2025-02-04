const emailContactInput = document.getElementById("emailContactInput");
const subjectContactInput =document.getElementById("subjectContactInput");
const messageContactInput = document.getElementById("messageContactInput");
const btnSend = document.getElementById("btn-send");

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", function () {
        validateForm();
    });
} else {
    validateForm();
}

if(emailContactInput) emailContactInput.addEventListener("keyup", validateForm);
if(subjectContactInput) subjectContactInput.addEventListener("keyup", validateForm);
if(messageContactInput) messageContactInput.addEventListener("keyup", validateForm);

function validateForm(){
    const emailContactOk = validateMail(emailContactInput);
    const subjectOk = validateRequired(subjectContactInput);
    const messageOk = validateMessage(messageContactInput);

    if (emailContactOk && subjectOk && messageOk){
        btnSend.disabled = false;
    }
    else{
        btnSend.disabled = true;
    }
}

function validateMessage(input){
    if(messageContactInput.value !== "" && input.value.length > 20){
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

function validateMail(input){
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const emailContact = input.value.trim();

    if(emailContact.match(emailRegex)){
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
    else{
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }
}

function validateRequired(input) {
    if (input.value.trim() !== "") {
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    } else {
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }
}