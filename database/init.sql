-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: isxengines_db
-- ------------------------------------------------------
-- Server version	8.0.46-0ubuntu0.22.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','editor') COLLATE utf8mb4_unicode_ci DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'admin','admin@isxengines.com','$2y$10$pQwEQpHBD4Im.XYywPKkyeS6tGXEhaLuyck20/f5SMSBdffViw/32','Admin','admin','2026-07-09 16:30:56','2026-07-09 17:13:19');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(320) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `featured_image` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'ISX Engines Team',
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT '0',
  `views` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES (1,'ISX CM870 vs CM871: What Changed and Why It Matters','isx-cm870-vs-cm871-differences','ISX CM870 vs CM871: Key Differences Explained | ISX Engines','Complete comparison of the Cummins ISX CM870 and CM871 engines. Learn the key differences in emissions systems, fuel injection, turbocharger design, and which engine is better for your application.','<h2>Understanding the ISX CM870 vs CM871: A Complete Comparison</h2><p>The Cummins ISX CM870 and CM871 represent two critical generations of the ISX engine platform, separated by the 2007 EPA emissions mandate that fundamentally changed diesel engine design. If you\'re shopping for a remanufactured ISX engine, understanding these differences is essential to making the right choice for your truck or equipment.</p><h3>The Emissions Divide: Pre-DPF vs DPF Era</h3><p>The single biggest difference between the CM870 and CM871 is the emissions technology. The CM870 (2003-2006) uses only EGR (Exhaust Gas Recirculation) to meet EPA 2004 standards. The CM871 (2007-2009) adds a DPF (Diesel Particulate Filter) to meet the stricter EPA 2007 requirements.</p><p>This means the CM871 has additional components: a DPF housing, DOC (Diesel Oxidation Catalyst), and the associated sensors and regeneration system. Many owner-operators prefer the CM870 for its simplicity, while fleets often prefer the CM871 for its cleaner emissions profile.</p><h3>Fuel System Differences</h3><p>Both engines use the Cummins HPI (Hydraulic Pressure Intensified) fuel system, but the CM871 received updates to improve injection timing precision for better combustion and lower particulate output. The CM871 injectors operate at slightly higher pressures and have modified spray patterns.</p><h3>Turbocharger Technology</h3><p>The CM870 uses a fixed-geometry turbocharger, while the CM871 introduced the Holset VGT (Variable Geometry Turbocharger). The VGT provides better response across the RPM range and is critical for the exhaust temperatures needed for DPF regeneration. However, VGT actuator failures are one of the most common CM871 issues.</p><h3>ECM and Electronics</h3><p>The CM870 runs on an earlier ECM calibration with fewer sensors and simpler diagnostics. The CM871\'s ECM manages additional systems including DPF soot loading calculations, regeneration cycles, and VGT position control. This means more potential fault codes but also more precise engine management.</p><h3>Common Problems by Generation</h3><p><strong>CM870 Common Issues:</strong></p><ul><li>EGR cooler failures and coolant leaks</li><li>Camshaft lobe wear (especially early production)</li><li>Injector cup cracking</li><li>Oil consumption from worn valve guides</li></ul><p><strong>CM871 Common Issues:</strong></p><ul><li>VGT turbo actuator failures</li><li>DPF clogging and failed regenerations</li><li>EGR valve sticking</li><li>Aftertreatment temperature sensor failures</li></ul><h3>Which One Should You Choose?</h3><p>For owner-operators who want simplicity and lower maintenance costs, the CM870 is often the preferred choice. It has fewer emissions components to fail and is generally less expensive to maintain. For fleets operating in states with strict emissions inspections, or for applications requiring EPA 2007 compliance, the CM871 is the necessary choice.</p><p>At US Engine Production, we remanufacture both the CM870 and CM871 to OEM specifications. Every engine is dyno-tested and backed by our 1-year unlimited mileage warranty. Call us at 1-631-991-7700 for a quote on either engine.</p>','Complete comparison of the Cummins ISX CM870 and CM871 engines covering emissions systems, fuel injection, turbocharger differences, common problems, and which engine is the better choice.','/assets/images/isx-cm870.png','ISX Engines Technical Team','Engine Comparison','ISX,CM870,CM871,EGR,DPF,comparison,Cummins',1,0,'2026-07-01 10:00:00','2026-07-09 10:00:00');
