// Script (js/script.js)
// Example: Seat Selection Interactivity
const seats = document.querySelectorAll('.seat');
seats.forEach(seat => {
    seat.addEventListener('click', () => {
        seat.classList.toggle('selected');
    });
});