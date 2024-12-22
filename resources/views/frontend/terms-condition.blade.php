@extends('frontend.layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/frontend/style/terms-condition/style.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/frontend/style/terms-condition/responsive.css') }}" />
@endsection

@section('content')
<div class="main-content">
    <section class="terms-container">
      <h1>Terms & Conditions</h1>
      <div class="terms-content">
        <h3>Penggunaan Layanan</h3>
        <ul>
          <li>HaidTracker menyediakan layanan pencatatan dan pelacakan siklus menstruasi serta gejala yang dialami pengguna.</li>
          <li>Dengan menggunakan layanan ini, pengguna menyatakan setuju untuk mematuhi semua ketentuan yang ditetapkan dalam dokumen ini.</li>
        </ul>

        <h3>Registrasi dan Akun</h3>
        <ul>
          <li>Pengguna diwajibkan untuk memberikan informasi yang akurat dan terkini selama proses pendaftaran.</li>
          <li>Setiap pengguna bertanggung jawab atas kerahasiaan informasi login akun mereka.</li>
          <li>HaidTracker berhak menangguhkan atau menghapus akun jika ditemukan pelanggaran terhadap ketentuan layanan.</li>
        </ul>

        <h3>Privasi dan Keamanan Data</h3>
        <ul>
          <li>Data pribadi pengguna akan dikelola sesuai dengan Kebijakan Privasi.</li>
          <li>Meskipun HaidTracker mengambil langkah untuk melindungi data pengguna, pengguna juga menyadari bahwa tidak ada sistem yang sepenuhnya aman.</li>
        </ul>

        <h3>Larangan Penggunaan</h3>
        <ul>
          <li>Pengguna dilarang menggunakan layanan ini untuk tujuan ilegal, merusak sistem, atau aktivitas lain yang bertentangan dengan hukum.</li>
        </ul>

        <h3>Hak Kekayaan Intelektual</h3>
        <ul>
          <li>Semua konten, desain, logo, dan teknologi di HaidTracker merupakan hak milik HaidTracker dan dilindungi undang-undang kekayaan intelektual.</li>
        </ul>

        <h3>Batas Tanggung Jawab</h3>
        <ul>
          <li>HaidTracker bukan pengganti saran medis profesional. Informasi yang diberikan hanya bersifat panduan.</li>
          <li>HaidTracker tidak bertanggung jawab atas kesalahan data yang dimasukkan pengguna atau hasil prediksi yang kurang akurat.</li>
        </ul>

        <h3>Perubahan Layanan</h3>
        <ul>
          <li>HaidTracker berhak mengubah, menambah, atau menghentikan layanan sewaktu-waktu dengan atau tanpa pemberitahuan.</li>
        </ul>

        <h3>Usia Minimum</h3>
        <ul>
          <li>Pengguna harus berusia 18 tahun atau lebih. Jika berusia di bawah 18 tahun, diperlukan persetujuan orang tua atau wali.</li>
        </ul>

        <h3>Perselisihan Hukum</h3>
        <ul>
          <li>Syarat dan ketentuan ini diatur oleh hukum yang berlaku di Indonesia.</li>
        </ul>

        <h3>Persetujuan</h3>
        <ul>
          <li>Dengan menggunakan layanan HaidTracker, pengguna dianggap telah membaca, memahami, dan menyetujui syarat dan ketentuan ini.</li>
        </ul>
      </div>
    </section>

    <section class="privacy-policy">
      <h1>Privacy Policy</h1>
      <div class="privacy-content">
        <h3>Informasi yang Dikumpulkan</h3>
        <ul>
          <li>HaidTracker mengumpulkan data pribadi seperti nama, email, dan data siklus menstruasi yang diberikan pengguna secara langsung.</li>
        </ul>

        <h3>Penggunaan Informasi</h3>
        <ul>
          <li>Informasi yang dikumpulkan digunakan untuk menyediakan layanan, meningkatkan fitur, dan memberi pengalaman pengguna yang lebih baik.</li>
          <li>Data pengguna juga dapat dianonimkan untuk keperluan statistik dan pengembangan aplikasi.</li>
        </ul>

        <h3>Keamanan Data</h3>
        <ul>
          <li>HaidTracker menggunakan langkah-langkah keamanan untuk melindungi informasi pengguna dari akses yang tidak sah.</li>
          <li>Namun, pengguna memahami bahwa tidak ada sistem keamanan yang sepenuhnya aman.</li>
        </ul>

        <h3>Berbagi Informasi</h3>
        <ul>
          <li>HaidTracker tidak akan membagikan informasi pribadi pengguna kepada pihak ketiga tanpa persetujuan, kecuali diwajibkan oleh hukum.</li>
        </ul>

        <h3>Hak Pengguna</h3>
        <ul>
          <li>Pengguna memiliki hak untuk mengakses, memperbarui, atau menghapus data pribadi mereka.</li>
          <li>Permintaan terkait data dapat dilakukan melalui kontak resmi HaidTracker.</li>
        </ul>

        <h3>Penggunaan Cookie</h3>
        <ul>
          <li>HaidTracker dapat menggunakan cookie untuk meningkatkan pengalaman pengguna.</li>
          <li>Pengguna dapat menyesuaikan pengaturan cookie melalui browser mereka.</li>
        </ul>

        <h3>Perubahan Kebijakan Privasi</h3>
        <ul>
          <li>Kebijakan Privasi ini dapat diperbarui dari waktu ke waktu. Perubahan akan diberitahukan melalui situs atau email.</li>
        </ul>

        <h3>Kontak</h3>
        <ul>
          <li>Untuk pertanyaan atau masalah terkait Kebijakan Privasi, pengguna dapat menghubungi kami di
            <a href="mailto:tugaskolaborasi02@gmail.com">tugaskolaborasi02@gmail.com</a>.
          </li>
        </ul>
      </div>
    </section>
</div>

@endsection