INSERT INTO `blog_posts` VALUES (2,'Top 5 Cummins ISX15 CM2350 Problems and How to Fix Them','top-5-isx15-cm2350-problems','Top 5 Cummins ISX15 CM2350 Problems & Solutions | ISX Engines','Discover the most common Cummins ISX15 CM2350 engine problems including aftertreatment issues, EGR failures, fuel system problems, and turbo failures. Expert solutions from US Engine Production.','<h2>The 5 Most Common Cummins ISX15 CM2350 Problems</h2><p>The Cummins ISX15 CM2350 (2013-2020) is one of the most popular heavy-duty diesel engines on the road today. While it\'s a reliable platform overall, certain issues appear repeatedly across high-mileage units. As remanufacturing specialists who rebuild dozens of CM2350 engines every month, we\'ve identified the top 5 problems and their solutions.</p><h3>1. Aftertreatment System Failures (SCR/DEF)</h3><p>The CM2350\'s SCR (Selective Catalytic Reduction) system is the most common source of downtime. Symptoms include constant DPF regeneration, DEF quality fault codes (SPN 3364), and reduced power derates.</p><p><strong>Root Causes:</strong></p><ul><li>DEF dosing valve crystallization from poor-quality DEF fluid</li><li>NOx sensor failures giving false readings</li><li>SCR catalyst degradation after 400,000+ miles</li><li>DEF pump failures from contaminated fluid</li></ul><p><strong>Solutions:</strong> Always use API-certified DEF fluid. Replace NOx sensors at 300,000-mile intervals. If the SCR catalyst efficiency drops below 90%, replacement is required. A DEF system flush can resolve crystallization issues.</p><h3>2. EGR Cooler and Valve Failures</h3><p>Despite being a later-generation engine, the CM2350 still suffers from EGR-related issues. The EGR cooler can develop internal leaks that push coolant into the intake manifold, while the EGR valve accumulates carbon deposits that prevent proper sealing.</p><p><strong>Symptoms:</strong></p><ul><li>Coolant loss with no visible external leak</li><li>White smoke at startup</li><li>Rough idle and misfires</li><li>EGR valve position fault codes</li></ul><p><strong>Solutions:</strong> Inspect the EGR cooler for leaks during every major service. Replace the EGR valve if carbon buildup exceeds 2mm. Consider upgrading to the revised EGR cooler design (Cummins TSB ISX15-033) which has improved tube-to-header joints.</p><h3>3. High-Pressure Fuel Pump (XPI) Failures</h3><p>The CM2350 uses the Cummins XPI (Xtra High Pressure Injection) common rail fuel system operating at up to 36,000 PSI. The high-pressure fuel pump is the heart of this system, and failures can be catastrophic.</p><p><strong>Symptoms:</strong></p><ul><li>Hard starting or no-start conditions</li><li>Low rail pressure fault codes (SPN 157)</li><li>Metal debris in fuel filters</li><li>Sudden power loss at highway speeds</li></ul><p><strong>Solutions:</strong> Change fuel filters every 15,000 miles (not 25,000 as some recommend). Use only ultra-low sulfur diesel from reputable stations. Install a fuel pressure gauge to monitor rail pressure trends. If metal is found in filters, the entire fuel system (pump, injectors, rails) must be inspected.</p><h3>4. Turbocharger Actuator and Bearing Failures</h3><p>The Holset HE400VG variable geometry turbocharger on the CM2350 is a precision component that operates in extreme conditions. The electronic actuator and turbo bearings are the most common failure points.</p><p><strong>Symptoms:</strong></p><ul><li>Turbo boost codes (SPN 102)</li><li>Black smoke under load</li><li>Whining or grinding noise from turbo</li><li>Oil in the charge air cooler</li></ul><p><strong>Solutions:</strong> Replace the turbo actuator if response time exceeds specifications. Check for shaft play (axial and radial) during every PM service. Ensure the oil supply line is not restricted. Consider a remanufactured turbo with updated bearings if the original has over 500,000 miles.</p><h3>5. Crankcase Ventilation System Issues</h3><p>The CM2350\'s crankcase ventilation (CCV) system routes blow-by gases back into the intake. Over time, the CCV filter and separator become clogged, causing excessive crankcase pressure.</p><p><strong>Symptoms:</strong></p><ul><li>Oil leaks from every gasket and seal</li><li>Oil pushed out of the dipstick tube</li><li>Excessive oil consumption</li><li>CCV system fault codes</li></ul><p><strong>Solutions:</strong> Replace the CCV filter element every 100,000 miles. Clean the separator housing during filter replacement. If crankcase pressure exceeds 3 inches of water column, investigate for excessive ring blow-by which may indicate the need for an overhaul.</p><h3>When Is It Time for a Remanufactured Engine?</h3><p>If your CM2350 is experiencing multiple issues simultaneously, or if the engine has over 800,000 miles with declining oil pressure and increasing blow-by, a remanufactured engine may be more cost-effective than continued repairs. At US Engine Production, our remanufactured ISX15 CM2350 engines include new pistons, rings, bearings, gaskets, and all wear components. Every engine is dyno-tested for 4 hours before shipping.</p><p>Call 1-631-991-7700 or email sales@usepny.com for a quote on a remanufactured CM2350.</p>','The 5 most common Cummins ISX15 CM2350 engine problems: aftertreatment failures, EGR issues, XPI fuel pump failures, turbo problems, and crankcase ventilation. Expert solutions included.','/assets/images/isx15-cm2350.png','ISX Engines Technical Team','Troubleshooting','ISX15,CM2350,problems,troubleshooting,aftertreatment,EGR,fuel pump,turbo',1,0,'2026-07-05 14:00:00','2026-07-09 14:00:00');
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `engine_categories`
--

