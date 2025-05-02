<?php 
include '../includes/conexion.php';
include '../includes/header.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = floatval($_POST['precio']);
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $stock = intval($_POST['stock']);
    
    // Procesar imagen
    $imagen = 'default.jpg';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imagen = uniqid().'.'.$extension;
        move_uploaded_file($_FILES['imagen']['tmp_name'], '../assets/img/'.$imagen);
    }
    
    $sql = "INSERT INTO productos (nombre, descripcion, precio, categoria, marca, modelo, imagen, stock) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssdssssi", $nombre, $descripcion, $precio, $categoria, $marca, $modelo, $imagen, $stock);
    
    if ($stmt->execute()) {
        echo '<div class="alert alert-success">Producto agregado correctamente.</div>';
    } else {
        echo '<div class="alert alert-danger">Error al agregar el producto: '.$conexion->error.'</div>';
    }
    
    $stmt->close();
}
?>

<h1 class="mb-4">Agregar Producto</h1>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre del Producto</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select class="form-select" id="categoria" name="categoria" required>
                <option value="">Seleccionar...</option>
                <option value="Zapatillas">Zapatillas</option>
                <option value="Ropa">Ropa</option>
                <option value="Accesorios">Accesorios</option>
                <option value="Tenis">Tenis</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="marca" class="form-label">Marca</label>
            <input type="text" class="form-control" id="marca" name="marca" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="modelo" class="form-label">Modelo</label>
            <input type="text" class="form-control" id="modelo" name="modelo">
        </div>
    </div>
    <div class="mb-3">
        <label for="imagen" class="form-label">Imagen del Producto</label>
        <input type="file" class="form-control" id="imagen" name="imagen">
    </div>
    <button type="submit" class="btn btn-primary">Guardar Producto</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php 
$conexion->close();
include '../includes/footer.php'; 
?>