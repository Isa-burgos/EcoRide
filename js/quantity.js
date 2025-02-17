document.addEventListener("DOMContentLoaded", () => {
    initQuantitySelector(".quantity-selector", ".passengerCount", "nbPlaceInput", 1, 4);
    initQuantitySelector(".quantity-credit-selector", ".creditCount", "creditInput", 1, 100);
});

function initQuantitySelector(selectorClass, inputClass, hiddenInputId, minValue, maxValue) {
    document.querySelectorAll(selectorClass).forEach(selector => {
        const input = selector.querySelector(inputClass);
        const decreaseBtn = selector.querySelector(".decrease");
        const increaseBtn = selector.querySelector(".increase");
        const hiddenInput = document.getElementById(hiddenInputId);

        decreaseBtn.addEventListener("click", () => {
            let currentValue = parseInt(input.value);

            if (currentValue > minValue) {
                input.value = currentValue - 1;
                hiddenInput.value = input.value;
            }
        });

        increaseBtn.addEventListener("click", () => {
            let currentValue = parseInt(input.value);

            if (currentValue < maxValue) {
                input.value = currentValue + 1;
                hiddenInput.value = input.value;
            }
        });
    });
}
