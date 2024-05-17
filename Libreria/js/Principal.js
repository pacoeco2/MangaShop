const fadeInElements = document.querySelectorAll('.fade-in');

function checkVisibility() {
    const triggerTop = window.innerHeight / 5;
    const triggerBottom = window.innerHeight / 5 * 4;

    fadeInElements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementBottom = element.getBoundingClientRect().bottom;

        if (elementTop < triggerBottom && elementBottom > triggerTop) {
            element.classList.add('visible');
        } else {
            element.classList.remove('visible');
        }
    });
}

window.addEventListener('scroll', checkVisibility);
checkVisibility();

function agregarAlCarrito(id) {
    fetch('../php/agregar_al_carrito.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            // Actualiza el sub-menú del carrito
            const submenuCarrito = document.getElementById('submenu-carrito');
            submenuCarrito.innerHTML = '';
            data.carrito.forEach(item => {
                submenuCarrito.innerHTML += '<p>' + item.nombre + ' - ' + item.precio + ' - Cantidad: ' + item.cantidad + '</p>';
            });
        });
}