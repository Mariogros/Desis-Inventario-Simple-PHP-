document.addEventListener('DOMContentLoaded', function() {
    cargarBodegas();
    cargarMonedas();
    
    document.getElementById('bodega').addEventListener('change', function() {
        const bodegaId = this.value;
        cargarSucursales(bodegaId);
    });
    
    document.getElementById('formProducto').addEventListener('submit', function(e) {
        e.preventDefault();
        validarYGuardar();
    });
});

function cargarBodegas() {
    fetch('php/obtener_bodegas.php')
        .then(response => response.json())
        .then(data => {
            const selectBodega = document.getElementById('bodega');
            selectBodega.innerHTML = '<option value="">Seleccione una bodega</option>';
            
            data.forEach(bodega => {
                const option = document.createElement('option');
                option.value = bodega.id;
                option.textContent = bodega.nombre;
                selectBodega.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error al cargar bodegas:', error);
        });
}

function cargarSucursales(bodegaId) {
    const selectSucursal = document.getElementById('sucursal');
    selectSucursal.innerHTML = '<option value="">Seleccione una sucursal</option>';
    
    if (!bodegaId) {
        selectSucursal.disabled = true;
        return;
    }
    
    selectSucursal.disabled = false;
    
    fetch('php/obtener_sucursales.php?bodega_id=' + bodegaId)
        .then(response => response.json())
        .then(data => {
            data.forEach(sucursal => {
                const option = document.createElement('option');
                option.value = sucursal.id;
                option.textContent = sucursal.nombre;
                selectSucursal.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error al cargar sucursales:', error);
        });
}

function cargarMonedas() {
    fetch('php/obtener_monedas.php')
        .then(response => response.json())
        .then(data => {
            const selectMoneda = document.getElementById('moneda');
            selectMoneda.innerHTML = '<option value="">Seleccione una moneda</option>';
            
            data.forEach(moneda => {
                const option = document.createElement('option');
                option.value = moneda.id;
                option.textContent = moneda.nombre + ' (' + moneda.codigo + ')';
                selectMoneda.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error al cargar monedas:', error);
        });
}

function validarCodigo(codigo) {
    if (!codigo || codigo.trim() === '') {
        alert('El código del producto no puede estar en blanco.');
        return false;
    }
    
    if (codigo.length < 5 || codigo.length > 15) {
        alert('El código del producto debe tener entre 5 y 15 caracteres.');
        return false;
    }
    
    const regex = /^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;
    if (!regex.test(codigo)) {
        alert('El código del producto debe contener letras y números.');
        return false;
    }
    
    return true;
}

function validarNombre(nombre) {
    if (!nombre || nombre.trim() === '') {
        alert('El nombre del producto no puede estar en blanco.');
        return false;
    }
    
    if (nombre.length < 2 || nombre.length > 50) {
        alert('El nombre del producto debe tener entre 2 y 50 caracteres.');
        return false;
    }
    
    return true;
}

function validarPrecio(precio) {
    if (!precio || precio.trim() === '') {
        alert('El precio del producto no puede estar en blanco.');
        return false;
    }
    
    const regex = /^\d+(\.\d{1,2})?$/;
    if (!regex.test(precio) || parseFloat(precio) <= 0) {
        alert('El precio del producto debe ser un número positivo con hasta dos decimales.');
        return false;
    }
    
    return true;
}

function validarMateriales() {
    const checkboxes = document.querySelectorAll('input[name="materiales[]"]:checked');
    
    if (checkboxes.length < 2) {
        alert('Debe seleccionar al menos dos materiales para el producto.');
        return false;
    }
    
    return true;
}

function validarBodega(bodega) {
    if (!bodega || bodega === '') {
        alert('Debe seleccionar una bodega.');
        return false;
    }
    
    return true;
}

function validarSucursal(sucursal) {
    if (!sucursal || sucursal === '') {
        alert('Debe seleccionar una sucursal para la bodega seleccionada.');
        return false;
    }
    
    return true;
}

function validarMoneda(moneda) {
    if (!moneda || moneda === '') {
        alert('Debe seleccionar una moneda para el producto.');
        return false;
    }
    
    return true;
}

function validarDescripcion(descripcion) {
    if (!descripcion || descripcion.trim() === '') {
        alert('La descripción del producto no puede estar en blanco.');
        return false;
    }
    
    if (descripcion.length < 10 || descripcion.length > 1000) {
        alert('La descripción del producto debe tener entre 10 y 1000 caracteres.');
        return false;
    }
    
    return true;
}

function verificarCodigoUnico(codigo) {
    return fetch('php/verificar_codigo.php?codigo=' + encodeURIComponent(codigo))
        .then(response => response.json())
        .then(data => {
            if (data.existe) {
                alert('El código del producto ya está registrado.');
                return false;
            }
            return true;
        })
        .catch(error => {
            console.error('Error al verificar código:', error);
            return false;
        });
}

async function validarYGuardar() {
    const codigo = document.getElementById('codigo').value.trim();
    const nombre = document.getElementById('nombre').value.trim();
    const bodega = document.getElementById('bodega').value;
    const sucursal = document.getElementById('sucursal').value;
    const moneda = document.getElementById('moneda').value;
    const precio = document.getElementById('precio').value.trim();
    const descripcion = document.getElementById('descripcion').value.trim();
    
    if (!validarCodigo(codigo)) return;
    if (!validarNombre(nombre)) return;
    if (!validarBodega(bodega)) return;
    if (!validarSucursal(sucursal)) return;
    if (!validarMoneda(moneda)) return;
    if (!validarPrecio(precio)) return;
    if (!validarMateriales()) return;
    if (!validarDescripcion(descripcion)) return;
    
    const codigoEsUnico = await verificarCodigoUnico(codigo);
    if (!codigoEsUnico) return;
    
    const materialesCheckboxes = document.querySelectorAll('input[name="materiales[]"]:checked');
    const materiales = Array.from(materialesCheckboxes).map(cb => cb.value);
    
    const formData = new FormData();
    formData.append('codigo', codigo);
    formData.append('nombre', nombre);
    formData.append('bodega_id', bodega);
    formData.append('sucursal_id', sucursal);
    formData.append('moneda_id', moneda);
    formData.append('precio', precio);
    formData.append('descripcion', descripcion);
    formData.append('materiales', JSON.stringify(materiales));
    
    fetch('php/guardar_producto.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Producto guardado exitosamente.');
            document.getElementById('formProducto').reset();
            document.getElementById('sucursal').innerHTML = '<option value="">Seleccione una sucursal</option>';
            document.getElementById('sucursal').disabled = true;
        } else {
            alert('Error al guardar el producto: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al guardar producto:', error);
        alert('Error al guardar el producto. Por favor, intente nuevamente.');
    });
}
