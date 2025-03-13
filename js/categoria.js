cargarCategorias();

function cargarCategorias() {
    const action = "cargarCategorias";
    fetch('/Bootstrap/php/categoria.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action })
    })
        .then(response => response.json())
        .then(data => {
            let select = document.getElementById('categoriaProducto');
            data.forEach(categoria => {
                let option = document.createElement('option');
                option.value = categoria.ID_Categoria;
                option.text = categoria.Nombre_Categoria;
                select.appendChild(option);
            });
        });
}
function crearCategoria(){
    const action = "crearCategoria";
    const nombreCategoria = document.getElementById('nombreCategoria').value;
    fetch('/Bootstrap/php/categoria.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action, nombreCategoria })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Categoria creada correctamente');
            } else {
                alert('Error al crear la categoria');
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Error en el registro");
        });
}