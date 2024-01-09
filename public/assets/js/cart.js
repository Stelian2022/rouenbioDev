var decreaseButton = document.querySelector('.decrease-quantity');
var increaseButton = document.querySelector('.increase-quantity');
var quantityInput = document.querySelector('.quantity-input');

decreaseButton.addEventListener('click', function () {
var currentValue = parseInt(quantityInput.value);
if (currentValue > 0) {
quantityInput.value = currentValue - 1;
}
});

increaseButton.addEventListener('click', function () {
var currentValue = parseInt(quantityInput.value);
quantityInput.value = currentValue + 1;
});


