-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 27, 2021 at 02:50 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emovie`
--

DELIMITER $$
--
-- Functions
--
DROP FUNCTION IF EXISTS `SPLIT_STR`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `SPLIT_STR` (`x` VARCHAR(255), `delim` VARCHAR(12), `pos` INT) RETURNS VARCHAR(255) CHARSET utf8 RETURN REPLACE(SUBSTRING(SUBSTRING_INDEX(x, delim, pos),
       LENGTH(SUBSTRING_INDEX(x, delim, pos -1)) + 1),
       delim, '')$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `broken_links`
--

DROP TABLE IF EXISTS `broken_links`;
CREATE TABLE IF NOT EXISTS `broken_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL,
  `fOptionsID` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `IP` varchar(50) NOT NULL,
  `browser` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `broken_links`
--

INSERT INTO `broken_links` (`id`, `fid`, `fOptionsID`, `date`, `IP`, `browser`) VALUES
(1, 1, 2, '2021-12-25 00:15:42', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:96.0) Gecko/20100101 Firefox/96.0'),
(2, 6, 7, '2021-12-26 00:03:15', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:96.0) Gecko/20100101 Firefox/96.0');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cateName` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `cateName`) VALUES
(1, '3D Movies'),
(2, 'Western Movies'),
(3, 'Thriller Movies'),
(4, 'Horror Movies'),
(5, 'Mystery Movies'),
(6, 'Dramatic Movies'),
(7, 'Fantasy Movies'),
(8, 'Romantic Movies'),
(9, 'Sci-Fi Movies'),
(10, 'Crime Movies'),
(11, 'Life Story Movies'),
(12, 'Musical Movies'),
(13, 'Historical Movies'),
(14, 'Adventure Movies'),
(15, 'War Movies'),
(16, 'Sports Movies'),
(17, 'Family Movies'),
(18, 'Art Films'),
(19, 'Comedy Movies'),
(20, 'Animated Movies'),
(21, 'Action Movies');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
CREATE TABLE IF NOT EXISTS `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_name` varchar(200) NOT NULL,
  `movie_category` int(11) NOT NULL,
  `movie_cover` varchar(500) NOT NULL,
  `short_desc` varchar(1000) DEFAULT NULL,
  `description` text NOT NULL,
  `hit` int(11) NOT NULL,
  `imdbID` varchar(100) NOT NULL,
  `addedDate` datetime NOT NULL,
  `lastEditDate` datetime DEFAULT NULL,
  `movieYear` int(11) NOT NULL,
  `movieTime` time NOT NULL,
  `imdbScore` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `movie_name`, `movie_category`, `movie_cover`, `short_desc`, `description`, `hit`, `imdbID`, `addedDate`, `lastEditDate`, `movieYear`, `movieTime`, `imdbScore`) VALUES
