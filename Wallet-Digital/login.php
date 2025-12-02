<?php
session_start();
include("conexion.php");

if ($_POST) {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    $consulta = $conexion->query("SELECT * FROM usuarios 
                                  WHERE username='$usuario' OR email='$usuario'");
    
    if ($consulta->num_rows > 0) {
        $datos = $consulta->fetch_assoc();

        if (password_verify($password, $datos["password"])) {
            $_SESSION["id"] = $datos["id"];
            $_SESSION["nombre"] = $datos["nombre"];
            $_SESSION["imagen"] = $datos["imagen"];

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<title>Iniciar Sesión</title>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- Tipografía profesional -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        background: linear-gradient(135deg, #8b5cf6, #dc2626, #7c3aed);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        font-family: 'Inter', sans-serif;
        color: #333;
    }

    /* Tarjeta estilo premium con glassmorphism avanzado */
    .login-card {
        width: 450px;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 25px;
        padding: 50px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        animation: fadeIn 0.8s ease;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, #667eea, transparent);
        opacity: 0.6;
    }

    .login-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(255, 255, 255, 0.5);
        background: rgba(255, 255, 255, 0.8);
    }

    .login-title {
        font-size: 32px;
        font-weight: 700;
        text-align: center;
        color: #1a1a2e;
        margin-bottom: 40px;
        letter-spacing: -0.5px;
    }

    /* Inputs premium con mejor diseño */
    .form-group {
        position: relative;
        margin-bottom: 30px;
    }

    .form-control {
        height: 56px;
        border-radius: 12px;
        padding-left: 50px;
        border: 2px solid #e1e5e9;
        transition: all 0.3s ease;
        font-size: 16px;
        background: #f8f9fa;
        font-family: 'Inter', sans-serif;
    }

    .form-control:focus {
        border-color: #00d4ff;
        box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
        outline: none;
    }

    /* Icono dentro del input */
    .input-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        color: #667eea;
    }

    /* Botón elegante con gradiente */
    .btn-login {
        width: 100%;
        height: 56px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        font-size: 18px;
        font-weight: 600;
        border-radius: 12px;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        margin-top: 15px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        cursor: pointer;
    }

    .btn-login:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    }

    /* Animación mejorada */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Responsividad */
    @media (max-width: 480px) {
        .login-card {
            width: 90%;
            padding: 30px;
        }

        .login-title {
            font-size: 28px;
        }
    }
</style>

</head>

<body>

<div class="login-card">

    <h2 class="login-title">Iniciar Sesión</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">

        <!-- Usuario -->
        <div class="form-group">
            <i class="bi bi-person input-icon"></i>
            <input type="text" name="usuario" class="form-control" placeholder="Usuario o Email" required>
        </div>

        <!-- Password -->
        <div class="form-group">
            <i class="bi bi-lock input-icon"></i>
            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
        </div>

        <button class="btn btn-login">Iniciar Sesión</button>

    </form>

</div>

</body>
</html>
