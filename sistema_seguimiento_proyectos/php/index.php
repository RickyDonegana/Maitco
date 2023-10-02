<?php
// Conexión a la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_de_datos = "ssp_db";

// Crear una conexión
$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión a la base de datos fallida: " . $conn->connect_error);
}

// Obtener el tipo de usuario actual (puedes obtenerlo de tu sesión o de algún otro método)
$userType = "Cliente"; // Cambia esto por el tipo de usuario actual

// Consulta SQL para obtener los proyectos según el tipo de usuario
$sql = "SELECT project_name, description, start_date, estimated_delivery_date FROM proyectos WHERE client = '$userType' OR developer = '$userType'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos | Maitco</title>
    <link rel="shortcut icon" href="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" type="image/png">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body>
    <!-- Encabezado de la página con menú fijo -->
    <header class="header">
        <nav class="menu">
            <div class="logo">
                <img src="https://maitco.com/wp-content/uploads/2017/07/LOGO-CHICO-2.png" alt="Logo de la Empresa">
            </div>
            <ul class="tabs">
                <li><a href="../php/index.php">Inicio</a></li>
                <li><a href="../php/proyectos.php">Proyectos</a></li>
                <li><a href="../html/tareas.html">Tareas</a></li>
                <li><a href="../html/configuracion.html">Configuración</a></li>
            </ul>
            <div class="user-icon">
                <img src="user-icon.png" alt="Icono de Usuario">
            </div>
        </nav>
    </header>

    <!-- Contenido principal con proyectos -->
    <main class="main-content">
        <section class="project-container">
            <?php
            // Iterar a través de los resultados de la consulta y mostrar los proyectos
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="project-box">';
                    echo '<h3 class="project-title">' . $row["project_name"] . '</h3>';
                    echo '<p class="project-description">' . $row["description"] . '</p>';
                    echo '<p class="project-dates">';
                    echo 'Fecha de Inicio: ' . $row["start_date"] . '<br>';
                    echo 'Fecha Estimada de Finalización: ' . $row["estimated_delivery_date"];
                    echo '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No se encontraron proyectos para este usuario.</p>';
            }

            // Cerrar la conexión a la base de datos
            $conn->close();
            ?>
        </section>
    </main>

    <!-- Pie de página u otros elementos adicionales si es necesario -->
</body>

</html>