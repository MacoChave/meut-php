CREATE PROCEDURE ut_sp_m_pagina_rol (
    IN p_id_pagina INT,
    IN p_id_rol INT,
    IN p_permisos JSON 
) BEGIN 
    -- Declarar variables
    DECLARE i INT DEFAULT 0;
    DECLARE v_len INT DEFAULT 0;
    DECLARE v_permiso VARCHAR(50);
    DECLARE v_id_permiso INT;

    -- Manejo de errores y transacciones
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN 
        ROLLBACK; 
        RESIGNAL; 
    END; 

    START TRANSACTION; 
    
    -- Proteger si p_permisos es NULL 
    SET v_len = IFNULL(JSON_LENGTH(p_permisos), 0);

    -- Soft delete de los permisos existentes
    UPDATE ut_permiso_rol_pagina 
    SET activo = 0 
    WHERE id_pagina = p_id_pagina 
      AND id_rol = p_id_rol 
      AND activo = 1;

    -- Iterar sobre el JSON de permisos
    WHILE i < v_len DO
        SET v_permiso = JSON_UNQUOTE(JSON_EXTRACT(p_permisos, CONCAT('$[', i, ']')));

        -- Obtener el id del permiso
        SELECT id_permiso INTO v_id_permiso 
        FROM ut_permiso 
        WHERE nombre = v_permiso
        LIMIT 1;

        -- Insertar o reactivar el permiso en ut_permiso_rol_pagina
        INSERT INTO ut_permiso_rol_pagina (id_pagina, id_rol, id_permiso, activo) 
        VALUES (p_id_pagina, p_id_rol, v_id_permiso, 1)
        ON DUPLICATE KEY UPDATE activo = 1;

        SET i = i + 1;
    END WHILE;

    SELECT 'Permisos actualizados correctamente' AS mensaje;

    COMMIT; 
END;