DROP TABLE IF EXISTS `engine_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `engine_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engine_categories`
--

LOCK TABLES `engine_categories` WRITE;
/*!40000 ALTER TABLE `engine_categories` DISABLE KEYS */;
INSERT INTO `engine_categories` VALUES (1,'Pre-Emissions ISX','pre-emissions-isx','The original Cummins ISX Signature series engines (1998-2002) before emissions regulations',1,1,'2026-07-09 16:30:56'),(2,'EGR Era ISX','egr-era-isx','Cummins ISX engines with Exhaust Gas Recirculation technology (2003-2006)',2,1,'2026-07-09 16:30:56'),(3,'DPF Era ISX','dpf-era-isx','Cummins ISX engines with Diesel Particulate Filter systems (2007-2009)',3,1,'2026-07-09 16:30:56'),(4,'ISX15 Common Rail','isx15-common-rail','The modern ISX15 with common-rail fuel injection and SCR (2010-2020)',4,1,'2026-07-09 16:30:56'),(5,'X15 Series','x15-series','The next-generation Cummins X15 engines (2017-Present)',5,1,'2026-07-09 16:30:56'),(6,'ISX12 / X12','isx12-x12','The medium-duty 12-liter ISX and X12 engine family',6,1,'2026-07-09 16:30:56'),(7,'Natural Gas & Alternative','natural-gas-alternative','ISX12N, X15N, and other alternative fuel variants',7,1,'2026-07-09 16:30:56'),(8,'Off-Highway QSX','off-highway-qsx','The QSX15 for industrial, marine, and off-highway applications',8,1,'2026-07-09 16:30:56');
/*!40000 ALTER TABLE `engine_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `engines`
--

DROP TABLE IF EXISTS `engines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `engines` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(320) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `h1_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `featured_image` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `years_produced` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `displacement` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `horsepower` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `torque` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ecm_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuel_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Diesel',
  `bore_stroke` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `configuration` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Inline 6-Cylinder',
  `emission_standard` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key_features` text COLLATE utf8mb4_unicode_ci,
  `common_problems` text COLLATE utf8mb4_unicode_ci,
  `schema_json` text COLLATE utf8mb4_unicode_ci,
  `is_published` tinyint(1) DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `engines_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `engine_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engines`
--

