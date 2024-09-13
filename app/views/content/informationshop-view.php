<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pitbull Baikers</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .background {
            background-image: url('https://i.pinimg.com/236x/57/12/8f/57128f7a189cad5eca4df652234aaebc.jpg'); /* Asegúrate de poner la ruta correcta de tu imagen */
            background-size: cover; /* Esto hace que la imagen cubra todo el fondo */
            background-position: center;
            height: 100vh; /* Esto hace que la sección ocupe toda la altura de la pantalla */
            display: flex;
            justify-content: center; /* Centra horizontalmente el contenido */
            align-items: center; /* Centra verticalmente el contenido */
            position: relative;
            flex-direction: column; /* Organiza el contenido verticalmente */
        }

        .title {
            text-align: center; /* Centra el título */
            color: black; /* Título en color negro */
            background-color: rgba(255, 255, 255, 0.7); /* Fondo blanco semitransparente */
            padding: 10px 20px; /* Espaciado interno */
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra del título */
            width: 100%; /* Toma el ancho completo */
            max-width: 800px; /* Ancho máximo para el título */
            margin-bottom: 20px; /* Espacio entre el título y el contenido */
        }

        .content {
            text-align: left; /* Alinea todo el texto a la izquierda */
            background-color: white; /* Fondo blanco */
            color: black; /* Texto en color negro */
            padding: 20px;
            border-radius: 10px; /* Bordes redondeados */
            width: 50%; /* Ajusta el ancho del contenido */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Añade una sombra */
            opacity: 0; /* Inicialmente invisible */
            transform: translateY(50px); /* Inicialmente desplazado hacia abajo */
            transition: opacity 1s, transform 1s; /* Efecto de transición suave */
            position: relative; /* Posiciona el contenido relativamente */
        }

        .content h2,
        .content h3,
        .content h4,
        .content h5,
        .content h6 {
            color: black; /* Todos los títulos en color negro */
            margin: 10px 0; /* Margen arriba y abajo de cada título */
        }

        .content h2 {
            margin-top: 0; /* Elimina el margen superior del primer título para alinear con el contenido */
            padding-bottom: 10px; /* Espacio debajo del título */
            border-bottom: 2px solid black; /* Línea inferior para destacar el título */
        }

        .content ul {
            padding-left: 20px; /* Espaciado a la izquierda para la lista */
            margin-top: 10px; /* Espacio arriba de la lista */
        }

        .content li {
            margin-bottom: 10px; /* Espacio entre los ítems de la lista */
        }

        /* Efecto de aparición al desplazarse */
        .content.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="background">
        <!-- Título móvil -->
        <div class="title">
            <h1>Bienvenidos a Pitbull Baikers</h1>
        </div>

        <!-- Contenido desplazable -->
        <div class="content" id="infoContent">
            <h2>Información general</h2>
            <h3>Servicios que ofrecemos</h3>
            <ul>
                <li>Revisión y mantenimiento de motores</li>
                <li>Cambio de aceite y filtros</li>
                <li>Reparación de frenos</li>
                <li>Reemplazo de neumáticos</li>
                <li>Servicio de suspensión</li>
                <li>Ajuste y reparación de transmisión</li>
                <li>Inspección y reparación de sistemas eléctricos</li>
                <li>Reparación de sistemas de escape</li>
            </ul>
            <h4>Productos de referencia</h4>
            <h5>Quinto nivel</h5>
            <h6>Sexto nivel</h6>
        </div>
    </div>

    <script>
        // Añadir efecto de aparición al contenido cuando el usuario baja
        window.addEventListener('scroll', function() {
            var content = document.getElementById('infoContent');
            var contentPosition = content.getBoundingClientRect().top;
            var screenPosition = window.innerHeight / 1.3;

            if (contentPosition < screenPosition) {
                content.classList.add('visible');
            }
        });
    </script>
</body>
</html>
