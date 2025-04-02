<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login y Registro</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-form, .register-form {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-container {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 350px;
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

        /* OV PRELOADER */
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
            background-image: url(public/img/mision.png);
            background-repeat: no-repeat;
            background-position: center;
            -webkit-background-size: cover;
            background-size: cover;
            animation: slideIn 1s forwards;
        }
        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
            }
            to {
                transform: translateX(-100%);
            }
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
            </div>
            <div class="col-md-6">
                <div class="form-container">
                    <!-- Formulario de Login -->
                    <div id="loginFormContainer">
                        <h2>Iniciar Sesión</h2>
                        <form id="loginForm">
                            <input type="text" id="documento" class="form-control mb-2" placeholder="documento" required>
                            <input type="password" id="password" class="form-control mb-2" placeholder="Contraseña" required>
                            <!-- select oara saber si se logue como vendedor o comprador -->
                            <select class="form-select" id="tipoUsuario" required>
                                <option value="">Seleccione el tipo de usuario</option>
                                <option value="1">Administrador</option>
                                <option value="2">Vendedor</option>
                                <option value="3">Comprador</option>
                            </select>
                            <a href="recuperar-contrasena.html" class="d-block mt-2">¿Olvidaste tu contraseña?</a>
                            <button type="button" class="btn btn-primary btn-block" onclick="verificarLogin()">Iniciar Sesión</button>
                        </form>
                        <p class="mt-3">¿No tienes cuenta? <span class="toggle-link" onclick="toggleForms()">Regístrate aquí</span></p>
                        <div id="message" class="message"></div>
                    </div>

                    <!-- Formulario de Registro -->
                    <div id="registerFormContainer" style="display: none;">
                        <h2>Registro de Usuario</h2>
                        <form id="registerForm">
                            <input type="text" id="registroDocumento" class="form-control mb-2" placeholder="Documento" required>
                            <input type="text" id="registroNombre" class="form-control mb-2" placeholder="Nombre" required>
                            <input type="text" id="registroApellido" class="form-control mb-2" placeholder="Apellido" required>
                            <input type="text" id="registroTelefono" class="form-control mb-2" placeholder="Telefono" required>
                            <input type="email" id="registroEmail" class="form-control mb-2" placeholder="Correo Electrónico" required>
                            <input type="password" id="registroContraseña" class="form-control mb-2" placeholder="Contraseña" required>
                            <button type="button" class="btn btn-success btn-block" onclick="registrarUsuario()">Registrarse</button>
                        </form>
                        <p class="mt-3">¿Ya tienes cuenta? <span class="toggle-link" onclick="toggleForms()">Inicia sesión aquí</span></p>
                        <div id="mensajeRegistro" class="message"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/usuario.js"></script>

    <script type="text/javascript">
        $(window).on('load', function() {
            // Se desvanece la animación con el icono
            $(".ov-icon").css('animation', 'slideOut 1s forwards');
            // Posteriormente se desvanece todo el contenedor que cubre la pantalla completa
            $(".ov-preloader").delay(1000).fadeOut("slow");
        });
    </script>
</body>
</html>
