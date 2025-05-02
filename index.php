<?php include 'includes/header.php'; ?>

<h1 class="mb-4">Bienvenido a Alss</h1>
<p class="lead">Tu tienda deportiva online con los mejores productos.</p>

<div class="row mt-5">
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <img src="assets/img/zapatillas.jpg" class="card-img-top" alt="Zapatillas">
            <div class="card-body">
                <h5 class="card-title">Zapatillas</h5>
                <p class="card-text">Encuentra las mejores zapatillas para tu deporte favorito.</p>
                <a href="productos.php?categoria=Zapatillas" class="btn btn-primary">Ver productos</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <img src="assets/img/ropa.jpg" class="card-img-top" alt="Ropa">
            <div class="card-body">
                <h5 class="card-title">Ropa Deportiva</h5>
                <p class="card-text">Viste con lo mejor para tus entrenamientos y competiciones.</p>
                <a href="productos.php?categoria=Ropa" class="btn btn-primary">Ver productos</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <img src="assets/img/accesorios.jpg" class="card-img-top" alt="Accesorios">
            <div class="card-body">
                <h5 class="card-title">Accesorios</h5>
                <p class="card-text">Todo lo que necesitas para complementar tu equipo deportivo.</p>
                <a href="productos.php?categoria=Accesorios" class="btn btn-primary">Ver productos</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>