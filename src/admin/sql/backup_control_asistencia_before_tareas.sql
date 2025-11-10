-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: control_asistencia
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `asistencia`
--

DROP TABLE IF EXISTS `asistencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asistencia` (
  `idasistencia` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_persona` varchar(20) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tipo` varchar(45) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`idasistencia`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asistencia`
--

LOCK TABLES `asistencia` WRITE;
/*!40000 ALTER TABLE `asistencia` DISABLE KEYS */;
INSERT INTO `asistencia` VALUES (134,'123e','2025-09-25 02:15:48','Entrada','2025-09-24'),(135,'8VwqyL','2025-10-07 02:07:26','Entrada','2025-10-06'),(136,'hola1','2025-10-07 02:12:33','Entrada','2025-10-06');
/*!40000 ALTER TABLE `asistencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamento` (
  `iddepartamento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `fechacreada` datetime NOT NULL,
  `idusuario` varchar(45) NOT NULL,
  PRIMARY KEY (`iddepartamento`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento`
--

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
INSERT INTO `departamento` VALUES (1,'Analista de cr├®ditos','asesor de ventas','2025-10-05 00:00:00','1'),(2,'Promotor de ahorro y cr├®dito','trabajo de promoci├│n','2025-10-05 00:15:24','1'),(3,'Gerencia','representante legal','2025-10-05 21:24:52','1'),(4,'Administraci├│n','encargado de agencia','2025-10-05 21:25:08','1'),(5,'Recibidor(a)/Pagador(a)','encargado de los movimientos de caja','2025-10-05 21:25:45','1'),(6,'Vigilancia','vigilante diurno','2025-10-05 21:26:14','1'),(7,'Limpieza','encargado de la limpieza de oficinas','2025-10-05 21:26:50','1');
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mensajes` (
  `idmensaje` int(11) NOT NULL AUTO_INCREMENT,
  `idusuariomensaje` int(11) NOT NULL,
  `textomensaje` text NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  `fechamensaje` datetime NOT NULL,
  `fechacreada` datetime NOT NULL,
  `idusuario` int(11) NOT NULL,
  PRIMARY KEY (`idmensaje`),
  KEY `idusuario` (`idusuario`),
  CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensajes`
--

LOCK TABLES `mensajes` WRITE;
/*!40000 ALTER TABLE `mensajes` DISABLE KEYS */;
INSERT INTO `mensajes` VALUES (2,1,'hola, esto es un mensaje de prueba del sistema de usuarios',1,'2025-10-01 00:00:00','2025-10-01 00:00:00',1);
/*!40000 ALTER TABLE `mensajes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipousuario`
--

DROP TABLE IF EXISTS `tipousuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipousuario` (
  `idtipousuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `fechacreada` datetime NOT NULL,
  `idusuario` varchar(45) NOT NULL,
  PRIMARY KEY (`idtipousuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipousuario`
--

LOCK TABLES `tipousuario` WRITE;
/*!40000 ALTER TABLE `tipousuario` DISABLE KEYS */;
INSERT INTO `tipousuario` VALUES (1,'Administrador','Con priviliegios de gestionar todo el sistema','2025-09-30 00:00:00','1'),(2,'Vendedor','vende y promueve los productos','2025-09-30 00:30:13','admin');
/*!40000 ALTER TABLE `tipousuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `login` varchar(45) NOT NULL,
  `iddepartamento` int(11) NOT NULL,
  `idtipousuario` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(64) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  `fechacreado` datetime NOT NULL,
  `usuariocreado` varchar(45) NOT NULL,
  `codigo_persona` varchar(20) DEFAULT NULL,
  `idmensaje` int(11) NOT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `codigo_persona` (`codigo_persona`),
  KEY `fk_departamento` (`iddepartamento`),
  KEY `fk_tiposusario` (`idtipousuario`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`iddepartamento`) REFERENCES `departamento` (`iddepartamento`),
  CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`idtipousuario`) REFERENCES `tipousuario` (`idtipousuario`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'admin','valverde','admin',1,1,'kevalverde@est.ecotec.edu.ec','8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918','default.jpg',1,'2025-09-30 00:00:00','admin','444',1),(15,'kevin','valverde','kevin',3,2,'kevalverde@est.ecotec.edu.ec','b221d9dbb083a7f33428d7c2a3c3198ae925614d70210e28716ccaa7cd4ddb79','',1,'2025-09-03 18:36:52','kevin','hola',0),(18,'felipe','garzon','felipe',6,2,'kevve@hotmal.com','8761bc707d28b114733653f5255e8d13ab8868925176ad2c0942231fa311e30a','',1,'2025-09-24 20:14:05','felipe','123e',0),(19,'carlos','cujilema','carlos',6,2,'carlos@hotmal.com','ec216fb204db213fecf8a4a72363a84fc97d5d1e3ec362eaf42a69ce6a025e16','',1,'2025-10-06 20:11:42','carlos','hola1',0),(20,'santi','mullo','santi',7,2,'kevve@hotmal.com','e633f4fc79badea1dc5db970cf397c8248bac47cc3acf9915ba60b5d76b0e88f','1760322658.jpg',1,'2025-10-12 20:30:58','santi','1345',0),(21,'camila','gonzales','camila',6,2,'camila@gmail.com','489ca219174f91b48313c188f4c998a5413fcaf194a93fd8e24bbdb178dc8f3a','1760327897.jpg',1,'2025-10-12 21:58:17','camila','Hola',0),(22,'Julio','Astudillo','julio',2,2,'j.astudillo@est.ecotec.edu.ec','06d5e4e62193e60a114967a26c6793e48d0430dfcbecd5240bb7c44713b3ab18','',1,'2025-11-09 20:31:16','Julio','YuxeuE',0);
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

-- Dump completed on 2025-11-10  0:08:28
