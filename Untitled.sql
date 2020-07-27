-- MySQL dump 10.13  Distrib 8.0.19, for macos10.15 (x86_64)
--
-- Host: 192.168.100.15    Database: wwipsi_actividades
-- ------------------------------------------------------
-- Server version	8.0.19

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
-- Table structure for table `actividad`
--

DROP TABLE IF EXISTS `actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `actividad` (
  `idactividad` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `idcreado` int DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `indicaciones` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `observaciones` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `tipo` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `terapia` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `track` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`idactividad`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividad`
--

LOCK TABLES `actividad` WRITE;
/*!40000 ALTER TABLE `actividad` DISABLE KEYS */;
INSERT INTO `actividad` VALUES (1,'Mi primer terapia',3,NULL,'Descripción de mi primer terapia x','Normal','evaluacion','enojo',NULL),(15,'cuiestionario 1',3,NULL,NULL,'hacer cuestionario 1','individual','ansiedad',NULL),(21,'Actividad inicial',1,NULL,'Actividad inicial','Inicial','normal','enojo',NULL),(22,'Mi Primer actividad',1,NULL,'INdicaciones','OBservaciones','normal','enojo',NULL);
/*!40000 ALTER TABLE `actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente_cuestionario`
--

DROP TABLE IF EXISTS `cliente_cuestionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente_cuestionario` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `idcliente` int DEFAULT NULL,
  `idcuestionario` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente_cuestionario`
--

LOCK TABLES `cliente_cuestionario` WRITE;
/*!40000 ALTER TABLE `cliente_cuestionario` DISABLE KEYS */;
INSERT INTO `cliente_cuestionario` VALUES (3,111,1),(4,111,2);
/*!40000 ALTER TABLE `cliente_cuestionario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `apellidop` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `apellidom` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `correo` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `pass` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `edad` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `sexo` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `peso` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `altura` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `enfermedades` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `medicamentos` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `galleta` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `fechacreado` datetime DEFAULT NULL,
  `autoriza` int DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `observaciones` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `idusuario` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_clienteid` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (111,'Gutierrez','Paterno','Torres','hola@xpika','202cb962ac59075b964b07152d234b70','27','masculino','80.5','1.83','Fresno 106','7711112386','','','b5RahFL6B0TzAl4','2020-04-11 12:54:56',1,'20200629234441_0_1780.jpg','Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore\r\nmagna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl\r\nut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent',3);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes_direccion`
--

DROP TABLE IF EXISTS `clientes_direccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes_direccion` (
  `iddireccion` int unsigned NOT NULL AUTO_INCREMENT,
  `idcliente` int DEFAULT NULL,
  `nombre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `apellidos` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `empresa` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `direccion1` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `entrecalles` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `numero` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `colonia` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `ciudad` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cp` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `pais` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `estado` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `mail` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `telefono` int DEFAULT NULL,
  `envio` int DEFAULT NULL,
  `factura` int DEFAULT NULL,
  PRIMARY KEY (`iddireccion`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes_direccion`
--

LOCK TABLES `clientes_direccion` WRITE;
/*!40000 ALTER TABLE `clientes_direccion` DISABLE KEYS */;
INSERT INTO `clientes_direccion` VALUES (5,414,NULL,NULL,NULL,'dir 1','calles','109','centro','pachuca','42000','mexico','hidalgo',NULL,NULL,NULL,NULL),(6,414,NULL,NULL,NULL,'dir nueva','nueva','nnueva','cnueva','cnueva','46666','cmexico','cestado',NULL,NULL,NULL,NULL),(8,414,NULL,NULL,NULL,'asda','asd','asd','asd','asd','1231','asd','asd',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `clientes_direccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contexto`
--

DROP TABLE IF EXISTS `contexto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contexto` (
  `idsubactividad` int unsigned NOT NULL AUTO_INCREMENT,
  `idactividad` int DEFAULT NULL,
  `idcreado` int DEFAULT NULL,
  `tipo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `texto` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `idpadre` int DEFAULT NULL,
  `incisos` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `personalizado` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `usuario` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`idsubactividad`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contexto`
--

LOCK TABLES `contexto` WRITE;
/*!40000 ALTER TABLE `contexto` DISABLE KEYS */;
INSERT INTO `contexto` VALUES (7,1,1,'video','Video\r\n<br>\r\n\r\n<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/7nooe94rQ2Q\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',NULL,NULL,NULL,NULL,NULL),(8,1,1,'pregunta','¿Cómo te sientes después de la primera terapia? escribe por que',NULL,NULL,NULL,NULL,'Descripcion'),(9,2,1,'video','Video',NULL,NULL,NULL,NULL,NULL),(10,21,1,'pregunta','Pregunta 1',NULL,'1',NULL,NULL,''),(11,21,1,'pregunta','Pregunta 22',NULL,NULL,NULL,NULL,''),(12,21,1,'pregunta','Pregunta 3',NULL,NULL,NULL,NULL,''),(13,1,1,'pregunta','Pregunta 23',NULL,'1','1','1','Texto descriptivo'),(14,22,1,'texto','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',NULL,NULL,NULL,NULL,NULL),(15,15,1,'pregunta','Como te hace sentir eso',NULL,'1','1','1','Texto descriptivo');
/*!40000 ALTER TABLE `contexto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuest_pregunta`
--

DROP TABLE IF EXISTS `cuest_pregunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cuest_pregunta` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `idcuestionario` int DEFAULT NULL,
  `pregunta` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tipo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `orden` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuest_pregunta`
--

LOCK TABLES `cuest_pregunta` WRITE;
/*!40000 ALTER TABLE `cuest_pregunta` DISABLE KEYS */;
INSERT INTO `cuest_pregunta` VALUES (1,1,'Pregunta','radio',2),(2,1,'Pregunta','radio',3),(3,1,'¿Cómo te sientes después de la primera terapia? escribe por que ','radio',1),(4,1,'Pregunta 7','radio',4),(5,1,'Pregunta','radio',6),(6,1,'Pregunta 5','respuesta',5),(7,1,'Pregunta','radio',9),(8,1,'Pregunta 8','radio',8),(9,1,'pregunta xyz','radio',12),(10,13,'pregyba','caja',1),(11,14,'Pregunta 1','caja',1),(12,14,'12312','caja',2),(13,15,'¿como te hace sentir eso?','radio',1),(14,14,'Resumen de lectura 1','respuesta',3),(15,1,'Pregunta','respuesta',7);
/*!40000 ALTER TABLE `cuest_pregunta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuest_respuesta`
--

DROP TABLE IF EXISTS `cuest_respuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cuest_respuesta` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `idpregunta` int DEFAULT NULL,
  `respuesta` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `valor` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `orden` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuest_respuesta`
--

LOCK TABLES `cuest_respuesta` WRITE;
/*!40000 ALTER TABLE `cuest_respuesta` DISABLE KEYS */;
INSERT INTO `cuest_respuesta` VALUES (1,3,'Feliz','1',1),(2,3,'triste','12',2),(3,3,'Enojado','3',3),(4,12,'Feliz','1',1),(5,13,'Bien','1',1),(6,13,'Mal','2',2),(7,13,'No lo se','4',3),(8,14,'Respuesta','1',1);
/*!40000 ALTER TABLE `cuest_respuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuestionario`
--

DROP TABLE IF EXISTS `cuestionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cuestionario` (
  `idcuestionario` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `idcreado` int DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `indicaciones` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `observaciones` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `tipo` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `terapia` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`idcuestionario`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuestionario`
--

LOCK TABLES `cuestionario` WRITE;
/*!40000 ALTER TABLE `cuestionario` DISABLE KEYS */;
INSERT INTO `cuestionario` VALUES (1,'Mi primer terapia',3,NULL,'Descripción de mi primer terapia','','individual','enojo'),(2,'Actividad 2',3,NULL,NULL,NULL,'individual','ansiedad'),(15,'cuiestionario 1',3,NULL,NULL,'hacer cuestionario 1','individual','ansiedad'),(14,'Entrevista inicial',3,NULL,NULL,'Entrevista inicial','inicial','ansiedad'),(16,'Actividad x COSA',1,NULL,'Indicaciones de x cosa','Texto','inicial','enojo');
/*!40000 ALTER TABLE `cuestionario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `respuestas`
--

DROP TABLE IF EXISTS `respuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `respuestas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `idsubactividad` int DEFAULT NULL,
  `respuesta` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `valor` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `orden` int DEFAULT NULL,
  `imagen` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `respuestas`
--

LOCK TABLES `respuestas` WRITE;
/*!40000 ALTER TABLE `respuestas` DISABLE KEYS */;
INSERT INTO `respuestas` VALUES (1,8,'Feliz','1',1,NULL),(2,8,'triste','12',2,NULL),(3,8,'Enojado','3',3,NULL),(4,8,'Feliz','1',1,NULL),(5,8,'Bien','1',1,NULL),(6,8,'Mal','2',2,NULL),(7,8,'No lo se','4',3,NULL),(8,8,'Respuesta','1',1,NULL),(15,13,'Pleno',NULL,3,NULL),(14,13,'Enojado',NULL,2,'resp_202007232028264786.jpg'),(13,13,'Feliz',NULL,1,'resp_202007232028174411.jpg'),(16,13,'Estresado',NULL,4,NULL),(17,15,'Feliz',NULL,1,'resp_202007232047597491.jpg'),(18,15,'Enojado',NULL,2,'resp_202007232048134776.jpg');
/*!40000 ALTER TABLE `respuestas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subactividad`
--

DROP TABLE IF EXISTS `subactividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subactividad` (
  `idsubactividad` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `orden` int DEFAULT NULL,
  `pagina` int DEFAULT NULL,
  `idactividad` int DEFAULT NULL,
  `idcreado` int DEFAULT NULL,
  PRIMARY KEY (`idsubactividad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subactividad`
--

LOCK TABLES `subactividad` WRITE;
/*!40000 ALTER TABLE `subactividad` DISABLE KEYS */;
/*!40000 ALTER TABLE `subactividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terapias`
--

DROP TABLE IF EXISTS `terapias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `terapias` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terapias`
--

LOCK TABLES `terapias` WRITE;
/*!40000 ALTER TABLE `terapias` DISABLE KEYS */;
INSERT INTO `terapias` VALUES (2,'Pareja'),(3,'Infantil'),(5,'Terapia');
/*!40000 ALTER TABLE `terapias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `track`
--

DROP TABLE IF EXISTS `track`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `track` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `video` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `terapia` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `idusuario` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `track`
--

LOCK TABLES `track` WRITE;
/*!40000 ALTER TABLE `track` DISABLE KEYS */;
INSERT INTO `track` VALUES (1,'Track x','<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/V71ue-C2Q-U\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe> ','Pareja',1);
/*!40000 ALTER TABLE `track` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `idusuario` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `apellidop` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `apellidom` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `pass` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `autoriza` int DEFAULT NULL,
  `idfondo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `nivel` int DEFAULT NULL,
  `correo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `observaciones` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Soporte',NULL,NULL,'202cb962ac59075b964b07152d234b70',1,'fondo/27A.jpg',1,'omargg83@gmail.com','20200630003556_0_759.jpg',NULL),(2,'Steve',NULL,NULL,'202cb962ac59075b964b07152d234b70',1,'fondo/Fern_by_aalex04.jpg',1,'steve@gmail.com','20200630003556_0_759.jpg',NULL),(3,'Psicologo','paterno','materno','202cb962ac59075b964b07152d234b70',1,NULL,2,'correo2@gmail.com','20200630003556_0_759.jpg',NULL),(4,'master',NULL,NULL,'202cb962ac59075b964b07152d234b70',1,'fondo/Darkening_Clockwork_by_Matt_Katzenberger.jpg',1,'master@tic-shop.com.mx','20200630003556_0_759.jpg',NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-26 20:50:49
