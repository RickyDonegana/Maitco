// Lista de proyectos (inicialmente vacía)
const proyectos = [];

// Función para obtener los datos del proyecto desde el formulario
function obtenerDatosProyecto() {
    const campos = ["nombre_proyecto", "descripcion", "cliente", "desarrollador", "fecha_inicio", "fecha_entrega_estimada", "estado"];
    const proyecto = {};

    for (const campo of campos) {
        const valor = document.getElementById(campo).value.trim();
        if (!valor) {
            return null; // Retorna null si falta algún campo
        }
        proyecto[campo] = valor;
    }

    return proyecto;
}

// Función para limpiar el formulario
function limpiarFormulario() {
    const campos = ["nombre_proyecto", "descripcion", "cliente", "desarrollador", "fecha_inicio", "fecha_entrega_estimada", "estado"];
    for (const campo of campos) {
        document.getElementById(campo).value = '';
    }
}

// Función para agregar un proyecto a la tabla
function agregarProyectoATabla(proyecto) {
    const tbody = document.querySelector('tbody');
    const row = document.createElement('tr');
    row.id = `proyecto-${proyecto.id_proyecto}`; // Agrega un ID a la fila
    row.innerHTML = `
        <td>${proyecto.id_proyecto}</td>
        <td>${proyecto.nombre_proyecto}</td>
        <td>${proyecto.descripcion}</td>
        <td>${proyecto.cliente}</td>
        <td>${proyecto.desarrollador}</td>
        <td>${proyecto.fecha_inicio}</td>
        <td>${proyecto.fecha_entrega_estimada}</td>
        <td>${proyecto.estado || 'Pendiente'}</td>
        <td>
            <button onclick="editarProyecto(${proyecto.id_proyecto})">Editar</button>
            <button onclick="finalizarProyecto(${proyecto.id_proyecto})">Finalizar</button>
        </td>
    `;

    tbody.appendChild(row);
}

// Función para gestionar un proyecto (agregar o editar)
function gestionarProyecto(id = null) {
    const proyecto = obtenerDatosProyecto();
    if (!proyecto) {
        alert("Por favor, complete todos los campos.");
        return;
    }

    if (id === null) {
        // Agregar un nuevo proyecto
        proyecto.id_proyecto = proyectos.length + 1;
        proyectos.push(proyecto);
        agregarProyectoATabla(proyecto);
    } else {
        // Editar un proyecto existente
        const proyectoIndex = proyectos.findIndex((p) => p.id_proyecto === id);
        if (proyectoIndex !== -1) {
            proyectos[proyectoIndex] = proyecto;
            // No necesitas la función actualizarFilaProyecto, ya que no se define en el código proporcionado
            // Si existe, debes agregarla y usarla aquí
        }
    }

    limpiarFormulario();
    ocultarFormulario();
}

// Función para editar un proyecto existente
function editarProyecto(id) {
    const proyecto = proyectos.find((p) => p.id_proyecto === id);
    if (proyecto) {
        // Llena el formulario con los datos del proyecto
        document.getElementById('id_proyecto').value = proyecto.id_proyecto;
        const campos = ["nombre_proyecto", "descripcion", "cliente", "desarrollador", "fecha_inicio", "fecha_entrega_estimada", "estado"];
        for (const campo of campos) {
            document.getElementById(campo).value = proyecto[campo];
        }

        // Cambia el texto del botón a "Editar"
        document.getElementById('btnAgregarEditarProyecto').textContent = 'Editar';

        // Muestra el formulario
        document.getElementById('nuevoProyectoForm').style.display = 'block';
    }
}

// Función para finalizar un proyecto con confirmación
function finalizarProyecto(id) {
    const proyecto = proyectos.find((p) => p.id_proyecto === id);
    if (proyecto) {
        // Mostrar un mensaje de confirmación
        const confirmar = window.confirm(`¿Estás seguro de que deseas finalizar el proyecto "${proyecto.nombre_proyecto}"?`);
        if (confirmar) {
            // Eliminar el proyecto de la lista de proyectos
            const proyectoIndex = proyectos.indexOf(proyecto);
            if (proyectoIndex !== -1) {
                proyectos.splice(proyectoIndex, 1);
            }

            // Eliminar la fila de la tabla
            const fila = document.getElementById(`proyecto-${id}`);
            if (fila) {
                fila.remove();
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const btnNuevoProyecto = document.getElementById('btnNuevoProyecto');
    const nuevoProyectoForm = document.getElementById('nuevoProyectoForm');

    btnNuevoProyecto.addEventListener('click', function () {
        // Cambiar el estado de visibilidad del formulario
        nuevoProyectoForm.style.display = nuevoProyectoForm.style.display === 'none' ? 'block' : 'none';

        // Limpiar el campo oculto del ID del proyecto
        document.getElementById('id_proyecto').value = '';

        // Cambiar el texto del botón de "Guardar" a "Agregar" si el formulario se muestra
        document.getElementById('btnAgregarEditarProyecto').textContent = nuevoProyectoForm.style.display === 'none' ? 'Agregar' : 'Guardar';
    });

    const btnAgregarEditarProyecto = document.getElementById('btnAgregarEditarProyecto');

    btnAgregarEditarProyecto.addEventListener('click', function () {
        const proyectoId = document.getElementById('id_proyecto').value;

        if (proyectoId === '') {
            gestionarProyecto(); // Agregar un nuevo proyecto
        } else {
            gestionarProyecto(parseInt(proyectoId)); // Editar un proyecto existente
        }
    });

});
