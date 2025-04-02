<!DOCTYPE html>
<html lang="es">
<?php
session_start();
$rol = $_SESSION['tipoUsuario'];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos, Usuarios y Pedidos</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../estilos.css">
    <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Font+Name">
</head>

<body>

    <!-- div para cargar el overlay -->
    <div id="overlay" class="overlay"></div>
    <!-- Navbar -->
    <!-- menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="principal.php">Admin Panel</a>
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
                            <?php if ($rol === 'vendedor') : ?>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalCrearProveedor">Crear Proveedor</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="proveedores.php">Listar Proveedor</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUsuarios" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categorias
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownCategorias">
                            <?php if ($rol === 'vendedor') : ?>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalCrearCategoria">Crear Categoria</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="#">Listar Categoria</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProductos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Productos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownProductos">
                            <?php if ($rol === 'vendedor') : ?>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalCrearProducto">Crear Producto</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="productos.php">Ver Productos</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- Botón Perfil -->
                <div class="ms-auto align-items-center">
                    <ul class="navbar-nav">
                        <label class="text-white me-3 p-2">
                            <?php echo $_SESSION['tipoUsuario'] ?>
                        </label>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownPerfil" role="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user"></i>
                            </a>
                            <ul class="dropdown-menu mr-0" aria-labelledby="navbarDropdownPerfil" style="position: absolute; left: -100px;">
                                <li><a class="dropdown-item" id="verPerfil" onclick="mostrarPerfil()">Ver Perfil</a></li>
                                <li><a class="dropdown-item" href="#pedidos">Cuenta</a></li>
                                <li><a class="dropdown-item" href="#" onclick="cambiarRol()">Cambiar Rol</a></li>
                                <li><a class="dropdown-item" href="../index.php">Cerrar sesión</a></li>
                            </ul>
                        </li>
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

    <!-- Modal para Crear Categoria -->
    <div class="modal fade" id="modalCrearCategoria" tabindex="-1" aria-labelledby="modalCrearCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearCategoriaLabel">Crear Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Nombre de la Categoria: </label>
                            <input type="text" class="form-control" id="nombreCategoria">
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="crearCategoria()">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Crear Proveedor -->
    <div class="modal fade" id="modalCrearProveedor" tabindex="-1" aria-labelledby="modalCrearProveedorLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearProveedorLabel">Crear Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="nombreProveedor" class="form-label">Nombre del Proveedor: </label>
                            <input type="text" class="form-control" id="nombreProveedor">
                        </div>
                        <div class="mb-3">
                            <label for="telefonoProveedor" class="form-label">Telefono: </label>
                            <input type="text" class="form-control" id="telefonoProveedor">
                        </div>
                        <div class="mb-3">
                            <label for="direccionProveedor" class="form-label">Direccion: </label>
                            <input type="text" class="form-control" id="direccionProveedor">
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="crearProveedor()">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Crear Producto -->
    <div class="modal fade" id="modalCrearProducto" tabindex="-1" aria-labelledby="modalCrearProductoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearProductoLabel">Crear Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formCrearProducto" enctype="multipart/form-data">
                        <!-- select con los proveedores de la bd -->
                        <div class="mb-3">
                            <label class="form-label">Proveedor</label>
                            <select class="form-select" id="proveedorProducto">
                                <option value="">Seleccionar Proveedor</option>
                            </select>
                        </div>
                        <!-- select con las categorias de la bd -->
                        <div class="mb-3">
                            <label class="form-label">Categoria</label>
                            <select class="form-select" id="categoriaProducto">
                                <option value="">Seleccionar Categoria</option>
                            </select>
                        </div>
                        <!-- div para subir imagen a la bd -->
                        <div class="mb-3">
                            <label class="form-label">Imagen del Producto</label>
                            <input type="file" class="form-control" id="imagenProducto" name="imagenProducto">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombreProducto">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcionProducto"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Precio</label>
                            <input type="number" class="form-control" id="precioProducto">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="cantidadProducto">
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="crearProducto()">Guardar</button>
                    </form>
                    <div id="msjCrearProducto" class="msjCrearProducto"></div>
                </div>
            </div>
        </div>
    </div>