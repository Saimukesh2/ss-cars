-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ss-cars
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ss_mst_car`
--

DROP TABLE IF EXISTS `ss_mst_car`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ss_mst_car` (
  `car_id` int NOT NULL AUTO_INCREMENT,
  `car_name` varchar(100) DEFAULT NULL,
  `model_id` int DEFAULT NULL,
  `year` year DEFAULT NULL,
  `color_available` varchar(500) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `features` varchar(255) DEFAULT NULL,
  `mieleage` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`car_id`)
) ENGINE=InnoDB AUTO_INCREMENT=395 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_mst_car`
--

LOCK TABLES `ss_mst_car` WRITE;
/*!40000 ALTER TABLE `ss_mst_car` DISABLE KEYS */;
INSERT INTO `ss_mst_car` VALUES (1,'Tata Sierra',1,1991,'Red,Blue,White',400000.00,'4WD, Power Windows, Sunroof','10-12','Active'),(2,'Tata Estate',2,1992,'White,Silver',450000.00,'Power Steering, AC, Foldable Rear Seats','10-12','Active'),(3,'Tata Sumo',3,1994,'White, Silver, Gold',650000.00,'Power Steering, Air Conditioning, ABS','14-16','Active'),(4,'Tata Indica',4,1998,'White, Silver, Red, Blue',450000.00,'Power Steering, AC, CD Player, Front Disc Brakes','17-18','Active'),(5,'Tata Safari',5,1998,'Black, White, Silver',1000000.00,'4WD, Power Windows, Alloy Wheels, ABS','10-13','Active'),(6,'Tata Spacio',6,2001,'White, Yellow, Silver',500000.00,'Power Steering, Air Conditioning, High Ground Clearance','13-15','Active'),(7,'Tata Indigo',7,2002,'Blue, Silver, White',600000.00,'Power Windows, Alloy Wheels, ABS, Dual Airbags','18-20','Active'),(8,'Tata Indigo Marina',8,2004,'Blue, Silver, White',700000.00,'Power Windows, AC, Alloy Wheels, Large Boot Space','14-17','Active'),(9,'Tata Xenon',9,2007,'White, Silver, Black',1050000.00,'4WD, ABS, Airbags, High Towing Capacity','13-15','Active'),(10,'Tata Vista',10,2008,'Red, White, Silver, Grey',500000.00,'ABS, Airbags, Power Steering, Bluetooth Connectivity','17-19','Active'),(11,'Tata Manza',11,2009,'Red, White, Silver, Blue',600000.00,'ABS, Airbags, Alloy Wheels, Harman Infotainment','17-19','Active'),(12,'Tata Indigo eCS',12,2010,'White, Blue, Silver',650000.00,'ABS, Airbags, Power Steering, Improved Mileage	','20-23','Active'),(13,'Tata Venture Super',13,2010,'White, Silver',850000.00,'High Roof, Spacious Interior, AC, Power Steering	','12-14','Active'),(14,'Tata Nano Europa',14,2010,'Blue, Silver, White',250000.00,'European Design, Enhanced Features','22-25','Active'),(15,'Tata Sumo Gold',15,2011,'White, Silver, Gold, Black',700000.00,'High Ground Clearance, ABS, Large Seating Capacity	','14-16','Active'),(16,'Tata Indica eV2',16,2011,'White, Blue, Silver,Red',600000.00,'ABS, Airbags, Power Steering, Improved Mileage	','20-23','Active'),(17,'Tata Nano CNG',17,2011,'Yellow, Blue, Silver',250000.00,'CNG Kit, Power Steering, Basic Features','30-35','Active'),(18,'Tata Safari Storme 4x4',18,2012,'White, Black, Grey',1400000.00,'4WD, Leather Seats, Touchscreen, ABS','10-12','Active'),(19,'Tata Zest',19,2014,'Blue, Brown, White, Silver',550000.00,'ABS, Airbags, Touchscreen Infotainment, DRLs','17-19','Active'),(20,'Tata Movus',20,2014,'White, Silver, Gold',700000.00,'High Ground Clearance, Power Steering, Air Conditioning','12-14','Active'),(21,'Tata Zest Diesel',21,2014,'White, Silver, Gold',550000.00,'ABS, Airbags, Touchscreen Infotainment, Rear Parking Camera','20-23','Active'),(22,'Tata Winger 6+1',22,2014,'White,Silver',1000000.00,'High Roof, Luxury Seating, AC, Large Capacity','12-14','Active'),(23,'Tata Nano Twist',23,2014,'Yellow, Blue, Silver, Red',250000.00,'Power Steering, AC, Bluetooth Connectivity','21-25','Active'),(24,'Tata Yodha Pickup',24,2015,'White, Silver',800000.00,'High Towing Capacity, ABS, Power Steering','13-15','Active'),(25,'Tata Nano GenX',25,2015,'Yellow, Red, Blue, Silver',300000.00,'Power Steering, AC, Bluetooth Connectivity	','21-25','Active'),(26,'Tata Bolt',26,2015,'Red, White, Silver, Grey',550000.00,'ABS, Airbags, Harman Infotainment, Power Windows','17-19','Active'),(27,'Tata Tiago',27,2016,'Orange, Blue, White, Grey',600000.00,'ABS, Airbags, Harman Infotainment, Multi-Drive Modes','19-23','Active'),(28,'Tata HexaXMA',28,2016,'White, Black, Silver, Grey',1300000.00,'4WD, ABS, Airbags, Touchscreen Infotainment','12-15','Active'),(29,'Tata Winger 15+1',29,2016,'White, Silver',1100000.00,'High Roof, Large Capacity, AC, Power Steering','11-13','Active'),(30,'Tata Tiago XZ',30,2016,'Blue, White, Grey',700000.00,'ABS, Airbags, Touchscreen Infotainment, DRLs','19-21','Active'),(31,'Tata Nexon XZ+',31,2017,'Blue, White, Grey',1000000.00,'Sunroof, ABS, Airbags, Connected Car Technology	','17-21','Active'),(32,'Tata Yodha',32,2017,'White, Silver',700000.00,'High Towing Capacity, ABS, Air Conditioning','13-15','Active'),(33,'Tata Hexa',33,2017,'Blue,White,Grey,Black',1300000.00,'4WD, 6 Airbags, Sunroof, Touchscreen Infotainment','12-15','Active'),(34,'Tata Nexon',34,2017,'Blue, Red, White, Silver',800000.00,'ABS, Dual Airbags, Sunroof, Connected Car Tech, Cruise Control','17-21','Active'),(35,'Tata Tigor',35,2017,'Blue, Grey, White, Silver',750000.00,'ABS, Airbags, Touchscreen Infotainment, Rear Parking Camera','20-22','Active'),(36,'Tata TigorJTP',36,2018,'Red, White, Grey, Blue',900000.00,'Turbocharged Engine, Sports Suspension, Touchscreen','18-22','Active'),(37,'Tata Hexa Adventure',37,2018,'White, Silver, Black, Grey',1400000.00,'4WD, ABS, 6 Airbags, Touchscreen Infotainment	','12-15','Active'),(38,'Tata Tigor NRG',38,2018,'Green, White, Silver',650000.00,'ABS, Airbags, Roof Rails, Rugged Styling','19-21','Active'),(39,'Tata Harrier',39,2019,'Black,Whte,Grey',1500000.00,'ABS, Airbags, Sunroof, Adaptive Cruise Control','14-18','Active'),(40,'Tata Tigor EV',40,2019,'Blue, White, Grey',1200000.00,'Electric Powertrain, ABS, Airbags, Regenerative Braking','213-306 km range','Active'),(41,'Tata 45X (Altroz)',41,2019,'Gold, Red, Blue',750000.00,'ABS, Airbags, 7-inch Infotainment, Ambient Lighting','18-21','Active'),(42,'Tata Harrier XZ+',42,2020,'Black,White,Grey',1600000.00,'Panoramic Sunroof, 6 Airbags, Touchscreen Infotainment','16-21','Active'),(43,'Tata Altroz XT',43,2020,'Gold, Red, White, Grey',700000.00,'ABS, Airbags, 7-inch Infotainment, Ambient Lighting','18-21','Active'),(44,'Tata Harrier Dark',44,2020,'Black,Grey',1550000.00,'ABS, 6 Airbags, Panoramic Sunroof, Dark Themed Interiors','14-17','Active'),(45,'Tata Nexon EV',45,2020,'Blue,White,Grey',1450000.00,'Electric Powertrain, ABS, Airbags, Connected Car Tech','312-453 km range','Active'),(46,'Tata Altroz',46,2020,'Gold, Red, White, Blue',650000.00,'ABS, Airbags, 7-inch Infotainment, Ambient Lighting','18-21','Active'),(47,'Tata Safari',47,2021,'Blue,Black,White,Grey',1800000.00,'ABS, 6 Airbags, Panoramic Sunroof, Terrain Response Modes','12-15','Active'),(48,'Tata Punch',48,2021,'Blue, White, Orange, Grey',900000.00,'ABS, Dual Airbags, 7-inch Infotainment, Traction Pro Mode','18-20','Active'),(49,'Tata Altroz Dark',49,2021,'Black',750000.00,'ABS, Airbags, Dark Themed Interiors, Touchscreen','18-21','Active'),(50,'Tata Nexon EV Prime',50,2022,'White, Blue, Grey',1400000.00,'Electric Powertrain, ABS, Airbags, Connected Car Tech','312 km range','Active'),(51,'Tata Yodha 2.0',51,2022,'White,Black,Blue',800000.00,'High Towing Capacity, Robust Design, Power Steering','13-15','Active'),(52,'Tata Tiago EV',52,2022,'White,Grey,Blue',850000.00,'Electric Powertrain, ABS, Airbags, Connected Car Tech','315 km range','Active'),(53,'Tata Tigor CNG',53,2022,'Blue,White,Grey',700000.00,'Dual Airbags, ABS, Factory-fitted CNG Kit, Touchscreen','26-28 (CNG Mode)','Active'),(54,'Tata Nexon EV Max',54,2023,'White, Blue, Grey',1700000.00,'Electric Powertrain, Advanced Safety Features, Long Range','463 km range','Active'),(55,'Tata Altroz CNG',55,2023,' Blue,  Red, Grey, White',1055000.00,'Factory-fitted CNG kit,ABS, dual airbags','25-28 (CNG Mode)','Active'),(56,'Tata Harrier and Safari Red Dark Edition',56,2023,'Oberon Black with red accents',2100000.00,'Advanced driver-assistance systems (ADAS),ventilated seats, wireless charger','14-16','Active'),(57,'Tata Tiago EV Blitz',57,2023,'Teal Blue, Daytona Grey, Pristine White',850000.00,'connected car tech, ABS, dual airbags, regenerative braking.','250-315 km range','Active'),(58,'Tata Punch CNG',58,2023,'Orange,  Blue,  Red, Tropical Mist',950000.00,'Dual-cylinder CNG tanks, ABS, dual airbags,touchscreen','26-28','Active');
/*!40000 ALTER TABLE `ss_mst_car` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_mst_category`
--

