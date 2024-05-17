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



document.addEventListener('DOMContentLoaded', () => {
    const carritoIcon = document.getElementById('carrito-icon');
    const carritoSubmenu = document.getElementById('carrito-submenu');
    const carritoItems = document.getElementById('carrito-items');
    const carritoTotal = document.getElementById('carrito-total');
    const carritoCount = document.createElement('span'); // Crear el contador de carrito
    carritoCount.id = 'carrito-count';
    carritoIcon.appendChild(carritoCount);

    const carrito = [];

    carritoIcon.addEventListener('click', (event) => {
        event.stopPropagation(); // Prevent triggering of document's click event
        carritoSubmenu.classList.toggle('visible');
    });

    carritoSubmenu.addEventListener('click', (event) => {
        event.stopPropagation(); // Prevent triggering of document's click event
    });

    document.addEventListener('click', () => {
        carritoSubmenu.classList.remove('visible'); // Hide submenu when anywhere else on the document is clicked
    });

    document.querySelectorAll('.CarritoP').forEach(button => {
        button.addEventListener('click', (event) => {
            const button = event.currentTarget;
            const id = button.dataset.id;
            const nombre = button.dataset.nombre;
            const precio = parseFloat(button.dataset.precio);
            const imagen = button.dataset.imagen;

            const cantidadInput = button.previousElementSibling.querySelector('.cantidad');
            const cantidad = parseInt(cantidadInput.value);

            const existingItem = carrito.find(item => item.id === id);
            if (existingItem) {
                existingItem.cantidad += cantidad;
            } else {
                carrito.push({ id, nombre, precio, imagen, cantidad });
            }

            renderCarrito();
        });
    });

    document.querySelectorAll('.cantidad-selector .plus').forEach(button => {
        button.addEventListener('click', () => {
            const cantidadInput = button.previousElementSibling;
            cantidadInput.value = parseInt(cantidadInput.value) + 1;
        });
    });

    document.querySelectorAll('.cantidad-selector .minus').forEach(button => {
        button.addEventListener('click', () => {
            const cantidadInput = button.nextElementSibling;
            if (parseInt(cantidadInput.value) > 1) {
                cantidadInput.value = parseInt(cantidadInput.value) - 1;
            }
        });
    });

    function renderCarrito() {
        carritoItems.innerHTML = '';
        let total = 0;
        let totalItems = 0;

        carrito.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.className = 'carrito-item';

            itemElement.innerHTML = `
                <img src="${item.imagen}" alt="${item.nombre}">
                <div class="carrito-item-details">
                    <a href="masinfo.php?id=${item.id}">${item.nombre}</a>
                    <p>$${item.precio.toFixed(2)} x ${item.cantidad}</p>
                </div>
                <button class="eliminar-item" data-id="${item.id}"><i class="bi bi-trash"></i></button>
            `;

            carritoItems.appendChild(itemElement);
            total += item.precio * item.cantidad;
            totalItems += item.cantidad;

            // Add event listener to the "Eliminar item" button
            itemElement.querySelector('.eliminar-item').addEventListener('click', (event) => {
                const id = event.currentTarget.dataset.id;
                const index = carrito.findIndex(item => item.id === id);
                if (index !== -1) {
                    carrito.splice(index, 1); // Eliminar el elemento del carrito
                    renderCarrito(); // Renderizar de nuevo el carrito
                }
            });
        });

        carritoTotal.textContent = `Total: $${total.toFixed(2)}`;
        carritoCount.textContent = totalItems; // Actualizar el contador de carrito
    }
});
