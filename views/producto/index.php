<h1 class="mb-4 text-center">PRODUCTOS</h1>

<!-- Sección para listar productos -->
<div class="container mt-5" id="productos">
    <div class="mb-3">
        <a href="<?php echo BASE_URL; ?>?controller=producto&action=create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Producto
        </a>
    </div>
    
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
        <tbody>
            <?php if (isset($productos) && is_array($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo $producto->id; ?></td>
                    <td>
                        <?php if ($producto->imagen): ?>
                            <img src="<?php echo BASE_URL . 'public/uploads/' . $producto->imagen; ?>" width="50" height="50" alt="Imagen del producto">
                        <?php else: ?>
                            <span>Sin imagen</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $producto->nombre; ?></td>
                    <td><?php echo $producto->descripcion; ?></td>
                    <td><?php echo $producto->precio; ?></td>
                    <td><?php echo $producto->stock; ?></td>
                    <td><?php echo $producto->categoria_nombre; ?></td>
                    <td><?php echo $producto->proveedor_nombre; ?></td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>?controller=producto&action=edit&id=<?php echo $producto->id; ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="<?php echo BASE_URL; ?>?controller=producto&action=delete&id=<?php echo $producto->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar este producto?');">
                            <i class="fas fa-trash"></i> Eliminar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">No hay productos disponibles</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div> 