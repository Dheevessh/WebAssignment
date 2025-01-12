
const ticketPrice = 10; // Price of one ticket in Ringgit
const peopleInput = document.getElementById('people-input');
const totalPriceDisplay = document.getElementById('total-price');

peopleInput.addEventListener('input', function () {
    const numPeople = parseInt(this.value, 10) || 0; // Get the number of people or default to 0
    const totalPrice = numPeople * ticketPrice; // Calculate the total price
    totalPriceDisplay.textContent = totalPrice; // Update the displayed total price
    document.getElementById('people').value = numPeople; // Update the hidden input for form submission
});
