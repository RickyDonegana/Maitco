// Lista de proyectos (simulación de datos)
const proyectos = [];

// Función para agregar un nuevo proyecto
function agregarProyecto() {
    const campos = ["nombreProyecto", "descripcionProyecto", "cliente", "desarrollador", "fechaInicio", "fechaEstimada"];
    const proyecto = {};

    // Verificar que todos los campos estén completos
    for (const campo of campos) {
        const valor = document.getElementById(campo).value;
        if (!valor) {
            alert("Por favor, complete todos los campos.");
            return;
        }
        proyecto[campo] = valor;
    }

    proyecto.id = proyectos.length + 1;
    proyectos.push(proyecto);
    limpiarFormulario();
    agregarProyectoATabla(proyecto);
    ocultarFormulario();
}

// Función para limpiar el formulario
function limpiarFormulario() {
    const campos = ["nombreProyecto", "descripcionProyecto", "cliente", "desarrollador", "fechaInicio", "fechaEstimada"];
    for (const campo of campos) {
        document.getElementById(campo).value = '';
    }
}

// Función para agregar un proyecto a la tabla
function agregarProyectoATabla(proyecto) {
    const tbody = document.querySelector('tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${proyecto.id}</td>
        <td>${proyecto.nombre}</td>
        <td>${proyecto.descripcion}</td>
        <td>${proyecto.cliente}</td>
        <td>${proyecto.desarrollador}</td>
        <td>${proyecto.fechaInicio}</td>
        <td>${proyecto.fechaEstimada}</td>
        <td>
            <button onclick="editarProyecto(${proyecto.id})">Editar</button>
            <button onclick="finalizarProyecto(${proyecto.id})">Finalizar</button>
        </td>
    `;

    tbody.appendChild(row);
}

// Función para cargar proyectos (simulación de carga)
function cargarProyectos() {
    for (let i = 0; i < 5; i++) {
        const proyecto = {
            id: i + 1,
            nombre: `Proyecto ${i + 1}`,
            descripcion: `Descripción del Proyecto ${i + 1}`,
            cliente: `Cliente ${i + 1}`,
            desarrollador: `Desarrollador ${i + 1}`,
            fechaInicio: '2023-10-01',
            fechaEstimada: '2023-10-31',
        };
        proyectos.push(proyecto);
        agregarProyectoATabla(proyecto);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const btnNuevoProyecto = document.getElementById('btnNuevoProyecto');
    const tablaContainer = document.getElementById('tabla-container');

    btnNuevoProyecto.addEventListener('click', function () {
        tablaContainer.style.display = 'none'; // Oculta la tabla
    });

    cargarProyectos();
});
