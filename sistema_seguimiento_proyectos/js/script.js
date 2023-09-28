// Función para agregar un nuevo proyecto (debes implementar la lógica para agregarlo a la lista de proyectos)
function agregarProyecto() {
    // Obtén los valores del formulario y agrega el nuevo proyecto a la lista de proyectos
    const nuevoProyecto = {
        id: proyectos.length + 1,
        nombre: document.getElementById('nombreProyecto').value,
        descripcion: document.getElementById('descripcionProyecto').value,
        fechaInicio: document.getElementById('fechaInicio').value,
        fechaEstimada: document.getElementById('fechaEstimada').value,
    };

    proyectos.push(nuevoProyecto);

    // Limpia el formulario y vuelve a cargar los proyectos
    document.getElementById('nombreProyecto').value = '';
    document.getElementById('descripcionProyecto').value = '';
    document.getElementById('fechaInicio').value = '';
    document.getElementById('fechaEstimada').value = '';

    // Agregar el nuevo proyecto a la tabla
    agregarProyectoATabla(nuevoProyecto);
}

// Función para agregar un proyecto a la tabla
function agregarProyectoATabla(proyecto) {
    const tbody = document.querySelector('tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${proyecto.id}</td>
        <td>${proyecto.nombre}</td>
        <td>${proyecto.descripcion}</td>
        <td>${proyecto.fechaInicio}</td>
        <td>${proyecto.fechaEstimada}</td>
        <td>
            <button onclick="editarProyecto(${proyecto.id})">Editar</button>
            <button onclick="finalizarProyecto(${proyecto.id})">Finalizar</button>
        </td>
    `;

    tbody.appendChild(row);
}

// Resto de tu código...

document.addEventListener('DOMContentLoaded', function () {
    const btnNuevoProyecto = document.getElementById('btnNuevoProyecto');
    const nuevoProyectoForm = document.getElementById('nuevoProyectoForm');

    // Mostrar el formulario al hacer clic en el botón "Nuevo Proyecto"
    btnNuevoProyecto.addEventListener('click', function () {
        nuevoProyectoForm.style.display = 'block';
    });

    // Llama a la función para cargar los proyectos cuando se carga la página
    cargarProyectos();
});
