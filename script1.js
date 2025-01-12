
const ticketPrice = 10; // Price of one ticket in Ringgit
const peopleInput = document.getElementById('people-input');
const totalPriceDisplay = document.getElementById('total-price');

peopleInput.addEventListener('input', function () {
    const numPeople = parseInt(this.value, 10) || 0; // Get the number of people or default to 0
    const totalPrice = numPeople * ticketPrice; // Calculate the total price
    totalPriceDisplay.textContent = totalPrice; // Update the displayed total price
    document.getElementById('people').value = numPeople; // Update the hidden input for form submission
});

// Function to handle movie selection and apply color change
function selectMovie(movie) {
    // Set the movie in the form
    document.getElementById('selected-movie').value = movie;
    
    // Change the appearance of the selected movie item
    const movieItems = document.querySelectorAll('.movie-item');
    movieItems.forEach(item => {
        item.classList.remove('clicked'); // Reset any previous selection
    });

    const selectedMovieItem = event.target.closest('.movie-item');
    selectedMovieItem.classList.add('clicked'); // Apply the clicked style
    
    // Show the seat selection section
    document.getElementById('seat-selection').classList.remove('hidden');
}