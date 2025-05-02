document.addEventListener('DOMContentLoaded', function() {
    // Validación de formulario de productos
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const precio = form.querySelector('#precio');
            if (precio && parseFloat(precio.value) <= 0) {
                e.preventDefault();
                alert('El precio debe ser mayor que cero');
                precio.focus();
            }
            
            const stock = form.querySelector('#stock');
            if (stock && parseInt(stock.value) < 0) {
                e.preventDefault();
                alert('El stock no puede ser negativo');
                stock.focus();
            }
        });
    });
    
    // Mostrar mensajes de éxito/error
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        alert('Operación realizada con éxito');
    } else if (urlParams.has('error')) {
        alert('Ocurrió un error al realizar la operación');
    }
});