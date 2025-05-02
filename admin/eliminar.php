<?php 
include '../includes/conexion.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);

// Obtener imagen para eliminarla
$sql_img = "SELECT imagen FROM productos WHERE id = ?";
$stmt_img = $conexion->prepare($sql_img);
$stmt_img->bind_param("i", $id);
$stmt_img->execute();
$result_img = $stmt_img->get_result();
$imagen = $result_img->fetch_assoc()['imagen'];
$stmt_img->close();

// Eliminar producto
$sql = "DELETE FROM productos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Eliminar imagen si no es la default
    if ($imagen != 'default.jpg' && file_exists('../assets/img/'.$imagen)) {
        unlink('../assets/img/'.$imagen);
    }
    header('Location: index.php?success=1');
} else {
    header('Location: index.php?error=1');
}

$stmt->close();
$conexion->close();
exit;
?>