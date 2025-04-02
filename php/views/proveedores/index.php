<h1 class="mb-4 text-center">PROVEEDORES</h1>

<div class="container mt-3">
    <div class="mb-3">
        <a href="<?php echo BASE_URL; ?>?controller=proveedor&action=create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Proveedor
        </a>
    </div>
    
    <h2 class="mb-3">Lista de Proveedores</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="row">
        <?php if (isset($proveedores) && is_array($proveedores)): ?>
            <?php foreach ($proveedores as $proveedor): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $proveedor->nombre; ?></h5>
                            <p class="card-text">
                                <strong>Teléfono:</strong> <?php echo $proveedor->telefono; ?><br>
                                <strong>Dirección:</strong> <?php echo $proveedor->direccion; ?><br>
                                <strong>Email:</strong> <?php echo $proveedor->email; ?>
                            </p>
                            <div class="d-flex justify-content-between">
                                <a href="<?php echo BASE_URL; ?>?controller=proveedor&action=view&id=<?php echo $proveedor->id; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Ver Productos
                                </a>
                                <div>
                                    <a href="<?php echo BASE_URL; ?>?controller=proveedor&action=edit&id=<?php echo $proveedor->id; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>?controller=proveedor&action=delete&id=<?php echo $proveedor->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar este proveedor? Si tiene productos asociados, no se podrá eliminar.');">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">No hay proveedores disponibles</div>
            </div>
        <?php endif; ?>
    </div>
</div> 