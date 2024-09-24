<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos a Pitbull Baikers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <style>
        .hero {
            background-image: url('https://www.galgo.com/wp-content/uploads/2023/04/yamaha-mt-03.jpeg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            position: relative;
        }
        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }
        .hero-content {
            position: relative;
            z-index: 1;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .hero-content.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .footer {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>

<section class="hero is-fullheight">
    <div class="hero-body">
        <div class="container hero-content">
            <h1 class="title has-text-white has-text-centered is-size-1">
                Bienvenidos a Pitbull Baikers
            </h1>
            <h2 class="subtitle has-text-white has-text-centered is-size-4">
                Tu taller de confianza para el cuidado de tu moto
            </h2>
            <div class="content has-text-white has-text-centered">
                <p>Scroll para descubrir más sobre nuestros servicios</p>
                <span class="icon is-large">
                    <i class="fas fa-chevron-down"></i>
                </span>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="columns">
            <div class="column is-two-thirds">
                <h2 class="title is-2">Información general</h2>

                <h3 class="title is-4">Servicios que ofrecemos</h3>
                <div class="content">
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
                </div>

                <h3 class="title is-4">¿Por qué elegirnos?</h3>
                <p class="content">En Pitbull Baikers, contamos con más de 15 años de experiencia en el mantenimiento y reparación de motocicletas de todo tipo.</p>

                <h3 class="title is-4">Atención al cliente</h3>
                <p class="content">Nuestro taller ofrece un servicio de atención personalizada.</p>

                <h4 class="title is-5">Horario de atención</h4>
                <p class="content">
                    Lunes a Viernes: 8:00 AM - 6:00 PM<br>
                    Sábados: 9:00 AM - 5:00 PM
                </p>

                <h3 class="title is-4">Ubicación y contacto</h3>
                <p class="content">
                    Cl. 17 Sur, Soacha, Cundinamarca<br>
                    Teléfono: +57 3124219279<br>
                    Email: contacto@pitbullbaikers.com
                </p>

                <h4 class="title is-5">Formas de pago</h4>
                <div class="content">
                    <ul>
                        <li>Tarjetas de crédito y débito</li>
                        <li>Transferencias bancarias</li>
                        <li>Pagos en efectivo</li>
                    </ul>
                </div>
            </div>
            
            <div class="column">
                <h3 class="title is-4">Nuestra ubicación</h3>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3977.1758560674725!2d-74.23888152425916!3d4.562382395412169!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f75466fd8b3e1%3A0xbffacfda8eba0b0b!2sPitbull%20Bikers%20Servicio%20Tecnico!5e0!3m2!1ses!2sco!4v1726276566784!5m2!1ses!2sco" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                
                <div class="content mt-4">
                    <p>Estamos ubicados en el corazón de Soacha, ofreciendo fácil acceso y amplio espacio para estacionamiento. Nuestra ubicación estratégica nos permite atender a clientes de toda la región de Cundinamarca.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-narrow">
                <h3 class="title is-4">Contáctanos</h3>
                <div class="content">
                    <p>
                        <a href="mailto:contacto@pitbullbaikers.com" class="is-flex is-align-items-center">
                            <span class="icon mr-2">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/4/4e/Gmail_Icon.png" alt="Gmail" width="24">
                            </span>
                            contacto@pitbullbaikers.com
                        </a>
                    </p>
                    <p>
                        <a href="https://www.facebook.com/PitbullBaikers" class="is-flex is-align-items-center">
                            <span class="icon mr-2">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook" width="24">
                            </span>
                            Pitbull Baikers
                        </a>
                    </p>
                    <p>
                        <a href="https://wa.me/573124219279" class="is-flex is-align-items-center">
                            <span class="icon mr-2">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" width="24">
                            </span>
                            +57 3124219279
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const heroContent = document.querySelector('.hero-content');
        
        function checkScroll() {
            let scrollPosition = window.pageYOffset;
            
            if (scrollPosition > 50) {
                heroContent.classList.add('visible');
            }
        }

        window.addEventListener('scroll', checkScroll);
    });
</script>
</body>
</html>