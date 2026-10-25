document.addEventListener('DOMContentLoaded', () => {
    let carrito = JSON.parse(localStorage.getItem('tocci_carrito')) || [];

    const formatearMoneda = (monto) => {
        return '$ ' + parseFloat(monto).toLocaleString('es-AR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    };

    const guardarCarrito = () => {
        localStorage.setItem('tocci_carrito', JSON.stringify(carrito));
        actualizarContadorCarrito();
        renderizarTablaCarrito();
    };

    const actualizarContadorCarrito = () => {
        const cartCount = document.getElementById('cart-count');
        if (cartCount) {
            const totalItems = carrito.reduce((acc, item) => acc + item.cantidad, 0);
            cartCount.textContent = totalItems;
        }
    };

    const agregarAlCarrito = (id, nombre, precio) => {
        const itemExistente = carrito.find(item => item.id === id);
        if (itemExistente) {
            itemExistente.cantidad += 1;
        } else {
            carrito.push({
                id: id,
                nombre: nombre,
                precio: parseFloat(precio),
                cantidad: 1,
                aclaraciones: ''
            });
        }
        guardarCarrito();
    };

    // Renderizado exclusivo para la pantalla carrito.php
    const renderizarTablaCarrito = () => {
        const tabla = document.getElementById('tabla-carrito');
        const msgVacio = document.getElementById('carrito-vacio-msg');
        const btnCheckout = document.getElementById('btn-checkout');
        const resumenSubtotal = document.getElementById('resumen-subtotal');
        const resumenTotal = document.getElementById('resumen-total');

        if (!tabla) return; // Si no estamos en la página de carrito, corta acá

        tabla.innerHTML = '';
        let total = 0;

        if (carrito.length === 0) {
            msgVacio.style.display = 'block';
            btnCheckout.classList.add('disabled');
            resumenSubtotal.textContent = '$ 0,00';
            resumenTotal.textContent = '$ 0,00';
            return;
        }

        msgVacio.style.display = 'none';
        btnCheckout.classList.remove('disabled');

        carrito.forEach((item, index) => {
            const subtotal = item.precio * item.cantidad;
            total += subtotal;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="fw-bold">${item.nombre}</td>
                <td>${formatearMoneda(item.precio)}</td>
                <td>
                    <div class="input-group input-group-sm">
                        <button class="btn btn-outline-secondary btn-restar" data-index="${index}">-</button>
                        <input type="text" class="form-control text-center px-1" value="${item.cantidad}" readonly style="max-width: 45px;">
                        <button class="btn btn-outline-secondary btn-sumar" data-index="${index}">+</button>
                    </div>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm input-aclaracion" 
                           data-index="${index}" 
                           placeholder="Ej: sin cebolla..." 
                           value="${item.aclaraciones || ''}">
                </td>
                <td class="fw-bold">${formatearMoneda(subtotal)}</td>
                <td class="text-center">
                    <button class="btn btn-outline-danger btn-sm btn-eliminar" data-index="${index}" title="Eliminar">
                        ✕
                    </button>
                </td>
            `;
            tabla.appendChild(tr);
        });

        resumenSubtotal.textContent = formatearMoneda(total);
        resumenTotal.textContent = formatearMoneda(total);
    };

    // Eventos globales del carrito
    document.addEventListener('click', (e) => {
        // Agregar desde index.php
        if (e.target.classList.contains('btn-agregar')) {
            const id = e.target.getAttribute('data-id');
            const nombre = e.target.getAttribute('data-nombre');
            const precio = e.target.getAttribute('data-precio');
            agregarAlCarrito(id, nombre, precio);

            const textoOriginal = e.target.innerHTML;
            e.target.innerHTML = '✔ ¡Agregado!';
            e.target.classList.replace('btn-primary', 'btn-success');
            setTimeout(() => {
                e.target.innerHTML = textoOriginal;
                e.target.classList.replace('btn-success', 'btn-primary');
            }, 1000);
        }

        // Sumar cantidad en carrito.php
        if (e.target.classList.contains('btn-sumar')) {
            const idx = e.target.getAttribute('data-index');
            carrito[idx].cantidad += 1;
            guardarCarrito();
        }

        // Restar cantidad en carrito.php
        if (e.target.classList.contains('btn-restar')) {
            const idx = e.target.getAttribute('data-index');
            if (carrito[idx].cantidad > 1) {
                carrito[idx].cantidad -= 1;
            } else {
                carrito.splice(idx, 1);
            }
            guardarCarrito();
        }

        // Eliminar producto en carrito.php
        if (e.target.classList.contains('btn-eliminar')) {
            const idx = e.target.getAttribute('data-index');
            carrito.splice(idx, 1);
            guardarCarrito();
        }

        // Vaciar carrito
        if (e.target.id === 'btn-vaciar-carrito') {
            if (carrito.length > 0 && confirm('¿Seguro que querés vaciar todo el carrito?')) {
                carrito = [];
                guardarCarrito();
            }
        }
    });

    // Guardar aclaraciones cuando el cliente escribe
    document.addEventListener('input', (e) => {
        if (e.target.classList.contains('input-aclaracion')) {
            const idx = e.target.getAttribute('data-index');
            carrito[idx].aclaraciones = e.target.value;
            localStorage.setItem('tocci_carrito', JSON.stringify(carrito));
        }
    });

    // Filtro por categoría en index.php
    const filtroCat = document.getElementById('filtro-categoria');
    if (filtroCat) {
        filtroCat.addEventListener('change', (e) => {
            const catSeleccionada = e.target.value;
            document.querySelectorAll('.tarjeta-producto').forEach(tarjeta => {
                const catProducto = tarjeta.getAttribute('data-categoria');
                tarjeta.style.display = (catSeleccionada === 'todas' || catProducto === catSeleccionada) ? 'block' : 'none';
            });
        });
    }

    // Inicialización al cargar la vista
    actualizarContadorCarrito();
    renderizarTablaCarrito();
});