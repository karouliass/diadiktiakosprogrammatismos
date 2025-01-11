-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 11 Ιαν 2025 στις 20:06:17
-- Έκδοση διακομιστή: 10.4.32-MariaDB
-- Έκδοση PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `e_books`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `book`
--

CREATE TABLE `book` (
  `BookID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `YearOfPublication` year(4) DEFAULT NULL,
  `NumberOfCopies` int(11) DEFAULT NULL,
  `cond` enum('New','Used','Unknown') DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `book`
--

INSERT INTO `book` (`BookID`, `Title`, `Description`, `YearOfPublication`, `NumberOfCopies`, `cond`) VALUES
(1, 'Mickey Mouse and Friends', 'This is a sample book description.', '1952', 5, 'Used'),
(3, 'gdf', 'fdfdfd', '2000', 1, 'New'),
(4, 'gdf', 'fdfdfd', '2000', 1, 'New'),
(5, 'drgfgdfgdf', 'eweress', '2000', 1, 'New');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `bookcategory`
--

CREATE TABLE `bookcategory` (
  `BookID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `bookcategory`
--

INSERT INTO `bookcategory` (`BookID`, `CategoryID`) VALUES
(4, 1),
(4, 2),
(4, 3),
(5, 1),
(5, 2),
(5, 3),
(5, 4);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `borrow`
--

CREATE TABLE `borrow` (
  `BorrowID` int(11) NOT NULL,
  `BookID` int(11) DEFAULT NULL,
  `BorrowDate` date NOT NULL,
  `ReturnDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `category`
--

INSERT INTO `category` (`CategoryID`, `Name`) VALUES
(1, 'Children Books'),
(3, 'Comedy'),
(5, 'Drama'),
(6, 'Other'),
(4, 'Philosophy'),
(2, 'Romance');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `contactmessages`
--

CREATE TABLE `contactmessages` (
  `MessageID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Message` text NOT NULL,
  `SubmittedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `contacts`
--

CREATE TABLE `contacts` (
  `ContactID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `contacts`
--

INSERT INTO `contacts` (`ContactID`, `Name`, `Role`) VALUES
(1, 'Theodoros Gkiliopoulos', 'TL20533'),
(2, 'Pavlos Antwnidakhs', 'TL20483'),
(3, 'Panagiwths Kouzhs', 'TL20411'),
(4, 'Panos Kouzis', 'CEO'),
(5, 'Panos Kouzis', 'CEO');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`BookID`);

--
-- Ευρετήρια για πίνακα `bookcategory`
--
ALTER TABLE `bookcategory`
  ADD PRIMARY KEY (`BookID`,`CategoryID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Ευρετήρια για πίνακα `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`BorrowID`),
  ADD KEY `borrow_ibfk_1` (`BookID`);

--
-- Ευρετήρια για πίνακα `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Ευρετήρια για πίνακα `contactmessages`
--
ALTER TABLE `contactmessages`
  ADD PRIMARY KEY (`MessageID`);

--
-- Ευρετήρια για πίνακα `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`ContactID`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `book`
--
ALTER TABLE `book`
  MODIFY `BookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT για πίνακα `borrow`
--
ALTER TABLE `borrow`
  MODIFY `BorrowID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT για πίνακα `contactmessages`
--
ALTER TABLE `contactmessages`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `contacts`
--
ALTER TABLE `contacts`
  MODIFY `ContactID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `bookcategory`
--
ALTER TABLE `bookcategory`
  ADD CONSTRAINT `bookcategory_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `book` (`BookID`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookcategory_ibfk_2` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `borrow_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `book` (`BookID`) ON DELETE CASCADE;

COMMIT;
ALTER TABLE `borrow` ADD FOREIGN KEY (`contactId`) REFERENCES `contacts`(`ContactID`) ON DELETE RESTRICT ON UPDATE RESTRICT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
