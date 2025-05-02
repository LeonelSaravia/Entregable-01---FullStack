<?php 
include 'includes/conexion.php';
include 'includes/header.php'; 

// Obtener parámetros de búsqueda
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$precio_min = isset($_GET['precio_min']) ? floatval($_GET['precio_min']) : 0;
$precio_max = isset($_GET['precio_max']) ? floatval($_GET['precio_max']) : 9999;

// Construir consulta SQL
$sql = "SELECT * FROM productos WHERE precio BETWEEN ? AND ?";
$params = array($precio_min, $precio_max);
$types = "dd";

if (!empty($categoria)) {
    $sql .= " AND categoria = ?";
    $params[] = $categoria;
    $types .= "s";
}

if (!empty($busqueda)) {
    $sql .= " AND (nombre LIKE ? OR marca LIKE ? OR modelo LIKE ?)";
    $search_term = "%$busqueda%";
    $params = array_merge($params, [$search_term, $search_term, $search_term]);
    $types .= "sss";
}

// Preparar y ejecutar consulta
$stmt = $conexion->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<h1 class="mb-4">Nuestros Productos</h1>

<div class="row">
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Filtrar Productos</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="productos.php">
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <select class="form-select" id="categoria" name="categoria">
                            <option value="">Todas</option>
                            <option value="Zapatillas" <?php echo ($categoria == 'Zapatillas') ? 'selected' : ''; ?>>Zapatillas</option>
                            <option value="Ropa" <?php echo ($categoria == 'Ropa') ? 'selected' : ''; ?>>Ropa</option>
                            <option value="Accesorios" <?php echo ($categoria == 'Accesorios') ? 'selected' : ''; ?>>Accesorios</option>
                            <option value="Tenis" <?php echo ($categoria == 'Tenis') ? 'selected' : ''; ?>>Tenis</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="precio_min" class="form-label">Precio Mínimo</label>
                        <input type="number" class="form-control" id="precio_min" name="precio_min" value="<?php echo $precio_min; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="precio_max" class="form-label">Precio Máximo</label>
                        <input type="number" class="form-control" id="precio_max" name="precio_max" value="<?php echo $precio_max; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Aplicar Filtros</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <?php if ($resultado->num_rows > 0): ?>
            <div class="row">
                <?php while ($producto = $resultado->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="assets/img/<?php echo $producto['imagen']; ?>" class="card-img-top" alt="<?php echo $producto['nombre']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                                <p class="card-text"><?php echo $producto['marca'] . ' ' . $producto['modelo']; ?></p>
                                <p class="card-text"><?php echo $producto['descripcion']; ?></p>
                                <p class="text-success fw-bold">$<?php echo number_format($producto['precio'], 2); ?></p>
                                <p class="text-muted">Categoría: <?php echo $producto['categoria']; ?></p>
                            </div>
                            <div class="card-footer bg-white">
                                <button class="btn btn-primary w-100">Agregar al carrito</button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">No se encontraron productos con los criterios de búsqueda seleccionados.</div>
        <?php endif; ?>
    </div>
</div>

<?php 
$stmt->close();
$conexion->close();
include 'includes/footer.php'; 
?>