<?php
include_once 'logica/conexion.php';

// Verificar si el formulario de inicio de sesión ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Recuperar los valores del formulario
   $correo = $_POST["correo"];
   $contrasena = $_POST["contrasena"];

   // Validar que ambos campos estén llenos
   if (!empty($correo) && !empty($contrasena)) {
    try {
        // Consultar la base de datos para obtener el usuario con el correo proporcionado
        $check_user_sql = "SELECT * FROM usuarios WHERE email = :correo";
        $check_user_stmt = $pdo->prepare($check_user_sql);
        $check_user_stmt->bindParam(':correo', $correo);
        $check_user_stmt->execute();
        $user = $check_user_stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
          // Verificar la contraseña
          if (password_verify($contrasena, $user['contrasena'])) {
              // Iniciar sesión
              session_start();

              // Almacenar información del usuario en las variables de sesión
              $_SESSION['user_id'] = $user['id'];  // Reemplaza 'id' con el nombre real de tu columna de identificación de usuario
              $_SESSION['user_nombre'] = $user['nombre_apellido'];  // Reemplaza 'nombre' con el nombre real de tu columna de nombre de usuario
              $_SESSION['user_email'] = $user['email'];

              // Redireccionar a la página de inicio
              header("Location: index.php");
              exit();
          } else {
              // Redireccionar si la contraseña es incorrecta
              header("Location: login.php?pass_error");
              exit();
          }
      } else {
          // Redireccionar si el correo no está registrado
          header("Location: login.php?mail_error");
          exit();
      }
    } catch (PDOException $e) {
        echo "Error al iniciar sesión: " . $e->getMessage();
    }
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
  <title>Login Form</title>
  <!---Custom CSS File--->
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <header>Login</header>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <input type="email" name="correo" placeholder="Enter your email">
        <input type="password" name="contrasena" placeholder="Enter your password">

        <a href="#">Forgot password?</a>
        <input type="submit" class="button" value="Login">
      </form>
      <div class="signup">
        <span class="signup">Don't have an account?
          <a href="register.php">Signup</a>
        </span>
      </div>
    </div>
  </div>
</body>

</html>