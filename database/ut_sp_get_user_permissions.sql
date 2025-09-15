/*
* Procedimiento para obtener los permisos por usuario
*/
CREATE PROCEDURE ut_sp_get_user_permissions (
    IN p_vista VARCHAR(3),
    IN p_user_id INT,
    IN p_rol VARCHAR(45),
    IN p_usuario VARCHAR(50),
    IN p_correo VARCHAR(100)
) 
BEGIN 
    IF p_vista = 'R' THEN 
        -- Permisos por roles
        SELECT padre.id_pagina id_padre , padre.nombre nombre_padre
            , hijo.id_pagina id_hijo , hijo.nombre nombre_hijo 
            , r.nombre rol 
            , JSON_ARRAYAGG(p.nombre) AS permisos
        FROM usuario_rol ur 
        JOIN ut_permiso_rol_pagina uprp ON ur.id_rol = uprp.id_rol 
        JOIN rol r ON uprp.id_rol  = r.id_rol
        JOIN ut_permiso p ON uprp.id_permiso = p.id_permiso 
        JOIN ut_pagina hijo ON uprp.id_pagina = hijo.id_pagina
        JOIN ut_pagina padre ON hijo.id_padre = padre.id_pagina
        WHERE uprp.activo = 1
        AND (p_rol IS NULL OR r.nombre LIKE CONCAT('%', ISNULL(p_rol, ''), '%'))
        GROUP BY padre.id_pagina , padre.nombre 
            , hijo.id_pagina , hijo.nombre 
            , r.nombre;
    ELSEIF p_vista = 'U' THEN 
        -- Permisos directos por usuarios
        SELECT padre.id_pagina id_padre , padre.nombre nombre_padre
            , hijo.id_pagina id_hijo , hijo.nombre nombre_hijo 
            , CONCAT(u.apellidos , ' , ' , u.nombre) usuario , u.correo
            , JSON_ARRAYAGG(p.nombre) permisos 
        FROM ut_permiso_user_pagina upup 
        JOIN usuario u ON upup.id_usuario = u.id_usuario
        JOIN ut_permiso p ON upup.id_permiso = p.id_permiso 
        JOIN ut_pagina hijo ON upup.id_pagina = hijo.id_pagina
        JOIN ut_pagina padre ON hijo.id_padre = padre.id_pagina
        WHERE upup.activo = 1
        GROUP BY padre.id_pagina , padre.nombre 
            , hijo.id_pagina , hijo.nombre 
            , u.apellidos , u.nombre , u.correo;
    ELSE 
        -- Permisos por usuario
        WITH PermisosUsuario AS (
            -- Permisos directos del usuario
            SELECT DISTINCT up.id_pagina 
            FROM ut_permiso_user_pagina upup 
            JOIN ut_pagina up ON upup.id_pagina = up.id_pagina
            WHERE upup.id_usuario = p_user_id

            UNION

            -- Permisos por roles del usuario
            SELECT DISTINCT up.id_pagina
            FROM usuario_rol ur 
            JOIN ut_permiso_rol_pagina uprp ON ur.id_rol = uprp.id_rol 
            JOIN ut_pagina up ON uprp.id_pagina = up.id_pagina
            WHERE ur.id_usuario = p_user_id
        )
        SELECT 
            padre.id_pagina AS id_padre,
            padre.nombre AS nombre_padre,
            hijo.id_pagina AS id_hijo,
            hijo.nombre AS nombre_hijo,
            hijo.ruta , hijo.componente 
        FROM PermisosUsuario pu
        JOIN ut_pagina hijo ON hijo.id_pagina = pu.id_pagina
        LEFT JOIN ut_pagina padre ON hijo.id_padre = padre.id_pagina
        ORDER BY padre.nombre, hijo.nombre;
    END IF;
END;
