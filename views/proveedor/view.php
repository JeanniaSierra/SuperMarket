<div class="card mb-4">
    <div class="card-header">
        <h2 class="card-title">Detalles del Proveedor</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h3><?php echo $proveedor->nombre; ?></h3>
                <p><strong>Dirección:</strong> <?php echo $proveedor->direccion; ?></p>
                <p><strong>Teléfono:</strong> <?php echo $proveedor->telefono; ?></p>
                <p><strong>Email:</strong> <?php echo $proveedor->email; ?></p>
            </div>
            <div class="col-md-6 text-end">
                <a href="<?php echo BASE_URL; ?>?controller=proveedor&action=edit&id=<?php echo $proveedor->id; ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar Proveedor
                </a>
                <a href="<?php echo BASE_URL; ?>?controller=proveedor&action=index" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver a la lista
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Productos de este Proveedor</h3>
    </div>
    <div class="card-body">
        <?php if (isset($productos) && is_array($productos) && count($productos) > 0): ?>
            <div class="row">
                <?php foreach ($productos as $producto): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if ($producto->imagen): ?>
                                <img src="<?php echo BASE_URL . 'public/uploads/' . $producto->imagen; ?>" class="card-img-top" alt="<?php echo $producto->nombre; ?>">
                            <?php else: ?>
                                <div class="card-img-top bg-light text-center py-5">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $producto->nombre; ?></h5>
                                <p class="card-text"><?php echo substr($producto->descripcion, 0, 100); ?><?php echo (strlen($producto->descripcion) > 100) ? '...' : ''; ?></p>
                                <p><strong>Precio:</strong> $<?php echo number_format($producto->precio, 2); ?></p>
                                <p><strong>Stock:</strong> <?php echo $producto->stock; ?> unidades</p>
                                <a href="<?php echo BASE_URL; ?>?controller=producto&action=edit&id=<?php echo $producto->id; ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                Este proveedor no tiene productos asociados.
            </div>
        <?php endif; ?>
    </div>
</div> 