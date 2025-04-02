cargarProductos();
// llama funcion de otro js
// includeScript("global.js" );

function cargarProductos() {
    const action = "cargarProductos";
    fetch('/Bootstrap/controlador/producto.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action })
    })
        .then(response => response.json())
        .then(data => {
            let tbody = document.getElementById('listaProductos');
            tbody.innerHTML = '';
            data.forEach(producto => {
                    let tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${producto.ID_Producto}</td>
                        <td><img src="${producto.imagen}" width="50" height="50"></td>
                        <td>${producto.Nombre}</td>
                        <td>${producto.Descripcion}</td>
                        <td>${producto.Precio}</td>
                        <td>${producto.Stock}</td>
                        <td>${producto.Categoria}</td>
                        <td>${producto.Proveedor}</td>
                        <td>
                            <button class="btn btn-warning" onclick="abrirModalEditar(${producto.ID_Producto})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminarProducto(${producto.ID_Producto})">Eliminar</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
            }); 
        });
}
function crearProducto() {
    const action = "crearProducto";
    const formData = new FormData();
    formData.append('action', action);
    formData.append('imagen', document.getElementById("imagenProducto").files[0]);
    formData.append('nombre', document.getElementById("nombreProducto").value);
    formData.append('descripcion', document.getElementById("descripcionProducto").value);
    formData.append('precio', document.getElementById("precioProducto").value);
    formData.append('stock', document.getElementById("cantidadProducto").value);
    formData.append('idCategoria', document.getElementById("categoriaProducto").value);
    formData.append('idProveedor', document.getElementById("proveedorProducto").value);

    fetch('/Bootstrap/controlador/producto.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, "success");
            document.getElementById('modalCrearProducto').classList.add('hide');
            document.getElementById('modalCrearProducto').style.display = 'none';
            cargarProductos();
        } else{
            showNotification(data.message, "error");

        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Error en la creación");
    });
}
function abrirModalEditar(idProducto) {
    // abrir modal
    document.getElementById('modalEditarProducto').style.display = 'block';
    document.getElementById('modalEditarProducto').classList.add('show');
    // cargar datos del producto
    const action = "obtenerProducto";
    fetch('/Bootstrap/controlador/producto.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action, idProducto })
    })
        .then(response => response.json())
        .then(data => {
            // cargar en imput del modal
            document.getElementById("idProducto").value = data.ID_Producto;
            document.getElementById("EdiNombreProducto").value = data.Nombre;
            document.getElementById("EdiDescripcionProducto").value = data.Descripcion;
            document.getElementById("EdiPrecioProducto").value = data.Precio;
            document.getElementById("EdiCantidadProducto").value = data.Stock;
        });
}
function actualizarProducto() {
    const action = "editarProducto";
    const id = document.getElementById("idProducto").value;
    const nombre = document.getElementById("EdiNombreProducto").value;
    const descripcion = document.getElementById("EdiDescripcionProducto").value;
    const precio = document.getElementById("EdiPrecioProducto").value;
    const stock = document.getElementById("EdiCantidadProducto").value;

    fetch('/Bootstrap/controlador/producto.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action, id, nombre, descripcion, precio, stock})
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Producto actualizado exitosamente");
                document.getElementById('modalEditarProducto').classList.add('hide');
                document.getElementById('modalEditarProducto').style.display = 'none';
                cargarProductos();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Error en la actualización");
        });
}
function eliminarProducto(idProducto) {
    const action = "eliminarProducto";
    fetch('/Bootstrap/controlador/producto.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action, idProducto })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Producto eliminado exitosamente");
                cargarProductos();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Error en la eliminación");
        });
}
    