(1, 'Fantastic Beasts: The Secrets of Dumbledore', 14, 'movie_cover/fantastic-beasts-the-secrets-of-dumbledore-EMXey7SwU1nV6EGMa.png', 'The third installment of the \'Fantastic Beasts and Where to Find Them\' series which follows the adventures of Newt Scamander.', 'Professor Albus Dumbledore knows the powerful Dark wizard Gellert Grindelwald is moving to seize control of the wizarding world. Unable to stop him alone, he entrusts Magizoologist Newt Scamander to lead an intrepid team of wizards, witches and one brave Muggle baker on a dangerous mission, where they encounter old and new beasts and clash with Grindelwald’s growing legion of followers. But with the stakes so high, how long can Dumbledore remain on the sidelines?', 4, 'tt4123432', '2021-12-21 18:48:11', NULL, 2022, '00:00:00', 0),
(2, 'The Lost City', 19, 'movie_cover/the-lost-city-EMDlu8Zck4JwpKQIn.jpg', 'A reclusive romance novelist on a book tour with her cover model gets swept up in a kidnapping attempt that lands them both in a cutthroat jungle adventure.', 'Follows a reclusive romance novelist who was sure nothing could be worse than getting stuck on a book tour with her cover model, until a kidnapping attempt sweeps them both into a cutthroat jungle adventure, proving life can be so much stranger, and more romantic, than any of her paperback fictions.', 1, 'tt13320622', '2021-12-21 19:05:31', NULL, 2022, '00:00:00', 0),
(3, 'The Batman', 21, 'movie_cover/the-batman-EMJhOIkX4LFUPa6Bi.jpeg', 'In his second year of fighting crime, Batman uncovers corruption in Gotham City that connects to his own family while facing a serial killer known as the Riddler.', 'In his second year of fighting crime, Batman uncovers corruption in Gotham City that connects to his own family while facing a serial killer known as the Riddler.', 1, 'tt1877830', '2021-12-21 19:07:57', NULL, 2022, '00:00:00', 0),
(4, 'Spider-Man: No Way Home', 21, 'movie_cover/spiderman-no-way-home-EM37B9kLyERbHuOXj.jpg', 'With Spider-Man\'s identity now revealed, Peter asks Doctor Strange for help.', 'Peter Parker is unmasked and no longer able to separate his normal life from the high-stakes of being a super-hero. When he asks for help from Doctor Strange the stakes become even more dangerous, forcing him to discover what it truly means to be Spider-Man.', 1, 'tt10872600', '2021-12-21 19:48:51', NULL, 2021, '02:28:00', 9),
(5, 'Eternals', 21, 'movie_cover/eternals-EM9yal4qLHRcmP8nB.jpeg', 'The saga of the Eternals, a race of immortal beings who lived on Earth and shaped its history and civilizations.', 'The Eternals are a team of ancient aliens who have been living on Earth in secret for thousands of years. When an unexpected tragedy forces them out of the shadows, they are forced to reunite against mankind’s most ancient enemy, the Deviants.', 1, 'tt9032400', '2021-12-22 17:34:52', NULL, 2021, '02:37:00', 6.8),
(6, 'Shang-Chi and the Legend of the Ten Rings', 7, 'movie_cover/shangchi-and-the-legend-of-the-ten-rings-EMizEpXPoUTVdch6Z.jpeg', 'Shang-Chi, the master of weaponry-based Kung Fu, is forced to confront his past after being drawn into the Ten Rings organization.', 'Shang-Chi must confront the past he thought he left behind when he is drawn into the web of the mysterious Ten Rings organization.', 3, 'tt9376612', '2021-12-22 17:37:59', '2021-12-25 23:58:43', 2021, '02:12:00', 7.5),
(7, 'The Unforgivable', 10, 'movie_cover/the-unforgivable-EMUw7Knx1ZMg6RbFu.png', 'A woman is released from prison after serving a sentence for a violent crime and re-enters a society that refuses to forgive her past.', 'A woman is released from prison after serving a sentence for a violent crime and re-enters a society that refuses to forgive her past.', 2, 'tt11233960', '2021-12-22 17:43:31', NULL, 2021, '01:52:00', 7.2),
(8, 'West Side Story', 6, 'movie_cover/west-side-story-EMEjDkVaRfFUNGMZy.png', 'Two youngsters from rival New York City gangs fall in love, but tensions between their respective friends build toward tragedy.', 'An adaptation of the 1957 musical, West Side Story explores forbidden love and the rivalry between the Jets and the Sharks, two teenage street gangs of different ethnic backgrounds.', 2, 'tt3581652', '2021-12-22 17:45:50', NULL, 2021, '02:36:00', 7.9),
(9, 'The Matrix Resurrections', 9, 'movie_cover/the-matrix-resurrections-EMMf9gIohbDtaCYRT.jpg', 'Plagued by strange memories, Neo\'s life takes an unexpected turn when he finds himself back inside the Matrix.', 'Return to a world of two realities: one, everyday life; the other, what lies behind it. To find out if his reality is a construct, to truly know himself, Mr. Anderson will have to choose to follow the white rabbit once more.', 3, 'tt10838180', '2021-12-22 17:48:00', '2021-12-22 17:49:27', 2021, '02:28:00', 6.6),
(10, 'The Power of the Dog', 2, 'movie_cover/the-power-of-the-dog-EM5xJ6djbuADfznTF.jpg', 'A domineering but charismatic rancher wages a war of intimidation on his brother\'s new wife and her teen son, until long-hidden secrets come to light.', 'Charismatic rancher Phil Burbank inspires fear and awe in those around him. When his brother brings home a new wife and her son, Phil torments them until he finds himself exposed to the possibility of love.', 3, 'tt10293406', '2021-12-22 17:51:42', NULL, 2021, '02:06:00', 7),
(11, 'Don\'t Look Up', 19, 'movie_cover/dont-look-up-EMtG7ZwHYPEeMcIWK.jpg', 'Two low-level astronomers must go on a giant media tour to warn mankind of an approaching comet that will destroy planet Earth.', 'Two astronomers go on a media tour to warn humankind of a planet-killing comet hurtling toward Earth. The response from a distracted world: Meh.', 2, 'tt11286314', '2021-12-22 18:25:51', NULL, 2021, '02:18:00', 7.4),
(12, 'The Last Duel', 13, 'movie_cover/the-last-duel-EMv7xl09Pn52iOCyu.jpg', 'King Charles VI declares that Knight Jean de Carrouges settle his dispute with his squire by challenging him to a duel.', 'King Charles VI declares that Knight Jean de Carrouges settle his dispute with his squire, Jacques Le Gris, by challenging him to a duel.', 2, 'tt4244994', '2021-12-22 18:29:18', NULL, 2021, '02:32:00', 7.5),
(13, 'Dune: Part One', 14, 'movie_cover/dune-part-one-EMwNWVPAcqMtEuYh8.jpg', 'Feature adaptation of Frank Herbert\'s science fiction novel about the son of a noble family entrusted with the protection of the most valuable asset and most vital element in the galaxy.', 'Paul Atreides, a brilliant and gifted young man born into a great destiny beyond his understanding, must travel to the most dangerous planet in the universe to ensure the future of his family and his people. As malevolent forces explode into conflict over the planet\'s exclusive supply of the most precious resource in existence-a commodity capable of unlocking humanity\'s greatest potential-only those who can conquer their fear will survive.', 2, 'tt1160419', '2021-12-22 18:31:44', NULL, 2021, '02:35:00', 8.2),
(14, '365 dni', 8, 'movie_cover/365-dni-EMSOPgD7k9C43FJcd.jpg', 'A woman falls victim to a dominant mafia boss, who imprisons her and gives her one year to fall in love with him.', 'Massimo is a member of the Sicilian Mafia family and Laura is a sales director. She does not expect that on a trip to Sicily trying to save her relationship, Massimo will kidnap her and give her 365 days to fall in love with him.', 2, 'tt9620292', '2021-12-22 18:39:19', NULL, 2020, '01:54:00', 3.3),
(15, 'Promising Young Woman', 5, 'movie_cover/promising-young-woman-EMBcRSMO7lYkIJZ62.png', 'A young woman, traumatized by a tragic event in her past, seeks out vengeance against those who crossed her path.', 'A young woman, traumatized by a tragic event in her past, seeks out vengeance against those who crossed her path.', 2, 'tt9620292', '2021-12-22 18:42:15', NULL, 2020, '01:53:00', 7.5),
(16, 'The Christmas Chronicles: Part Two', 17, 'movie_cover/the-christmas-chronicles-part-two-EM7OCXilm0vYt4Ijd.jpg', 'Kate Pierce, now a cynical teen, is unexpectedly reunited with Santa Claus when a mysterious troublemaker threatens to cancel Christmas - forever.', 'Kate Pierce is reluctantly spending Christmas with her mom’s new boyfriend and his son Jack. But when the North Pole and Christmas are threatened to be destroyed, Kate and Jack are unexpectedly pulled into a new adventure with Santa Claus.', 2, 'tt11057644', '2021-12-22 18:48:46', NULL, 2020, '01:52:00', 6),
(17, 'Tenet', 3, 'movie_cover/tenet-EMCuNi28J6tFhUa31.jpg', 'Armed with only one word, Tenet, and fighting for the survival of the entire world.', 'Armed with only one word - Tenet - and fighting for the survival of the entire world, the Protagonist journeys through a twilight world of international espionage on a mission that will unfold in something beyond real time.', 2, 'tt6723592', '2021-12-22 18:54:13', NULL, 2020, '02:30:00', 7.4),
(18, 'The Night House', 4, 'movie_cover/the-night-house-EMDyJ1PaSd3uh6L29.jpg', 'A widow begins to uncover her recently deceased husband\'s disturbing secrets.', 'Reeling from the unexpected death of her husband, Beth is left alone in the lakeside home he built for her. Soon she begins to uncover her recently deceased husband\'s disturbing secrets.', 2, 'tt9731534', '2021-12-22 19:05:37', NULL, 2020, '01:47:00', 6.5),
(19, 'Holidate', 8, 'movie_cover/holidate-EMBlqhODgTMvRHNt0.jpg', 'Fed up with being single on holidays, two strangers agree to be each other\'s platonic plus-ones all year long, only to catch real feelings along the way.', 'Fed up with being single on holidays, two strangers agree to be each other\'s platonic plus-ones all year long, only to catch real feelings along the way.', 1, 'tt9866072', '2021-12-24 21:23:00', NULL, 2020, '01:44:00', 6.1),
(20, 'Wonder Woman 1984', 14, 'movie_cover/wonder-woman-1984-EMW5lbghJS6uQFODX.png', 'A botched store robbery places Wonder Woman in a global battle against a powerful and mysterious ancient force that puts her powers in jeopardy.', 'Diana must contend with a work colleague and businessman, whose desire for extreme wealth sends the world down a path of destruction, after an ancient artifact that grants wishes goes missing.', 3, 'tt7126948', '2021-12-24 21:25:12', NULL, 2020, '02:31:00', 5.4),
(21, 'Zola', 10, 'movie_cover/zola-EMGX1zWMOirQETw54.jpg', 'A stripper named Zola embarks on a wild road trip to Florida.', 'A waitress agrees to accompany an exotic dancer, her put-upon boyfriend, and her mysterious and domineering roommate on a road trip to Florida to seek their fortune at a high-end strip club.', 1, 'tt5439812', '2021-12-24 23:56:22', NULL, 2020, '01:26:00', 6.5),
(22, 'Birds of Prey: And the Fantabulous Emancipation of One Harley Quinn', 21, 'movie_cover/birds-of-prey-and-the-fantabulous-emancipation-of-one-harley-quinn-EMt013mLW8v7MNDxp.jpg', 'After splitting with the Joker, Harley Quinn joins superheroines Black Canary, Huntress and Renee Montoya to save a young girl from an evil crime lord.', 'Harley Quinn joins forces with a singer, an assassin and a police detective to help a young girl who had a hit placed on her after she stole a rare diamond from a crime lord.', 2, 'tt7713068', '2021-12-25 00:08:05', NULL, 2020, '01:49:00', 6.1),
(23, 'News of the World', 6, 'movie_cover/news-of-the-world-EMQNztg637sViLFPS.jpg', 'A Texan traveling across the wild West bringing the news of the world to local townspeople, agrees to help rescue a young girl who was kidnapped.', 'A Civil War veteran agrees to deliver a girl, taken by the Kiowa people years ago, to her aunt and uncle, against her will. They travel hundreds of miles and face grave dangers as they search for a place that either can call home.', 2, 'tt6878306', '2021-12-25 00:12:32', NULL, 2020, '01:58:00', 6.8),
(24, 'The Unbearable Weight of Massive Talent', 19, 'movie_cover/the-unbearable-weight-of-massive-talent-EMcLixEDIX8bpmvGV.jpg', 'A cash-strapped Nicolas Cage agrees to make a paid appearance at a billionaire super fan\'s birthday party, but...', 'Creatively unfulfilled and facing financial ruin, Nick Cage must accept a $1 million offer to attend the birthday of a dangerous superfan. Things take a wildly unexpected turn when Cage is recruited by a CIA operative and forced to live up to his own legend, channeling his most iconic and beloved on-screen characters in order to save himself and his loved ones.', 1, 'tt11291274', '2021-12-27 02:26:40', NULL, 2022, '00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `watching_type` varchar(100) NOT NULL,
  `source_name` varchar(100) NOT NULL,
  `lang_setting` varchar(100) NOT NULL,
  `source_code` text NOT NULL,
  `fid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `watching_type`, `source_name`, `lang_setting`, `source_code`, `fid`) VALUES
(2, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/Y9dr2zw-TXQ\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 1),
(1, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/55FSKz9ZCB4\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 1),
(3, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/XJ42M8rsnjE\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 2),
(4, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/mqqft2x_Aa4\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 3),
(5, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/JfVOs4VSpmA\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 4),
(6, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/x_me3xsvDgk\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 5),
(7, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/8YjFbMbfXaQ\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 6),
(8, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/WZWaozzM9Pk\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 7),
(9, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/A5GJLwWiYSg\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 8),
(10, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/9ix7TUGVYIo\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 9),
(11, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/nNpvWBuTfrc\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 9),
(12, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/LRDPo0CHrko\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 10),
(13, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/RbIxYm3mKzI\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 11),
(14, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/mgygUwPJvYk\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 12),
(15, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/8g18jFHCLXk\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 13),
(16, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/DRCEto_MHSI\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 14),
(17, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/7i5kiFDunk8\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 15),
(18, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/HVzBwSOcBaI\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 16),
(19, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/AZGcmvrTX9M\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 17),
(20, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/2Tshycci2ZA\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 18),
(21, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/hxaaAoI57fk\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 19),
(22, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/XW2E2Fnh52w\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 20),
(23, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/24KbaKlCDDI\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 21),
(24, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/kGM4uYZzfu0\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 22),
(25, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/x3HbbzHK5Mc\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 22),
(26, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/zTZDb_iKooI\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 23),
(27, 'Trailer', 'Youtube', 'English', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/I8VuWhvk87o\" title=\"YouTube video player\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 24);

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

DROP TABLE IF EXISTS `scores`;
CREATE TABLE IF NOT EXISTS `scores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL,
  `star_score` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `fid`, `star_score`) VALUES
(1, 4, 5),
(2, 6, 4),
(3, 19, 5),
(4, 20, 4),
(5, 11, 4),
(6, 12, 5),
(7, 17, 4),
(8, 14, 5),
(9, 10, 4),
(10, 15, 4),
(11, 18, 4);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
