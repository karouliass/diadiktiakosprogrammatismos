-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 15 Δεκ 2024 στις 20:13:38
-- Έκδοση διακομιστή: 10.4.32-MariaDB
-- Έκδοση PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8mb4;

-- Βάση δεδομένων: `e-books`

-- --------------------------------------------------------

-- Δομή πίνακα για τον πίνακα `book`

CREATE TABLE `book` (
  `BookID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `YearOfPublication` year(4) DEFAULT NULL CHECK (`YearOfPublication` between 1900 and 2024),
  `NumberOfCopies` int(11) DEFAULT NULL CHECK (`NumberOfCopies` > 0),
  `cond` enum('New','Used','Unknown') DEFAULT 'New',
  PRIMARY KEY (`BookID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Άδειασμα δεδομένων του πίνακα `book`

INSERT INTO `book` (`BookID`, `Title`, `Description`, `YearOfPublication`, `NumberOfCopies`, `cond`) VALUES
(1, 'Mickey Mouse and Friends', 'This is a sample book description.', '1952', 5, 'Used');

-- --------------------------------------------------------

-- Δομή πίνακα για τον πίνακα `borrow`

CREATE TABLE `borrow` (
  `BorrowID` int(11) NOT NULL AUTO_INCREMENT,
  `BookID` int(11) DEFAULT NULL,
  `BorrowDate` date NOT NULL,
  `ReturnDate` date DEFAULT NULL,
  PRIMARY KEY (`BorrowID`),
  CONSTRAINT `borrow_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `book` (`BookID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Δομή πίνακα για τον πίνακα `category`

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  PRIMARY KEY (`CategoryID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Άδειασμα δεδομένων του πίνακα `category`

INSERT INTO `category` (`CategoryID`, `Name`) VALUES
(1, 'Children Books'),
(3, 'Comedy'),
(4, 'Philosophy'),
(2, 'Romance'),
(5, 'Drama'),
(6, 'Other');

-- Δομή πίνακα για τους επαφές `Contacts`

CREATE TABLE `Contacts` (
    `ContactID` INT AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(100) NOT NULL,
    `Role` VARCHAR(100) NOT NULL
);

-- Άδειασμα δεδομένων του πίνακα `Contacts`

INSERT INTO `Contacts` (`Name`, `Role`) VALUES 
('Theodoros Gkiliopoulos', 'TL20533'),
('Pavlos Antwnidakhs', 'TL20483'),
('Panagiwths Kouzhs', 'TL20411');

-- Δομή πίνακα για τα μηνύματα επαφής `ContactMessages`

CREATE TABLE `ContactMessages` (
    `MessageID` INT AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(100) NOT NULL,
    `Email` VARCHAR(100) NOT NULL,
    `Message` TEXT NOT NULL,
    `SubmittedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Ευρετήρια για άχρηστους πίνακες

-- Εφαρμογή primary key και auto-increment για πίνακες

ALTER TABLE `book`
  MODIFY `BookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `borrow`
  MODIFY `BorrowID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

COMMIT;

SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT;
SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS;
SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION;
