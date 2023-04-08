-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 12, 2014 at 09:38 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `otomasyon`
--
CREATE DATABASE IF NOT EXISTS `otomasyon` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `otomasyon`;

-- --------------------------------------------------------

--
-- Table structure for table `ders`
--

CREATE TABLE IF NOT EXISTS `ders` (
  `ders_kodu` varchar(32) NOT NULL,
  `ders_ad` varchar(50) NOT NULL,
  PRIMARY KEY (`ders_kodu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ders`
--

INSERT INTO `ders` (`ders_kodu`, `ders_ad`) VALUES
('AAddd', 'MATEMATIK\r'),
('VT101', 'Veri Tabani\r');

-- --------------------------------------------------------

--
-- Table structure for table `fakulte`
--

CREATE TABLE IF NOT EXISTS `fakulte` (
  `fakulte_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ad` varchar(50) NOT NULL,
  PRIMARY KEY (`fakulte_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `fakulte`
--

INSERT INTO `fakulte` (`fakulte_id`, `ad`) VALUES
(1, 'Mühendislik ve Tasarım\r'),
(3, 'Hukuk\r');

-- --------------------------------------------------------

--
-- Table structure for table `mazeret`
--

CREATE TABLE IF NOT EXISTS `mazeret` (
  `mazeret_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aciklama` text NOT NULL,
  `tarih` date NOT NULL,
  `kabul` tinyint(4) NOT NULL,
  `ogrenci_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`mazeret_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mazeret`
--

INSERT INTO `mazeret` (`mazeret_id`, `aciklama`, `tarih`, `kabul`, `ogrenci_id`) VALUES
(1, 'başım ağrıy ders girmicem', '2014-12-10', 1, 1),
(2, 'Okula gitmek istemiyorum :((((', '2014-12-13', -1, 1),
(3, 'dsdds', '0000-00-00', -1, 1),
(4, 'hastayım....', '2014-12-17', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mazeretalma`
--

CREATE TABLE IF NOT EXISTS `mazeretalma` (
  `ders_id` int(10) unsigned NOT NULL,
  `mazeret_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mazeretalma`
--

INSERT INTO `mazeretalma` (`ders_id`, `mazeret_id`) VALUES
(4, 1),
(3, 2),
(3, 3),
(5, 4),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `ogrenci`
--

CREATE TABLE IF NOT EXISTS `ogrenci` (
  `ogrenci_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parola` varchar(256) NOT NULL,
  `okul_no` varchar(16) NOT NULL,
  `ad_soyad` varchar(50) NOT NULL,
  `sinif` tinyint(4) NOT NULL,
  `fakulte_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ogrenci_id`),
  UNIQUE KEY `okul_no` (`okul_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ogrenci`
--

INSERT INTO `ogrenci` (`ogrenci_id`, `parola`, `okul_no`, `ad_soyad`, `sinif`, `fakulte_id`) VALUES
(1, '1994', '120502006', 'Ömer Faruk CAN', 3, 1),
(2, '123', '120502002', 'Enes Bilgehan Kağan', 3, 1),
(3, '12345', 'YU1105.02006', 'Issa Baban Chawai', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ogretimelemani`
--

CREATE TABLE IF NOT EXISTS `ogretimelemani` (
  `tc` bigint(20) unsigned NOT NULL,
  `ad` varchar(50) NOT NULL,
  `fakulte_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ogretimelemani`
--

INSERT INTO `ogretimelemani` (`tc`, `ad`, `fakulte_id`) VALUES
(55555555554, 'Rıfat Yazıcı', 1),
(55555555555, 'Mustafa Cem Kasapbaşı', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rapor`
--

CREATE TABLE IF NOT EXISTS `rapor` (
  `rapor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `resim` varchar(128) NOT NULL,
  `tarih` date NOT NULL,
  `kac_gun` tinyint(3) unsigned NOT NULL,
  `kabul` tinyint(4) NOT NULL,
  `ogrenci_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`rapor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rapor`
--

INSERT INTO `rapor` (`rapor_id`, `resim`, `tarih`, `kac_gun`, `kabul`, `ogrenci_id`) VALUES
(1, 'raporlar\\2014-12-25_rapor_1_89392425.jpg', '2014-12-25', 3, 1, 1),
(2, 'raporlar\\2014-12-13_rapor_1_46019500.jpg', '2014-12-13', 5, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `raporalma`
--

CREATE TABLE IF NOT EXISTS `raporalma` (
  `rapor_id` int(10) unsigned NOT NULL,
  `ders_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `raporalma`
--

INSERT INTO `raporalma` (`rapor_id`, `ders_id`) VALUES
(1, 3),
(2, 3),
(2, 5),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sabitler`
--

CREATE TABLE IF NOT EXISTS `sabitler` (
  `no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ad` varchar(64) NOT NULL,
  `deger` varchar(256) NOT NULL,
  PRIMARY KEY (`no`),
  UNIQUE KEY `ad` (`ad`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sabitler`
--

INSERT INTO `sabitler` (`no`, `ad`, `deger`) VALUES
(1, 'anasayfa_bilgi', 'Anasayfada ki öğrencileri bilgilendirme amaçlı not buraya gelecek'),
(2, 'rapor_sayfa_aciklama', '*15 günü geçen raporlar kabul edilmez...');

-- --------------------------------------------------------

--
-- Table structure for table `verilenders`
--

CREATE TABLE IF NOT EXISTS `verilenders` (
  `ders_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ders_kodu` varchar(32) NOT NULL,
  `tc` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`ders_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `verilenders`
--

INSERT INTO `verilenders` (`ders_id`, `ders_kodu`, `tc`) VALUES
(3, 'VT101', 55555555555),
(4, 'AAddd', 55555555555),
(5, 'VT101', 55555555554);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
