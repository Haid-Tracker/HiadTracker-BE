document.addEventListener("DOMContentLoaded", function () {
  // Seleksi semua elemen toggle-password
  const togglePasswordIcons = document.querySelectorAll(".toggle-password");

  togglePasswordIcons.forEach((icon) => {
    icon.addEventListener("click", function () {
      // Ambil elemen input yang terkait menggunakan atribut toggle
      const inputField = document.querySelector(this.getAttribute("toggle"));

      if (inputField.type === "password") {
        inputField.type = "text";
        this.classList.remove("fa-eye");
        this.classList.add("fa-eye-slash");
      } else {
        inputField.type = "password";
        this.classList.remove("fa-eye-slash");
        this.classList.add("fa-eye");
      }
    });
  });
});

// CDN JS Fontawesome
src = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js";
defer;
// CDN JS Fontawesome
