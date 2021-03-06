-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2021 at 01:43 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kurs`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `eventID` int(11) NOT NULL,
  `eventName` varchar(255) NOT NULL,
  `eventStartDatum` date NOT NULL,
  `eventEndDatum` date NOT NULL,
  `eventKategorie` varchar(255) NOT NULL,
  `eventBundesland` varchar(255) NOT NULL,
  `eventBeschreibung` text NOT NULL,
  `eventBild` varchar(100) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`eventID`, `eventName`, `eventStartDatum`, `eventEndDatum`, `eventKategorie`, `eventBundesland`, `eventBeschreibung`, `eventBild`) VALUES
(1, 'Lorem Ipsum', '2021-07-12', '2021-07-13', 'Klassikkonzert', '', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem.', 'concert1.jpg'),
(2, 'Faucibus Tincidunt', '2021-07-03', '2021-07-03', 'Rave', 'Nieder??sterreich', 'Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc.', 'rave1.jpg'),
(3, 'Commun Vocabules', '2021-07-15', '2021-07-15', 'Rave', 'Ober??sterreich', 'Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc, litot Europa usa li sam vocabular.', 'rave2.jpg'),
(4, 'Omnicos Directe', '2021-08-12', '2021-08-12', 'Klassikkonzert', 'Steiermark', 'On refusa continuar payar custosi traductores. At solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.', 'concert2.jpg'),
(5, 'Desirabilite de un nov lingua franca', '2021-08-25', '2021-08-25', 'Ballett', 'Nieder??sterreich', 'Ma quande lingues coalesce, li grammatica del resultant lingue es plu simplic e regulari quam ti del coalescent lingues.', 'ballet1.jpg'),
(6, 'Li nov lingua', '2021-09-01', '0000-00-00', 'Kunstausstellung', 'Salzburg', 'Franca va esser plu simplic e regulari quam li existent Europan lingues. It va esser tam simplic quam Occidental in fact, it va esser Occidental. A un Angleso it va semblar un simplificat Angles, quam un skeptic Cambridge amico dit me que.', 'art1.jpg'),
(7, 'Occidental Es', '2021-07-12', '2021-07-13', 'Musical', 'Tirol', 'Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc, litot Europa usa li sam vocabular. Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules.', 'musical1.jpg'),
(8, 'Omnicos Directe', '2021-07-15', '2021-07-15', 'Operette', 'Burgenland', 'Al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.', 'operette1.jpg'),
(9, 'Magnis Dis Parturient', '2021-09-04', '2021-09-06', 'Rockkonzert', 'Nieder??sterreich', 'Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.', 'rock1.jpg'),
(10, 'Consectetuer Adipiscing Elit', '2021-09-09', '2021-09-09', 'Oper', 'Wien', 'Lorem ipsum dolor sit amet. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 'opera1.jpg'),
(11, 'Dictum Felis Eu Pede', '2021-07-03', '2021-07-04', 'Kunstausstellung', 'Tirol', 'Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.', 'art2.jpg'),
(12, 'Quisque Rutrum', '2021-07-23', '2021-07-24', 'Rave', 'Salzburg', 'Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.', 'rave3.jpg'),
(14, 'Metus Varius Laoreet', '2021-09-05', '2021-09-05', 'Musical', 'K??rnten', 'Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Etiam sit amet orci eget eros faucibus tincidunt.', 'musical2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`eventID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `eventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
