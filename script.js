window.onload = () => {
    document.querySelectorAll('.movie-card .btn').forEach(button => {
        button.addEventListener('click', (e) => {
            button.innerText = 'Loading...';
            setTimeout(() => {
                button.innerText = 'Book Now';
            }, 2000);
        });
    });
};