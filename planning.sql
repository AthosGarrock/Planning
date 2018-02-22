/* Database export results for db planning */

/* Preserve session variables */
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS;
SET FOREIGN_KEY_CHECKS=0;

/* Export data */

/* Table structure for categories */
CREATE TABLE `categories` (
  `name` varchar(80) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `color` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* Table structure for day_entry */
CREATE TABLE `day_entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme` varchar(50) DEFAULT NULL,
  `d_start` date DEFAULT NULL,
  `d_end` date DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/* Table structure for entry */
CREATE TABLE `entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `de_fk` int(11) DEFAULT NULL,
  `activite` varchar(50) DEFAULT NULL,
  `e_start` time DEFAULT NULL,
  `e_end` time DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `FK_Day_Entry` (`de_fk`),
  CONSTRAINT `fk_de_ref` FOREIGN KEY (`de_fk`) REFERENCES `day_entry` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/* Table structure for week */
CREATE TABLE `week` (
  `de_fk` int(11) DEFAULT NULL,
  `mon` tinyint(1) DEFAULT NULL,
  `tue` tinyint(1) DEFAULT NULL,
  `wed` tinyint(1) DEFAULT NULL,
  `thu` tinyint(1) DEFAULT NULL,
  `fri` tinyint(1) DEFAULT NULL,
  `sat` tinyint(1) DEFAULT NULL,
  `sun` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* Restore session variables to original values */
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
