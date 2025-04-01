<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['tareas'])) {
    $_SESSION['tareas'] = [];
}

// para poder agregar las tareas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nombre'])) {
    $_SESSION['tareas'][] = [
        'tarea' => $_POST['nombre'],
        'completada' => false
    ];
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Una vez complatada la tarea
if (isset($_GET['completar'])) {
    $indice = $_GET['completar'];
    if (isset($_SESSION['tareas'][$indice])) {
        $_SESSION['tareas'][$indice]['completada'] = true;
    }
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Para eliminar la tarea
if (isset($_GET['eliminar'])) {
    $indice = $_GET['eliminar'];
    if (isset($_SESSION['tareas'][$indice])) {
        unset($_SESSION['tareas'][$indice]);
        $_SESSION['tareas'] = array_values($_SESSION['tareas']); // Reindexar
    }
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

$tareas = $_SESSION['tareas'];
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Tareas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Formulario para agregar tareas -->
    <form method="POST" action="">

        <h2>Gestor de Tareas</h2>

        <label for="nombre">Nombre de la Tarea</label>
        <input type="text" id="nombre" name="nombre" placeholder="Ingresar nombre" required>
        
        <div class="buttons">
            <button type="submit" class="btn btn-blue">Agregar</button>
        </div>
    </form>

    <!-- Mostrar las tareas -->
    <div class="task-list">
        <?php if (!empty($tareas)): ?>
            <ul>
                <?php foreach ($tareas as $index => $tarea): ?>
                    <li class="<?php echo $tarea['completada'] ? 'completada' : ''; ?>">
                        <span><?php echo $tarea['tarea']; ?></span>
                        <div class="buttons-task">
                            <?php if (!$tarea['completada']): ?>
                                <a href="?completar=<?php echo $index; ?>" class="btn btn-blue">Completar</a>
                            <?php endif; ?>
                            <a href="?eliminar=<?php echo $index; ?>" class="btn btn-red">Eliminar</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay tareas para mostrar.</p>
        <?php endif; ?>
    </div>
    <div class="image-container" style="text-align: center; margin-top: 30px;">
        <img src="imagenes/imagen.jpeg" alt="Imagen de WhatsApp" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">
        </a>
    </div>

</body>
</html>
