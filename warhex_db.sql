-- Database: `warhex_db`
CREATE DATABASE IF NOT EXISTS `warhex_db`;
USE `warhex_db`;

-- Table structure for table `admin_users`
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin
REPLACE INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$8.4.T8UqE1s.L5X3xIe7Q.aXz23p89D0J6zV1rRzK9H3z6w5W.6w6'); 

-- Table structure for table `products`
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `cell_class` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

REPLACE INTO `products` (`id`, `title`, `description`, `image`, `cell_class`) VALUES
(1, 'HEX Controller Pro', 'Tactile precision switches, zero-latency wireless, and a grip molded for long-battle endurance.', 'assets/WarHex1.png', 'prod-cell--b'),
(2, 'WarHex Mech Figurine', 'Limited edition 1:12 scale Iron Horizon Unit-01. Hand-painted, numbered, battle-worn finish.', 'assets/WarHex3.png', 'prod-cell--d prod-cell--reverse'),
(3, 'Iron Horizon Headset', 'Spatial audio with 7.1 surround. Hear the battlefield before you see it.', 'assets/WarHex5.jpg', 'prod-cell--e'),
(4, 'HEX Combat Jacket', 'Tactical-grade fabric, embroidered WarHex insignia, built for the streets and the arena.', 'assets/WarHex4.png', 'prod-cell--f');

-- Table structure for table `series`
CREATE TABLE IF NOT EXISTS `series` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `release_year` varchar(10) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

REPLACE INTO `series` (`id`, `title`, `genre`, `release_year`, `image`, `category`) VALUES
(1, 'IRON HORIZON', 'MECHA / ACTION', '2024', 'assets/WarHex1.png', 'ACTION,MECHA'),
(2, 'PROJECT NOVA', 'RPG / ADVENTURE', '2024', 'assets/WarHex2.png', 'RPG,ADVENTURE'),
(3, 'ZERO FRONTIER', 'SURVIVAL / STRATEGY', '2023', 'assets/WarHex3.png', 'SURVIVAL,STRATEGY'),
(4, 'DESERT ECHO', 'TACTICAL / RPG', '2023', 'assets/WarHex4.png', 'RPG'),
(5, 'SHADOW PROTOCOL', 'ACTION / STEALTH', '2022', 'assets/WarHex1.png', 'ACTION');

-- Table structure for table `news`
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `news` (`id`, `title`, `date`, `image`, `tags`) VALUES
(1, 'Iron Horizon Season 2 Officially Announced — New Mech Classes and Expanded Campaign Revealed', '2024.12.01', 'assets/WarHex1.png', 'IRON HORIZON,ANNOUNCEMENT'),
(2, 'Project Nova Version 3.2 Patch Notes — Major Balance Changes and New RPG Skill Tree', '2024.11.28', 'assets/WarHex2.png', 'PROJECT NOVA,PATCH NOTES'),
(3, 'WarHex Global Tournament 2024 — Zero Frontier Ranked Season Opens Registration for All Regions', '2024.11.25', 'assets/WarHex3.png', 'ALL SERIES,TOURNAMENTS'),
(4, 'Desert Echo Expansion "Ashlands Protocol" Coming Q1 2025 — New Maps, Weapons, and Co-op Mode', '2024.11.20', 'assets/WarHex4.png', 'DESERT ECHO,DLC'),
(5, 'WarHex Inc. Wins "Best Independent Studio" at Global Game Awards 2024 — Full Ceremony Recap', '2024.11.15', 'assets/WarHex1.png', 'WARHEX,AWARDS'),
(6, 'Shadow Protocol Free Weekend Event — Play the Full Game at No Cost November 22–24', '2024.11.10', 'assets/WarHex2.png', 'SHADOW PROTOCOL,EVENTS');
