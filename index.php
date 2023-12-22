<?php

session_start();
if (!isset($_GET['invitado'])) {
    if (!isset($_SESSION['user_id'])) {
        // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
        header("Location: index.php?invitado");
        exit();
    }
}
if (!isset($_GET['invitado'])) {
    // Obtener el ID del usuario desde la variable de sesión
    $user_id = $_SESSION['user_id'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php if (!isset($_GET['invitado'])) : ?>
        <p><?php echo $_SESSION['user_id']; ?></p>
        <p><?php echo $_SESSION['user_email']; ?></p>
        <p><?php echo $_SESSION['user_nombre']; ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['invitado'])) : ?>
        <p>Invitado</p>
    <?php endif; ?>
</body>

</html>