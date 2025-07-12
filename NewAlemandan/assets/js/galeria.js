// Corregir el selector para que coincida con el HTML
var swiper = new Swiper(".aquatic-swiper", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    autoplay: {
        delay: 1800,
        pauseOnMouseEnter: false,
        disableOnInteraction: false
    },
    coverflowEffect: {
        rotate: 0,
        stretch: 0,
        depth: 100,
        modifier: 3,
        slideShadows: true
    },
    loop: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        300: { slidesPerView: 1 },  // Móviles pequeños
        640: { slidesPerView: 1 },  // Móviles
        768: { slidesPerView: 1 },  // Tablets
        1024: { slidesPerView: 2 }, // Laptops
        1560: { slidesPerView: 3 }  // Escritorios grandes
    }
});