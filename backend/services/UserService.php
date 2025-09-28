<?php

namespace Services;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UserService
{
    public function getUserById(int $id): ?array
    {
        // Aquí iría la lógica para obtener el usuario desde la base de datos
        // Por simplicidad, devolvemos un usuario simulado
        return [
            'id' => $id,
            'name' => 'Usuario ' . $id,
            'email' => 'user' . $id . '@example.com'
        ];
    }

    /**
     * Genera el Excel con PhpSpreadsheet y lo devuelve como un archivo descargable.
     */
    public function getUserTemplatePath(): string
    {
        // Crea el objeto
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Usuarios');

        // Define los encabezados
        // Nombres: string, Apellidos: string, Correo electrónico: string, Dirección: string, Teléfono: int, Fecha de nacimiento:date, No. Registro: int, CUI: int, Rol: string, Estación actual: string, Evidencia de estación: string
        $headers = [
            ['column' => 'Nombre', 'type' => DataType::TYPE_STRING, 'comment' => 'El nombre debe contener solo letras y espacios. No se permiten números ni caracteres especiales.'],
            ['column' => 'Apellido', 'type' => DataType::TYPE_STRING, 'comment' => 'El apellido debe contener solo letras y espacios. No se permiten números ni caracteres especiales.'],
            ['column' => 'Correo electrónico', 'type' => DataType::TYPE_STRING],
            ['column' => 'Dirección', 'type' => DataType::TYPE_STRING],
            ['column' => 'Teléfono', 'type' => DataType::TYPE_NUMERIC],
            ['column' => 'Fecha de nacimiento', 'type' => DataType::TYPE_ISO_DATE],
            ['column' => 'No. Registro', 'type' => DataType::TYPE_NUMERIC],
            ['column' => 'CUI', 'type' => DataType::TYPE_NUMERIC],
            ['column' => 'Rol', 'type' => DataType::TYPE_STRING, 'comment' => 'El rol debe ser uno de los siguientes: Administrador, Usuario, Invitado.', 'validate' => ['Administrador', 'Estudiante', 'Docente', 'Encargado']],
            ['column' => 'Estación actual', 'type' => DataType::TYPE_NULL],
            ['column' => 'Evidencia de estación', 'type' => DataType::TYPE_NULL]
        ];

        // Agrega los encabezados a la primera fila
        foreach ($headers as $index => $header) {
            $col = Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($col . '1', $header['column']);

            // Agrega comentario si existe
            if (isset($header['comment'])) {
                $sheet->getComment($col . '1')->getText()->createTextRun($header['comment']);
            }

            // Ajustar ancho automático
            $sheet->getColumnDimension($col)->setAutoSize(true);

            // Agrega validación de datos si existe
            if (isset($header['validate'])) {
                $validation = $sheet->getCell($col . '2')->getDataValidation();
                $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
                $validation->setAllowBlank(true);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Valor inválido');
                $validation->setError('El valor ingresado no es válido. Por favor, selecciona un valor de la lista.');
                $validation->setPromptTitle('Selecciona un valor');
                $validation->setPrompt('Por favor, selecciona un valor de la lista.');
                $validation->setFormula1('"' . implode(',', $header['validate']) . '"');
            }

            // Establece el tipo de dato para la columna (aplica a toda la columna)
            if ($header['type'] === DataType::TYPE_NUMERIC)
                $sheet->getStyle($col . '2')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
            if ($header['type'] === DataType::TYPE_ISO_DATE)
                $sheet->getStyle($col . '2')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
        }

        // Agregar una fila de ejemplo
        $example = [
            'Juan',
            'Pérez',
            'juan@example.com',
            'Zona 1, Ciudad',
            55555555,
            '1990-05-15',
            123,
            9876543210101,
            'Estudiante',
            '',
            ''
        ];
        foreach ($example as $index => $value) {
            $col = Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValueExplicit($col . '2', $value, $headers[$index]['type']);
        }

        // Guarda el archivo temporal
        $writer = new Xlsx($spreadsheet);
        $filePath = __DIR__ . '/../../templates/user_template.xlsx';
        $writer->save($filePath);
        return $filePath;
    }
}
