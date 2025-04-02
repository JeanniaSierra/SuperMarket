<!DOCTYPE html>
<html lang="es">
<?php
session_start();
$rol = $_SESSION['tipoUsuario'] ?? '';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos, Usuarios y Pedidos</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
</head>
<body>
    <!-- div para cargar el overlay -->
    <div id="overlay" class="overlay"></div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPedidos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Proveedor
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownPedidos">
                            <?php if ($rol === 'vendedor'): ?>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>?controller=proveedor&action=create">Crear Proveedor</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>?controller=proveedor&action=index">Listar Proveedor</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUsuarios" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categorias
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownCategorias">
                            <?php if ($rol === 'vendedor'): ?>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>?controller=categoria&action=create">Crear Categoria</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>?controller=categoria&action=index">Listar Categoria</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProductos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Productos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownProductos">
                            <?php if ($rol === 'vendedor'): ?>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>?controller=producto&action=create">Crear Producto</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>?controller=producto&action=index">Ver Productos</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- Botón Perfil -->
                <div class="ms-auto align-items-center">
                    <ul class="navbar-nav">
                        <?php if (isset($_SESSION['tipoUsuario'])): ?>
                        <label class="text-white me-3 p-2">
                            <?php echo $_SESSION['tipoUsuario']; ?>
                        </label>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownPerfil" role="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user"></i>
                            </a>
                            <ul class="dropdown-menu mr-0" aria-labelledby="navbarDropdownPerfil" style="position: absolute; left: -100px;">
                                <li><a class="dropdown-item" id="verPerfil" onclick="mostrarPerfil()">Ver Perfil</a></li>
                                <li><a class="dropdown-item" href="#pedidos">Cuenta</a></li>
                                <li><a class="dropdown-item" href="#" onclick="cambiarRol()">Cambiar Rol</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>?controller=usuario&action=logout">Cerrar sesión</a></li>
                            </ul>
                        </li>
                        <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>?controller=usuario&action=login">Iniciar sesión</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenedor para mostrar el perfil del usuario -->
    <div class="container-perfil" id="perfilDatos" style="display: none;">
        <div class="container-p">
            <div class="mb-3">
                <button type="button" class="btn btn-close" onclick="cerrarPerfilDatos()"></button>
            </div>
            <h3>Perfil del Usuario</h3>
            <div class="form-group">
                <label>Documento de usuario:</label>
                <input type="text" id="perfilDocumento" class="form-control" disabled>

                <label>Nombre de usuario:</label>
                <input type="text" id="perfilNombre" class="form-control" disabled>

                <label>Apellido de usuario:</label>
                <input type="text" id="perfilApellido" class="form-control" disabled>

                <label>Telefono de usuario:</label>
                <input type="text" id="perfilTelefono" class="form-control" disabled>

                <label>Email:</label>
                <input type="email" id="perfilEmail" class="form-control" disabled>
            </div>
            <div class="mt-3 text-center">
                <button type="button" class="btn btn-primary" onclick="habilitar()">Editar</button>
                <button type="submit" class="btn btn-primary" onclick="modificarPerfil()">Guardar</button>
            </div>
        </div>
    </div>

    <!-- Contenido principal de la página -->
    <div class="container mt-4">
        <?php
        // Cargar la vista específica
        if (isset($content)) {
            require_once VIEW_PATH . '/' . $content . '.php';
        }
        ?>
    </div>

    <footer>
        <p>ejemplo@correo.com</p>
        <p>3123433333</p>
        <p>Sogamoso, Boyacá</p>

        <div class="social-icons">
            <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </footer>

    <script src="<?php echo BASE_URL; ?>public/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/js/usuario.js"></script>
    <script src="<?php echo BASE_URL; ?>public/js/proveedor.js"></script>
    <script src="<?php echo BASE_URL; ?>public/js/categoria.js"></script>
    <script src="<?php echo BASE_URL; ?>public/js/producto.js"></script>
</body>
</html> 