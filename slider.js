// Menunggu hingga DOM selesai dimuat
document.addEventListener("DOMContentLoaded", function () {
  // Inisialisasi Swiper
  const swiper = new Swiper(".swiper-container", {
    loop: true, // Looping slide
    autoplay: {
      delay: 5000, // Waktu delay antar slide
    },
    effect: "fade", // Efek transisi
    speed: 1000,
  });
});
