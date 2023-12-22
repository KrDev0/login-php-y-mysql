<?php
include_once 'logica/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    if (!empty($nombre) && !empty($correo) && !empty($contrasena)) {
        try {
            $check_email_sql = "SELECT email FROM usuarios WHERE email = :correo";
            $check_email_stmt = $pdo->prepare($check_email_sql);
            $check_email_stmt->bindParam(':correo', $correo);
            $check_email_stmt->execute();

            if ($check_email_stmt->fetch(PDO::FETCH_ASSOC)) {
                // Redireccionar si el correo ya está registrado
                header("Location: register.php?email_reg");
                exit();
            }

             // Cifrar la contraseña con la función password_hash
             $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

             // Preparar la consulta SQL para insertar datos en la tabla usuarios
             $sql = "INSERT INTO usuarios (nombre_apellido, email, contrasena) VALUES (:nombre, :correo, :contrasena)";
             $stmt = $pdo->prepare($sql);
 
             // Bindear parámetros
             $stmt->bindParam(':nombre', $nombre);
             $stmt->bindParam(':correo', $correo);
             $stmt->bindParam(':contrasena', $hashed_password);
 
             // Ejecutar la consulta
             $stmt->execute();
 
             // Redireccionar si el registro es exitoso
             header("Location: login.php?ok");
             exit();

           
        } catch (PDOException $e) {
            echo "Error al registrar: " . $e->getMessage();
        }
    } else {
        header("Location: register.php?falta_campo");
        exit();
    }
}
?>

<!DOCTYPE html>
<!---Coding By CoderGirl | www.codinglabweb.com--->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration Form</title>
    <!---Custom CSS File--->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="registration form">
            <header>Signup</header>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" name="nombre" placeholder="Enter your name">
                <input type="email" name="correo" placeholder="Enter your email">
                <input type="password" name="contrasena" placeholder="Create a password">
                <input type="submit" class="button" value="Signup">
            </form>
            <div class="signup">
                <span class="signup">Already have an account?
                    <a href="login.php">Login</a>
                </span>
            </div>
        </div>
    </div>
</body>

</html>