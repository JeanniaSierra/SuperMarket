cargarProveedores()
function cargarProveedores() {
    const action = "cargarProveedores";
    fetch('/Bootstrap/php/proveedor.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action })
    })
        .then(response => response.json())
        .then(data => {
            let select = document.getElementById('proveedorProducto');
            data.forEach(proveedor => {
                let option = document.createElement('option');
                option.value = proveedor.ID_Proveedor;
                option.text = proveedor.Nombre_Proveedor;
                select.appendChild(option);
            });
        });
}
function crearProveedor(){
    let nombre = document.getElementById('nombreProveedor').value;
    let telefono = document.getElementById('telefonoProveedor').value;
    let direccion = document.getElementById('direccionProveedor').value;
    const action = "crearProveedor";
    fetch('/Bootstrap/php/proveedor.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action, nombre, telefono, direccion })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Proveedor creado correctamente');
                document.getElementById('nombreProveedor').value = '';
                document.getElementById('telefonoProveedor').value = '';
                document.getElementById('direccionProveedor').value = '';
            } else {
                alert('Error al crear el proveedor');
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Error en el registro");
        });
}


