<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'];
    $test_type = $_POST['test_type'];
    $credentials_or_search_term = $_POST['credentials_or_search_term'];
    $file_name = $_POST['file_name'];

    $command = escapeshellcmd("python web_scraping.py \"$url\" \"$test_type\" \"$credentials_or_search_term\" \"$file_name\"");
    $output = shell_exec($command);

    if ($output) {
        echo "Archivo CSV generado exitosamente: $file_name\n";
        //echo "Resultados del scraping:\n$output";
    } else {
        echo "Error: No se pudo generar el archivo CSV.";
    }
}
?>
