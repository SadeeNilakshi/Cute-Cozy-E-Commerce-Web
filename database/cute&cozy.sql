-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.32 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for cute&cozy
CREATE DATABASE IF NOT EXISTS `cute&cozy` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cute&cozy`;

-- Dumping structure for table cute&cozy.about
CREATE TABLE IF NOT EXISTS `about` (
  `id` int NOT NULL AUTO_INCREMENT,
  `footerseo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.about: ~1 rows (approximately)
REPLACE INTO `about` (`id`, `footerseo`) VALUES
	(1, 'Step into our world of elegance and style, where every piece tells a story of empowerment and beauty. Founded with a vision to celebrate the essence of womanhood, we curate a stunning collection of fashion items that inspire confidence and allure.');

-- Dumping structure for table cute&cozy.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `email` varchar(100) NOT NULL,
  `fname` varchar(25) NOT NULL,
  `lname` varchar(25) NOT NULL,
  `verification_code` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.admin: ~5 rows (approximately)
REPLACE INTO `admin` (`email`, `fname`, `lname`, `verification_code`) VALUES
	('deltacodexsoftwares@gmail.com', 'delta Codex', 'Software Solutions', NULL),
	('sadeeshanilakshi25@gmail.com', 'Sadeesha', 'Nilakshini', NULL),
	('samadhinew2@gmail.com', 'Sadeesha', 'Nilakshini', NULL),
	('tharibro2211@gmail.com', 'Tharindu', 'Chanaka', NULL),
	('tharinduchanaka6@gmail.com', 'Tharindu', 'Chanaka', NULL);

-- Dumping structure for table cute&cozy.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `qty` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cart_user1_idx` (`user_email`),
  KEY `fk_cart_product1_idx` (`product_id`),
  CONSTRAINT `fk_cart_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_cart_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.cart: ~0 rows (approximately)

-- Dumping structure for table cute&cozy.category
CREATE TABLE IF NOT EXISTS `category` (
  `c_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `path` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  PRIMARY KEY (`c_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.category: ~4 rows (approximately)
REPLACE INTO `category` (`c_id`, `name`, `path`) VALUES
	(1, 'Foot Wear', 'Category/shoes.jpg'),
	(2, 'Hand Bag', 'Category/Coch Brand Hand Bags/fluffy3.jpg'),
	(3, 'Fancy', 'Category/jewellery2.jpg'),
	(4, 'Beauty', 'Category/makeup2.jpg');

-- Dumping structure for table cute&cozy.chat
CREATE TABLE IF NOT EXISTS `chat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `datetime` datetime NOT NULL,
  `status` int NOT NULL,
  `from` varchar(100) NOT NULL,
  `to` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_chat_user1_idx` (`from`),
  KEY `fk_chat_user2_idx` (`to`),
  CONSTRAINT `fk_chat_user1` FOREIGN KEY (`from`) REFERENCES `user` (`email`),
  CONSTRAINT `fk_chat_user2` FOREIGN KEY (`to`) REFERENCES `user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.chat: ~0 rows (approximately)

-- Dumping structure for table cute&cozy.city
CREATE TABLE IF NOT EXISTS `city` (
  `id` int NOT NULL AUTO_INCREMENT,
  `city_name` varchar(50) NOT NULL,
  `district_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_city_district1_idx` (`district_id`),
  CONSTRAINT `fk_city_district1` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.city: ~4 rows (approximately)
REPLACE INTO `city` (`id`, `city_name`, `district_id`) VALUES
	(1, 'Bandarawela', 1),
	(2, 'Welimada', 1),
	(3, 'Badulla', 1),
	(4, 'Koslanda', 1);

-- Dumping structure for table cute&cozy.district
CREATE TABLE IF NOT EXISTS `district` (
  `id` int NOT NULL AUTO_INCREMENT,
  `district_name` varchar(45) NOT NULL,
  `province_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_district_province1_idx` (`province_id`),
  CONSTRAINT `fk_district_province1` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.district: ~6 rows (approximately)
REPLACE INTO `district` (`id`, `district_name`, `province_id`) VALUES
	(1, 'Badulla', 1),
	(2, 'Monaragala', 1),
	(3, 'Colombo', 2),
	(4, 'Gampaha', 2),
	(5, 'Mathara', 3),
	(6, 'Galle', 3);

-- Dumping structure for table cute&cozy.feedback
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` int NOT NULL,
  `feedback` text NOT NULL,
  `date` datetime NOT NULL,
  `product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_feedback_product1_idx` (`product_id`),
  KEY `fk_feedback_user1_idx` (`user_email`),
  CONSTRAINT `fk_feedback_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_feedback_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.feedback: ~0 rows (approximately)

-- Dumping structure for table cute&cozy.gender
CREATE TABLE IF NOT EXISTS `gender` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gender_name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.gender: ~2 rows (approximately)
REPLACE INTO `gender` (`id`, `gender_name`) VALUES
	(1, 'Female'),
	(2, 'Male');

-- Dumping structure for table cute&cozy.hot_deal
CREATE TABLE IF NOT EXISTS `hot_deal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ending_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.hot_deal: ~1 rows (approximately)
REPLACE INTO `hot_deal` (`id`, `ending_date`) VALUES
	(1, '2024-04-08 00:00:00');

-- Dumping structure for table cute&cozy.image
CREATE TABLE IF NOT EXISTS `image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(150) NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_image_product1_idx` (`product_id`),
  CONSTRAINT `fk_image_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.image: ~3 rows (approximately)

-- Dumping structure for table cute&cozy.invoice
CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` varchar(45) NOT NULL,
  `date` date NOT NULL,
  `total` double NOT NULL,
  `d_status` int NOT NULL,
  `remove_status` int NOT NULL,
  `iqty` int NOT NULL,
  `product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_product1_idx` (`product_id`),
  KEY `fk_invoice_user1_idx` (`user_email`),
  CONSTRAINT `fk_invoice_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_invoice_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.invoice: ~2 rows (approximately)

-- Dumping structure for table cute&cozy.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `price` double NOT NULL,
  `qty` int NOT NULL,
  `description` text NOT NULL,
  `title` varchar(100) NOT NULL,
  `datetime_added` datetime NOT NULL,
  `delivery_fee_colombo` double NOT NULL,
  `delivery_fee_other` double NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `status_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_user1_idx` (`user_email`),
  KEY `fk_product_status1_idx` (`status_id`),
  KEY `fk_product_category1_idx` (`category_id`),
  CONSTRAINT `fk_product_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`c_id`),
  CONSTRAINT `fk_product_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`s_id`),
  CONSTRAINT `fk_product_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.product: ~3 rows (approximately)

