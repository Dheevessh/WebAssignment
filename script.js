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
});
