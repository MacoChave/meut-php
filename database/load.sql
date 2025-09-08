-- 
-- ----------------------------------------
-- SELECT DATABASE
-- ----------------------------------------
-- 
use dev_meutdb;

-- 
-- ----------------------------------------
-- BULK INSERT
-- ----------------------------------------
-- 
-- ----------------------------------------
-- ROLES INSERT
-- ----------------------------------------
INSERT INTO dev_meutdb.rol (nombre,descripcion) VALUES
	 ('Super','Usuario con todos los permisos desbloqueados'),
	 ('Administrador','Personal encargado de gestionar el sistema'),
	 ('Encargado','Personal administrativo encargados de las estaciones'),
	 ('Docente','Personal administrativo para evaluar proyectos'),
	 ('Secretaria','Personal de reportes y asistencias'),
	 ('Estudiante','Usuario de pregrado');

-- ----------------------------------------
-- COURSES INSERT
-- ----------------------------------------
INSERT INTO dev_meutdb.ut_curso (nombre) VALUES
	 ('Introducción a la planeación científica'),
	 ('Elaboración y planeación de tesis');

-- ----------------------------------------
-- PAGES INSERT
-- ----------------------------------------
INSERT INTO dev_meutdb.ut_pagina (nombre,descripcion,ruta,id_padre,indice) VALUES
	 ('Administrador','','/administrador',NULL,0),
	 ('Encargado','','/encargado',NULL,0),
	 ('Docente','','/docente',NULL,0),
	 ('Secretaria','','/secretaria',NULL,0),
	 ('Estudiante','','/estudiante',NULL,0),
	 ('Reporte','','/reporte',NULL,0),
	 ('Aplicación','','/aplicacion',NULL,0),
	 ('Solicitud de impresiones','','/solicitud-impresion',1,0),
	 ('Impresión de tesis','','/impresion-tesis',1,0),
	 ('Asesor de tesis','','/asesor-tesis',4,0);
INSERT INTO dev_meutdb.ut_pagina (nombre,descripcion,ruta,id_padre,indice) VALUES
	 ('Punto de tesis','','/punto-tesis',2,0),
	 ('Curso I','','/curso-I',2,0),
	 ('Curso II','','/curso-II',2,0),
	 ('Comisión y Estilo','','/comision-y-estilos',2,0),
	 ('Previos Internos','','/previos-internos',2,0),
	 ('Punto de tesis','','/punto-tesis',3,0),
	 ('Curso I','','/curso-I',3,0),
	 ('Curso II','','/curso-II',3,0),
	 ('Comisión y Estilo','','/comision-y-estilos',3,0),
	 ('Previos Internos','','/previos-internos',3,0);
INSERT INTO dev_meutdb.ut_pagina (nombre,descripcion,ruta,id_padre,indice) VALUES
	 ('Punto de tesis','','/punto-tesis',4,0),
	 ('Curso I','','/curso-I',4,0),
	 ('Curso II','','/curso-II',4,0),
	 ('Comisión y Estilo','','/comision-y-estilos',4,0),
	 ('Previos Internos','','/previos-internos',4,0),
	 ('Punto de tesis','','/punto-tesis',5,0),
	 ('Mi progreso','','/progreso',5,0),
	 ('Curso I','','/curso-I',5,0),
	 ('Cambio de tema','','/cambio-tema',5,0),
	 ('Curso II','','/curso-II',5,0);
INSERT INTO dev_meutdb.ut_pagina (nombre,descripcion,ruta,id_padre,indice) VALUES
	 ('Comisión y Estilo','','/comision-y-estilos',5,0),
	 ('Previos Internos','','/previos-internos',5,0),
	 ('Solicitud de Impresión','','/solicitud-impresion',5,0),
	 ('Entrega de tesis','','/entrega-tesis',5,0),
	 ('Resumen','','/resumen',6,0),
	 ('Progreso','','/progresos',6,0),
	 ('Paginas','Gestión de nombres de páginas','/paginas',7,2),
	 ('Usuarios','Gestión de usuarios del sistema','/usuarios',7,1),
	 ('Horarios','','/horarios',7,0),
	 ('Cursos','','/cursos',7,0);
INSERT INTO dev_meutdb.ut_pagina (nombre,descripcion,ruta,id_padre,indice) VALUES
	 ('Accesos','','/accesos-rol',7,0);

-- ----------------------------------------
-- SUPER ADMIN INSERT - pwd: super.admin1234
-- ----------------------------------------
INSERT INTO dev_meutdb.usuario (nombre,apellidos,genero,correo,pass,direccion,fecha_nac,estado,fecha_creacion,id_municipio,doc_cui,carnet,cui) VALUES
	 ('Super','Admin','M','super.admin@test.com','$2b$10$ak6R7du37WtH9MiV5OUoTe.x2DS65F8op4qnyLjIcZerQxkyoO6w6','Guatemala','2023-01-01','','2023-12-07 23:30:50',1,NULL,123456789,'1234 56789 1234');
