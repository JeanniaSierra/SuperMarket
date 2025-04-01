<div class="card">
    <div class="card-header">
        <h2 class="card-title">Editar Producto</h2>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>?controller=producto&action=edit" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $producto->id; ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $producto->nombre; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo $producto->precio; ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo $producto->descripcion; ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="stock" class="form-label">Cantidad en Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $producto->stock; ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="id_categoria" class="form-label">Categoría</label>
                    <select class="form-select" id="id_categoria" name="id_categoria" required>
                        <option value="">Seleccionar Categoría</option>
                        <?php if (isset($categorias) && is_array($categorias)): ?>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo $categoria->id; ?>" <?php echo ($categoria->id == $producto->id_categoria) ? 'selected' : ''; ?>>
                                    <?php echo $categoria->nombre; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="id_proveedor" class="form-label">Proveedor</label>
                    <select class="form-select" id="id_proveedor" name="id_proveedor" required>
                        <option value="">Seleccionar Proveedor</option>
                        <?php if (isset($proveedores) && is_array($proveedores)): ?>
                            <?php foreach ($proveedores as $proveedor): ?>
                                <option value="<?php echo $proveedor->id; ?>" <?php echo ($proveedor->id == $producto->id_proveedor) ? 'selected' : ''; ?>>
                                    <?php echo $proveedor->nombre; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Producto</label>
                <?php if ($producto->imagen): ?>
                    <div class="mb-2">
                        <img src="<?php echo BASE_URL . 'public/uploads/' . $producto->imagen; ?>" alt="Imagen actual" style="max-width: 200px; max-height: 200px;">
                        <p class="mt-1">Imagen actual: <?php echo $producto->imagen; ?></p>
                    </div>
                <?php endif; ?>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                <small class="form-text text-muted">Deje este campo vacío si no desea cambiar la imagen.</small>
                <div id="preview-container" class="mt-2" style="display: none;">
                    <img id="preview-image" src="#" alt="Vista previa" style="max-width: 200px; max-height: 200px;">
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?php echo BASE_URL; ?>?controller=producto&action=index" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Producto</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('imagen').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            previewImage.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script> 