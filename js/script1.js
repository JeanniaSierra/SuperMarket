// const usuarioValido = "admin";
// const contrasenaValida = "12345";
let intentosRestantes = 3;

function verificarLogin() {
    let action ="login";
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let mensaje = document.getElementById("message");

    fetch("/Bootstrap/php/usuario.php",{
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({action, username, password})
    })
    .then(response => response.json())
    .then(data=> {
        if(data.success){
            mensaje.style.color = "green";
            mensaje.textContent = "¡Inicio de sesión exitoso!";
            window.location.href="index.html";
        }else{
            intentosRestantes--; 
            mensaje.style.color = "red";
            mensaje.textContent = `Usuario o contraseña incorrectos. Intentos restantes: ${intentosRestantes}`;
            
            if (intentosRestantes === 0) {
                mensaje.textContent = "Cuenta bloqueada. Intenta más tarde.";
                document.getElementById("loginForm").elements["username"].disabled = true;
                document.getElementById("loginForm").elements["password"].disabled = true;
            }

        }
    });
}
    // if (username === usuarioValido && password === contrasenaValida) {
    //     mensaje.style.color = "green";
    //     mensaje.textContent = "¡Inicio de sesión exitoso!";
    //     window.location.href="index.html";
    //     // setTimeout(() => {
    //     //     window.location.href = "index.html";
    //     // }, 1000);
    // } else {
    //     intentosRestantes--; 
    //     mensaje.style.color = "red";
    //     mensaje.textContent = `Usuario o contraseña incorrectos. Intentos restantes: ${intentosRestantes}`;
        
    //     if (intentosRestantes === 0) {
    //         mensaje.textContent = "Cuenta bloqueada. Intenta más tarde.";
    //         document.getElementById("loginForm").elements["username"].disabled = true;
    //         document.getElementById("loginForm").elements["password"].disabled = true;
    //     }
    // }

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
function registrarUsuario(){

    const username = document.getElementById("registroUsuario").value;
    const email = document.getElementById("registroEmail").value;
    const password = document.getElementById("registroContraseña").value;

    fetch("/bootstrap/php/usuario1.php",{
        method: "POST",
        headers:{
            "Content-Type":"application/json"
        },
        body: JSON.stringify({username,email,password})
    })
    .then(response => response.json())
    .then(data=>{
        const mensajeRegistro = document.getElementById("mensajeRegistro");
        if(data.success){
            mensajeRegistro.style.color ="green";
            mensajeRegistro.textContent="Registro exitoso!";
        }else{
            mensajeRegistro.style.color ="red";
            mensajeRegistro.textContent="Error" + data.message;
        }
    })
    .catch(error => {
        console.error("error", error);
        document.getElementById("mensajeRegistro").textContent="Error en el registro";
    });
}

function mostrarPerfil(){
    const action ="getPerfil";
    fetch("/Bootstrap/php/usuario1.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({action})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("perfilUsuario").value = data.username;
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









