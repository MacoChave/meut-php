<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
require __DIR__ . '/../helpers/vite.php';

$manifest = json_decode(file_get_contents(__DIR__ . '/dist/.vite/manifest.json'), true);
$entry = $manifest['src/main.ts'];
$jsFile = $entry['file'] ?? 'app.js';
$cssFile = $entry['css'][0] ?? null;

echo '<!-- ' . json_encode($manifest) . ' -->';

$articulos = [
    ["id" => 1, "nombre" => "Artículo 1", "precio" => 10.00],
    ["id" => 2, "nombre" => "Artículo 2", "precio" => 15.50],
    ["id" => 3, "nombre" => "Artículo 3", "precio" => 7.25],
    ["id" => 4, "nombre" => "Artículo 4", "precio" => 12.30],
    ["id" => 5, "nombre" => "Artículo 5", "precio" => 9.99]
];
?>

<!DOCTYPE html>
<html lang="es" translate="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP + Vue SSR Simulado</title>
    <!-- <link rel="stylesheet" href="/dist/<?php echo $cssFile ?>"> -->
    <?php echo vite('src/main.ts') ?>
</head>

<body class="">
    <div id="app">
        <h1 class="text-xl font-bold">Contenido desde PHP</h1>
        <ul class="list-disc ml-6">
            <?php foreach ($articulos as $articulo): ?>
                <li>
                    <strong>
                        <?
                        htmlspecialchars($articulo['nombre'], ENT_QUOTES, 'UTF-8');
                        ?>
                    </strong>
                    <?
                    htmlspecialchars($articulo['precio'], ENT_QUOTES, 'UTF-8');
                    ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <!-- Aquí Vue hidrata encima -->
    </div>

    <!-- <script type="module" src="/dist/<?php echo $jsFile ?>"></script> -->
</body>

</html>