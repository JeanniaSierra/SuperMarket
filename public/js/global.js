function showNotification(message, type = "info") {
    const container = document.getElementById("notification-container");

    // Crear el elemento de notificación
    const notification = document.createElement("div");
    notification.className = `notification ${type}`;
    notification.textContent = message;

    // Agregar la notificación al contenedor
    container.appendChild(notification);

    // Eliminar la notificación después de 4 segundos
    setTimeout(() => {
        notification.remove();
    }, 4000);
}