-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 27. Nov 2017 um 10:24
-- Server-Version: 5.6.34-log
-- PHP-Version: 7.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `lindseyj`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `message`
--

CREATE TABLE `message` (
  `M_ID` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ID_R` int(11) NOT NULL,
  `ID_U` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `message`
--

INSERT INTO `message` (`M_ID`, `time`, `message`, `ID_R`, `ID_U`) VALUES
(1, '2017-10-23 13:07:11', 'dfasdfas', 1, 40),
(2, '2017-10-23 13:07:12', 'asdf', 1, 40),
(3, '2017-10-23 13:07:12', 'dfas', 1, 40),
(4, '2017-10-23 13:07:12', 'asd', 1, 40),
(5, '2017-10-23 13:07:13', 'f', 1, 40),
(6, '2017-10-23 13:07:13', 'asdf', 1, 40),
(7, '2017-10-23 13:07:13', 'asdf', 1, 40),
(8, '2017-10-23 13:07:13', 'asdf', 1, 40),
(9, '2017-10-23 13:07:15', ':d', 1, 40),
(10, '2017-10-23 13:07:18', ':p', 1, 40),
(11, '2017-10-23 13:07:20', ':P', 1, 40),
(12, '2017-10-23 13:07:23', ';P', 1, 40),
(13, '2017-11-06 11:02:34', ':fu:', 1, 38),
(14, '2017-11-13 11:47:47', ':D', 2, 38),
(15, '2017-11-13 12:17:21', 'asdf', 3, 41),
(16, '2017-11-13 12:18:15', 'test', 3, 38),
(17, '2017-11-20 11:21:10', 'asdf', 1, 38),
(18, '2017-11-20 11:27:49', 'asdf', 2, 38),
(19, '2017-11-20 11:27:50', 'as', 2, 38),
(20, '2017-11-20 11:27:51', 'df', 2, 38),
(21, '2017-11-20 11:27:51', 'df', 2, 38),
(22, '2017-11-20 11:27:51', 'asd', 2, 38),
(23, '2017-11-20 11:27:52', 'f', 2, 38),
(24, '2017-11-20 11:27:52', 'asdf', 2, 38),
(25, '2017-11-20 11:27:52', 'dfas', 2, 38),
(26, '2017-11-20 11:27:52', 'dfas', 2, 38),
(27, '2017-11-20 11:51:37', 'mesage', 2, 38),
(28, '2017-11-20 12:06:07', '../files/', 2, 38),
(29, '2017-11-20 12:14:12', 'files/test.txt', 2, 38),
(30, '2017-11-20 12:14:32', '../files/test.txt', 2, 38),
(31, '2017-11-20 12:19:01', '../files/test.txt', 2, 38),
(32, '2017-11-20 12:20:55', '../files/test.txt', 2, 38),
(33, '2017-11-27 10:13:49', '../files/test.txt', 1, 38);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `room`
--

CREATE TABLE `room` (
  `R_ID` int(11) NOT NULL,
  `roomname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `room`
--

INSERT INTO `room` (`R_ID`, `roomname`, `time`, `owner`) VALUES
(1, 'dfas', '2017-10-23 13:07:02', 40),
(2, 'Way-Up Chatraum', '2017-11-13 11:47:16', 38),
(3, 'Chatraum', '2017-11-13 12:17:14', 41);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `room_user`
--

CREATE TABLE `room_user` (
  `ID_R` int(11) NOT NULL,
  `ID_U` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `room_user`
--

INSERT INTO `room_user` (`ID_R`, `ID_U`) VALUES
(1, 40),
(1, 39),
(1, 38),
(2, 38),
(3, 41),
(3, 38);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `U_ID` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`U_ID`, `username`, `password`) VALUES
(38, 'SilasMeier', '$2y$10$HmwClDS4bdh9qNdnufcwN.MIJV5qDTYdaLCDhNEag/sfhQV.QCwaa'),
(39, 'Heckaboi', '$2y$10$krrTDlpTeAf6Y/1tPdD9YOPa7NmlFh6gCLtOjgHvr1SvPDbVMTMqC'),
(40, 'asdfasdf', '$2y$10$mPWSnvJ2EYJI2Gj2gq9K4evRCKFyzwnzGU67TaZhzueKtgXR8ghzS'),
(41, 'Silas', '$2y$10$x1PqSOm1qJD12ARq/OooWeazTjwxFwJ2Q5F09.ZtPO4mjhPKVD8ca');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`M_ID`),
  ADD KEY `ID_R` (`ID_R`),
  ADD KEY `ID_U` (`ID_U`);

--
-- Indizes für die Tabelle `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`R_ID`),
  ADD KEY `owner` (`owner`);

--
-- Indizes für die Tabelle `room_user`
--
ALTER TABLE `room_user`
  ADD KEY `ID_R` (`ID_R`),
  ADD KEY `ID_U` (`ID_U`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`U_ID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `message`
--
ALTER TABLE `message`
  MODIFY `M_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT für Tabelle `room`
--
ALTER TABLE `room`
  MODIFY `R_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `U_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`ID_R`) REFERENCES `room` (`R_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`ID_U`) REFERENCES `user` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `user` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `room_user`
--
ALTER TABLE `room_user`
  ADD CONSTRAINT `room_user_ibfk_1` FOREIGN KEY (`ID_R`) REFERENCES `room` (`R_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `room_user_ibfk_2` FOREIGN KEY (`ID_U`) REFERENCES `user` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
