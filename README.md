<div align="center">
  
  ![TicketLapor Banner](https://capsule-render.vercel.app/api?type=waving&color=gradient&height=250&section=header&text=TicketLapor&fontSize=70&fontAlignY=35&desc=Sistem%20Layanan%20Pengaduan%20Masyarakat%20Modern&descAlignY=55&descAlign=50)

  **Platform pelaporan masyarakat yang interaktif, cepat, dan modern berbasis TALL Stack.**
  <br />
  
  [![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![Livewire](https://img.shields.io/badge/Livewire-3.x-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)](https://livewire.laravel.com)
  [![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
  [![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
  
  <br />
</div>

---

## 🎯 Mengapa TicketLapor?

TicketLapor dirancang khusus untuk memberikan kemudahan bagi masyarakat dalam melaporkan masalah di sekitar mereka (seperti infrastruktur, kebersihan, hingga keadaan darurat) dengan **UI/UX yang memanjakan mata** bergaya *Glassmorphism*. 

Sistem ini sangat responsif karena menggunakan teknologi **Livewire 3** (SPA-like feel tanpa reload halaman) dan mengedepankan kepraktisan pengguna.

---

## ✨ Fitur Unggulan

<table align="center">
  <tr>
    <td width="50%">
      <h3>🚨 Laporan Darurat Tanpa Login</h3>
      <p>Keadaan darurat butuh tindakan cepat. Masyarakat bisa langsung membuat laporan darurat yang dilengkapi dengan <strong>Integrasi Peta (Leaflet Maps) & GPS</strong> secara presisi tanpa harus melalui proses pendaftaran.</p>
    </td>
    <td width="50%">
      <h3>🔐 Google OAuth (1-Click Login)</h3>
      <p>Bye-bye lupa password! Sistem menggunakan <strong>Laravel Socialite</strong> sehingga pendaftaran akun baru maupun proses masuk (login) bisa dilakukan hanya dengan satu klik melalui akun Google.</p>
    </td>
  </tr>
  <tr>
    <td width="50%">
      <h3>📊 Dasbor Admin & Analitik</h3>
      <p>Bagi petugas, tersedia Dasbor Admin yang komprehensif untuk melacak, membalas, dan memperbarui status tiket. Dilengkapi grafik statistik penyelesaian tiket.</p>
    </td>
    <td width="50%">
      <h3>👥 Manajemen Pengguna yang Aman</h3>
      <p>Sistem <i>Role-Based Access Control</i> (Spatie) terintegrasi. Admin bisa mengubah status (<i>Ban/Deactivate</i>) pengguna atau mempromosikan masyarakat menjadi admin pembantu.</p>
    </td>
  </tr>
</table>

---

## 📸 Tampilan Antarmuka (Preview)

> **Note:** Ganti tautan gambar di bawah ini dengan tangkapan layar (screenshot) asli dari aplikasi Anda.

<details open>
  <summary><b>Lihat Tangkapan Layar (Screenshots)</b></summary>
  <br/>

| Halaman Utama & Dasbor | Pelaporan Darurat & Peta |
|:---:|:---:|
| <img src="https://via.placeholder.com/600x350/ffffff/3B82F6?text=Dashboard+Pengguna" alt="Dashboard Pengguna" width="100%"> | <img src="https://via.placeholder.com/600x350/ffffff/EF4444?text=Laporan+Darurat+%2B+Maps" alt="Emergency Report" width="100%"> |

| Manajemen Tiket (Admin) | Login Google |
|:---:|:---:|
| <img src="https://via.placeholder.com/600x350/ffffff/8B5CF6?text=Admin+Panel" alt="Admin Panel" width="100%"> | <img src="https://via.placeholder.com/600x350/ffffff/10B981?text=Google+SSO" alt="Login" width="100%"> |

</details>

---

## 🛠️ Instalasi & Setup Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek ini di mesin lokal Anda.

### Persyaratan Sistem
- **PHP** >= 8.2
- **Composer** 
- **Node.js** & NPM
- **Database** (MySQL / PostgreSQL / SQLite)

### Langkah Instalasi

1. **Clone repositori ini**
   ```bash
   git clone https://github.com/username-anda/ticketlapor.git
   cd ticketlapor
   ```

2. **Instal dependensi Backend & Frontend**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin file konfigurasi bawaan dan hasilkan kunci aplikasi:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   > ⚠️ **Penting:** Buka file `.env`, atur koneksi `DB_*` Anda, dan wajib isi bagian **Google OAuth** untuk fitur login:
   > ```env
   > GOOGLE_CLIENT_ID=client-id-dari-google-console
   > GOOGLE_CLIENT_SECRET=client-secret-dari-google-console
   > GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
   > ```

4. **Migrasi & Seeder Database**
   Buat struktur tabel dan isi dengan data awal (kategori, peran/roles):
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Server**
   Anda membutuhkan dua terminal yang berjalan bersamaan:
   ```bash
   # Terminal 1: Menjalankan Vite (Asset Bundler)
   npm run dev

   # Terminal 2: Menjalankan server Laravel
   php artisan serve
   ```

6. Kunjungi `http://127.0.0.1:8000` di *browser* Anda!

---

## 🚀 Teknologi yang Digunakan (Tech Stack)
- **Backend:** Laravel 11.x, PHP 8.2+
- **Frontend:** Livewire 3, Alpine.js
- **Styling:** Tailwind CSS (dengan efek UI Glassmorphism)
- **Database:** MySQL
- **Paket Utama:** 
  - `laravel/socialite` (SSO Google)
  - `spatie/laravel-permission` (Manajemen Role)
  - `Leaflet.js` (Peta Interaktif)

---

## 🤝 Kontribusi

Proyek ini terbuka untuk umum! Jika Anda ingin berkontribusi:
1. Lakukan *Fork* pada repositori ini.
2. Buat *branch* fitur Anda (`git checkout -b fitur-keren`).
3. Lakukan *Commit* perubahan Anda (`git commit -m 'Menambahkan fitur keren'`).
4. *Push* ke *branch* tersebut (`git push origin fitur-keren`).
5. Buat *Pull Request*.

---

<div align="center">
  Dibuat dengan ❤️ untuk kemudahan masyarakat.<br/>
  © 2026 TicketLapor
</div>
