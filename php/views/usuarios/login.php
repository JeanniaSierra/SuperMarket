<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }
        .login-form, .register-form {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-container {
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            background-color: white;
        }
        .message {
            margin-top: 10px;
            color: red;
        }
        .toggle-link {
            cursor: pointer;
            color: #007bff;
            text-decoration: underline;
        }
        .toggle-link:hover {
            color: #0056b3;
        }
        .ov-preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fefefe;
            z-index: 999999;
            height: 100%;
            width: 100%;
            overflow: hidden !important;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .ov-preloader .ov-icon {
            width: 100px;
            height: 100px;
            background-image: url('<?php echo BASE_URL; ?>public/img/mision.png');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            animation: slideIn 1s forwards;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }
        @keyframes slideOut {
            from { transform: translateX(0); }
            to { transform: translateX(-100%); }
        }
    </style>
</head>
<body>
    <div class="ov-preloader">
        <div class="ov-icon"></div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Área para imagen o contenido adicional -->
            </div>
            <div class="col-md-6">
                <div class="form-container">
                    <!-- Formulario de Login -->
                    <div id="loginFormContainer">
                        <h2 class="text-center mb-4">Iniciar Sesión</h2>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form id="loginForm" action="<?php echo BASE_URL; ?>?controller=usuario&action=login" method="POST">
                            <div class="mb-3">
                                <input type="text" id="documento" name="documento" class="form-control" placeholder="Documento" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
                            </div>
                            <div class="mb-3">
                                <select class="form-select" id="tipoUsuario" name="tipoUsuario" required>
                                    <option value="">Seleccione el tipo de usuario</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Vendedor">Vendedor</option>
                                    <option value="Comprador">Comprador</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <a href="<?php echo BASE_URL; ?>?controller=usuario&action=recoveryForm" class="d-block">¿Olvidaste tu contraseña?</a>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                        </form>
                        <p class="mt-3 text-center">¿No tienes cuenta? <span class="toggle-link" onclick="toggleForms()">Regístrate aquí</span></p>
                        <div id="message" class="message"></div>
                    </div>

                    <!-- Formulario de Registro -->
                    <div id="registerFormContainer" style="display: none;">
                        <h2 class="text-center mb-4">Registro de Usuario</h2>
                        <form id="registerForm" action="<?php echo BASE_URL; ?>?controller=usuario&action=register" method="POST">
                            <div class="mb-3">
                                <input type="text" id="registroDocumento" name="documento" class="form-control" placeholder="Documento" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" id="registroNombre" name="nombre" class="form-control" placeholder="Nombre" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" id="registroApellido" name="apellido" class="form-control" placeholder="Apellido" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" id="registroTelefono" name="telefono" class="form-control" placeholder="Teléfono" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" id="registroEmail" name="email" class="form-control" placeholder="Correo Electrónico" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" id="registroPassword" name="password" class="form-control" placeholder="Contraseña" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Registrarse</button>
                            </div>
                        </form>
                        <p class="mt-3 text-center">¿Ya tienes cuenta? <span class="toggle-link" onclick="toggleForms()">Inicia sesión aquí</span></p>
                        <div id="mensajeRegistro" class="message"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>public/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/js/usuario.js"></script>

    <script type="text/javascript">
        $(window).on('load', function() {
            // Se desvanece la animación con el icono
            $(".ov-icon").css('animation', 'slideOut 1s forwards');
            // Posteriormente se desvanece todo el contenedor que cubre la pantalla completa
            $(".ov-preloader").delay(1000).fadeOut("slow");
        });

        function toggleForms() {
            $("#loginFormContainer").toggle();
            $("#registerFormContainer").toggle();
        }
    </script>
</body>
</html> 