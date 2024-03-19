-- MariaDB dump 10.19  Distrib 10.6.16-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: dbdrearepositorio
-- ------------------------------------------------------
-- Server version	5.7.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tanswer`
--

CREATE DATABASE `dbdrearepositorio`;
USE `dbdrearepositorio`;

DROP TABLE IF EXISTS `tanswer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tanswer` (
  `idAnswer` char(13) NOT NULL,
  `idExam` char(13) NOT NULL,
  `numberAnswer` int(11) NOT NULL,
  `descriptionAnswer` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idAnswer`),
  KEY `idExam` (`idExam`),
  CONSTRAINT `tanswer_ibfk_1` FOREIGN KEY (`idExam`) REFERENCES `texam` (`idExam`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tanswer`
--

LOCK TABLES `tanswer` WRITE;
/*!40000 ALTER TABLE `tanswer` DISABLE KEYS */;
/*!40000 ALTER TABLE `tanswer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tcontact`
--

DROP TABLE IF EXISTS `tcontact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tcontact` (
  `idContact` char(13) NOT NULL,
  `completeNameContact` varchar(300) NOT NULL,
  `emailContact` varchar(100) NOT NULL,
  `affairContact` varchar(200) NOT NULL,
  `messageContact` text NOT NULL,
  `dateContact` date NOT NULL,
  `statusContact` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idContact`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tcontact`
--

LOCK TABLES `tcontact` WRITE;
/*!40000 ALTER TABLE `tcontact` DISABLE KEYS */;
INSERT INTO `tcontact` VALUES ('654b0a67d5de4','Edwin Marco Serrano Pataca','edwin.mar345@gmail.com','Evaluaciones del año 2020','Buenas, quisiera saber si tienen a disposición, si tienen las evaluaciones\nque se aplicaron el año 2020, sobre todo las evaluaciones tipo ERA,\ngracias y espero una pronta respuesta','2023-11-07',0,'2023-11-07 23:11:19','2023-11-07 23:11:19'),('65529def9606a','Edwin Marco','edwin.mar345@gmail.com','Evaluaciones año 2022','Me dirijo a la institución para poder pedirle si tienen las evaluaciones del año 2022, deseo esos documentos para mejorar el nivel aprendizaje, espero su pronta respuesta','2023-11-13',0,'2023-11-13 17:06:39','2023-11-13 17:06:39');
/*!40000 ALTER TABLE `tcontact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tdirection`
--

DROP TABLE IF EXISTS `tdirection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tdirection` (
  `idDirection` char(13) NOT NULL,
  `namecompleteDirection` varchar(400) NOT NULL,
  `namesortDirection` varchar(100) NOT NULL,
  `nameRegion` varchar(200) NOT NULL,
  `logoExtension` varchar(7) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idDirection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tdirection`
--

LOCK TABLES `tdirection` WRITE;
/*!40000 ALTER TABLE `tdirection` DISABLE KEYS */;
INSERT INTO `tdirection` VALUES ('6577db49acd56','Dirección de Regional de Educación de Apurímac','DRE Apurímac','Apurímac','png','2023-12-11 23:02:17','2023-12-11 23:06:16'),('6577f3351591e','Dirección Regional de Educación del Callao','DRE Callao','Callao','png','2023-12-12 00:44:21','2023-12-12 00:44:21'),('6577f40ad5ffc','Dirección Regional de Educación Lima Metropolitana','DRE Lima Metropolitana','Lima Metropolitana','png','2023-12-12 00:47:54','2023-12-12 00:47:54'),('657d2485a657d','Direccion Regional de Educacion de Ayacucho','DRE Ayacucho','Ayacucho','png','2023-12-15 23:16:05','2023-12-15 23:16:05'),('6588ecf17e350','Dirección Regional de Educación de Huánuco','DRE Huánuco','Huánuco','jpg','2023-12-24 21:46:09','2023-12-24 21:46:09');
/*!40000 ALTER TABLE `tdirection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tdocument`
--

DROP TABLE IF EXISTS `tdocument`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tdocument` (
  `idDocument` char(13) NOT NULL,
  `key_document` varchar(30) NOT NULL,
  `number_document` int(11) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idDocument`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tdocument`
--

LOCK TABLES `tdocument` WRITE;
/*!40000 ALTER TABLE `tdocument` DISABLE KEYS */;
INSERT INTO `tdocument` VALUES ('5ece4797eaf5e','exam',14,1,'2023-10-14 22:30:27','2023-12-24 21:48:34');
/*!40000 ALTER TABLE `tdocument` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `texam`
--

DROP TABLE IF EXISTS `texam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `texam` (
  `idExam` char(13) NOT NULL,
  `idTypeExam` char(13) NOT NULL,
  `idGrade` char(13) NOT NULL,
  `idSubject` char(13) NOT NULL,
  `idDirection` char(13) DEFAULT NULL,
  `codeExam` varchar(30) NOT NULL,
  `nameExam` text NOT NULL,
  `descriptionExam` text NOT NULL,
  `totalPageExam` int(11) NOT NULL,
  `yearExam` int(11) NOT NULL,
  `numberEvaluation` int(11) NOT NULL DEFAULT '1',
  `stateExam` varchar(20) NOT NULL,
  `keywordExam` text NOT NULL,
  `extensionExam` varchar(7) NOT NULL,
  `statusAnwser` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idExam`),
  KEY `idTypeExam` (`idTypeExam`),
  KEY `idGrade` (`idGrade`),
  KEY `idSubject` (`idSubject`),
  KEY `fk_idDirection` (`idDirection`),
  CONSTRAINT `fk_idDirection` FOREIGN KEY (`idDirection`) REFERENCES `tdirection` (`idDirection`),
  CONSTRAINT `texam_ibfk_1` FOREIGN KEY (`idTypeExam`) REFERENCES `ttypeexam` (`idTypeExam`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `texam_ibfk_2` FOREIGN KEY (`idGrade`) REFERENCES `tgrade` (`idGrade`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `texam_ibfk_3` FOREIGN KEY (`idSubject`) REFERENCES `tsubject` (`idSubject`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `texam`
--

LOCK TABLES `texam` WRITE;
/*!40000 ALTER TABLE `texam` DISABLE KEYS */;
INSERT INTO `texam` VALUES ('6518fb6d29755','640bcb3725ac0','6518e4c4426d8','641f76356ced4','6577f3351591e','1','Evaluación ERA Callao Matemática 6° Primaria','Evaluación realizada para el tipo de documento de matematica',10,2015,1,'Publico','M.C.M__7SEPARATOR7__RM__7SEPARATOR7__Divisiones con potenciación','pdf',0,'2023-09-30 23:54:05','2023-12-12 01:08:05'),('651a51feb5f74','6440b47e00103','6518e4cacfdd2','641f76356ced4',NULL,'2','Evaluación LLECE Matemática 1° Secundaria','Evaluacion de entrada que se dieron el dia 24 del año 2018',14,2018,1,'Publico','division__7SEPARATOR7__potenciacion__7SEPARATOR7__radicacion__7SEPARATOR7__mcm','pdf',0,'2023-10-02 00:15:42','2023-10-02 00:15:42'),('651a578c438f9','640bc3fc1ff41','6518e4bca059b','641f76356ced4',NULL,'3','Evaluación ECE Matemática 5° Primaria','Esta es una evaluación de entrada',10,2018,1,'Publico','rm__7SEPARATOR7__muliplicacion__7SEPARATOR7__sumatorias','pdf',0,'2023-10-02 00:39:24','2023-10-02 00:39:24'),('651a57ef6c210','640bcb3725ac0','6518e4cacfdd2','641cd15b35194',NULL,'4','Evaluación ERA Comunicación 1° Secundaria','evaluación de entrada',12,2023,1,'Publico','rv__7SEPARATOR7__comprensión lectora__7SEPARATOR7__verbo','pdf',0,'2023-10-02 00:41:03','2023-10-02 00:41:03'),('651a58349277d','640bcb3725ac0','6518e4c4426d8','641cd15b35194',NULL,'5','Evaluación ERA Comunicación 6° Primaria','evaluacion de entrada para laravel',12,2017,1,'Oculto','rv__7SEPARATOR7__verbo__7SEPARATOR7__oraciones__7SEPARATOR7__verbos__7SEPARATOR7__preposiciones','pdf',0,'2023-10-02 00:42:12','2023-10-14 22:46:32'),('652b5f9551fa5','640bcb3725ac0','6518e4d958a4d','6518e506534e6',NULL,'6','Evaluación ERA Razonamiento Matemático 3° Secundaria','Examen inicial para ingresar conocimientos nuevos',10,2013,1,'Oculto','rv__7SEPARATOR7__conocimiento matemático__7SEPARATOR7__bienestar general','pdf',0,'2023-10-14 22:42:13','2023-10-14 22:42:13'),('652b608d1da9d','640bcb3725ac0','6518e4ab706d5','641cd15b35194','6577db49acd56','7','Evaluación ERA Apurímac Comunicación 4° Primaria','evaluacion general',12,2018,1,'Publico','compresion lectora__7SEPARATOR7__predicado__7SEPARATOR7__oraciones compuestas','pdf',0,'2023-10-14 22:46:21','2023-12-12 01:10:34'),('6552990d09445','640bc3fc1ff41','641cf48b8e1b7','641f76356ced4','6577f3351591e','8','Evaluación ECE Callao Matemática 1° Primaria','Evaluacion realizada para corroborar el aprendizaje',10,2015,1,'Publico','rm__7SEPARATOR7__razonamiento__7SEPARATOR7__sumas__7SEPARATOR7__sucesiones','pdf',0,'2023-11-13 16:45:49','2023-12-12 01:08:24'),('6552996a14d86','640bc3fc1ff41','641cf5f4a062f','641f76356ced4','6577f3351591e','9','Evaluación ECE Callao Matemática 2° Primaria','Evaluacion exclusiva para el nivel primaria',10,2015,1,'Publico','rm__7SEPARATOR7__multiplicacion__7SEPARATOR7__sucesiones__7SEPARATOR7__división','pdf',0,'2023-11-13 16:47:22','2023-12-12 01:07:51'),('65529a2f4d4c9','640bc3fc1ff41','641cf48b8e1b7','655299acb73a3',NULL,'10','Evaluación ECE Comprensión Lectora 1° Primaria','Evaluacion para ver el grado de compresion de los estudiantes',10,2015,1,'Publico','compresion__7SEPARATOR7__inferenciar__7SEPARATOR7__lectura','pdf',0,'2023-11-13 16:50:39','2023-11-13 16:50:39'),('65529a684217d','640bc3fc1ff41','641cf5f4a062f','655299acb73a3',NULL,'11','Evaluación ECE Comprensión Lectora 2° Primaria','Evaluacion que se aplicó a nivel nacional',11,2015,1,'Publico','lectura__7SEPARATOR7__comunicación__7SEPARATOR7__predicado__7SEPARATOR7__sujeto','pdf',0,'2023-11-13 16:51:36','2023-11-13 16:51:36'),('65529aba40e41','640bcb3725ac0','641cf48b8e1b7','641cd15b35194','6577db49acd56','12','2° Evaluación ERA Apurímac Comunicación 1° Primaria','Evaluacion regional de apurimac',11,2018,2,'Publico','sujeto__7SEPARATOR7__oraciones__7SEPARATOR7__tilde','pdf',0,'2023-11-13 16:52:58','2023-12-16 00:36:30'),('6588ec13ec3e2','640bcb3725ac0','6518e4d1ebfd8','641f76356ced4','657d2485a657d','13','3° Evaluación ERA Ayacucho Matemática 2° Secundaria','Evaluación que se dio en el año 2023, siendo el ultimo de la trimestre',12,2023,3,'Publico','conjunto unitario__7SEPARATOR7__funciones__7SEPARATOR7__operacion de potenciación','pdf',0,'2023-12-24 21:42:28','2023-12-24 21:42:28'),('6588ed82b2399','640bcb3725ac0','6518e4ab706d5','641cd15b35194','6588ecf17e350','14','2° Evaluación ERA Huánuco Comunicación 4° Primaria','Esta es la 2° evaluación de la región de huanuco',12,2016,2,'Publico','compresión lectora__7SEPARATOR7__lectura','pdf',0,'2023-12-24 21:48:34','2023-12-24 21:48:34');
/*!40000 ALTER TABLE `texam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tgrade`
--

DROP TABLE IF EXISTS `tgrade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tgrade` (
  `idGrade` char(13) NOT NULL,
  `nameGrade` varchar(50) NOT NULL,
  `numberGrade` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idGrade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tgrade`
--

LOCK TABLES `tgrade` WRITE;
/*!40000 ALTER TABLE `tgrade` DISABLE KEYS */;
INSERT INTO `tgrade` VALUES ('641cf48b8e1b7','Primaria',1,'2023-03-23 19:53:31','2023-03-23 19:53:31'),('641cf5f4a062f','Primaria',2,'2023-03-23 19:59:32','2023-03-23 19:59:32'),('641f90e01fc01','Primaria',3,'2023-03-25 19:25:04','2023-03-25 19:25:04'),('6518e4ab706d5','Primaria',4,'2023-09-30 22:16:59','2023-09-30 22:17:08'),('6518e4bca059b','Primaria',5,'2023-09-30 22:17:16','2023-09-30 22:17:16'),('6518e4c4426d8','Primaria',6,'2023-09-30 22:17:24','2023-09-30 22:17:24'),('6518e4cacfdd2','Secundaria',1,'2023-09-30 22:17:30','2023-09-30 22:17:30'),('6518e4d1ebfd8','Secundaria',2,'2023-09-30 22:17:37','2023-09-30 22:17:37'),('6518e4d958a4d','Secundaria',3,'2023-09-30 22:17:45','2023-09-30 22:17:45'),('6518e4dfc8bd9','Secundaria',4,'2023-09-30 22:17:51','2023-09-30 22:17:51'),('6518e4e7e3052','Secundaria',5,'2023-09-30 22:17:59','2023-09-30 22:17:59');
/*!40000 ALTER TABLE `tgrade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tresetpassword`
--

DROP TABLE IF EXISTS `tresetpassword`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tresetpassword` (
  `idResetPassword` char(13) NOT NULL,
  `idUser` char(13) NOT NULL,
  `token` text NOT NULL,
  `isRecuperate` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idResetPassword`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `tresetpassword_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `tuser` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tresetpassword`
--

LOCK TABLES `tresetpassword` WRITE;
/*!40000 ALTER TABLE `tresetpassword` DISABLE KEYS */;
/*!40000 ALTER TABLE `tresetpassword` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trole`
--

DROP TABLE IF EXISTS `trole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trole` (
  `idRole` char(13) NOT NULL,
  `nameRole` varchar(50) NOT NULL,
  `descriptionRole` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idRole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trole`
--

LOCK TABLES `trole` WRITE;
/*!40000 ALTER TABLE `trole` DISABLE KEYS */;
INSERT INTO `trole` VALUES ('5ece4797eaf5e','Administrador','Acceso total al sistema','2023-09-28 00:02:20','2023-09-28 00:02:20'),('6515073a329ac','Registrador','Acceso para poder registrar evaluaciones y/o respuestas y solo se puede publicar previa aprobación','2023-09-28 00:02:20','2023-09-28 00:02:20'),('6515074f590dc','Normal','Acceso básico para un usuario que desee crearse un usuario en el sistema','2023-09-28 00:02:20','2023-09-28 00:02:20'),('651508865dd1e','Supervisor','Posibilidad de manipular las evaluaciones, aprobar la publicación de las mismas','2023-09-28 00:02:20','2023-09-28 00:02:20');
/*!40000 ALTER TABLE `trole` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tsubject`
--

DROP TABLE IF EXISTS `tsubject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tsubject` (
  `idSubject` char(13) NOT NULL,
  `nameSubject` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idSubject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tsubject`
--

LOCK TABLES `tsubject` WRITE;
/*!40000 ALTER TABLE `tsubject` DISABLE KEYS */;
INSERT INTO `tsubject` VALUES ('641cd15b35194','Comunicación','2023-03-23 17:23:23','2023-03-23 17:23:23'),('641f76356ced4','Matemática','2023-03-25 17:31:17','2023-03-25 17:31:17'),('6518e4f7701fb','Ciencia Tecnología y Ambiente','2023-09-30 22:18:15','2023-09-30 22:18:15'),('6518e506534e6','Razonamiento Matemático','2023-09-30 22:18:30','2023-09-30 22:18:30'),('655299acb73a3','Comprensión Lectora','2023-11-13 16:48:28','2023-11-13 16:48:28');
/*!40000 ALTER TABLE `tsubject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ttypeexam`
--

DROP TABLE IF EXISTS `ttypeexam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ttypeexam` (
  `idTypeExam` char(13) NOT NULL,
  `nameTypeExam` varchar(100) NOT NULL,
  `acronymTypeExam` varchar(10) NOT NULL,
  `descriptionTypeExam` varchar(200) NOT NULL,
  `numberExecuteYear` int(11) DEFAULT '1',
  `extensionImageType` varchar(7) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idTypeExam`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ttypeexam`
--

LOCK TABLES `ttypeexam` WRITE;
/*!40000 ALTER TABLE `ttypeexam` DISABLE KEYS */;
INSERT INTO `ttypeexam` VALUES ('640bc3fc1ff41','Evaluación Censal de Estudiantes','ece','es una evaluación que permite conocer los logros de aprendizaje alcanzados por los estudiantes. Esta evaluación se realiza a todas las escuelas públicas y privadas.',2,'jpg','2023-03-10 18:57:48','2023-12-15 23:01:40'),('640bcb3725ac0','Evaluación Regional de Aprendizajes','era','Evaluación aplicada por trimestres a todos los alumnos de las instituciones del país',3,'jpg','2023-03-10 19:28:39','2023-12-15 22:57:12'),('6440b47e00103','Examen censal de respuestas','llece','Examen general de partes',1,'png','2023-04-19 22:41:50','2023-04-19 22:41:50'),('657d2118a1ae2','Evaluación Muestral de Estudiantes','em','Es una evaluación estandarizada que se aplica a una muestra de estudiantes, representativa a nivel nacional, para medir sus logros de aprendizaje',2,'png','2023-12-15 23:01:28','2023-12-15 23:10:00');
/*!40000 ALTER TABLE `ttypeexam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tuser`
--

DROP TABLE IF EXISTS `tuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tuser` (
  `idUser` char(13) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(700) NOT NULL,
  `numberDni` char(8) NOT NULL,
  `firstName` varchar(60) NOT NULL,
  `surName` varchar(60) NOT NULL,
  `avatarExtension` varchar(7) NOT NULL,
  `state` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idUser`),
  KEY `idx_user_id` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tuser`
--

LOCK TABLES `tuser` WRITE;
/*!40000 ALTER TABLE `tuser` DISABLE KEYS */;
INSERT INTO `tuser` VALUES ('64192d94c2741','edwin.mar345@gmail.com','eyJpdiI6Im1RajdEM2V3cmozUlZsenNCYzh2U2c9PSIsInZhbHVlIjoiUktTN0MvcVV3ZmdhQTNuRmxsdTkzdz09IiwibWFjIjoiZTEyY2E2NzhkMzE0MzQyMThiMjg4NGFmNzJlZDhhMDQxODQ0YTUzNDE3NjhhNWNhYmNkNDcwYWY4OWZjOGM1MiIsInRhZyI6IiJ9','76280830','Edwin Marco','Serrano Pataca','jpg','Habilitado','2023-03-20 23:07:48','2023-12-11 22:27:38'),('65150bc7802f9','john32@gmail.com','eyJpdiI6ImFxMCs2NjhpVGFRbytJcy9GTEpMZWc9PSIsInZhbHVlIjoiRUM0NXkrdkJqQVZTVUJmOXNJdU40QT09IiwibWFjIjoiNTA0YTA4M2ZjM2ZhMDA4YjViMmQ2MzZmZDhhNzVlY2ZmMzIyYzUzMTExNDY0ZDY2ZTNhZTAyNjM4ZmY5NzFmNiIsInRhZyI6IiJ9','90120312','Jhon','Durand','','Habilitado','2023-09-28 00:14:47','2023-09-30 19:51:08'),('651626641c1d3','mibarra@unamba.edu.pe','eyJpdiI6Im9JQ05VWXhLeUdBVXllbDNZdy9BU2c9PSIsInZhbHVlIjoienZDd004OGpDblNkUHVVLzdFTmx1dz09IiwibWFjIjoiNTYxYzBmOWE4YWY0Y2UwMmU2NWYwYjQ4NmNlODg1NWYxNzE5NTY3Y2EzYjRmNGUzNDRiOTA5YWM5NGU4ODBjOSIsInRhZyI6IiJ9','23974689','Manuel Jesús','Ibarra Cabrera','','Habilitado','2023-09-28 20:20:36','2023-09-28 20:21:08'),('65eabb4caebf0','holamundo@hotmail.com','eyJpdiI6ImRSaU1ROGRQZnc2cVZMYy9ycWtIZ1E9PSIsInZhbHVlIjoiWWhJODU3dkMwMkhrTmc4WmRXWXZHZz09IiwibWFjIjoiYzNjNTUwM2FhMTNhYTA3N2Y5NzcyZDhmOGJlNzNmMDYxNGFkYmMwZTgzY2Q3NmIzN2Q4ZDgzMTgzNTA4OGZkZCIsInRhZyI6IiJ9','88238123','Juan','Monarca','','Deshabilitado','2024-03-08 02:16:28','2024-03-08 02:16:28'),('65eabb4caebf1','nahuinlla101131@gmail.com','eyJpdiI6ImRSaU1ROGRQZnc2cVZMYy9ycWtIZ1E9PSIsInZhbHVlIjoiWWhJODU3dkMwMkhrTmc4WmRXWXZHZz09IiwibWFjIjoiYzNjNTUwM2FhMTNhYTA3N2Y5NzcyZDhmOGJlNzNmMDYxNGFkYmMwZTgzY2Q3NmIzN2Q4ZDgzMTgzNTA4OGZkZCIsInRhZyI6IiJ9','88238123','Emerson','NV','','Habilitado','2024-03-08 02:16:28','2024-03-08 02:16:28');
/*!40000 ALTER TABLE `tuser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tuserexam`
--

DROP TABLE IF EXISTS `tuserexam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tuserexam` (
  `idUserExam` char(13) NOT NULL,
  `idUser` char(13) NOT NULL,
  `idExam` char(13) NOT NULL,
  `typeFunctionExam` varchar(50) NOT NULL,
  `dataExam` text NOT NULL,
  `dateUserExam` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idUserExam`),
  KEY `idUser` (`idUser`),
  KEY `idExam` (`idExam`),
  CONSTRAINT `tuserexam_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `tuser` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tuserexam_ibfk_2` FOREIGN KEY (`idExam`) REFERENCES `texam` (`idExam`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tuserexam`
--

LOCK TABLES `tuserexam` WRITE;
/*!40000 ALTER TABLE `tuserexam` DISABLE KEYS */;
INSERT INTO `tuserexam` VALUES ('6518fb6d2aeeb','65150bc7802f9','6518fb6d29755','Registro','{\"idExam\":\"6518fb6d29755\",\"idTypeExam\":\"640bcb3725ac0\",\"idGrade\":\"6518e4c4426d8\",\"idSubject\":\"641f76356ced4\",\"codeExam\":\"\",\"nameExam\":\"Evaluaci\\u00f3n ERA Matem\\u00e1tica 6\\u00b0 Primaria\",\"descriptionExam\":\"Evaluaci\\u00f3n realizada para el tipo de documento de matematica\",\"totalPageExam\":\"10\",\"yearExam\":\"2019\",\"stateExam\":\"Oculto\",\"keywordExam\":\"M.C.M__7SEPARATOR7__RM__7SEPARATOR7__Divisiones con potenciaci\\u00f3n\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-10-01T04:54:05.000000Z\",\"updated_at\":\"2023-10-01T04:54:05.000000Z\"}','2023-09-30','2023-09-30 23:54:05','2023-09-30 23:54:05'),('651a51fec67a9','64192d94c2741','651a51feb5f74','Registro','{\"idExam\":\"651a51feb5f74\",\"idTypeExam\":\"6440b47e00103\",\"idGrade\":\"6518e4cacfdd2\",\"idSubject\":\"641f76356ced4\",\"codeExam\":\"\",\"nameExam\":\"Evaluaci\\u00f3n LLECE Matem\\u00e1tica 1\\u00b0 Secundaria\",\"descriptionExam\":\"Evaluacion de entrada que se dieron el dia 24 del a\\u00f1o 2018\",\"totalPageExam\":\"14\",\"yearExam\":\"2018\",\"stateExam\":\"Publico\",\"keywordExam\":\"division__7SEPARATOR7__potenciacion__7SEPARATOR7__radicacion__7SEPARATOR7__mcm\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-10-02T05:15:42.000000Z\",\"updated_at\":\"2023-10-02T05:15:42.000000Z\"}','2023-10-02','2023-10-02 00:15:42','2023-10-02 00:15:42'),('651a578c4446c','64192d94c2741','651a578c438f9','Registro','{\"idExam\":\"651a578c438f9\",\"idTypeExam\":\"640bc3fc1ff41\",\"idGrade\":\"6518e4bca059b\",\"idSubject\":\"641f76356ced4\",\"codeExam\":\"\",\"nameExam\":\"Evaluaci\\u00f3n ECE Matem\\u00e1tica 5\\u00b0 Primaria\",\"descriptionExam\":\"Esta es una evaluaci\\u00f3n de entrada\",\"totalPageExam\":\"10\",\"yearExam\":\"2018\",\"stateExam\":\"Publico\",\"keywordExam\":\"rm__7SEPARATOR7__muliplicacion__7SEPARATOR7__sumatorias\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-10-02T05:39:24.000000Z\",\"updated_at\":\"2023-10-02T05:39:24.000000Z\"}','2023-10-02','2023-10-02 00:39:24','2023-10-02 00:39:24'),('651a57ef6d094','64192d94c2741','651a57ef6c210','Registro','{\"idExam\":\"651a57ef6c210\",\"idTypeExam\":\"640bcb3725ac0\",\"idGrade\":\"6518e4cacfdd2\",\"idSubject\":\"641cd15b35194\",\"codeExam\":\"\",\"nameExam\":\"Evaluaci\\u00f3n ERA Comunicaci\\u00f3n 1\\u00b0 Secundaria\",\"descriptionExam\":\"evaluaci\\u00f3n de entrada\",\"totalPageExam\":\"12\",\"yearExam\":\"2023\",\"stateExam\":\"Publico\",\"keywordExam\":\"rv__7SEPARATOR7__comprensi\\u00f3n lectora__7SEPARATOR7__verbo\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-10-02T05:41:03.000000Z\",\"updated_at\":\"2023-10-02T05:41:03.000000Z\"}','2023-10-02','2023-10-02 00:41:03','2023-10-02 00:41:03'),('651a583493891','64192d94c2741','651a58349277d','Registro','{\"idExam\":\"651a58349277d\",\"idTypeExam\":\"640bcb3725ac0\",\"idGrade\":\"6518e4c4426d8\",\"idSubject\":\"641cd15b35194\",\"codeExam\":\"\",\"nameExam\":\"Evaluaci\\u00f3n ERA Comunicaci\\u00f3n 6\\u00b0 Primaria\",\"descriptionExam\":\"evaluacion de entrada para laravel\",\"totalPageExam\":\"12\",\"yearExam\":\"2017\",\"stateExam\":\"Publico\",\"keywordExam\":\"rv__7SEPARATOR7__verbo__7SEPARATOR7__oraciones__7SEPARATOR7__verbos__7SEPARATOR7__preposiciones\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-10-02T05:42:12.000000Z\",\"updated_at\":\"2023-10-02T05:42:12.000000Z\"}','2023-10-02','2023-10-02 00:42:12','2023-10-02 00:42:12'),('651a59351db11','64192d94c2741','6518fb6d29755','Modificación','{\"idExam\":\"6518fb6d29755\",\"idTypeExam\":\"640bcb3725ac0\",\"idGrade\":\"6518e4c4426d8\",\"idSubject\":\"641f76356ced4\",\"codeExam\":\"\",\"nameExam\":\"Evaluaci\\u00f3n ERA Matem\\u00e1tica 6\\u00b0 Primaria\",\"descriptionExam\":\"Evaluaci\\u00f3n realizada para el tipo de documento de matematica\",\"totalPageExam\":\"10\",\"yearExam\":\"2015\",\"stateExam\":\"Publico\",\"keywordExam\":\"M.C.M__7SEPARATOR7__RM__7SEPARATOR7__Divisiones con potenciaci\\u00f3n\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-10-01T04:54:05.000000Z\",\"updated_at\":\"2023-10-02T05:46:29.000000Z\"}','2023-10-02','2023-10-02 00:46:29','2023-10-02 00:46:29'),('652b5f956fec0','64192d94c2741','652b5f9551fa5','Registro','{\"idExam\":\"652b5f9551fa5\",\"idTypeExam\":\"640bcb3725ac0\",\"idGrade\":\"6518e4d958a4d\",\"idSubject\":\"6518e506534e6\",\"codeExam\":6,\"nameExam\":\"Evaluaci\\u00f3n ERA Razonamiento Matem\\u00e1tico 3\\u00b0 Secundaria\",\"descriptionExam\":\"Examen inicial para ingresar conocimientos nuevos\",\"totalPageExam\":\"10\",\"yearExam\":\"2013\",\"stateExam\":\"Oculto\",\"keywordExam\":\"rv__7SEPARATOR7__conocimiento matem\\u00e1tico__7SEPARATOR7__bienestar general\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-10-15T03:42:13.000000Z\",\"updated_at\":\"2023-10-15T03:42:13.000000Z\"}','2023-10-14','2023-10-14 22:42:13','2023-10-14 22:42:13'),('652b608d1ea88','64192d94c2741','652b608d1da9d','Registro','{\"idExam\":\"652b608d1da9d\",\"idTypeExam\":\"640bcb3725ac0\",\"idGrade\":\"6518e4ab706d5\",\"idSubject\":\"641cd15b35194\",\"codeExam\":7,\"nameExam\":\"Evaluaci\\u00f3n ERA Comunicaci\\u00f3n 4\\u00b0 Primaria\",\"descriptionExam\":\"evaluacion general\",\"totalPageExam\":\"12\",\"yearExam\":\"2018\",\"stateExam\":\"Publico\",\"keywordExam\":\"compresion lectora__7SEPARATOR7__predicado__7SEPARATOR7__oraciones compuestas\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-10-15T03:46:21.000000Z\",\"updated_at\":\"2023-10-15T03:46:21.000000Z\"}','2023-10-14','2023-10-14 22:46:21','2023-10-14 22:46:21'),('6552990d0ac01','64192d94c2741','6552990d09445','Registro','{\"idExam\":\"6552990d09445\",\"idTypeExam\":\"640bc3fc1ff41\",\"idGrade\":\"641cf48b8e1b7\",\"idSubject\":\"641f76356ced4\",\"codeExam\":8,\"nameExam\":\"Evaluaci\\u00f3n ECE Matem\\u00e1tica 1\\u00b0 Primaria\",\"descriptionExam\":\"Evaluacion realizada para corroborar el aprendizaje\",\"totalPageExam\":\"10\",\"yearExam\":\"2015\",\"stateExam\":\"Publico\",\"keywordExam\":\"rm__7SEPARATOR7__razonamiento__7SEPARATOR7__sumas__7SEPARATOR7__sucesiones\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-11-13T21:45:49.000000Z\",\"updated_at\":\"2023-11-13T21:45:49.000000Z\"}','2023-11-13','2023-11-13 16:45:49','2023-11-13 16:45:49'),('6552996a1619d','64192d94c2741','6552996a14d86','Registro','{\"idExam\":\"6552996a14d86\",\"idTypeExam\":\"640bc3fc1ff41\",\"idGrade\":\"641cf5f4a062f\",\"idSubject\":\"641f76356ced4\",\"codeExam\":9,\"nameExam\":\"Evaluaci\\u00f3n ECE Matem\\u00e1tica 2\\u00b0 Primaria\",\"descriptionExam\":\"Evaluacion exclusiva para el nivel primaria\",\"totalPageExam\":\"10\",\"yearExam\":\"2015\",\"stateExam\":\"Publico\",\"keywordExam\":\"rm__7SEPARATOR7__multiplicacion__7SEPARATOR7__sucesiones__7SEPARATOR7__divisi\\u00f3n\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-11-13T21:47:22.000000Z\",\"updated_at\":\"2023-11-13T21:47:22.000000Z\"}','2023-11-13','2023-11-13 16:47:22','2023-11-13 16:47:22'),('65529a2f4edea','64192d94c2741','65529a2f4d4c9','Registro','{\"idExam\":\"65529a2f4d4c9\",\"idTypeExam\":\"640bc3fc1ff41\",\"idGrade\":\"641cf48b8e1b7\",\"idSubject\":\"655299acb73a3\",\"codeExam\":10,\"nameExam\":\"Evaluaci\\u00f3n ECE Comprensi\\u00f3n Lectora 1\\u00b0 Primaria\",\"descriptionExam\":\"Evaluacion para ver el grado de compresion de los estudiantes\",\"totalPageExam\":\"10\",\"yearExam\":\"2015\",\"stateExam\":\"Publico\",\"keywordExam\":\"compresion__7SEPARATOR7__inferenciar__7SEPARATOR7__lectura\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-11-13T21:50:39.000000Z\",\"updated_at\":\"2023-11-13T21:50:39.000000Z\"}','2023-11-13','2023-11-13 16:50:39','2023-11-13 16:50:39'),('65529a6843828','64192d94c2741','65529a684217d','Registro','{\"idExam\":\"65529a684217d\",\"idTypeExam\":\"640bc3fc1ff41\",\"idGrade\":\"641cf5f4a062f\",\"idSubject\":\"655299acb73a3\",\"codeExam\":11,\"nameExam\":\"Evaluaci\\u00f3n ECE Comprensi\\u00f3n Lectora 2\\u00b0 Primaria\",\"descriptionExam\":\"Evaluacion que se aplic\\u00f3 a nivel nacional\",\"totalPageExam\":\"11\",\"yearExam\":\"2015\",\"stateExam\":\"Publico\",\"keywordExam\":\"lectura__7SEPARATOR7__comunicaci\\u00f3n__7SEPARATOR7__predicado__7SEPARATOR7__sujeto\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-11-13T21:51:36.000000Z\",\"updated_at\":\"2023-11-13T21:51:36.000000Z\"}','2023-11-13','2023-11-13 16:51:36','2023-11-13 16:51:36'),('65529aba42372','64192d94c2741','65529aba40e41','Registro','{\"idExam\":\"65529aba40e41\",\"idTypeExam\":\"640bcb3725ac0\",\"idGrade\":\"641cf48b8e1b7\",\"idSubject\":\"641cd15b35194\",\"codeExam\":12,\"nameExam\":\"Evaluaci\\u00f3n ERA Comunicaci\\u00f3n 1\\u00b0 Primaria\",\"descriptionExam\":\"Evaluacion regional de apurimca\",\"totalPageExam\":\"11\",\"yearExam\":\"2018\",\"stateExam\":\"Publico\",\"keywordExam\":\"sujeto__7SEPARATOR7__oraciones__7SEPARATOR7__tilde\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-11-13T21:52:58.000000Z\",\"updated_at\":\"2023-11-13T21:52:58.000000Z\"}','2023-11-13','2023-11-13 16:52:58','2023-11-13 16:52:58'),('6577f884e0b42','64192d94c2741','65529aba40e41','Modificación','{\"idExam\":\"65529aba40e41\",\"idTypeExam\":\"640bcb3725ac0\",\"idGrade\":\"641cf48b8e1b7\",\"idSubject\":\"641cd15b35194\",\"idDirection\":\"6577db49acd56\",\"codeExam\":\"12\",\"nameExam\":\"Evaluaci\\u00f3n ERA Apur\\u00edmac Comunicaci\\u00f3n 1\\u00b0 Primaria\",\"descriptionExam\":\"Evaluacion regional de apurimac\",\"totalPageExam\":\"11\",\"yearExam\":\"2018\",\"stateExam\":\"Publico\",\"keywordExam\":\"sujeto__7SEPARATOR7__oraciones__7SEPARATOR7__tilde\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-11-13T21:52:58.000000Z\",\"updated_at\":\"2023-12-12T06:07:00.000000Z\"}','2023-12-12','2023-12-12 01:07:00','2023-12-12 01:07:00'),('6577f8b79050a','64192d94c2741','6552996a14d86','Modificación','{\"idExam\":\"6552996a14d86\",\"idTypeExam\":\"640bc3fc1ff41\",\"idGrade\":\"641cf5f4a062f\",\"idSubject\":\"641f76356ced4\",\"idDirection\":\"6577f3351591e\",\"codeExam\":\"9\",\"nameExam\":\"Evaluaci\\u00f3n ECE Callao Matem\\u00e1tica 2\\u00b0 Primaria\",\"descriptionExam\":\"Evaluacion exclusiva para el nivel primaria\",\"totalPageExam\":\"10\",\"yearExam\":\"2015\",\"stateExam\":\"Publico\",\"keywordExam\":\"rm__7SEPARATOR7__multiplicacion__7SEPARATOR7__sucesiones__7SEPARATOR7__divisi\\u00f3n\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-11-13T21:47:22.000000Z\",\"updated_at\":\"2023-12-12T06:07:51.000000Z\"}','2023-12-12','2023-12-12 01:07:51','2023-12-12 01:07:51'),('6577f8c5b7231','64192d94c2741','6518fb6d29755','Modificación','{\"idExam\":\"6518fb6d29755\",\"idTypeExam\":\"640bcb3725ac0\",\"idGrade\":\"6518e4c4426d8\",\"idSubject\":\"641f76356ced4\",\"idDirection\":\"6577f3351591e\",\"codeExam\":\"1\",\"nameExam\":\"Evaluaci\\u00f3n ERA Callao Matem\\u00e1tica 6\\u00b0 Primaria\",\"descriptionExam\":\"Evaluaci\\u00f3n realizada para el tipo de documento de matematica\",\"totalPageExam\":\"10\",\"yearExam\":\"2015\",\"stateExam\":\"Publico\",\"keywordExam\":\"M.C.M__7SEPARATOR7__RM__7SEPARATOR7__Divisiones con potenciaci\\u00f3n\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-10-01T04:54:05.000000Z\",\"updated_at\":\"2023-12-12T06:08:05.000000Z\"}','2023-12-12','2023-12-12 01:08:05','2023-12-12 01:08:05'),('6577f8d803f29','64192d94c2741','6552990d09445','Modificación','{\"idExam\":\"6552990d09445\",\"idTypeExam\":\"640bc3fc1ff41\",\"idGrade\":\"641cf48b8e1b7\",\"idSubject\":\"641f76356ced4\",\"idDirection\":\"6577f3351591e\",\"codeExam\":\"8\",\"nameExam\":\"Evaluaci\\u00f3n ECE Callao Matem\\u00e1tica 1\\u00b0 Primaria\",\"descriptionExam\":\"Evaluacion realizada para corroborar el aprendizaje\",\"totalPageExam\":\"10\",\"yearExam\":\"2015\",\"stateExam\":\"Publico\",\"keywordExam\":\"rm__7SEPARATOR7__razonamiento__7SEPARATOR7__sumas__7SEPARATOR7__sucesiones\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-11-13T21:45:49.000000Z\",\"updated_at\":\"2023-12-12T06:08:24.000000Z\"}','2023-12-12','2023-12-12 01:08:24','2023-12-12 01:08:24'),('6577f952669a1','64192d94c2741','652b608d1da9d','Modificación','{\"idExam\":\"652b608d1da9d\",\"idTypeExam\":\"640bcb3725ac0\",\"idGrade\":\"6518e4ab706d5\",\"idSubject\":\"641cd15b35194\",\"idDirection\":\"6577db49acd56\",\"codeExam\":\"7\",\"nameExam\":\"Evaluaci\\u00f3n ERA Apur\\u00edmac Comunicaci\\u00f3n 4\\u00b0 Primaria\",\"descriptionExam\":\"evaluacion general\",\"totalPageExam\":\"12\",\"yearExam\":\"2018\",\"stateExam\":\"Oculto\",\"keywordExam\":\"compresion lectora__7SEPARATOR7__predicado__7SEPARATOR7__oraciones compuestas\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-10-15T03:46:21.000000Z\",\"updated_at\":\"2023-12-12T06:10:26.000000Z\"}','2023-12-12','2023-12-12 01:10:26','2023-12-12 01:10:26'),('657d375e5fb6d','64192d94c2741','65529aba40e41','Modificación','{\"idExam\":\"65529aba40e41\",\"idTypeExam\":\"640bcb3725ac0\",\"idGrade\":\"641cf48b8e1b7\",\"idSubject\":\"641cd15b35194\",\"idDirection\":\"6577db49acd56\",\"codeExam\":\"12\",\"nameExam\":\"2\\u00b0 Evaluaci\\u00f3n ERA Apur\\u00edmac Comunicaci\\u00f3n 1\\u00b0 Primaria\",\"descriptionExam\":\"Evaluacion regional de apurimac\",\"totalPageExam\":\"11\",\"yearExam\":\"2018\",\"stateExam\":\"Publico\",\"keywordExam\":\"sujeto__7SEPARATOR7__oraciones__7SEPARATOR7__tilde\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-11-13T21:52:58.000000Z\",\"updated_at\":\"2023-12-16T05:36:30.000000Z\"}','2023-12-16','2023-12-16 00:36:30','2023-12-16 00:36:30'),('6588ec14078b0','64192d94c2741','6588ec13ec3e2','Registro','{\"idExam\":\"6588ec13ec3e2\",\"idTypeExam\":\"640bcb3725ac0\",\"idGrade\":\"6518e4d1ebfd8\",\"idSubject\":\"641f76356ced4\",\"idDirection\":\"657d2485a657d\",\"codeExam\":13,\"nameExam\":\"3\\u00b0 Evaluaci\\u00f3n ERA Ayacucho Matem\\u00e1tica 2\\u00b0 Secundaria\",\"descriptionExam\":\"Evaluaci\\u00f3n que se dio en el a\\u00f1o 2023, siendo el ultimo de la trimestre\",\"totalPageExam\":\"12\",\"yearExam\":\"2023\",\"stateExam\":\"Publico\",\"keywordExam\":\"conjunto unitario__7SEPARATOR7__funciones__7SEPARATOR7__operacion de potenciaci\\u00f3n\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-12-25T02:42:28.000000Z\",\"updated_at\":\"2023-12-25T02:42:28.000000Z\"}','2023-12-24','2023-12-24 21:42:28','2023-12-24 21:42:28'),('6588ed82b2fe1','64192d94c2741','6588ed82b2399','Registro','{\"idExam\":\"6588ed82b2399\",\"idTypeExam\":\"640bcb3725ac0\",\"idGrade\":\"6518e4ab706d5\",\"idSubject\":\"641cd15b35194\",\"idDirection\":\"6588ecf17e350\",\"codeExam\":14,\"nameExam\":\"2\\u00b0 Evaluaci\\u00f3n ERA Hu\\u00e1nuco Comunicaci\\u00f3n 4\\u00b0 Primaria\",\"descriptionExam\":\"Esta es la 2\\u00b0 evaluaci\\u00f3n de la regi\\u00f3n de huanuco\",\"totalPageExam\":\"12\",\"yearExam\":\"2016\",\"stateExam\":\"Publico\",\"keywordExam\":\"compresi\\u00f3n lectora__7SEPARATOR7__lectura\",\"extensionExam\":\"pdf\",\"statusAnwser\":0,\"created_at\":\"2023-12-25T02:48:34.000000Z\",\"updated_at\":\"2023-12-25T02:48:34.000000Z\"}','2023-12-24','2023-12-24 21:48:34','2023-12-24 21:48:34');
/*!40000 ALTER TABLE `tuserexam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tuserrole`
--

DROP TABLE IF EXISTS `tuserrole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tuserrole` (
  `idUserRole` char(13) NOT NULL,
  `idUser` char(13) NOT NULL,
  `idRole` char(13) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idUserRole`),
  KEY `idUser` (`idUser`),
  KEY `idRole` (`idRole`),
  CONSTRAINT `tuserrole_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `tuser` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tuserrole_ibfk_2` FOREIGN KEY (`idRole`) REFERENCES `trole` (`idRole`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tuserrole`
--

LOCK TABLES `tuserrole` WRITE;
/*!40000 ALTER TABLE `tuserrole` DISABLE KEYS */;
INSERT INTO `tuserrole` VALUES ('65150bc789fcf','65150bc7802f9','6515073a329ac','2023-09-28 00:14:47','2023-09-30 19:52:55'),('651624ddd7ffd','64192d94c2741','5ece4797eaf5e','2023-09-28 20:14:05','2023-09-28 20:14:05'),('651626641ddf9','651626641c1d3','5ece4797eaf5e','2023-09-28 20:20:36','2023-09-28 20:20:53'),('65eabb4caf590','65eabb4caebf0','6515074f590dc','2024-03-08 02:16:28','2024-03-08 02:16:28');
/*!40000 ALTER TABLE `tuserrole` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-19 15:44:39
