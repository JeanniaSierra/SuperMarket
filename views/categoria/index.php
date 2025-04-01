<h1 class="mb-4 text-center">CATEGORÍAS</h1>

<div class="container mt-3">
    <div class="mb-3">
        <a href="<?php echo BASE_URL; ?>?controller=categoria&action=create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Categoría
        </a>
    </div>
    
    <h2 class="mb-3">Lista de Categorías</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($categorias) && is_array($categorias)): ?>
                <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?php echo $categoria->id; ?></td>
                    <td><?php echo $categoria->nombre; ?></td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>?controller=categoria&action=edit&id=<?php echo $categoria->id; ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="<?php echo BASE_URL; ?>?controller=categoria&action=delete&id=<?php echo $categoria->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar esta categoría? Si tiene productos asociados, no se podrá eliminar.');">
                            <i class="fas fa-trash"></i> Eliminar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No hay categorías disponibles</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div> 