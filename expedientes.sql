# --------------------------------------------------------
# Host:                         10.10.11.253
# Database:                     sernanp
# Server version:               5.1.41-3ubuntu12.6
# Server OS:                    debian-linux-gnu
# HeidiSQL version:             5.0.0.3272
# Date/time:                    2010-08-31 11:11:17
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping structure for table sernanp.expedientes
CREATE TABLE IF NOT EXISTS `expedientes` (
  `id_expediente` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_expediente` varchar(15) DEFAULT NULL,
  `id_documento` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_expediente`)
) ENGINE=MyISAM DEFAULT ;

# Data exporting was unselected.
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
