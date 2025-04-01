<div class="card">
    <div class="card-header">
        <h2 class="card-title">Editar Categoría</h2>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>?controller=categoria&action=edit" method="POST">
            <input type="hidden" name="id" value="<?php echo $categoria->id; ?>">
            
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Categoría</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $categoria->nombre; ?>" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?php echo BASE_URL; ?>?controller=categoria&action=index" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Categoría</button>
            </div>
        </form>
    </div>
</div> 