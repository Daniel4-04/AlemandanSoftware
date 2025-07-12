<?php include '../includes/header.php'; ?>
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css">
<main>
    <div class="container">
        <section class="who">
            <h3>Alemandan CRM</h3>
            <h4 class="tagline">¿Por qué escogernos?</h4>

            <div class="info-blocks">
                <div class="info-block">
                    <div class="info-left">
                        <img src="/assets/img/hero1.png" class="left-img" alt="Tareas repetitivas">
                        <p>Libérate de las tareas repetitivas que consumen tu tiempo. Alemandan simplifica procesos, organiza flujos y trabaja de forma automática. Enfócate en hacer crecer tu negocio.</p>
                    </div>
                    <div class="info-right">
                        <img src="/assets/img/body1.png" class="right-img" alt="Servicios conectados">
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-left">
                        <img src="/assets/img/hero2.png" class="left-img" alt="Notificaciones al instante">
                        <p>Conoce el estado de tu tienda en cualquier momento y desde cualquier lugar. Accede a información clara, ordenada y actualizada al instante para tomar el control con confianza.</p>
                    </div>
                    <div class="info-right">
                        <img src="/assets/img/body2.jpg" class="right-img" alt="Reportes actualizados">
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-left">
                        <img src="/assets/img/hero3.png" class="left-img" alt="Aliado estratégico">
                        <p>No es solo una herramienta, es un aliado pensado para ayudarte a evolucionar. Adáptalo a tu forma de trabajar, analiza mejor cada paso y convierte los datos en decisiones inteligentes.</p>
                    </div>                         
                </div>
            </div>
        </section>

        <section class="love">
            <h3><span class="blue">Más </span>que apariencia, <span class="blue">propósito</span>!</h3>
        </section>
    </div>

    <section class="signup">
        <div class="container">
            <h2>¡No te pierdas ninguna novedad!</h2>
            <p class="tagline">Suscríbete y recibe noticias, promociones y actualizaciones directamente en tu correo.</p>
            <form action="" class="signup-form">
                <input type="email" name="email" placeholder="Ingresa tu correo electrónico">
                <input type="submit" value="Enviar">
            </form>
        </div>
    </section>

    <section id="aquatic-section" class="aquatic-section">
        <div class="aquatic-container">
          <div class="aquatic-content">
            <span class="section-subtitle">Descubre</span>
            <h1 class="section-title">Alemandan</h1>
            <hr class="section-divider">
          </div>
      
          <div class="aquatic-swiper swiper">
            <div class="swiper-wrapper">
              <!-- Slide 1 -->
              <div class="swiper-slide aquatic-slide aquatic-slide--one">
                <img src="/assets/img/gallery1.jpg" alt="Galería 1" class="slide-img">
                <div class="slide-content">
                  <h2>Seguridad en cada clic</h2>
                  <p>Tu información está protegida con estándares de seguridad que cuidan cada movimiento. Tu tranquilidad no es opcional, es prioridad.</p>
                  
                </div>
              </div>
              
              <!-- Slide 2 -->
              <div class="swiper-slide aquatic-slide aquatic-slide--two">
                <img src="/assets/img/gallery2.jpg" alt="Galería 1" class="slide-img">
                <div class="slide-content">
                  <h2>Desiciones con datos reales</h2>
                  <p>Toma decisiones más inteligentes con información precisa y actualizada al instante. Ya no gestionas a ciegas: ahora tienes claridad para avanzar con confianza.</p>
                  
                </div>
              </div>
              
              <!-- Slide 3 -->
              <div class="swiper-slide aquatic-slide aquatic-slide--three">
                <img src="/assets/img/gallery3.jpg" alt="Galería 1" class="slide-img">
                <div class="slide-content">
                  <h2>Siempre conectado</h2>
                  <p>Accede a tu negocio desde cualquier lugar, en cualquier momento. Conéctate desde tu celular, tablet o computador sin perder el control de lo que pasa.</p>
                  
                </div>
              </div>
              
              <!-- Slide 4 -->
              <div class="swiper-slide aquatic-slide aquatic-slide--four">
                <img src="/assets/img/gallery4.jpg" alt="Galería 1" class="slide-img">
                <div class="slide-content">
                  <h2>Tranquilidad en cada paso</h2>
                  <p>Atención rápida, humana y efectiva. Porque entendemos que detrás de cada consulta hay una necesidad real.</p>
                  
                </div>
              </div>
                            
              <!-- Slide 5 -->
              <div class="swiper-slide aquatic-slide aquatic-slide--five">
                <img src="/assets/img/gallery5.jpg" alt="Galería 1" class="slide-img">
                <div class="slide-content">
                  <h2>Simplicidad que impulsa</h2>
                  <p>Cada parte del sistema está pensada para que encuentres lo que buscas sin complicaciones. Navegarlo es tan natural como avanzar.</p>
                  
                </div>
              </div>
            </div>
            <div class="swiper-pagination"></div>
          </div>
      
          <img src="https://cdn.pixabay.com/photo/2021/11/04/19/39/jellyfish-6769173_960_720.png" alt="Jellyfish background" class="aquatic-bg">
          <img src="https://cdn.pixabay.com/photo/2012/04/13/13/57/scallop-32506_960_720.png" alt="Scallop background" class="aquatic-bg2">
        </div>
      </section>

</main>

<!-- Scripts -->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="/assets/js/galeria.js"></script>

<!-- Al final del <body> -->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script>
  const swiper = new Swiper('.aquatic-swiper', {
    loop: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
  });
</script>


<?php include '../includes/footer.php'; ?>
