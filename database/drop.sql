-- 
-- -----------------------------------------------
--  DROP TRIGGERS
-- -----------------------------------------------
--  
drop trigger if exists ut_tr_aftins_usuario;
drop trigger if exists ut_tr_aftins_tesis;
drop trigger if exists ut_tr_aftupd_tesis; 
drop trigger if exists ut_tr_aftins_rol;
drop trigger if exists ut_tr_aftins_page;
-- 
-- -----------------------------------------------
--  DROP FUNCTIONS
-- -----------------------------------------------
-- 
-- 
-- -----------------------------------------------
--  DROP PROCEDURES
-- -----------------------------------------------
-- 
drop procedure if exists ut_sp_crear_usuario;
-- 
-- -----------------------------------------------
--  DROP VIEWS
-- -----------------------------------------------
-- 
drop view if exists 
	ut_v_rol , 
	ut_v_revision , 
	ut_v_asignacion , 
	ut_v_usuarios , 
	ut_v_cursos , 
	ut_v_cursotutor , 
	ut_v_notification , 
	ut_v_chat , 
	ut_v_resumen;
-- 
-- -----------------------------------------------
--  DROP TABLES
-- -----------------------------------------------
-- 
drop table if exists 
	departamento,
	municipio,
	ut_jornada,
	ut_horario,
	ut_pagina,
	usuario,
	rol,
	usuario_rol,
	ut_permiso,
	ut_perfil,
	ut_curso,
	ut_curso_tutor,
	ut_asignacion,
	ut_bitacora,
	ut_notificacion,
	ut_tesis,
	ut_revision;
