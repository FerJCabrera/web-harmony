<?php
require_once 'bootstrap.php';

header('Content-Type: application/json');

$response = array();

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $url = $_POST['url'] ?? '';
        $user = $_POST['user'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $search_term = $_POST['search_term'] ?? '';
        $report_name = $_POST['report_name'] ?? 'reporte.csv';

        if (empty($url) || empty($search_term) || empty($report_name)) {
            throw new Exception('Datos incompletos.');
        }

        // Comando para ejecutar el script de Python con los argumentos
        $command = escapeshellcmd("python " . __DIR__ . "C:\xampp\htdocs\projectsend\test_harmony\run_tests.py \"$url\" \"$user\" \"$email\" \"$password\" \"$search_term\" \"$report_name\"");
        error_log("Ejecutando comando: $command");

        // Ejecutar el comando y capturar la salida
        $output = shell_exec($command);
        error_log("Salida del comando: $output");

        if ($output === null) {
            throw new Exception('Error ejecutando el comando Python.');
        }

        // Verificar y limpiar la salida para asegurar que es JSON válido
        $output = trim($output);
        if (empty($output)) {
            throw new Exception('La salida del comando está vacía.');
        }

        $response = array(
            'status' => 'success',
            'message' => 'Pruebas completadas.',
            'output' => $output
        );
    } else {
        throw new Exception('Método no permitido.');
    }
} catch (Exception $e) {
    $response = array(
        'status' => 'error',
        'message' => $e->getMessage(),
        'output' => ''
    );
    error_log("Error: " . $e->getMessage());
}

echo json_encode($response);
?>
