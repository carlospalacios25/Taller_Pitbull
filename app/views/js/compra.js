document.getElementById('agregar-producto').addEventListener('click', function() {
  var productoContainer = document.getElementById('productos-container');
  var nuevoProducto = productoContainer.querySelector('.producto-item').cloneNode(true);
  
  nuevoProducto.querySelectorAll('input').forEach(function(input) {
      input.value = '';
  });

  productoContainer.appendChild(nuevoProducto);
});