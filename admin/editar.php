<?php 
include '../includes/conexion.php';
include '../includes/header.php'; 

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = floatval($_POST['precio']);
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $stock = intval($_POST['stock']);
    
    // Procesar imagen solo si se subió una nueva
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imagen = uniqid().'.'.$extension;
        move_uploaded_file($_FILES['imagen']['tmp_name'], '../assets/img/'.$imagen);
        
        // Eliminar imagen anterior si no es la default
        $sql_old = "SELECT imagen FROM productos WHERE id = ?";
        $stmt_old = $conexion->prepare($sql_old);
        $stmt_old->bind_param("i", $id);
        $stmt_old->execute();
        $result_old = $stmt_old->get_result();
        $old_img = $result_old->fetch_assoc()['imagen'];
        $stmt_old->close();
        
        if ($old_img != 'default.jpg' && file_exists('../assets/img/'.$old_img)) {
            unlink('../assets/img/'.$old_img);
        }
        
        $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, categoria=?, marca=?, modelo=?, imagen=?, stock=? WHERE id=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssdssssii", $nombre, $descripcion, $precio, $categoria, $marca, $modelo, $imagen, $stock, $id);
    } else {
        $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, categoria=?, marca=?, modelo=?, stock=? WHERE id=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssdsssii", $nombre, $descripcion, $precio, $categoria, $marca, $modelo, $stock, $id);
    }
    
    if ($stmt->execute()) {
        echo '<div class="alert alert-success">Producto actualizado correctamente.</div>';
    } else {
        echo '<div class="alert alert-danger">Error al actualizar el producto: '.$conexion->error.'</div>';
    }
    
    $stmt->close();
}

// Obtener datos del producto
$sql = "SELECT * FROM productos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    header('Location: index.php');
    exit;
}

$producto = $resultado->fetch_assoc();
$stmt->close();
?>

<h1 class="mb-4">Editar Producto</h1>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre del Producto</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $producto['stock']; ?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select class="form-select" id="categoria" name="categoria" required>
                <option value="Zapatillas" <?php echo ($producto['categoria'] == 'Zapatillas') ? 'selected' : ''; ?>>Zapatillas</option>
                <option value="Ropa" <?php echo ($producto['categoria'] == 'Ropa') ? 'selected' : ''; ?>>Ropa</option>
                <option value="Accesorios" <?php echo ($producto['categoria'] == 'Accesorios') ? 'selected' : ''; ?>>Accesorios</option>
                <option value="Tenis" <?php echo ($producto['categoria'] == 'Tenis') ? 'selected' : ''; ?>>Tenis</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="marca" class="form-label">Marca</label>
            <input type="text" class="form-control" id="marca" name="marca" value="<?php echo htmlspecialchars($producto['marca']); ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="modelo" class="form-label">Modelo</label>
            <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo htmlspecialchars($producto['modelo']); ?>">
        </div>
    </div>
    <div class="mb-3">
        <label for="imagen" class="form-label">Imagen del Producto</label>
        <input type="file" class="form-control" id="imagen" name="imagen">
        <?php if ($producto['imagen'] != 'default.jpg'): ?>
            <div class="mt-2">
                <img src="../assets/img/<?php echo $producto['imagen']; ?>" alt="Imagen actual" style="max-height: 100px;">
                <p class="small text-muted mt-1">Imagen actual</p>
            </div>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php 
$conexion->close();
include '../includes/footer.php'; 
?>