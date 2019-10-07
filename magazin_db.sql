-- --------------------------------------------------------
-- Server:                       127.0.0.1
-- Versiune server:              10.3.13-MariaDB-log - mariadb.org binary distribution
-- SO server:                    Win64
-- HeidiSQL Versiune:            10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Descarcă structura pentru tabelă magazin.clienti
CREATE TABLE IF NOT EXISTS `clienti` (
  `Id_Client` int(3) NOT NULL AUTO_INCREMENT,
  `Username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Parola` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `Numele` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `Prenumele` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `Data_nasterii` datetime DEFAULT NULL,
  `Telefon` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Email` varchar(65) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Adresa` varchar(65) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Id_Client`),
  UNIQUE KEY `Username` (`Username`),
  UNIQUE KEY `Id_Client` (`Id_Client`),
  UNIQUE KEY `Telefon` (`Telefon`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Descarcă datele pentru tabela magazin.clienti: ~2 rows (aproximativ)
/*!40000 ALTER TABLE `clienti` DISABLE KEYS */;
INSERT INTO `clienti` (`Id_Client`, `Username`, `Parola`, `Numele`, `Prenumele`, `Data_nasterii`, `Telefon`, `Email`, `Adresa`) VALUES
	(1, 'AlexRusu', 'alex*1rusu', 'Rusu', 'Alex', '1995-10-05 10:50:40', '68546839', 'alexrusu@gmail.com', 'Alexandru cel Bun 23/45'),
	(2, 'AnaIacob', 'ana*2iacob', 'Iacob', 'Ana', '1995-02-15 22:10:01', '74657533', 'anaiacob@gmail.com', 'Stefan cel mare 2/67');
/*!40000 ALTER TABLE `clienti` ENABLE KEYS */;

-- Descarcă structura pentru tabelă magazin.comenzi
CREATE TABLE IF NOT EXISTS `comenzi` (
  `Id_Comanda` int(11) NOT NULL AUTO_INCREMENT,
  `Id_Linie_Comanda` int(11) NOT NULL,
  `Id_Client` int(11) NOT NULL,
  `Suma_Comandata` float NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id_Comanda`),
  KEY `Id_Client` (`Id_Client`),
  KEY `Id_Linie_Comanda` (`Id_Linie_Comanda`),
  CONSTRAINT `Id_Client` FOREIGN KEY (`Id_Client`) REFERENCES `clienti` (`Id_Client`),
  CONSTRAINT `Id_Linie_Comanda` FOREIGN KEY (`Id_Linie_Comanda`) REFERENCES `liniecomanda` (`Id_Linie_Comanda`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Descarcă datele pentru tabela magazin.comenzi: ~2 rows (aproximativ)
/*!40000 ALTER TABLE `comenzi` DISABLE KEYS */;
INSERT INTO `comenzi` (`Id_Comanda`, `Id_Linie_Comanda`, `Id_Client`, `Suma_Comandata`) VALUES
	(1, 1, 1, 6),
	(2, 2, 1, 20);
/*!40000 ALTER TABLE `comenzi` ENABLE KEYS */;

-- Descarcă structura pentru tabelă magazin.inregistrare
CREATE TABLE IF NOT EXISTS `inregistrare` (
  `Id_Inregistrare` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Descarcă datele pentru tabela magazin.inregistrare: ~0 rows (aproximativ)
/*!40000 ALTER TABLE `inregistrare` DISABLE KEYS */;
/*!40000 ALTER TABLE `inregistrare` ENABLE KEYS */;

-- Descarcă structura pentru tabelă magazin.liniecomanda
CREATE TABLE IF NOT EXISTS `liniecomanda` (
  `Id_Linie_Comanda` int(3) NOT NULL AUTO_INCREMENT,
  `Data_Comenzii` datetime NOT NULL DEFAULT curtime(),
  `Id_Produs` int(3) NOT NULL,
  `Cantitate_Comandata` int(2) NOT NULL,
  `Pret_Line_Comanda` double NOT NULL,
  PRIMARY KEY (`Id_Linie_Comanda`),
  KEY `Id_Produs` (`Id_Produs`),
  CONSTRAINT `Id_Produs` FOREIGN KEY (`Id_Produs`) REFERENCES `produse` (`Id_Produs`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Descarcă datele pentru tabela magazin.liniecomanda: ~2 rows (aproximativ)
/*!40000 ALTER TABLE `liniecomanda` DISABLE KEYS */;
INSERT INTO `liniecomanda` (`Id_Linie_Comanda`, `Data_Comenzii`, `Id_Produs`, `Cantitate_Comandata`, `Pret_Line_Comanda`) VALUES
	(1, '2019-10-07 16:47:47', 1, 2, 6),
	(2, '2019-10-07 16:56:52', 2, 1, 20);
/*!40000 ALTER TABLE `liniecomanda` ENABLE KEYS */;

-- Descarcă structura pentru tabelă magazin.logare
CREATE TABLE IF NOT EXISTS `logare` (
  `Nr` int(3) NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Parola` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`Nr`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Descarcă datele pentru tabela magazin.logare: ~0 rows (aproximativ)
/*!40000 ALTER TABLE `logare` DISABLE KEYS */;
/*!40000 ALTER TABLE `logare` ENABLE KEYS */;

-- Descarcă structura pentru tabelă magazin.lucratori
CREATE TABLE IF NOT EXISTS `lucratori` (
  `Id_Lucrator` int(3) NOT NULL AUTO_INCREMENT,
  `Functie` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nume_L` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Prenume_L` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Username_L` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Parola_L` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email_L` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Telefon_L` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Id_Lucrator`),
  UNIQUE KEY `Username_L` (`Username_L`),
  UNIQUE KEY `Parola_L` (`Parola_L`),
  UNIQUE KEY `Email_L` (`Email_L`),
  UNIQUE KEY `Telefon_L` (`Telefon_L`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Descarcă datele pentru tabela magazin.lucratori: ~1 rows (aproximativ)
/*!40000 ALTER TABLE `lucratori` DISABLE KEYS */;
INSERT INTO `lucratori` (`Id_Lucrator`, `Functie`, `Nume_L`, `Prenume_L`, `Username_L`, `Parola_L`, `Email_L`, `Telefon_L`) VALUES
	(1, 'Admin', 'Lusea', 'Mihail', 'Amihaillusea', 'AMihailLusea', 'mihaillusea@gmail.com', NULL);
/*!40000 ALTER TABLE `lucratori` ENABLE KEYS */;

-- Descarcă structura pentru procedură magazin.procedura_1
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `procedura_1`(
	IN `Param1` INT
)
    COMMENT 'acesta este o procedura'
BEGIN
select * from clienti magazin where magazin.Id_Client= Param1; 
END//
DELIMITER ;

-- Descarcă structura pentru tabelă magazin.produse
CREATE TABLE IF NOT EXISTS `produse` (
  `Id_Produs` int(3) NOT NULL AUTO_INCREMENT,
  `Denumire` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `Imagine_Produs` geometrycollection DEFAULT NULL,
  `Pret` float NOT NULL DEFAULT 0,
  `Cantitate_Totala` int(4) NOT NULL DEFAULT 0,
  `Cantitate_Vanduta` int(4) unsigned zerofill DEFAULT NULL,
  `Cantitate_Ramasa` int(4) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`Id_Produs`),
  UNIQUE KEY `Denumire` (`Denumire`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Descarcă datele pentru tabela magazin.produse: ~5 rows (aproximativ)
/*!40000 ALTER TABLE `produse` DISABLE KEYS */;
INSERT INTO `produse` (`Id_Produs`, `Denumire`, `Imagine_Produs`, `Pret`, `Cantitate_Totala`, `Cantitate_Vanduta`, `Cantitate_Ramasa`) VALUES
	(1, 'Paine alba, 300 g', NULL, 3, 100, 0000, 0000),
	(2, 'Banane', NULL, 25, 60, 0000, 0000),
	(3, 'Capsune', NULL, 40, 15, 0000, 0000),
	(4, 'Inghetata joc', NULL, 2.5, 45, 0000, 0000),
	(5, ' Tuty Frutty,  Limonada de 2,5 l', NULL, 24.5, 24, 0000, 0000);
/*!40000 ALTER TABLE `produse` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
