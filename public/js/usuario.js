// const usuarioValido = "admin";
// const contrasenaValida = "12345";
let intentosRestantes = 3;

function verificarLogin() {
    const action = "login";
    const documento = document.getElementById("documento").value;
    const password = document.getElementById("password").value;
    const tipoUsuario = document.getElementById("tipoUsuario").value;
    const mensaje = document.getElementById("message");

    fetch("/Bootstrap/controlador/usuario.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({action, documento, password, tipoUsuario})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mensaje.style.color = "green";
            mensaje.textContent = "¡Inicio de sesión exitoso!";
            localStorage.setItem('user_id', data.user_id);
            // Redirigir después de un pequeño retraso
            setTimeout(() => {
                window.location.href = "/Bootstrap/Vista/principal.php";
            }, 1000);
        } else {
            intentosRestantes--; 
            mensaje.style.color = "red";
            mensaje.textContent = `Usuario o contraseña incorrectos. Intentos restantes: ${intentosRestantes}`;
            
            if (intentosRestantes === 0) {
                mensaje.textContent = "Cuenta bloqueada. Intenta más tarde.";
                document.getElementById("loginForm").elements["documento"].disabled = true;
                document.getElementById("loginForm").elements["password"].disabled = true;
            }
        }
    })
    .catch(error => {
        console.error("Error:", error);
        document.getElementById("message").textContent = "Error al iniciar sesión";
    });
}
function toggleForms() {
    const loginFormContainer = document.getElementById("loginFormContainer");
    const registerFormContainer = document.getElementById("registerFormContainer");
    
    if (loginFormContainer.style.display === "none") {
        loginFormContainer.style.display = "block";
        registerFormContainer.style.display = "none";
    } else {
        loginFormContainer.style.display = "none";
        registerFormContainer.style.display = "block";
    }
}
// Función para enviar datos de registro
function registrarUsuario() {
    const action="register";
    const documento = document.getElementById("registroDocumento").value;
    const nombre = document.getElementById("registroNombre").value;
    const apellido = document.getElementById("registroApellido").value;
    const telefono = document.getElementById("registroTelefono").value;
    const email = document.getElementById("registroEmail").value;
    const password = document.getElementById("registroContraseña").value;

    fetch("/Bootstrap/controlador/usuario.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({action, documento, nombre, apellido, telefono, email, password})
    })
    .then(response => response.json())
    .then(data => {
        const mensajeRegistro = document.getElementById("mensajeRegistro");
        if (data.success) {
            mensajeRegistro.style.color = "green";
            mensajeRegistro.textContent = "¡Registro exitoso! Ahora puedes iniciar sesión.";
        } else {
            mensajeRegistro.style.color = "red";
            mensajeRegistro.textContent = "Error: " + data.message;
        }
    })
    .catch(error => {
        console.error("Error:", error);
        document.getElementById("mensajeRegistro").textContent = "Error en el registro";
    });
}
// Función para obtener y mostrar los datos del perfil
function mostrarPerfil() {
    document.getElementById("overlay").style.display = "block";
    const action="getPerfil";
    fetch("/Bootstrap/controlador/usuario.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({action})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("perfilDocumento").value = data.documento;
            document.getElementById("perfilNombre").value = data.Nombre;
            document.getElementById("perfilApellido").value = data.Apellido;
            document.getElementById("perfilTelefono").value = data.Telefono;
            document.getElementById("perfilEmail").value = data.email;
            document.getElementById("perfilDatos").style.display = "block";
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Hubo un problema al obtener los datos del perfil.");
    });
}
function cerrarPerfilDatos(){
    document.getElementById("perfilDatos").style.display="none";
    document.getElementById("perfilNombre").disabled = true;
    document.getElementById("perfilApellido").disabled = true;
    document.getElementById("perfilTelefono").disabled = true;
    document.getElementById("perfilEmail").disabled = true;
    document.getElementById("perfilNombre").disabled = true;
    document.getElementById("overlay").style.display = "none";
}
function habilitar(){

    document.getElementById("perfilNombre").disabled = false;
    document.getElementById("perfilApellido").disabled = false;
    document.getElementById("perfilTelefono").disabled = false;
    document.getElementById("perfilEmail").disabled = false;
}
function modificarPerfil(){
    const action ="modificar";
    const nombre = document.getElementById("perfilNombre").value;
    const apellido = document.getElementById("perfilApellido").value;
    const telefono = document.getElementById("perfilTelefono").value;
    const email = document.getElementById("perfilEmail").value;

    fetch("/Bootstrap/controlador/usuario.php",{
        method:"POST",
        headers:{
            "Content-Type":"application/json"
        },
        body: JSON.stringify({action, nombre,apellido,telefono,email})
    })
    .then(response =>response.json())
    .then(data =>{
        if(data.success){
            alert ("Se modificó datos del usuario con éxito");
        }else{
            alert("Error en el registro");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert ("Error en el registro");
    });


}