LOCK TABLES `engines` WRITE;
/*!40000 ALTER TABLE `engines` DISABLE KEYS */;
INSERT INTO `engines` VALUES (1,1,'Cummins ISX CM570','cummins-isx-cm570','Cummins ISX CM570 Engine Guide - Specs, Problems & Solutions','Complete guide to the Cummins ISX CM570 (1998-2002). Technical specifications, common problems, and expert troubleshooting for the original ISX Signature engine.','Cummins ISX CM570 Engine: The Complete Technical Guide','<h2>Overview of the Cummins ISX CM570</h2><p>The Cummins ISX CM570 was the original ISX engine, introduced in 1998 as a replacement for the legendary N14. Known internally as the Signature series, the CM570 represented a revolutionary leap in diesel engine technology with its dual overhead camshaft (DOHC) architecture and Hydraulic Pressure Intensifier (HPI) fuel injection system.</p><h2>Engine Architecture</h2><p>The CM570 features a 14.9-liter (912 cubic inch) displacement with an inline 6-cylinder configuration. Its most distinctive feature is the DOHC design with four valves per cylinder. The HPI fuel injection system uses engine oil pressurized to approximately 28,000 PSI to actuate the fuel injectors.</p><h2>Why the CM570 Matters Today</h2><p>Despite being over 25 years old, the CM570 remains popular because it predates all emissions equipment (no EGR, no DPF, no DEF). Many owner-operators specifically seek these engines for their simplicity and reliability.</p>','The original 1998-2002 Cummins ISX Signature engine with DOHC architecture and HPI fuel injection.','/assets/images/isx-cm570.png','1998-2002','14.9L (912 ci)','400-600 HP','1,350-1,850 lb-ft','CM570','Diesel','137mm x 169mm','Inline 6-Cylinder DOHC','Pre-EPA (No emissions)','Dual Overhead Camshaft (DOHC) 4-valve design\nHPI fuel injection\nNo emissions equipment\nAnti-backlash gear train\nIntegrated engine brake','Camshaft lobe and roller follower wear\nHPI injector o-ring failures\nOverhead adjustment every 300K miles\nOil consumption from worn valve guides\nFront gear train noise',NULL,1,1,'2026-07-09 16:40:25','2026-07-09 16:40:25'),(2,2,'Cummins ISX CM870','cummins-isx-cm870','Cummins ISX CM870 Engine Guide - EGR Era Specs & Problems','Complete guide to the Cummins ISX CM870 (2003-2006). First ISX with EGR and VGT turbocharger. Common problems and solutions.','Cummins ISX CM870: The EGR Era Engine Guide','<h2>Overview of the Cummins ISX CM870</h2><p>The Cummins ISX CM870, produced from 2003 to 2006, was the first ISX engine to incorporate Exhaust Gas Recirculation (EGR) technology to meet EPA 2002 emissions standards. This engine retained the DOHC architecture and HPI fuel injection from the CM570 but added a cooled EGR system and Variable Geometry Turbocharger (VGT).</p><h2>EGR System</h2><p>The CM870 introduced a cooled EGR system that recirculates exhaust gas back into the intake manifold to reduce NOx emissions. The EGR cooler uses engine coolant to cool the exhaust gas before re-entering combustion.</p><h2>Variable Geometry Turbocharger</h2><p>The Holset HE561VE VGT uses movable vanes in the turbine housing to optimize boost pressure across the entire RPM range, improving both low-end torque and high-RPM power delivery.</p>','The 2003-2006 Cummins ISX with first-generation EGR and VGT turbocharger.','/assets/images/isx-cm870.png','2003-2006','14.9L (912 ci)','400-600 HP','1,350-1,850 lb-ft','CM870','Diesel','137mm x 169mm','Inline 6-Cylinder DOHC','EPA 2002 (Cooled EGR)','First ISX with cooled EGR system\nHolset HE561VE VGT\nRetained DOHC from CM570\nHPI fuel injection\nImproved electronic controls','EGR cooler cracking and coolant contamination\nVGT actuator failures\nCamshaft lobe wear\nEGR valve carbon buildup\nCoolant loss through EGR system',NULL,1,2,'2026-07-09 16:41:53','2026-07-09 16:41:53'),(3,3,'Cummins ISX CM871','cummins-isx-cm871','Cummins ISX CM871 Engine Guide - DPF Era Specs & Regen Issues','Complete guide to the Cummins ISX CM871 (2007-2009). First ISX with DPF/DOC aftertreatment. Regeneration problems and solutions.','Cummins ISX CM871: The DPF Era Engine Guide','<h2>Overview of the Cummins ISX CM871</h2><p>The Cummins ISX CM871, produced from 2007 to 2009, was the first ISX to incorporate a Diesel Particulate Filter (DPF) and Diesel Oxidation Catalyst (DOC). This engine still uses DOHC architecture and HPI fuel injection but adds aftertreatment to capture and burn soot particles.</p><h2>Aftertreatment System</h2><p>The DPF captures soot particles while the DOC oxidizes hydrocarbons and CO. The system requires periodic regeneration to burn accumulated soot at temperatures above 1,000 degrees F.</p><h2>Regeneration Types</h2><p>Passive regeneration occurs naturally during highway driving. Active regeneration is initiated by the ECM when soot loading reaches a threshold. Parked regeneration is required when active regen cannot complete.</p>','The 2007-2009 Cummins ISX with DPF and DOC aftertreatment. Last DOHC ISX generation.','/assets/images/isx-cm871.png','2007-2009','14.9L (912 ci)','385-600 HP','1,350-1,850 lb-ft','CM871','Diesel','137mm x 169mm','Inline 6-Cylinder DOHC','EPA 2007 (EGR + DPF/DOC)','First ISX with DPF/DOC aftertreatment\nThree-stage regeneration\nRetained DOHC and HPI\nImproved EGR cooling\nHolset VGT with exhaust brake','DPF clogging and failed regeneration\nDOC catalyst degradation\n7th injector failures\nEGR cooler leaks\nVGT actuator sticking\nExcessive soot from short trips',NULL,1,3,'2026-07-09 16:41:53','2026-07-09 16:41:53'),(4,4,'Cummins ISX15 CM2250','cummins-isx15-cm2250','Cummins ISX15 CM2250 Engine Guide - Common Rail SCR Specs & Problems','Complete guide to the Cummins ISX15 CM2250 (2010-2013). First SOHC ISX with XPI common-rail injection and SCR/DEF system.','Cummins ISX15 CM2250: The Common Rail Revolution','<h2>Overview of the ISX15 CM2250</h2><p>The Cummins ISX15 CM2250, produced from 2010 to 2013, represented the most significant redesign in ISX history. Cummins switched from the DOHC architecture to a Single Overhead Camshaft (SOHC) design, replaced HPI with the XPI common-rail fuel injection system, and added Selective Catalytic Reduction (SCR) with Diesel Exhaust Fluid (DEF).</p><h2>XPI Common-Rail Fuel System</h2><p>The Cummins XPI system generates fuel pressure up to 36,000 PSI using a high-pressure fuel pump with ceramic plungers. Unlike HPI which uses engine oil, XPI uses diesel fuel directly, allowing multiple injection events per combustion cycle for better efficiency and lower emissions.</p><h2>SCR and DEF System</h2><p>The SCR system injects DEF (urea solution) into the exhaust stream upstream of the SCR catalyst. The DEF converts NOx into harmless nitrogen and water. This allowed Cummins to tune the engine for better fuel economy while still meeting EPA 2010 standards.</p><h2>SOHC Architecture</h2><p>The switch to SOHC eliminated the complex overhead gear train of the DOHC engines, reducing maintenance requirements. The single camshaft drives both intake and exhaust valves through rocker arms.</p>','The 2010-2013 ISX15 with revolutionary SOHC design, XPI common-rail injection, and SCR/DEF system.','/assets/images/isx15-cm2250.png','2010-2013','15.0L (912 ci)','400-600 HP','1,450-2,050 lb-ft','CM2250','Diesel','137mm x 169mm','Inline 6-Cylinder SOHC','EPA 2010 (EGR + DPF + SCR)','XPI common-rail fuel injection (36,000 PSI)\nSingle Overhead Camshaft (SOHC) design\nSCR with DEF aftertreatment\nMultiple injection events per cycle\nReduced maintenance vs DOHC\nImproved fuel economy','XPI fuel pump ceramic plunger failures\nDEF dosing valve crystallization\nSCR catalyst efficiency codes\nEGR differential pressure sensor issues\nDPF regeneration frequency\nNOx sensor failures',NULL,1,4,'2026-07-09 16:41:53','2026-07-09 16:41:53'),(5,4,'Cummins ISX15 CM2350','cummins-isx15-cm2350','Cummins ISX15 CM2350 Engine Guide - GHG17 Specs & Reliability','Complete guide to the Cummins ISX15 CM2350 (2013-2020). Final ISX15 generation with GHG Phase 1 compliance and improved reliability.','Cummins ISX15 CM2350: The Final ISX15 Generation','<h2>Overview of the ISX15 CM2350</h2><p>The Cummins ISX15 CM2350, produced from 2013 to 2020, was the final evolution of the ISX15 nameplate before transitioning to the X15 branding. The CM2350 retained the SOHC architecture and XPI fuel system from the CM2250 but incorporated significant improvements for GHG Phase 1 (Greenhouse Gas) compliance.</p><h2>GHG Phase 1 Compliance</h2><p>The CM2350 was designed to meet EPA GHG Phase 1 standards, which required reduced CO2 emissions. This was achieved through improved combustion efficiency, reduced parasitic losses, and optimized aftertreatment calibration.</p><h2>Reliability Improvements</h2><p>Cummins addressed many of the early CM2250 issues in the CM2350, including improved XPI fuel pump durability (upgraded ceramic plungers), more robust DEF dosing systems, and refined SCR catalyst formulations.</p>','The 2013-2020 final ISX15 generation with GHG Phase 1 compliance and improved XPI reliability.','/assets/images/isx15-cm2350.png','2013-2020','15.0L (912 ci)','400-600 HP','1,450-2,050 lb-ft','CM2350','Diesel','137mm x 169mm','Inline 6-Cylinder SOHC','EPA 2013 / GHG Phase 1','Improved XPI fuel pump durability\nGHG Phase 1 compliant\nEnhanced SCR efficiency\nReduced parasitic losses\nAdvanced diagnostics via INSITE\nConnected Diagnostics capability','DEF quality sensor false readings\nAftertreatment temperature sensor failures\nEGR valve sticking at high mileage\nTurbo actuator calibration drift\nCoolant leak at water pump weep hole',NULL,1,5,'2026-07-09 16:41:53','2026-07-09 16:41:53'),(6,5,'Cummins X15 Efficiency Series','cummins-x15-efficiency','Cummins X15 Efficiency Series Guide - Best Fuel Economy Specs','Complete guide to the Cummins X15 Efficiency Series. Optimized for maximum fuel economy in long-haul trucking applications.','Cummins X15 Efficiency Series: Maximum Fuel Economy','<h2>Overview of the X15 Efficiency Series</h2><p>The Cummins X15 Efficiency Series is designed specifically for long-haul, line-haul, and regional applications where fuel economy is the primary concern. Launched in 2017 as the successor to the ISX15, the X15 Efficiency delivers up to 3% better fuel economy than the ISX15 CM2350 it replaced.</p><h2>Fuel Economy Features</h2><p>The Efficiency Series achieves its fuel savings through advanced combustion optimization, reduced internal friction, improved aftertreatment efficiency, and integration with Cummins ADEPT (Advanced Dynamic Efficient Powertrain Technology) features including SmartCoast, SmartTorque2, and predictive cruise control integration.</p><h2>ADEPT Technology</h2><p>SmartCoast allows the engine to decouple from the drivetrain on downhill grades. SmartTorque2 provides additional torque in top gear without increasing fuel consumption. These features work together to maximize miles per gallon.</p>','The Cummins X15 Efficiency Series optimized for maximum fuel economy in long-haul applications.','/assets/images/x15-efficiency.png','2017-Present','15.0L (912 ci)','400-500 HP','1,450-1,850 lb-ft','CM2350 (X15)','Diesel','137mm x 169mm','Inline 6-Cylinder SOHC','EPA 2017 / GHG Phase 2','ADEPT fuel-saving technology\nSmartCoast and SmartTorque2\n3% better fuel economy vs ISX15\nPredictive cruise integration\nConnected Diagnostics\nOver-the-air calibration updates','DEF system crystallization in cold weather\nAftertreatment derating events\nTurbo actuator calibration\nCoolant temperature sensor drift\nSoftware update requirements',NULL,1,6,'2026-07-09 16:41:53','2026-07-09 16:41:53'),(7,5,'Cummins X15 Performance Series','cummins-x15-performance','Cummins X15 Performance Series Guide - Maximum Power Specs','Complete guide to the Cummins X15 Performance Series. Maximum horsepower and torque for heavy-haul and vocational applications.','Cummins X15 Performance Series: Maximum Power','<h2>Overview of the X15 Performance Series</h2><p>The Cummins X15 Performance Series is engineered for applications demanding maximum power and torque. With ratings up to 605 HP and 2,050 lb-ft of torque, this engine serves heavy-haul, tanker, flatbed, and vocational applications where pulling power is paramount.</p><h2>Power Delivery</h2><p>The Performance Series features aggressive turbo calibration, optimized injection timing, and enhanced cooling to sustain maximum power output under heavy loads. The engine maintains rated torque across a wide RPM band for excellent drivability.</p><h2>Applications</h2><p>Ideal for heavy-haul (80,000+ lbs GCW), tanker operations, flatbed with oversized loads, construction/vocational trucks, and any application where the truck regularly operates at or near maximum weight.</p>','The Cummins X15 Performance Series with maximum 605 HP and 2,050 lb-ft for heavy-haul applications.','/assets/images/x15-performance.png','2017-Present','15.0L (912 ci)','485-605 HP','1,650-2,050 lb-ft','CM2350 (X15)','Diesel','137mm x 169mm','Inline 6-Cylinder SOHC','EPA 2017 / GHG Phase 2','Up to 605 HP and 2,050 lb-ft\nWide torque band for heavy loads\nEnhanced cooling system\nAggressive turbo calibration\nHeavy-haul optimized\nConnected Diagnostics','Higher thermal stress on components\nTurbo bearing wear under sustained load\nCoolant system demands\nDPF loading rate in stop-and-go\nHigher DEF consumption',NULL,1,7,'2026-07-09 16:41:53','2026-07-09 16:41:53'),(8,6,'Cummins ISX12 / X12','cummins-isx12-x12','Cummins ISX12 and X12 Engine Guide - Medium Duty 12L Specs','Complete guide to the Cummins ISX12 and X12 engines. The 12-liter medium-duty diesel for regional haul and vocational applications.','Cummins ISX12 and X12: The 12-Liter Engine Guide','<h2>Overview of the ISX12 / X12</h2><p>The Cummins ISX12 (later rebranded X12) is an 11.9-liter inline 6-cylinder engine designed for medium-duty and regional-haul applications. Lighter and more compact than the 15-liter ISX15, the ISX12/X12 offers an excellent power-to-weight ratio for applications where the full 15-liter displacement is not needed.</p><h2>Weight Advantage</h2><p>The X12 weighs approximately 600 pounds less than the X15, translating directly to additional payload capacity. For weight-sensitive applications like tankers, bulk haulers, and regional delivery, this weight savings is significant.</p><h2>Performance Range</h2><p>Available in ratings from 350 to 513 HP with torque up to 1,695 lb-ft, the X12 covers a wide range of medium-duty applications from regional delivery to vocational work.</p>','The 12-liter Cummins ISX12/X12 for medium-duty and regional applications. 600 lbs lighter than X15.','/assets/images/isx12-x12.png','2010-Present','11.9L (726 ci)','350-513 HP','1,150-1,695 lb-ft','CM2350 (X12)','Diesel','130mm x 150mm','Inline 6-Cylinder SOHC','EPA 2010+ / GHG Phase 2','600 lbs lighter than X15\nCompact package for tight installations\nXPI common-rail fuel system\nFull aftertreatment (DPF + SCR)\nConnected Diagnostics\nIdeal for weight-sensitive applications','Similar aftertreatment issues as X15\nDEF system maintenance\nLower torque limit vs X15\nLess aftermarket support than ISX15\nCoolant system leaks',NULL,1,8,'2026-07-09 16:41:53','2026-07-09 16:41:53'),(9,7,'Cummins ISX12N Natural Gas','cummins-isx12n-natural-gas','Cummins ISX12N Natural Gas Engine Guide - Alternative Fuel Specs','Complete guide to the Cummins ISX12N natural gas engine. Spark-ignited, near-zero emissions for sustainable fleet operations.','Cummins ISX12N Natural Gas Engine Guide','<h2>Overview of the ISX12N</h2><p>The Cummins ISX12N is a spark-ignited natural gas engine based on the ISX12 diesel platform. Designed for fleets seeking to reduce their carbon footprint, the ISX12N runs on Compressed Natural Gas (CNG), Liquefied Natural Gas (LNG), or Renewable Natural Gas (RNG) and achieves near-zero NOx emissions.</p><h2>Near-Zero Emissions</h2><p>The ISX12N is certified to 0.02 g/bhp-hr NOx, which is 90% below the current EPA standard. When paired with Renewable Natural Gas (RNG), the engine can achieve carbon-negative operation.</p><h2>Applications</h2><p>Popular in refuse/waste collection, transit buses, regional haul, and drayage operations where CNG/LNG fueling infrastructure is available.</p>','The Cummins ISX12N spark-ignited natural gas engine with near-zero NOx emissions.','/assets/images/isx12n-natural-gas.png','2018-Present','11.9L (726 ci)','400 HP','1,450 lb-ft','N/A','Natural Gas','130mm x 150mm','Inline 6-Cylinder','Near-Zero NOx (0.02 g/bhp-hr)','Spark-ignited natural gas operation\nNear-zero NOx emissions\nCNG, LNG, or RNG compatible\nCarbon-negative with RNG\nThree-way catalyst aftertreatment\nNo DPF required','Spark plug maintenance intervals\nNatural gas fuel system leaks\nThrottle body carbon buildup\nCNG tank inspection requirements\nLimited fueling infrastructure',NULL,1,9,'2026-07-09 16:41:53','2026-07-09 16:41:53');
/*!40000 ALTER TABLE `engines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int DEFAULT NULL,
  `mime_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `width` int DEFAULT NULL,
  `height` int DEFAULT NULL,
  `uploaded_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `media_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(320) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `is_published` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'About ISX Engines','about','About ISX Engines - Your Cummins ISX Engine Authority','ISX Engines is the most comprehensive online resource for Cummins ISX engine information, covering every generation from the original 1998 CM570 to the modern X15.','<h2>About ISX Engines</h2><p>ISX Engines is the most comprehensive online resource dedicated exclusively to the Cummins ISX engine family. Our team of diesel engine specialists has decades of combined experience working with every ISX generation, from the original 1998 CM570 Signature to the modern X15 series.</p><h2>Our Mission</h2><p>We believe that every truck owner, fleet manager, and diesel technician deserves access to accurate, detailed, and expert-level information about their engines. Our mission is to be the definitive source for ISX engine specifications, troubleshooting guides, and maintenance information.</p><h2>What We Cover</h2><p>Our content spans the entire ISX lineage: Pre-emissions CM570, EGR-era CM870, DPF-era CM871, common-rail ISX15 CM2250 and CM2350, the modern X15 Efficiency/Performance/Productivity series, the medium-duty ISX12/X12, and natural gas variants.</p>',1,'2026-07-09 16:41:53','2026-07-09 16:41:53'),(2,'Contact Us','contact','Contact ISX Engines - Get Expert Help','Contact the ISX Engines team for questions about Cummins ISX engines, quote requests, or technical support.','<h2>Contact Us</h2><p>Have a question about a Cummins ISX engine? Need help identifying your engine model? Looking for a remanufactured ISX engine quote?</p><p>Our team of diesel engine specialists is here to help. Fill out our quote request form or reach out directly.</p><h2>Get a Quote</h2><p><a href=\"/quote\">Click here to request a free quote</a> on remanufactured ISX engines.</p>',1,'2026-07-09 16:41:53','2026-07-09 16:41:53');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotions`
--

DROP TABLE IF EXISTS `promotions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promotions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_text` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'Learn More',
  `display_type` enum('banner','popup','sidebar') COLLATE utf8mb4_unicode_ci DEFAULT 'banner',
  `position` enum('homepage_top','homepage_bottom','sidebar','all_pages') COLLATE utf8mb4_unicode_ci DEFAULT 'homepage_top',
  `is_active` tinyint(1) DEFAULT '1',
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotions`
--

LOCK TABLES `promotions` WRITE;
/*!40000 ALTER TABLE `promotions` DISABLE KEYS */;
INSERT INTO `promotions` VALUES (1,'Special Offer: Free Shipping on ISX15 Engines','For a limited time, get FREE nationwide shipping on all remanufactured ISX15 CM2250 and CM2350 engines. Call now to take advantage of this offer!',NULL,'/quote','Get Your Quote Now','banner','homepage_top',1,NULL,NULL,0,'2026-07-09 17:11:17');
/*!40000 ALTER TABLE `promotions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quote_requests`
--

DROP TABLE IF EXISTS `quote_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quote_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `engine_model` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vin` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `status` enum('new','contacted','quoted','closed') COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quote_requests`
--

LOCK TABLES `quote_requests` WRITE;
/*!40000 ALTER TABLE `quote_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `quote_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seo_settings`
--

DROP TABLE IF EXISTS `seo_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `seo_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seo_settings`
--

LOCK TABLES `seo_settings` WRITE;
/*!40000 ALTER TABLE `seo_settings` DISABLE KEYS */;
INSERT INTO `seo_settings` VALUES (1,'site_title','ISX Engines - Complete Guide to Every Cummins ISX Engine','2026-07-09 16:42:42'),(2,'site_description','The most comprehensive resource for Cummins ISX engines. Expert guides on ISX CM570, CM870, CM871, ISX15 CM2250, CM2350, X15, and X12 engines.','2026-07-09 16:30:56'),(3,'google_verification','','2026-07-09 16:30:56'),(4,'schema_org_name','ISX Engines','2026-07-09 16:30:56'),(5,'schema_org_type','AutoPartsStore','2026-07-09 16:42:42');
/*!40000 ALTER TABLE `seo_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES (1,'site_name','ISX Engines','2026-07-09 16:30:56'),(2,'site_url','http://34.26.235.14','2026-07-09 17:01:56'),(3,'contact_email','sales@usepny.com','2026-07-09 17:06:22'),(4,'phone','1-631-991-7700','2026-07-09 17:06:22'),(5,'address','200 Bangor St, Lindenhurst, NY 11757','2026-07-09 17:06:22'),(6,'facebook_url','','2026-07-09 16:30:56'),(7,'twitter_url','','2026-07-09 16:30:56'),(8,'youtube_url','','2026-07-09 16:30:56'),(9,'logo_path','/assets/images/logo.png','2026-07-09 16:30:56'),(15,'company_name','US Engine Production','2026-07-09 17:06:22'),(16,'hours','Monday - Friday, 8am - 6pm ET','2026-07-09 17:06:22'),(17,'warranty','1-Year Unlimited Mileage Warranty','2026-07-09 17:06:22');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-09 18:03:30
