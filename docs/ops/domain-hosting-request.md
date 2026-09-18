Judul: Pengajuan Operasional — Pembelian Domain dan Hosting untuk Web "Sim-Kop"

Tujuan
- Mengajukan pembelian domain dan paket hosting untuk website "Sim-Kop" agar situs live dengan konfigurasi aman, backup, dan SSL.

Ringkasan permintaan (singkat, untuk tim ops)
- Nama project: Sim-Kop
- Tindakan yang diminta: Pembelian domain + Paket hosting + konfigurasi DNS, SSL, email (opsional), dan migrasi situs
- Deadline ideal: [tanggal] (contoh: 7 hari kerja)
- Budget maksimal: [jumlah] (contoh: IDR 2.000.000/tahun)

Detail yang harus disertakan dalam pengajuan (isi oleh pemohon)
1. Pilihan domain (urutkan prioritas):
   - Domain utama: contoh1.sim-kop.id
   - Domain alternatif: contoh2.sim-kop.com
   - Registrar preferensi (opsional): e.g., Niagahoster, Rumahweb, Domainesia, GoDaddy
   - Siapa pemilik pendaftar (registrant): Nama organisasi/perorangan, email, nomor telepon

2. Jenis hosting yang diinginkan (pilih & jelaskan kebutuhan):
   - Shared Hosting (murah, cocok untuk traffic kecil)
   - VPS (lebih kontrol, cocok jika butuh cron, queue, SSH)
   - Cloud Instance (DigitalOcean / AWS / Hetzner / GCP)
   - Managed Laravel/PHP hosting (jika ingin optimasi khusus)
   - Spesifikasi (jika VPS/cloud): CPU, RAM, Disk (GB), OS (Ubuntu 22.04), lokasi region

3. Spesifikasi teknis aplikasi (agar ops pilih paket tepat)
   - Stack: PHP 8.x, Apache/Nginx, MySQL/MariaDB
   - Ukuran database saat ini: ~[MB/GB]
   - Estimasi trafik per bulan: [kunjungan]
   - Fitur penting: PDF generation, queue jobs, background jobs, cron, SMTP outgoing

4. Kebutuhan keamanan & operasi
   - SSL/TLS: Let's Encrypt (otomatis) atau sertifikat komersial
   - Backup: harian / mingguan — jumlah retensi (contoh: 7 hari)
   - Monitoring: uptime monitoring (opsional)
   - Firewall/basic security: mod_security, fail2ban (opsional)
   - Akses: SSH (opsional) — daftar akun yang butuh akses (nama + email)

5. Email & DNS
   - Ingin setup email: yes/no (domain@sim-kop.id)
   - Jika menggunakan 3rd-party mail (Google Workspace/Zoho), sertakan preferensi
   - DNS records yang diperlukan: A, CNAME, TXT (SPF), MX, _acme-challenge (Let's Encrypt)

6. Migrasi & deployment
   - Apakah akan migrasi dari lingkungan lokal? (ya/tidak)
   - Lokasi source: local / existing server (berikan akses sementara SFTP/SSH)
   - Rencana deployment: manual / git push / CI (GitHub Actions)
   - Pastikan set environment variables (.env): DB credentials, MAIL, APP_KEY

7. Admin & owner kontak
   - Nama: 
   - Email: 
   - Nomor telepon:
   - Jam kerja terbaik untuk melakukan migrasi:

8. Acceptance Criteria (untuk menutup pengajuan)
   - Domain aktif dan resolving ke hosting dalam waktu [X] jam
   - SSL valid dan HTTPS aktif
   - Situs dapat diakses, fitur utama berfungsi (login, lihat halaman PO/Invoice)
   - Backup terjadwal terpasang dan dapat di-restore
   - Akun kontak menerima akses (panel hosting, cPanel/SSH) jika diminta

Instruksi biaya & persetujuan
- Mohon lampirkan estimasi biaya (domain + hosting + biaya setup satu kali)
- Jika estimasi melebihi budget, minta opsi paket lebih murah

Contoh email/pesan pengajuan (kopi-tempel)

Kepada: Tim Operasional / IT
Subjek: Pengajuan Pembelian Domain & Hosting — Sim-Kop

Halo Tim,

Kami mohon bantuan untuk pembelian domain dan paket hosting untuk project "Sim-Kop".
Berikut detail permintaan:

- Domain prioritas: contoh1.sim-kop.id (alternatif: contoh2.sim-kop.com)
- Jenis hosting: VPS (1 vCPU, 1GB RAM, 25GB SSD) — atau rekomendasi jika ada
- Stack: PHP 8.x, MySQL, Nginx/Apache
- Estimasi DB: 200 MB
- Perlu sertifikat SSL (Let's Encrypt)
- Backup: harian, retensi 7 hari
- Akses: email@example.com (akun admin) memerlukan akses cPanel/SSH
- Deadline setup: [tanggal]
- Budget maksimal: IDR [jumlah]

Mohon kirim estimasi biaya dan langkah selanjutnya. Terima kasih.

Hormat kami,
[Nama Pemohon]

---

Catatan tambahan untuk tim ops:
- Jika registrar memerlukan verifikasi WHOIS, pastikan informasi registrant sesuai kebijakan organisasi.
- Jika ingin menggunakan CDN (Cloudflare), tandai supaya ops konfigurasi DNS sesuai.
