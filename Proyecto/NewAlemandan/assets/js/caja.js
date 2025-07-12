// assets/js/caja.js

document.addEventListener('DOMContentLoaded', function () {
    const iniciarCompraBtn = document.getElementById('iniciarCompraBtn');
    const escanearBtn = document.getElementById('escanearBtn');
    const codigoProductoInput = document.getElementById('codigoProducto');
    const finalizarCompraBtn = document.getElementById('finalizarCompraBtn');
    const buscarProductoInput = document.getElementById('buscarProducto');
    const resultadosBusqueda = document.getElementById('resultadosBusqueda');
    const listaProductos = document.getElementById('listaProductos');
    const subtotalSpan = document.getElementById('subtotal');
    const ivaSpan = document.getElementById('iva');
    const totalSpan = document.getElementById('total');
    const totalPagar = document.getElementById('totalPagar');
    const modal = document.getElementById('productModal');
    const closeModal = document.querySelector('.close-modal');
    const mensajeCompra = document.getElementById('mensajeCompra');
    const metodoBtns = document.querySelectorAll('.payment-btn');

    let productos = [];
    let subtotal = 0;
    let iva = 0;
    let total = 0;
    let metodoPago = 'efectivo';

    function actualizarTotales() {
        subtotal = productos.reduce((sum, p) => sum + (p.precio * p.cantidad), 0);
        iva = subtotal * 0.19;
        total = subtotal + iva;

        subtotalSpan.textContent = `$${subtotal.toFixed(2)}`;
        ivaSpan.textContent = `$${iva.toFixed(2)}`;
        totalSpan.textContent = `$${total.toFixed(2)}`;
        totalPagar.textContent = `$${total.toFixed(2)}`;

        finalizarCompraBtn.disabled = productos.length === 0;
    }

    function renderizarLista() {
        listaProductos.innerHTML = '';
        if (productos.length === 0) {
            listaProductos.innerHTML = `
                <tr class="empty-message">
                    <td colspan="5">
                        <i class="fas fa-shopping-cart"></i>
                        <p>No hay productos agregados</p>
                    </td>
                </tr>`;
            actualizarTotales();
            return;
        }

        productos.forEach((p, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${p.nombre}</td>
                <td>$${p.precio.toFixed(2)}</td>
                <td>
                    <input type="number" min="1" value="${p.cantidad}" data-index="${index}" class="cantidad-input" style="width:50px">
                </td>
                <td>$${(p.precio * p.cantidad).toFixed(2)}</td>
                <td>
                    <button class="eliminar-producto" data-index="${index}" title="Eliminar">
                        <i class="fas fa-trash-alt" style="color: red;"></i>
                    </button>
                </td>
            `;
            listaProductos.appendChild(row);
        });

        // Escuchar cambios de cantidad
        document.querySelectorAll('.cantidad-input').forEach(input => {
            input.addEventListener('change', e => {
                const index = parseInt(e.target.getAttribute('data-index'));
                let nuevaCantidad = parseInt(e.target.value);
                if (nuevaCantidad < 1 || isNaN(nuevaCantidad)) nuevaCantidad = 1;
                productos[index].cantidad = nuevaCantidad;
                renderizarLista();
            });
        });

        // Escuchar clics en eliminar
        document.querySelectorAll('.eliminar-producto').forEach(btn => {
            btn.addEventListener('click', e => {
                const index = parseInt(e.target.closest('button').getAttribute('data-index'));
                productos.splice(index, 1);
                renderizarLista();
            });
        });

        actualizarTotales();
    }

    iniciarCompraBtn.addEventListener('click', () => {
        productos = [];
        renderizarLista();
        codigoProductoInput.disabled = false;
        escanearBtn.disabled = false;
        mensajeCompra.innerHTML = '';
    });

    escanearBtn.addEventListener('click', () => {
        modal.style.display = 'block';
        buscarProductoInput.value = '';
        resultadosBusqueda.innerHTML = '';
    });

    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    buscarProductoInput.addEventListener('input', function () {
        const query = this.value.trim();
        if (query.length < 1) return;

        fetch(`/includes/buscar_producto.php?query=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                resultadosBusqueda.innerHTML = '';
                data.forEach(producto => {
                    const div = document.createElement('div');
                    div.classList.add('result-item');
                    div.textContent = `${producto.nombre} - $${parseFloat(producto.precio).toFixed(2)}`;
                    div.addEventListener('click', () => {
                        const productoFormateado = {
                            id: parseInt(producto.id),
                            nombre: producto.nombre,
                            precio: parseFloat(producto.precio),
                            cantidad: 1
                        };
                        agregarProducto(productoFormateado);
                        modal.style.display = 'none';
                    });
                    resultadosBusqueda.appendChild(div);
                });
            });
    });

    codigoProductoInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            const query = this.value.trim();
            if (query === '') return;

            fetch(`/includes/buscar_producto.php?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const p = data[0];
                        agregarProducto({ id: parseInt(p.id), nombre: p.nombre, precio: parseFloat(p.precio), cantidad: 1 });
                        codigoProductoInput.value = '';
                    }
                });
        }
    });

    function agregarProducto(producto) {
        const existente = productos.find(p => p.id === producto.id);
        if (existente) {
            existente.cantidad += 1;
        } else {
            productos.push(producto);
        }
        renderizarLista();
    }

    metodoBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            metodoPago = btn.getAttribute('data-method');
            metodoBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

    finalizarCompraBtn.addEventListener('click', () => {
        if (productos.length === 0) return;

        fetch('caja.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                accion: 'finalizar',
                productos: productos,
                metodo_pago: metodoPago
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'ok') {
                mensajeCompra.innerHTML = '<span style="color:green;">✅ Compra realizada con éxito</span>';
                productos = [];
                renderizarLista();
                codigoProductoInput.disabled = true;
                escanearBtn.disabled = true;
                finalizarCompraBtn.disabled = true;
            } else {
                mensajeCompra.innerHTML = `<span style="color:red;">❌ Error: ${data.message}</span>`;
            }
        })
        .catch(err => {
            mensajeCompra.innerHTML = `<span style="color:red;">❌ Error de red</span>`;
        });
    });
});
