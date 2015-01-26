-- phpMyAdmin SQL Dump
-- version 4.3.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 26. Jan 2015 um 18:45
-- Server Version: 5.5.39-MariaDB
-- PHP-Version: 5.5.20

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `fuwo`
--
CREATE DATABASE IF NOT EXISTS `fuwo_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `fuwo_db`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buildings`
--

CREATE TABLE IF NOT EXISTS `buildings` (
  `id` mediumint(9) NOT NULL,
  `name` varchar(32) NOT NULL,
  `image` varchar(128) NOT NULL,
  `description` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `planet`
--

CREATE TABLE IF NOT EXISTS `planet` (
`id` mediumint(9) NOT NULL,
  `universe_id` mediumint(9) NOT NULL,
  `system_id` mediumint(11) NOT NULL,
  `pos` mediumint(9) NOT NULL,
  `owner_id` mediumint(9) NOT NULL,
  `name` varchar(32) NOT NULL,
  `res_coal` int(11) NOT NULL,
  `res_ore` int(11) NOT NULL,
  `res_water` int(11) NOT NULL,
  `res_oil` int(11) NOT NULL,
  `res_metal` int(11) NOT NULL,
  `updated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `planetXbuildings`
--

CREATE TABLE IF NOT EXISTS `planetXbuildings` (
  `planet_id` mediumint(9) NOT NULL,
  `building_id` mediumint(9) NOT NULL,
  `level` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `solar_system`
--

CREATE TABLE IF NOT EXISTS `solar_system` (
  `id` mediumint(9) NOT NULL,
  `position` mediumint(9) NOT NULL,
  `name` varchar(32) NOT NULL,
  `planets` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `name` varchar(64) NOT NULL,
  `id` mediumint(9) NOT NULL,
  `password` varchar(128) NOT NULL,
  `mail` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `planet`
--
ALTER TABLE `planet`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `planet`
--
ALTER TABLE `planet`
MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
