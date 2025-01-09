document.addEventListener('DOMContentLoaded', () => {
    // Elements
    const movieButtons = document.querySelectorAll('.movie-btn');
    const seatSelectionSection = document.getElementById('seat-selection-section');
    const seatGrid = document.querySelector('.seat-grid');
    const nextButton = document.getElementById('next-to-menu');
    let selectedSeats = [];
    let selectedMovie = "";
    let selectedTime = "";

    // Handle movie selection
    movieButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            selectedMovie = event.target.getAttribute('data-movie'); // Assuming 'data-movie' attribute holds movie info
            document.getElementById('selected-movie').value = selectedMovie;
            highlightSelectedMovie(event.target);
            seatSelectionSection.style.display = 'block';
            generateSeats(); // Call function to generate seats
        });
    });

    // Highlight selected movie
    function highlightSelectedMovie(selectedElement) {
        const movieItems = document.querySelectorAll('.movie-btn');
        movieItems.forEach(item => item.classList.remove('selected'));
        selectedElement.classList.add('selected');
    }

    // Generate seat grid dynamically
    function generateSeats() {
        seatGrid.innerHTML = ''; // Clear existing seats
        for (let row = 65; row < 70; row++) { // ASCII values for A-E
            for (let col = 1; col <= 10; col++) {
                const seatId = String.fromCharCode(row) + col;
                const seat = document.createElement('div');
                seat.classList.add('seat');
                seat.textContent = seatId;
                seat.addEventListener('click', () => selectSeat(seat));
                seatGrid.appendChild(seat);
            }
        }
    }

    // Handle seat selection
    function selectSeat(seat) {
        const seatId = seat.textContent;
        if (selectedSeats.includes(seatId)) {
            // Deselect seat
            selectedSeats = selectedSeats.filter(s => s !== seatId);
            seat.classList.remove('selected');
        } else {
            // Select seat
            selectedSeats.push(seatId);
            seat.classList.add('selected');
        }
        document.getElementById('selected-seats').value = selectedSeats.join(', ');

        // Enable or disable the next button
        nextButton.disabled = selectedSeats.length === 0;
    }

    // Proceed to the snack menu
    nextButton.addEventListener('click', () => {
        // Assuming form submission or other action before navigation
        const form = document.getElementById('booking-form');
        form.submit(); // Submit the form
        // Navigate to the menu page
        window.location.href = 'menu.php';
    });

    // Handle time slot selection
    function selectTime(time, id) {
        selectedTime = time;
        document.getElementById('selected-time').value = selectedTime;
        highlightSelectedTimeSlot(id);
    }

    // Highlight selected time slot
    function highlightSelectedTimeSlot(slotId) {
        const timeSlots = document.querySelectorAll('.time-slot');
        timeSlots.forEach(slot => slot.classList.remove('selected'));
        document.getElementById(`time-${slotId}`).classList.add('selected');
    }
});
