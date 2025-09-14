/* GESTIONES */
INSERT INTO ut_pagina (nombre, descripcion, ruta, componente, icono, indice , id_padre )
VALUES
('Gestiones', 'Página para la gestión de agrupadores', null, null, 'settings', 1, null),


INSERT INTO ut_pagina (nombre, descripcion, ruta, componente, icono, indice , id_padre )
VALUES
('Usuario', 'Página para la gestión de usuarios', '/gestion/usuario', 'gestion/pages/Usuario.vue', 'users', 1, null),
('Curso', 'Página para la gestión de cursos', '/gestion/curso', 'gestion/pages/Curso.vue', 'book', 2, null),
('Horario', 'Página para la gestión de horarios', '/gestion/horario', 'gestion/pages/Horario.vue', 'calendar', 3, null),
('Jornada', 'Página para la gestión de jornadas', '/gestion/jornada', 'gestion/pages/Jornada.vue', 'calendar', 4, null);

/* SEGURIDAD */
INSERT INTO ut_pagina (nombre, descripcion, ruta, componente, icono, indice , id_padre )
VALUES
('Seguridad', 'Página para la gestión de la seguridad', null, null, 'lock', 2, null)


INSERT INTO ut_pagina (nombre, descripcion, ruta, componente, icono, indice , id_padre )
VALUES
('Páginas', 'Página para la gestión de usuarios', '/seguridad/paginas', 'seguridad/pages/Paginas.vue', 'list', 1, null),
('Permisos por rol', 'Página para los permisos por rol', '/seguridad/permiso-rol', 'seguridad/pages/PermisoRol.vue', 'key', 2, null),
('Permisos por usuario', 'Página para los permisos por usuario', '/seguridad/permiso-usuario', 'seguridad/pages/PermisoUsuario.vue', 'user-shield', 3, null),
('Constantes', 'Página para la gestión de constantes', '/seguridad/constantes', 'seguridad/pages/Constantes.vue', 'key', 4, null);

/* ENCARGADO */
INSERT INTO ut_pagina (nombre, descripcion, ruta, componente, icono, indice , id_padre )
VALUES
('Encargado', 'Portal para asignar estudiantes y docentes', null, null, 'user-tie', 3, null);


INSERT INTO ut_pagina (nombre, descripcion, ruta, componente, icono, indice , id_padre )
VALUES
('Punto de tesis', '', '/encargado/punto-tesis', 'encargado/pages/PuntoTesis.vue', 'file-alt', 1, null),
('Curso 1', '', '/encargado/curso-1', 'encargado/pages/Curso1.vue', 'book', 1, null),
('Curso 2', '', '/encargado/curso-2', 'encargado/pages/Curso2.vue', 'book', 1, null),
('Comisión y Estilos', '', '/encargado/comision-estilos', 'encargado/pages/ComisionEstilos.vue', 'file-alt', 1, null),
('Previos Internos', '', '/encargado/previos-internos', 'encargado/pages/PreviosInternos.vue', 'file-alt', 1, null);

/* DOCENTE */
INSERT INTO ut_pagina (nombre, descripcion, ruta, componente, icono, indice , id_padre )
VALUES
('Docente', 'Portal para evaluar estudiantes', null, null, 'chalkboard-teacher', 4, null);


INSERT INTO ut_pagina (nombre, descripcion, ruta, componente, icono, indice , id_padre )
VALUES
('Punto de tesis', '', '/docente/punto-tesis', 'docente/pages/PuntoTesis.vue', 'file-alt', 1, null),
('Curso 1', '', '/docente/curso-1', 'docente/pages/Curso1.vue', 'book', 1, null),
('Curso 2', '', '/docente/curso-2', 'docente/pages/Curso2.vue', 'book', 1, null),
('Comisión y Estilos', '', '/docente/comision-estilos', 'docente/pages/ComisionEstilos.vue', 'file-alt', 1, null),
('Previos Internos', '', '/docente/previos-internos', 'docente/pages/PreviosInternos.vue', 'file-alt', 1, null);

/* ESTUDIANTE */
INSERT INTO ut_pagina (nombre, descripcion, ruta, componente, icono, indice , id_padre )
VALUES
('Estudiante', 'Portal para estudiantes', null, null, 'chalkboard-teacher', 4, null);


INSERT INTO ut_pagina (nombre, descripcion, ruta, componente, icono, indice , id_padre )
VALUES
('Punto de tesis', '', '/estudiante/punto-tesis', 'estudiante/pages/PuntoTesis.vue', 'file-alt', 1, null),
('Curso 1', '', '/estudiante/curso-1', 'estudiante/pages/Curso1.vue', 'book', 1, null),
('Curso 2', '', '/estudiante/curso-2', 'estudiante/pages/Curso2.vue', 'book', 1, null),
('Comisión y Estilos', '', '/estudiante/comision-estilos', 'estudiante/pages/ComisionEstilos.vue', 'file-alt', 1, null),
('Previos Internos', '', '/estudiante/previos-internos', 'estudiante/pages/PreviosInternos.vue', 'file-alt', 1, null);

/* GENERAL */
INSERT INTO ut_pagina (nombre, descripcion, ruta, componente, icono, indice , id_padre )
VALUES
('Progreso', '', '/progreso', 'general/pages/Progreso.vue', 'chart-line', 6, null);