DROP TABLE IF EXISTS `ss_mst_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ss_mst_category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) DEFAULT NULL,
  `category_desc` text,
  `category_status` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_mst_category`
--

LOCK TABLES `ss_mst_category` WRITE;
/*!40000 ALTER TABLE `ss_mst_category` DISABLE KEYS */;
INSERT INTO `ss_mst_category` VALUES (1,'SUV','SUVs are larger, versatile vehicles that combine features of both on-road and off-road vehicles. Known for their high ground clearance, powerful engines, and spacious interiors, SUVs can handle various terrains and often come with options for all-wheel or four-wheel drive. They are popular among families and adventure enthusiasts who appreciate a commanding road presence and the ability to handle challenging driving conditions.','Active'),(2,'Station Wagon','Station wagons are car-like vehicles with an extended rear cargo area that provides a lot of luggage space, similar to SUVs but with a lower profile. They offer a blend of the comfort of a sedan with added storage capacity, making them suitable for families. Unlike SUVs, they usually have a lower ground clearance and are designed primarily for on-road use.','Active'),(3,'MUV','MUVs, also called Multi-Purpose Vehicles, are practical, spacious vehicles designed to carry more passengers and luggage. They usually offer flexibility in seating and cargo arrangements and are preferred by larger families or groups who need a comfortable and functional ride. MUVs focus on utility and may not be as rugged as SUVs.','Active'),(4,'Hatchback','Hatchbacks are compact, urban-friendly cars with a two-box design, featuring a rear door that swings upward to access the cargo area. They are often more affordable, fuel-efficient, and easier to park, making them ideal for city driving. Hatchbacks have foldable rear seats to allow flexible cargo space, but they usually have a limited capacity compared to larger vehicles.','Active'),(7,'Sedan','Sedans are mid-size to large passenger cars with a three-box design (engine, passenger, and cargo sections). Known for their comfortable ride and spacious interiors, sedans are popular among families and executives. They are designed primarily for on-road driving, providing a smooth, stable ride with balanced handling.','Active'),(8,'Pickup Truck','Pickup trucks are versatile vehicles with a cab for passengers and an open cargo area with a bed in the back. They are popular for their towing and hauling capabilities and are often used for commercial purposes, especially in construction and agriculture. Pickup trucks may come in various sizes and offer either two-wheel or four-wheel drive.','Active'),(9,'MPV','Similar to MUVs, MPVs are designed to maximize interior space and functionality. They can typically seat seven or more passengers and often have features that cater to family-oriented needs, such as sliding doors, configurable seats, and enhanced storage. MPVs are intended for comfortable, spacious on-road travel rather than off-road capability','Active'),(10,'City Car','City cars are ultra-compact vehicles optimized for urban environments. They are highly fuel-efficient, easy to park, and maneuverable in crowded areas. These cars are typically small, with limited seating and storage space, making them ideal for short city commutes rather than long highway trips.','Active');
/*!40000 ALTER TABLE `ss_mst_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_mst_models`
--

DROP TABLE IF EXISTS `ss_mst_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ss_mst_models` (
  `model_id` int NOT NULL AUTO_INCREMENT,
  `model_name` varchar(100) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `model_status` varchar(20) DEFAULT NULL,
  `model_desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_mst_models`
--

LOCK TABLES `ss_mst_models` WRITE;
/*!40000 ALTER TABLE `ss_mst_models` DISABLE KEYS */;
INSERT INTO `ss_mst_models` VALUES (1,'Sierra',1,'Active',''),(2,'Estate',2,'Active',''),(3,'Sumo',3,'Active',''),(4,'Indica',4,'Active',''),(5,'Safari',1,'Active',''),(6,'Spacio',3,'Active',NULL),(7,'Indigo',7,'Active',NULL),(8,'Indigo Marina',2,'Active',NULL),(9,'Xenon',8,'Active',NULL),(10,'Vista',4,'Active',NULL),(11,'Manza',7,'Active',NULL),(12,'Indigo eCS',7,'Active',NULL),(13,'Venture Super',9,'Active',NULL),(14,'Nano Europa',10,'Active',NULL),(15,'Sumo Gold',1,'Active',NULL),(16,'Indica eV2',4,'Active',NULL),(17,'Nano CNG',10,'Active',NULL),(18,'Safari Storme 4x4',1,'Active',NULL),(19,'Zest',7,'Active',NULL),(20,'Movus',9,'Active',NULL),(21,'Zest Diesel',7,'Active',NULL),(22,'Winger 6+1',9,'Active',NULL),(23,'Nano Twist',10,'Active',NULL),(24,'Yodha Pickup',8,'Active',NULL),(25,'Nano GenX',10,'Active',NULL),(26,'Bolt',4,'Active',NULL),(27,'Tiago',4,'Active',NULL),(28,'Hexa XMA',1,'Active',NULL),(29,'Winger 15+1',9,'Active',NULL),(30,'Tiago XZ',4,'Active',NULL),(31,'Nexon XZ+',1,'Active',NULL),(32,'Yodha',8,'Active',NULL),(33,'Hexa',1,'Active',NULL),(34,'Nexon',1,'Active',NULL),(35,'Tigor',7,'Active',NULL),(36,'Tigor JTP',7,'Active',NULL),(37,'Hexa Adventure',1,'Active',NULL),(38,'Tiago NRG',4,'Active',NULL),(39,' Harrier',1,'Active',NULL),(40,'Tigor EV',7,'Active',NULL),(41,'45X (Altroz)',4,'Active',NULL),(42,'Harrier XZ+',1,'Active',NULL),(43,'Altroz XT',4,'Active',NULL),(44,'Harrier Dark',4,'Active',NULL),(45,' Nexon EV',1,'Active',NULL),(46,'Altroz	',4,'Active',NULL),(47,'Safari',1,'Active',NULL),(48,'Punch',1,'Active',NULL),(49,'Altroz Dark',4,'Active',NULL),(50,'Nexon EV Prime',1,'Active',NULL),(51,'Yodha 2.0',8,'Active',NULL),(52,'Tiago EV',4,'Active',NULL),(53,'Tigor CNG',7,'Active',NULL),(54,'Nexon EV Max',1,'Active',NULL),(55,'Altroz CNG',4,'Active',NULL),(56,'Harrier and Safari Red Dark Edition',1,'Active',NULL),(57,'Tiago EV Blitz',4,'Active',NULL),(58,'Punch CNG',1,'Active',NULL),(82,NULL,NULL,'',NULL);
/*!40000 ALTER TABLE `ss_mst_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_rpt_revenue`
--

DROP TABLE IF EXISTS `ss_rpt_revenue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ss_rpt_revenue` (
  `revenue_id` int NOT NULL AUTO_INCREMENT,
  `sale_id` int DEFAULT NULL,
  `quantity_sold` varchar(50) DEFAULT NULL,
  `total_sale` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `net_sale` decimal(10,2) DEFAULT NULL,
  `tax_amount` decimal(10,2) DEFAULT NULL,
  `total_amount_with_tax` decimal(10,2) DEFAULT NULL,
  `profit` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`revenue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_rpt_revenue`
--

LOCK TABLES `ss_rpt_revenue` WRITE;
/*!40000 ALTER TABLE `ss_rpt_revenue` DISABLE KEYS */;
INSERT INTO `ss_rpt_revenue` VALUES (1,1,'1',700000.00,5000.00,695000.00,1000.00,696000.00,100000.00),(2,2,'1',1100000.00,5500.00,1094500.00,1556.00,1096056.00,250000.00),(3,13,'1',250000.00,1000.00,249000.00,1500.00,250500.00,50000.00);
/*!40000 ALTER TABLE `ss_rpt_revenue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_rpt_sales`
--

DROP TABLE IF EXISTS `ss_rpt_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ss_rpt_sales` (
  `sale_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `car_id` int DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `employee_id` int DEFAULT NULL,
  PRIMARY KEY (`sale_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_rpt_sales`
--

LOCK TABLES `ss_rpt_sales` WRITE;
/*!40000 ALTER TABLE `ss_rpt_sales` DISABLE KEYS */;
INSERT INTO `ss_rpt_sales` VALUES (1,1,20,'2023-08-14','Full Cash',1),(2,2,29,'2024-09-06','Cheque',2),(3,7,1,'2024-09-28','test',2),(10,4,1,'2024-10-09','test',2),(11,3,44,'2024-09-28','test',1),(12,3,7,'2024-09-21','test',4),(13,1,14,'2024-09-07','test',1),(14,4,58,'2024-11-08','testing the car foe',2),(15,7,27,'2024-10-02','testibfkgf',3),(16,1,20,'2024-10-09','testing the car foe',1);
/*!40000 ALTER TABLE `ss_rpt_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_rpt_service`
--

DROP TABLE IF EXISTS `ss_rpt_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ss_rpt_service` (
  `service_id` int NOT NULL AUTO_INCREMENT,
  `service_date` date DEFAULT NULL,
  `service_type` varchar(100) DEFAULT NULL,
  `service_cost` decimal(10,2) DEFAULT NULL,
  `feedback` varchar(255) DEFAULT NULL,
  `car_id` int DEFAULT NULL,
  `employee_id` int DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_rpt_service`
--

LOCK TABLES `ss_rpt_service` WRITE;
/*!40000 ALTER TABLE `ss_rpt_service` DISABLE KEYS */;
INSERT INTO `ss_rpt_service` VALUES (1,'2023-09-20','Regular',4500.00,'They put great effort fro servicing my car',1,1,1),(2,'2024-09-07','Regular Service',15000.00,'Testing the car for the drive',37,3,3),(5,'2024-10-12','test',64554.00,'test',17,3,5),(6,'2024-09-06','General',21999.00,'test',24,4,3),(7,'2024-11-08','Accident',20000.00,'testing',2,1,1);
/*!40000 ALTER TABLE `ss_rpt_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_trn_customer`
--

DROP TABLE IF EXISTS `ss_trn_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ss_trn_customer` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mail_id` varchar(50) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_trn_customer`
--

LOCK TABLES `ss_trn_customer` WRITE;
/*!40000 ALTER TABLE `ss_trn_customer` DISABLE KEYS */;
INSERT INTO `ss_trn_customer` VALUES (1,'Shiva','pulaiyar Kovil Street','8526473218','def@example.com',45,'Male','1985-06-12','Chennai','Tamil Nadu'),(2,'dfsdadsf','amdhasvmc','74856445','efgwdf@com',25,'Male','2024-08-28','ashasbhk','aksdbas'),(3,'abcdef','dabdcjd','741852','example@com',34,'Male','2024-08-28','adbadjs','adbca'),(4,'tsts','testinfg','123456678','test@com',38,'Male','2024-09-06','adbdct','tesgy'),(5,'test','testing','123456789','testing@com',37,'Male','2024-08-28','tessting','test'),(7,'qwerty','yuiopl','789456','defg@example.com',32,'Male','2024-08-28','zxcv','qscv'),(8,'cvbnm','address','77777777777','mail@editcustomer.com',25,'Female','2024-01-01','Chennai','Tamil Nadu');
/*!40000 ALTER TABLE `ss_trn_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_trn_employee`
--

DROP TABLE IF EXISTS `ss_trn_employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ss_trn_employee` (
  `employee_id` int NOT NULL AUTO_INCREMENT,
  `employee_name` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mail_id` varchar(100) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_trn_employee`
--

LOCK TABLES `ss_trn_employee` WRITE;
/*!40000 ALTER TABLE `ss_trn_employee` DISABLE KEYS */;
INSERT INTO `ss_trn_employee` VALUES (1,'joseph','Vivekanadhar street,Dubai main road, dubai kurukku sandhu, dubai','764531845','abc@example.com','sales','2021-08-06','Male',37,'1990-10-12','joseph','1234567890'),(2,'bdz','qwrqfq','bbzbbbb','efgwdf@example.com','zbfzbb','2024-09-06','Female',45,'2024-08-29','fds','qwertyu'),(3,'emplo','adress','74856445','defg@example.com','qsswe','2024-09-07','Male',55,'2024-09-06','qwddsfdf','dsvfvcvccx'),(4,'adddd','test','784664','bbzbbb@mail.com','djndc','2024-08-31','Male',454,'2024-09-06','fakndf','sdkfdsa');
/*!40000 ALTER TABLE `ss_trn_employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ss_trn_enquiry`
--

DROP TABLE IF EXISTS `ss_trn_enquiry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ss_trn_enquiry` (
  `enquiry_id` int NOT NULL AUTO_INCREMENT,
  `car_id` int DEFAULT NULL,
  `enquirer_name` varchar(20) DEFAULT NULL,
  `testdrive_willing` varchar(45) DEFAULT NULL,
  `testdrive_date` varchar(20) DEFAULT NULL,
  `feedback` varchar(250) DEFAULT NULL,
  `employee_id` int DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`enquiry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ss_trn_enquiry`
--

LOCK TABLES `ss_trn_enquiry` WRITE;
/*!40000 ALTER TABLE `ss_trn_enquiry` DISABLE KEYS */;
INSERT INTO `ss_trn_enquiry` VALUES (1,56,'Shiva','Yes','2024-08-15','Such a responsive company and  having a beautifull cars',1,'9941316584'),(2,44,'Ajay','Yes','2024-09-06','He wants to ride the drive in his near by home location which it may convinient to him',2,'0091446461642260'),(9,25,'Murugan','Yes','2024-06-09','He needs a small testdrive in showroom and he didnt confirm about testdrive',1,'78542393'),(10,11,'custp','Yes','2024-10-12','testing the car for the drive',3,'894566271'),(11,8,'dkfgsfshf','Yes','2024-10-11','test',4,'78956455155'),(12,15,'customer','Yes','2024-10-05','test',4,'72252022415'),(13,8,'testing','Yes','2024-10-10','testinghsdglih',1,'9224586338'),(14,1,'akdffgdf','Yes','2024-09-28','testing the car',1,'9562614569'),(15,1,'Aarav','Yes','2024-08-09','',3,'7894564124'),(16,14,'test','No','','',2,'741289'),(17,14,'test','No','','',2,'741289'),(18,14,'test','No',NULL,'',2,'741289');
/*!40000 ALTER TABLE `ss_trn_enquiry` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-05 11:30:03
