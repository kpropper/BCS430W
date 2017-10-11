-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Host: db589593745.db.1and1.com
-- Generation Time: Nov 23, 2016 at 10:12 AM
-- Server version: 5.5.52-0+deb7u1-log
-- PHP Version: 5.4.45-0+deb7u5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db589593745`
--

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE IF NOT EXISTS `grades` (
  `rowid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student` int(11) NOT NULL,
  `event` varchar(20) NOT NULL,
  `grade` smallint(6) NOT NULL,
  `date` date NOT NULL,
  `comment` varchar(80) NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`rowid`, `student`, `event`, `grade`, `date`, `comment`) VALUES
(1, 1, 'Midterm Exam', 85, '2015-10-13', ''),
(2, 2, 'Midterm Exam', 88, '2015-10-13', ''),
(3, 3, 'Midterm Exam', 88, '2015-10-13', ''),
(4, 4, 'Midterm Exam', 100, '2015-10-13', ''),
(5, 5, 'Midterm Exam', 85, '2015-10-13', ''),
(6, 6, 'Midterm Exam', 88, '2015-10-13', ''),
(7, 16, 'Midterm Exam', 90, '2015-10-13', ''),
(9, 8, 'Midterm Exam', 100, '2015-10-13', ''),
(10, 9, 'Midterm Exam', 85, '2015-10-13', ''),
(11, 10, 'Midterm Exam', 100, '2015-10-13', ''),
(12, 12, 'Midterm Exam', 85, '2015-10-13', ''),
(14, 14, 'Midterm Exam', 73, '2015-10-13', ''),
(15, 15, 'Midterm Exam', 85, '2015-10-13', ''),
(16, 17, 'Midterm Exam', 100, '2015-10-13', ''),
(17, 18, 'Midterm Exam', 100, '2015-10-13', ''),
(18, 19, 'Midterm Exam', 80, '2015-10-13', ''),
(19, 20, 'Midterm Exam', 85, '2015-10-13', ''),
(20, 22, 'Midterm Exam', 83, '2015-10-13', ''),
(22, 7, 'Midterm Exam', 100, '2015-10-14', '');

-- --------------------------------------------------------

--
-- Table structure for table `homework`
--

CREATE TABLE IF NOT EXISTS `homework` (
  `rowid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student` int(10) unsigned NOT NULL,
  `lecture` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `file` varchar(20) NOT NULL,
  `comments` varchar(1024) NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `homework`
--

INSERT INTO `homework` (`rowid`, `student`, `lecture`, `date`, `status`, `file`, `comments`) VALUES
(1, 1, 3, '2015-09-29', 0, '1.txt', 'Function that will add HTML tags to an inputted string for BOLD, ITALICS or UNDERLINE. Upload not accepting .php so had to change to text file'),
(2, 1, 3, '2015-09-29', 0, '2.txt', 'Upload not accepting php so had to change file to text again. Associative Array HW');

-- --------------------------------------------------------

--
-- Table structure for table `lectures`
--

CREATE TABLE IF NOT EXISTS `lectures` (
  `rowid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lecture` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `file` varchar(80) NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `lectures`
--

INSERT INTO `lectures` (`rowid`, `lecture`, `title`, `file`) VALUES
(2, 1, 'Powerpoint', 'BCS350-Web_Database_Design.pptx'),
(3, 2, 'Powerpoint', 'BCS350_Week_2.pptx'),
(4, 3, 'Powerpoint', 'BCS350-Week03.pptx'),
(5, 4, 'Powerpoint', 'BCS350__Week_4.pptx'),
(6, 4, 'Powerpoint - MySQL Tutorial', 'BCS350__MySQL_Tutorial.pptx'),
(7, 5, 'Powerpoint', 'BCS350__Week_5.pptx'),
(8, 6, 'Powerpoint', 'BCS350__Practical_MySQL_Queries.pptx'),
(9, 7, 'Powerpoint', 'BCS350__Midterm_Review.pptx'),
(10, 8, 'Powerpoint', 'BCS350_Week_8.pptx'),
(11, 9, 'Powerpoint', 'BCS350_Week_9.pptx'),
(12, 10, 'Powerpoint', 'BCS350_Week_10.pptx'),
(13, 11, 'Powerpoint', 'BCS350_Week_11.pptx'),
(14, 12, 'Powerpoint', 'BCS350_Week_12.pptx'),
(15, 13, 'Powerpoint - 1st Half', 'BCS350 – Review 1H.pptx'),
(16, 13, 'Powerpoint - 2nd Half', 'BCS350 – Review 2H.pptx'),
(17, 13, 'Database Normalization', 'Website Normalization.pptx');

-- --------------------------------------------------------

--
-- Table structure for table `roster`
--

CREATE TABLE IF NOT EXISTS `roster` (
  `rowid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lastname` varchar(25) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `ramid` char(13) NOT NULL,
  `email` varchar(80) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `role` varchar(10) NOT NULL,
  `password` varchar(80) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `roster`
--

INSERT INTO `roster` (`rowid`, `lastname`, `firstname`, `ramid`, `email`, `userid`, `role`, `password`, `status`) VALUES
(1, 'Aguero German', 'Ambar', '', 'agueac@farmingdale.edu', 'agueac', 'Student ', 'agueac', 1),
(2, 'Belluscio', 'Brett', '', 'bellba@farmingdale.edu', 'bellba', 'Student ', 'bellba', 1),
(3, 'Cabrera', 'Esteban', '', 'cabre@farmingdale.edu', 'cabre', 'Student ', 'cabre', 1),
(4, 'Ciesluk', 'William', '', 'ciesw@farmingdale.edu', 'ciesw', 'Student ', 'ciesw', 1),
(5, 'De Cordova', 'Jenna', '', 'decojl@farmingdale.edu', 'decojl', 'Student ', 'decojl', 1),
(6, 'Densford', 'Charles', '', 'densce@farmingdale.edu', 'densce', 'Student ', 'densce', 1),
(7, 'Dikeman', 'Christopher', '', 'dikecr@farmingdale.edu', 'dikecr', 'Student ', 'dikecr', 1),
(8, 'Dimayuga', 'Michael', '', 'dimam1@farmingdale.edu', 'dimam1', 'Student ', 'dimam1', 1),
(9, 'Flores', 'Karen', '', 'florkm4@farmingdale.edu', 'florkm4', 'Student ', 'florkm4', 1),
(10, 'Haider', 'Sumaiya', '', 'haids@farmingdale.edu', 'haids', 'Student ', 'haids', 1),
(11, 'Hodge', 'Alonzo', '', 'hodgai@farmingdale.edu', 'hodgai', 'Student ', 'hodgai', 1),
(12, 'Jones', 'Tamika', '', 'jonets@farmingdale.edu', 'jonets', 'Â ', 'jonets', 0),
(13, 'Kaplan', 'Charles', '', 'kaplancr@farmingdale.edu', 'kaplancr', 'Faculty', 'kaplancr', 1),
(14, 'Mariotti', 'Timothy', '', 'marita@farmingdale.edu', 'marita', 'Student ', 'marita', 1),
(15, 'Mooney', 'Joseph', '', 'moonjr@farmingdale.edu', 'moonjr', 'Student ', 'moonjr', 1),
(16, 'Moses', 'Tyler', '', 'mosetm@farmingdale.edu', 'mosetm', 'Student ', 'mosetm', 1),
(17, 'Parvin', 'Nafeesa', '', 'parvn@farmingdale.edu', 'parvn', 'Student ', 'parvn', 1),
(18, 'Polosino', 'Kelsey', '', 'polok@farmingdale.edu', 'polok', 'Student ', 'polok', 1),
(19, 'Rutkowski', 'Adrian', '', 'rutkar@farmingdale.edu', 'rutkar', 'Student ', 'rutkar', 1),
(20, 'Seigel', 'Andrew', '', 'seiga@farmingdale.edu', 'seiga', 'Student ', 'seiga', 1),
(21, 'Spindler', 'Matthew', '', 'spinmw@farmingdale.edu', 'spinmw', 'Student ', 'spinmw', 1),
(22, 'Tong', 'Kevin', '', 'tongk@farmingdale.edu', 'tongk', 'Student ', 'tongk', 1),
(23, 'Smith', 'John', 'R123456789', 'john.smith@fsc.org', 'johns', 'Student', 'secret', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
