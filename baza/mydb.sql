-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 14, 2024 at 04:13 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `friends`
--

CREATE TABLE `friends` (
  `login_id` int(11) NOT NULL,
  `login` text NOT NULL,
  `friend_id` int(11) NOT NULL,
  `friend` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`login_id`, `login`, `friend_id`, `friend`) VALUES
(1, 'Mari0', 2, 'adam');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `login` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `login`, `email`, `password`) VALUES
(1, 'Mari0', 'morteusz111@gmail.com', '$2y$10$rF4ShTH6PFKiyQgBEEeN/.TM7CCdLoxxomTAxum1XvmllUKwqd/0i'),
(2, 'adam', 'sdasd@gmail.com', '$2y$10$n3S0i6rxhmxb3JjknlAvu.WPBoF/QhmEObeJW.aY1dlrnXQpCYg4u');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`login_id`),
  ADD KEY `fk_firnedId` (`friend_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `fk_firnedId` FOREIGN KEY (`friend_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fk_loginId` FOREIGN KEY (`login_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
