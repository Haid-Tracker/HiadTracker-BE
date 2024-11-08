document.addEventListener("DOMContentLoaded", function () {
  const drawer = document.getElementById("drawer");
  const hamburger = document.getElementById("hamburger");

  hamburger.addEventListener("click", function () {
    drawer.classList.toggle("open");
    hamburger.classList.toggle("active");
  });
});
