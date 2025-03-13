<?php include 'header.php'; ?>
<!-- Página de inicio con Cards de productos -->
<div class="container mt-4">
    <h1 class="mb-4 center">PRODUCTOS</h1>
    
<!-- Sección para listar productos -->
<div class="container mt-5" id="productos">
    <h2 class="mb-3">Lista de Productos</h2>
    <table class="table table-striped" id="tablaProductos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre del Producto</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Categoria</th>
                <th>Proveedor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="listaProductos">
        </tbody>
    </table>
</div>

<!-- Modal para editar producto -->
<div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-labelledby="modalEditarProductoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarProductoLabel">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarProducto">
                    <input type="hidden" id="idProducto">
                    <div class="mb-3">
                        <label for="nombreProducto" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" id="EdiNombreProducto">
                    </div>
                    <div class="mb-3">
                        <label for="descripcionProducto" class="form-label">Descripción</label>
                        <textarea class="form-control" id="EdiDescripcionProducto"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precioProducto" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="EdiPrecioProducto">
                    </div>
                    <div class="mb-3">
                        <label for="cantidadProducto" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="EdiCantidadProducto">
                    </div>
                    <button type="button" class="btn btn-primary" onclick="actualizarProducto()">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>