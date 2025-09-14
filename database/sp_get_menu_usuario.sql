/*
* Procedimiento para obtener los permisos por usuario
*/
CREATE PROCEDURE sp_get_user_permissions (
    IN p_user_id INT 
) 
BEGIN 
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

END;