-- Dumping structure for table cute&cozy.profile_image
CREATE TABLE IF NOT EXISTS `profile_image` (
  `path` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`path`),
  KEY `fk_profile_image_user1_idx` (`user_email`),
  CONSTRAINT `fk_profile_image_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.profile_image: ~2 rows (approximately)
REPLACE INTO `profile_image` (`path`, `user_email`) VALUES
	('resources/proimg/Sadee_660a62db7b988.png', 'sadeesha25@gmail.com'),
	('resources/proimg/Sadeesha_660a2d2a71523.png', 'sadeeshanilakshi25@gmail.com'),
	('resources/proimg/Tharindu_66769e72d1e04.jpeg', 'tharinduchanaka6@gmail.com');

-- Dumping structure for table cute&cozy.province
CREATE TABLE IF NOT EXISTS `province` (
  `id` int NOT NULL AUTO_INCREMENT,
  `province_name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.province: ~4 rows (approximately)
REPLACE INTO `province` (`id`, `province_name`) VALUES
	(1, 'Uva'),
	(2, 'Western'),
	(3, 'Southern'),
	(4, 'Central');

-- Dumping structure for table cute&cozy.recent
CREATE TABLE IF NOT EXISTS `recent` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `recent_status` int NOT NULL,
  `removed` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_recent_product1_idx` (`product_id`),
  KEY `fk_recent_user1_idx` (`user_email`),
  CONSTRAINT `fk_recent_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_recent_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.recent: ~0 rows (approximately)

-- Dumping structure for table cute&cozy.stars
CREATE TABLE IF NOT EXISTS `stars` (
  `id` int NOT NULL AUTO_INCREMENT,
  `stars` int NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stars_product1_idx` (`product_id`),
  CONSTRAINT `fk_stars_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.stars: ~0 rows (approximately)

-- Dumping structure for table cute&cozy.status
CREATE TABLE IF NOT EXISTS `status` (
  `s_id` int NOT NULL AUTO_INCREMENT,
  `s_name` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`s_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.status: ~2 rows (approximately)
REPLACE INTO `status` (`s_id`, `s_name`) VALUES
	(1, 'Active'),
	(2, 'Decative');

-- Dumping structure for table cute&cozy.user
CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(100) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `password` varchar(25) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `join_date` datetime NOT NULL,
  `verification_code` varchar(25) DEFAULT NULL,
  `status` int NOT NULL,
  `gender_id` int NOT NULL,
  PRIMARY KEY (`email`),
  KEY `fk_user_gender_idx` (`gender_id`),
  CONSTRAINT `fk_user_gender` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.user: ~0 rows (approximately)
REPLACE INTO `user` (`email`, `fname`, `lname`, `password`, `mobile`, `join_date`, `verification_code`, `status`, `gender_id`) VALUES
	('sadeesha25@gmail.com', 'Sadee', 'Nilakshi', '456789', '0774133924', '2024-04-01 12:58:29', NULL, 1, 1),
	('sadeeshanilakshi25@gmail.com', 'Sadeesha', 'Nilakshi', '020325', '0743528374', '2024-04-01 09:02:43', NULL, 1, 1),
	('tharinduchanaka6@gmail.com', 'Tharindu', 'Chanaka', 'tharinduCHA@8754', '0751441764', '2024-03-28 18:56:56', NULL, 1, 2);

-- Dumping structure for table cute&cozy.user_has_address
CREATE TABLE IF NOT EXISTS `user_has_address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `line1` text NOT NULL,
  `line2` text NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `city_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_has_address_user1_idx` (`user_email`),
  KEY `fk_user_has_address_city1_idx` (`city_id`),
  CONSTRAINT `fk_user_has_address_city1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  CONSTRAINT `fk_user_has_address_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.user_has_address: ~3 rows (approximately)
REPLACE INTO `user_has_address` (`id`, `line1`, `line2`, `postal_code`, `user_email`, `city_id`) VALUES
	(1, '291/1', 'Uduhulpotha', '90100', 'tharinduchanaka6@gmail.com', 1),
	(2, 'No.303/02,', 'Bogahamadiththa,Badulla', '90000', 'sadeeshanilakshi25@gmail.com', 3),
	(3, 'No.302/03,', 'Badulla Road,Haliela', '90000', 'sadeesha25@gmail.com', 3);

-- Dumping structure for table cute&cozy.wishlist
CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_wishlist_product1_idx` (`product_id`),
  KEY `fk_wishlist_user1_idx` (`user_email`),
  CONSTRAINT `fk_wishlist_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_wishlist_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table cute&cozy.wishlist: ~1 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
