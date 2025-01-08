document.addEventListener('DOMContentLoaded', () => {
    // Handle movie selection
    const movieButtons = document.querySelectorAll('.movie-btn');
    const seatSelectionSection = document.getElementById('seat-selection-section');
    const seatGrid = document.querySelector('.seat-grid');
    const nextButton = document.getElementById('next-to-menu');

    movieButtons.forEach(button => {
        button.addEventListener('click', () => {
            seatSelectionSection.style.display = 'block';
            generateSeats(); // Call function to generate seats
        });
    });

    // Generate seat grid dynamically
    function generateSeats() {
        seatGrid.innerHTML = ''; // Clear existing seats
        for (let row = 'A'; row <= 'E'; row++) {
            for (let col = 1; col <= 10; col++) {
                const seat = document.createElement('div');
                seat.classList.add('seat');
                seat.textContent = `${row}${col}`;
                seat.addEventListener('click', () => selectSeat(seat));
                seatGrid.appendChild(seat);
            }
        }
    }

    // Handle seat selection
    function selectSeat(seat) {
        seat.classList.toggle('selected');
        nextButton.disabled = seatGrid.querySelectorAll('.selected').length === 0;
    }

    // Proceed to the snack menu
    nextButton.addEventListener('click', () => {
        window.location.href = 'menu.php';
    });

    function selectMovie(movie, element) {
        selectedMovie = movie;
        document.getElementById('selected-movie').value = movie;
    
        // Update UI for selected movie
        const movieItems = document.querySelectorAll('.movie-item');
        movieItems.forEach(item => item.classList.remove('selected'));
        element.closest('.movie-item').classList.add('selected');
    
        // Show seat selection section
        document.getElementById('seat-selection').classList.remove('hidden');
    }
    
    function selectTime(time, id) {
        selectedTime = time;
        document.getElementById('selected-time').value = time;
    
        // Update UI for selected time
        const timeSlots = document.querySelectorAll('.time-slot');
        timeSlots.forEach(slot => slot.classList.remove('selected'));
        document.getElementById(`time-${id}`).classList.add('selected');
    }
    
    function selectSeat(seatId) {
        const seat = document.getElementById(seatId);
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
    
        // Update people count
        document.getElementById('people').value = selectedSeats.length;
    }
    
});
