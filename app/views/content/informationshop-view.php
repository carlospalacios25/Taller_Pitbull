<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos a Pitbull Baikers</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="background">
        <!-- Título -->
        <div class="title">
            <h1>Bienvenidos a Pitbull Baikers</h1>
        </div>

        <!-- Contenedor principal con información y mapa -->
        <div class="main-container">
            <!-- Contenedor del contenido horizontal -->
            <div class="content-container">
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

                    <h3>¿Por qué elegirnos?</h3>
                    <p>En Pitbull Baikers, contamos con más de 15 años de experiencia en el mantenimiento y reparación de motocicletas de todo tipo.</p>

                    <h3>Atención al cliente</h3>
                    <p>Nuestro taller ofrece un servicio de atención personalizada.</p>

                    <h4>Horario de atención</h4>
                    <p>Lunes a Viernes: 8:00 AM - 6:00 PM</p>
                    <p>Sábados: 9:00 AM - 5:00 PM</p>

                    <h3>Ubicación y contacto</h3>
                    <p>Cl. 17 Sur, Soacha, Cundinamarca</p>
                    <p>Teléfono: +57 3124219279</p>
                    <p>Email: contacto@pitbullbaikers.com</p>

                    <h4>Formas de pago</h4>
                    <ul>
                        <li>Tarjetas de crédito y débito</li>
                        <li>Transferencias bancarias</li>
                        <li>Pagos en efectivo</li>
                    </ul>
                </div>
            </div>

            <!-- Contenedor del mapa -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3977.1758560674725!2d-74.23888152425916!3d4.562382395412169!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f75466fd8b3e1%3A0xbffacfda8eba0b0b!2sPitbull%20Bikers%20Servicio%20Tecnico!5e0!3m2!1ses!2sco!4v1726276566784!5m2!1ses!2sco" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

    </div>

    <script>
        // Eliminar el efecto de aparición al hacer scroll
        // Deja el contenido siempre visible
        var content = document.getElementById('infoContent');
        content.classList.add('visible');
    </script>

</body>
</html>
