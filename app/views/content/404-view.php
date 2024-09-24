<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error 404 - Página no encontrada</title>
  <!-- Vincular Bulma CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <style>
    /* Estilos personalizados */
    html, body {
      height: 100%;
      background-color: #f0f8ff; /* Fondo azul claro */
    }

    .hero {
      height: 100vh; /* Altura completa de la ventana */
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .box-custom {
      background-color: white;
      border-radius: 15px;
      padding: 3rem;
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
      max-width: 450px;
      text-align: center;
    }

    .box-custom h1 {
      margin-bottom: 1.5rem;
    }

    .processing-icon {
      font-size: 4rem;
      animation: spin 3s linear infinite;
      color: #3273dc; /* Azul primario de Bulma */
      margin-bottom: 2rem;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .button {
      margin-top: 2rem;
    }
  </style>
</head>
<body>
  <!-- Sección de error 404 -->
  <section class="hero">
    <div class="box box-custom">
      <h1 class="title is-2">
        Error 404
      </h1>
      <br>
      <h2 class="subtitle">
        ¡Ups! La página que buscas no existe.
      </h2>

      <!-- Muñeco procesando (icono de engranaje) -->
      <span class="icon processing-icon">
        <i class="fas fa-cog"></i> <!-- Ícono del muñeco (engranaje) -->
      </span>

      <!-- Botón de regreso al inicio -->
      <p>
      <a href="javascript:history.back()" class="back-button">Volver al inicio</a>
      </p>
    </div>
  </section>

  <!-- Vincular Font Awesome para los iconos -->
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>


