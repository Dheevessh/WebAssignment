CREATE DATABASE cinema_booking;
USE cinema_booking;

CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT,
    time TIME,
    seats INT,
    FOREIGN KEY (movie_id) REFERENCES movies(id)
);
