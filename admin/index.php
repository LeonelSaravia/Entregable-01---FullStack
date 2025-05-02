<?php 
include '../includes/conexion.php';
include '../includes/header.php'; 

// Verificar si es administrador (en un proyecto real usarías autenticación)
?>

<h1 class="mb-4">Panel de Administración</h1>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <h5 class="card-title">Productos</h5>
                <p class="card-text">Administra los productos de la tienda</p>
                <a href="agregar.php" class="btn btn-success">Agregar Producto</a>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5>Lista de Productos</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT id, nombre, precio, categoria, stock FROM productos ORDER BY id DESC";
                    $resultado = $conexion->query($sql);
                    
                    if ($resultado->num_rows > 0) {
                        while($fila = $resultado->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$fila['id']}</td>
                                    <td>{$fila['nombre']}</td>
                                    <td>$".number_format($fila['precio'], 2)."</td>
                                    <td>{$fila['categoria']}</td>
                                    <td>{$fila['stock']}</td>
                                    <td>
                                        <a href='editar.php?id={$fila['id']}' class='btn btn-sm btn-warning'>Editar</a>
                                        <a href='eliminar.php?id={$fila['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"¿Estás seguro?\")'>Eliminar</a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No hay productos registrados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
$conexion->close();
include '../includes/footer.php'; 
?>