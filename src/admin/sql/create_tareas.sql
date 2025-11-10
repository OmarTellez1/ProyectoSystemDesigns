-- Migration: create tareas tables
CREATE TABLE IF NOT EXISTS `tareas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_creado` datetime NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `tarea_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tarea_id` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `asignado_por` int(11) DEFAULT NULL,
  `asignado_en` datetime DEFAULT NULL,
  `completado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_completado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tarea` (`tarea_id`),
  KEY `fk_usuario` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Optionally add foreign keys if desired (uncomment):
-- ALTER TABLE `tarea_usuarios` ADD CONSTRAINT `tarea_usuarios_ibfk_1` FOREIGN KEY (`tarea_id`) REFERENCES `tareas` (`id`);
-- ALTER TABLE `tarea_usuarios` ADD CONSTRAINT `tarea_usuarios_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`);
