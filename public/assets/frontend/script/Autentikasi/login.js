document.addEventListener("DOMContentLoaded", () => {
  const togglePassword = document.querySelector(".toggle-password");
  const passwordField = document.querySelector("#password-field");

  togglePassword.addEventListener("click", () => {
    // Toggle type password/visible
    const type =
      passwordField.getAttribute("type") === "password" ? "text" : "password";
    passwordField.setAttribute("type", type);

    // Toggle icon
    togglePassword.classList.toggle("fa-eye");
    togglePassword.classList.toggle("fa-eye-slash");
  });
});

// CDN JS Fontawesome
src = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js";
defer;
// CDN JS Fontawesome
