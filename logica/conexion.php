<?php

require_once 'logica.php';

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);

    // Configurar PDO para que lance excepciones en caso de errores
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Configurar el conjunto de caracteres a UTF-8
    $pdo->exec('SET NAMES utf8');
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>