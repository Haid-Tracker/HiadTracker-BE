const showBanner = (selector) => {
    hideBanners();
    // Ensure animation plays even if the same alert type is triggered.
    requestAnimationFrame(() => {
        const banner = document.querySelector(selector);
        banner.classList.add("visible");
    });
};

const hideBanners = () => {
    document.querySelectorAll(".banner.visible").forEach((b) => {
        // Menambahkan animasi keluar
        b.classList.add("removing");
        b.classList.remove("visible");

        // Tunggu animasi selesai sebelum menghapus elemen dari DOM
        setTimeout(() => {
            b.parentNode.removeChild(b);
        }, 600); // Sesuaikan waktu dengan durasi animasi banner-out
    });
};

// Load Eva Icons
const script = document.createElement('script');
script.src = "https://unpkg.com/eva-icons";
script.onload = () => { eva.replace(); };
document.body.appendChild(script);
