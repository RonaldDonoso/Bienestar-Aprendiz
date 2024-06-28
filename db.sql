
CREATE TABLE `citas` (
  `id_cita` int NOT NULL,
  `primer_nombre` varchar(45) DEFAULT NULL,
  `segundo_nombre` varchar(45) DEFAULT NULL,
  `primer_apellido` varchar(45) DEFAULT NULL,
  `segundo_apellido` varchar(45) DEFAULT NULL,
  `tipo_documento` varchar(45) DEFAULT NULL,
  `numero_documento` varchar(45) DEFAULT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `num_ficha` varchar(45) DEFAULT NULL,
  `asunto` varchar(45) DEFAULT NULL,
  `fecha` varchar(45) DEFAULT NULL,
  `hora` varchar(45) DEFAULT NULL,
  `estado_cita` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_cita`)
) 
CREATE TABLE `eventos` (
  `id_evento` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `fecha_evento` varchar(45) DEFAULT NULL,
  `hora_evento` varchar(45) DEFAULT NULL,
  `lugar` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_evento`)
) 
CREATE TABLE `formulario_apoyo` (
  `id_formulario_apoyo` int NOT NULL AUTO_INCREMENT,
  `nombre_apoyo` varchar(45) DEFAULT NULL,
  `primer_nombre` varchar(45) DEFAULT NULL,
  `segundo_nombre` varchar(45) DEFAULT NULL,
  `primer_apellido` varchar(45) DEFAULT NULL,
  `segundo_apellido` varchar(45) DEFAULT NULL,
  `tipo_documento` varchar(45) DEFAULT NULL,
  `numero_documento` int DEFAULT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_formulario_apoyo`)
) 
CREATE TABLE `formulario_evento` (
  `id_formulario` int NOT NULL AUTO_INCREMENT,
  `primer_nombre` varchar(45) DEFAULT NULL,
  `segundo_nombre` varchar(45) DEFAULT NULL,
  `primer_apellido` varchar(45) DEFAULT NULL,
  `segundo_apellido` varchar(45) DEFAULT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `programa_formacion` varchar(45) DEFAULT NULL,
  `num_ficha` varchar(45) DEFAULT NULL,
  `id_jornada` varchar(45) DEFAULT NULL,
  `id_clasificacion_evento` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_formulario`)
) 
CREATE TABLE `mostrar_evento` (
  `id_evento` int NOT NULL,
  PRIMARY KEY (`id_evento`)
) 
CREATE TABLE `rol` (
  `id_rol` int NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) 

CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `primer_nombre` varchar(45) DEFAULT NULL,
  `segundo_nombre` varchar(45) DEFAULT NULL,
  `primer_apellido` varchar(45) DEFAULT NULL,
  `segundo_apellido` varchar(45) DEFAULT NULL,
  `tipo_documento` varchar(45) DEFAULT NULL,
  `numero_documento` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `contraseña` varchar(255) NOT NULL,
  `id_rol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) 