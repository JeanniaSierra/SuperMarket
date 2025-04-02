<div class="card">
    <div class="card-header">
        <h2 class="card-title">Editar Proveedor</h2>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>?controller=proveedor&action=edit" method="POST">
            <input type="hidden" name="id" value="<?php echo $proveedor->id; ?>">
            
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Proveedor</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $proveedor->nombre; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $proveedor->direccion; ?>">
            </div>
            
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $proveedor->telefono; ?>">
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $proveedor->email; ?>">
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?php echo BASE_URL; ?>?controller=proveedor&action=index" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Proveedor</button>
            </div>
        </form>
    </div>
</div> 