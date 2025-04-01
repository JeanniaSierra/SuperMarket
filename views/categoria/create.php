<div class="card">
    <div class="card-header">
        <h2 class="card-title">Crear Nueva Categoría</h2>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>?controller=categoria&action=create" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Categoría</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?php echo BASE_URL; ?>?controller=categoria&action=index" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Categoría</button>
            </div>
        </form>
    </div>
</div> 