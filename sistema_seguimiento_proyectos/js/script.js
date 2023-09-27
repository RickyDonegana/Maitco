// Este es un ejemplo de cómo podrías cargar proyectos ficticios en la tabla.
// En tu aplicación, estos datos deberían provenir de tu base de datos o servicio.

const proyectos = [
    {
        id: 1,
        nombre: 'Proyecto 1',
        descripcion: 'Descripción del Proyecto 1',
        fechaInicio: '2023-10-01',
        fechaEstimada: '2023-11-15',
    },
    {
        id: 2,
        nombre: 'Proyecto 2',
        descripcion: 'Descripción del Proyecto 2',
        fechaInicio: '2023-10-15',
        fechaEstimada: '2023-12-31',
    },
    // Agrega más proyectos aquí...
];

// Función para cargar los proyectos en la tabla
function cargarProyectos() {
    const tbody = document.querySelector('tbody');
    tbody.innerHTML = '';

    proyectos.forEach((proyecto) => {
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
    });
}

// Función para mostrar el formulario de nuevo proyecto
function mostrarFormularioNuevoProyecto() {
    const formulario = document.getElementById('nuevoProyectoForm');
    formulario.style.display = 'block';
}

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

    cargarProyectos();
}

// Llama a la función para cargar los proyectos cuando se carga la página
cargarProyectos();
