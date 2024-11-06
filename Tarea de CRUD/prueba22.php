<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Clientes</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #ff7eb9, #ff65a3);
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Contenedor principal */
        .container {
            max-width: 800px;
            width: 100%;
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            opacity: 0.95;
        }

        /* Encabezado */
        h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Campos de formulario */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
        }

        /* Botón de agregar */
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #ff65a3;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #ff3e81;
        }

        /* Tabla de clientes */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #ffe0ec;
            color: #333;
            font-weight: bold;
        }

        /* Botones de edición y eliminación */
        .btn-edit, .btn-delete {
            padding: 6px 12px;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-edit {
            background-color: #ff7eb9;
            transition: background-color 0.3s;
        }

        .btn-edit:hover {
            background-color: #ff4f9a;
        }

        .btn-delete {
            background-color: #ff3e81;
            transition: background-color 0.3s;
        }

        .btn-delete:hover {
            background-color: #e02d6e;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>CRUD de Clientes</h2>
        <div class="form-group">
            <label for="numeroCliente">Número de Cliente</label>
            <input type="text" id="numeroCliente" placeholder="Ingrese el número de cliente">
        </div>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" placeholder="Ingrese el nombre">
        </div>
        <div class="form-group">
            <label for="domicilio">Domicilio</label>
            <input type="text" id="domicilio" placeholder="Ingrese el domicilio">
        </div>
        <div class="form-group">
            <label for="numeroPedido">Número de Pedido</label>
            <input type="text" id="numeroPedido" placeholder="Ingrese el número de pedido">
        </div>
        <button class="btn" onclick="agregarCliente()">Agregar Cliente</button>

        <table>
            <thead>
                <tr>
                    <th>Número de Cliente</th>
                    <th>Nombre</th>
                    <th>Domicilio</th>
                    <th>Número de Pedido</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaClientes">
                <!-- Los registros de clientes aparecerán aquí -->
            </tbody>
        </table>
    </div>

    <script>
        let editIndex = -1;

        // Cargar datos al inicio desde localStorage
        function cargarClientes() {
            const clientes = JSON.parse(localStorage.getItem("clientes")) || [];
            return clientes;
        }

        // Guardar datos en localStorage
        function guardarClientes(clientes) {
            localStorage.setItem("clientes", JSON.stringify(clientes));
        }

        // Renderizar tabla con datos de localStorage
        function renderizarTabla() {
            const clientes = cargarClientes();
            const tablaClientes = document.getElementById('tablaClientes');
            tablaClientes.innerHTML = '';

            clientes.forEach((cliente, index) => {
                const row = `<tr>
                    <td>${cliente.numeroCliente}</td>
                    <td>${cliente.nombre}</td>
                    <td>${cliente.domicilio}</td>
                    <td>${cliente.numeroPedido}</td>
                    <td>
                        <button class="btn-edit" onclick="editarCliente(${index})">Editar</button>
                        <button class="btn-delete" onclick="eliminarCliente(${index})">Eliminar</button>
                    </td>
                </tr>`;
                tablaClientes.innerHTML += row;
            });
        }

        // Agregar o editar cliente
        function agregarCliente() {
            const numeroCliente = document.getElementById('numeroCliente').value;
            const nombre = document.getElementById('nombre').value;
            const domicilio = document.getElementById('domicilio').value;
            const numeroPedido = document.getElementById('numeroPedido').value;

            if (numeroCliente && nombre && domicilio && numeroPedido) {
                const clientes = cargarClientes();
                const cliente = { numeroCliente, nombre, domicilio, numeroPedido };

                if (editIndex === -1) {
                    clientes.push(cliente);
                } else {
                    clientes[editIndex] = cliente;
                    editIndex = -1;
                }

                guardarClientes(clientes);
                limpiarFormulario();
                renderizarTabla();
            } else {
                alert('Por favor, completa todos los campos.');
            }
        }

        // Limpiar formulario
        function limpiarFormulario() {
            document.getElementById('numeroCliente').value = '';
            document.getElementById('nombre').value = '';
            document.getElementById('domicilio').value = '';
            document.getElementById('numeroPedido').value = '';
        }

        // Editar cliente
        function editarCliente(index) {
            editIndex = index;
            const clientes = cargarClientes();
            const cliente = clientes[index];
            document.getElementById('numeroCliente').value = cliente.numeroCliente;
            document.getElementById('nombre').value = cliente.nombre;
            document.getElementById('domicilio').value = cliente.domicilio;
            document.getElementById('numeroPedido').value = cliente.numeroPedido;
        }

        // Eliminar cliente
        function eliminarCliente(index) {
            const clientes = cargarClientes();
            clientes.splice(index, 1);
            guardarClientes(clientes);
            renderizarTabla();
        }

        // Cargar datos en la tabla al iniciar
        window.onload = renderizarTabla;
    </script>
</body>
</html>
