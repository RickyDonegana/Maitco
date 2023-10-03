// Lista de proyectos (inicialmente vacía)
const proyectos = [];

// Función para agregar un nuevo proyecto o editar uno existente
function gestionarProyecto(id = null) {
    const proyecto = obtenerDatosProyecto();
    if (!proyecto) {
        alert("Por favor, complete todos los campos.");
        return;
    }

    if (id === null) {
        proyectos.push(proyecto);
        agregarProyectoATabla(proyecto);
    } else {
        const proyectoIndex = proyectos.findIndex((p) => p.id === id);
        if (proyectoIndex !== -1) {
            proyectos[proyectoIndex] = proyecto;
            actualizarFilaProyecto(id, proyecto);
        }
    }

    limpiarFormulario();
    ocultarFormulario();
}

// Función para obtener los datos del proyecto desde el formulario
function obtenerDatosProyecto() {
    const campos = ["nombreProyecto", "descripcionProyecto", "cliente", "desarrollador", "fechaInicio", "fechaEstimada"];
    const proyecto = {};

    for (const campo of campos) {
        const valor = document.getElementById(campo).value;
        if (!valor) {
            return null; // Retorna null si falta algún campo
        }
        proyecto[campo] = valor;
    }

    proyecto.id = proyectos.length + 1;
    return proyecto;
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
    row.id = `proyecto-${proyecto.id}`; // Agrega un ID a la fila
    row.innerHTML = `
        <td>${proyecto.id}</td>
        <td>${proyecto.nombreProyecto}</td>
        <td>${proyecto.descripcionProyecto}</td>
        <td>${proyecto.cliente}</td>
        <td>${proyecto.desarrollador}</td>
        <td>${proyecto.fechaInicio}</td>
        <td>${proyecto.fechaEstimada}</td>
        <td>${proyecto.estado || 'Pendiente'}</td>
        <td>
            <button onclick="gestionarProyecto(${proyecto.id})">Editar</button>
            <button onclick="finalizarProyecto(${proyecto.id})">Finalizar</button>
        </td>
    `;

    tbody.appendChild(row);
}

// Función para actualizar una fila de proyecto en la tabla
function actualizarFilaProyecto(id, proyecto) {
    const fila = document.getElementById(`proyecto-${id}`);
    if (fila) {
        const tdElementos = fila.querySelectorAll('td');
        tdElementos[1].textContent = proyecto.nombreProyecto;
        tdElementos[2].textContent = proyecto.descripcionProyecto;
        tdElementos[3].textContent = proyecto.cliente;
        tdElementos[4].textContent = proyecto.desarrollador;
        tdElementos[5].textContent = proyecto.fechaInicio;
        tdElementos[6].textContent = proyecto.fechaEstimada;
        tdElementos[7].textContent = proyecto.estado || 'Pendiente';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const btnNuevoProyecto = document.getElementById('btnNuevoProyecto');
    const tablaContainer = document.getElementById('tabla-container');
    const nuevoProyectoForm = document.getElementById('nuevoProyectoForm');

    btnNuevoProyecto.addEventListener('click', function () {
        // Cambiar el estado de visibilidad del formulario
        nuevoProyectoForm.style.display = nuevoProyectoForm.style.display === 'none' ? 'block' : 'none';

        // Limpiar el campo oculto del ID del proyecto
        document.getElementById('proyecto_id').value = '';

        // Cambiar el texto del botón de "Guardar" a "Agregar" si el formulario se muestra
        document.getElementById('btnAgregarEditarProyecto').textContent = nuevoProyectoForm.style.display === 'none' ? 'Agregar' : 'Guardar';
    });

    const btnGuardarProyecto = document.getElementById('btnAgregarEditarProyecto');

    btnGuardarProyecto.addEventListener('click', function () {
        const proyectoId = document.getElementById('proyecto_id').value;

        if (proyectoId === '') {
            gestionarProyecto(); // Agregar un nuevo proyecto
        } else {
            gestionarProyecto(parseInt(proyectoId)); // Editar un proyecto existente
        }
    });
});

// Función para finalizar un proyecto
function finalizarProyecto(id) {
    const proyectoIndex = proyectos.findIndex((p) => p.id === id);
    if (proyectoIndex !== -1) {
        // Eliminar el proyecto de la lista de proyectos
        proyectos.splice(proyectoIndex, 1);

        // Eliminar la fila de la tabla
        const fila = document.getElementById(`proyecto-${id}`);
        if (fila) {
            fila.remove();
        }
    }
}
