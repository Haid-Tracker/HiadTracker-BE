// Referensi ke elemen
const editButton = document.getElementById("edit-button");
const saveButton = document.getElementById("save-button");
const dataDiriSection = document.getElementById("data-diri-section");
const editDataDiriSection = document.getElementById("edit-data-diri-section");

// Event listener untuk tombol Edit
editButton.addEventListener("click", () => {
  // Menyembunyikan Data Diri dan menampilkan Edit Data Diri
  dataDiriSection.style.display = "none";
  editDataDiriSection.style.display = "block";
});

// Event listener untuk tombol Simpan
saveButton.addEventListener("click", () => {
  // Menyembunyikan Edit Data Diri dan menampilkan Data Diri
  editDataDiriSection.style.display = "none";
  dataDiriSection.style.display = "block";
});
