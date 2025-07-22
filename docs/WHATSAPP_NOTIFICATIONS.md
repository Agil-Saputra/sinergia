# WhatsApp Notification System - Sinergia

Sistem notifikasi WhatsApp untuk aplikasi Sinergia menggunakan API Fonnte untuk mengirim pesan otomatis kepada supervisor dan karyawan.

## Setup

### 1. Daftar Akun Fonnte

1. Kunjungi [https://fonnte.com](https://fonnte.com)
2. Daftar akun baru
3. Verifikasi nomor WhatsApp Anda
4. Dapatkan token API dari dashboard

### 2. Konfigurasi Environment

Tambahkan konfigurasi berikut ke file `.env`:

```env
# WhatsApp Notification Configuration (Fonnte API)
FONNTE_TOKEN=your-fonnte-token-here
FONNTE_URL=https://api.fonnte.com/send

# Emergency Contact Configuration
SUPERVISOR_PHONE=+6281234567890
SECURITY_PHONE=+6281234567891
HR_PHONE=+6281234567892
```

### 3. Format Nomor Telepon

- Nomor telepon harus dalam format internasional
- Contoh: `+6281234567890` atau `6281234567890`
- Sistem akan otomatis memformat nomor untuk WhatsApp

### 4. Database Setup

Pastikan kolom `phone_number` ada di tabel `users`:

```sql
ALTER TABLE users ADD COLUMN phone_number VARCHAR(255) NULL AFTER email;
```

## Fitur Notifikasi

### 1. Task Baru oleh Karyawan

**Trigger:** Ketika karyawan membuat task insidental
**Penerima:** Supervisor
**Isi Pesan:**
```
🆕 TUGAS BARU DIBUAT

📝 Judul: [Judul Task]
👤 Dibuat oleh: [Nama Karyawan]
⚡ Prioritas: [High/Medium/Low]
📅 Tanggal: [DD/MM/YYYY]
📋 Deskripsi: [Deskripsi task]

Silakan cek dashboard admin untuk memberikan feedback.
```

### 2. Task Assignment oleh Admin

**Trigger:** Ketika admin menugaskan task ke karyawan
**Penerima:** Karyawan yang ditugaskan
**Isi Pesan:**
```
📋 TUGAS BARU UNTUK ANDA

📝 Judul: [Judul Task]
👔 Dari: [Nama Admin]
⚡ Prioritas: [High/Medium/Low]
📅 Deadline: [DD/MM/YYYY atau "Tidak ada"]
⏱️ Estimasi: [X jam]
📋 Deskripsi: [Deskripsi task]
📝 Catatan: [Catatan tambahan]

Silakan buka aplikasi Sinergia untuk mulai mengerjakan tugas.
```

### 3. Feedback dari Supervisor

**Trigger:** Ketika supervisor memberikan feedback pada task yang selesai
**Penerima:** Karyawan yang mengerjakan task
**Isi Pesan:**
```
⭐ FEEDBACK TUGAS

📝 Tugas: [Judul Task]
📊 Penilaian: [Sangat Baik/Baik/Perlu Perbaikan]
💬 Catatan: [Feedback dari supervisor]

✅ Terima kasih atas kerja keras Anda!
```

Atau untuk feedback yang memerlukan perbaikan:
```
⚠️ FEEDBACK TUGAS

📝 Tugas: [Judul Task]
📊 Penilaian: Perlu Perbaikan
💬 Catatan: [Feedback dari supervisor]

⚠️ PERHATIAN: Tugas ini memerlukan perbaikan. Silakan lakukan perbaikan yang diperlukan dan tandai sebagai selesai di aplikasi.
```

### 4. Perbaikan Selesai

**Trigger:** Ketika karyawan menandai perbaikan sebagai selesai
**Penerima:** Supervisor
**Isi Pesan:**
```
✅ PERBAIKAN SELESAI

📝 Tugas: [Judul Task]
👤 Karyawan: [Nama Karyawan]
📅 Perbaikan selesai: [DD/MM/YYYY HH:mm]

Karyawan telah menyelesaikan perbaikan yang diminta. Silakan cek kembali di dashboard admin.
```

### 5. Laporan Darurat

**Trigger:** Ketika karyawan membuat emergency report
**Penerima:** Supervisor
**Isi Pesan:**
```
🚨 LAPORAN DARURAT

📝 Judul: [Judul Laporan]
👤 Pelapor: [Nama Karyawan]
🔴 Prioritas: [Kritis/Tinggi/Sedang/Rendah]
📍 Lokasi: [Lokasi]
📋 Deskripsi: [Deskripsi masalah]
📅 Waktu: [DD/MM/YYYY HH:mm]

⚠️ PERHATIAN: Laporan ini memerlukan tindakan segera!
```

## Testing

### Test Koneksi WhatsApp

Gunakan command berikut untuk test:

```bash
php artisan whatsapp:test "+6281234567890" "Test message"
```

### Test Manual

1. Buat task baru sebagai karyawan
2. Assign task dari dashboard admin
3. Complete task dan beri feedback
4. Buat emergency report

## Troubleshooting

### 1. Token Tidak Valid

**Error:** `Config [services.fonnte.token] not found`
**Solusi:** 
- Pastikan `FONNTE_TOKEN` sudah di set di file `.env`
- Clear config cache: `php artisan config:clear`

### 2. Nomor Tidak Menerima Pesan

**Kemungkinan Penyebab:**
- Nomor tidak terdaftar di WhatsApp
- Format nomor salah
- Akun Fonnte belum verified
- Saldo Fonnte habis

**Solusi:**
- Periksa format nomor telepon
- Cek dashboard Fonnte untuk status akun
- Top up saldo jika diperlukan

### 3. API Error

**Error:** `WhatsApp API Error`
**Solusi:**
- Cek koneksi internet
- Verifikasi token Fonnte
- Periksa log di `storage/logs/laravel.log`

## Logs

Semua aktivitas WhatsApp dicatat di log Laravel:
- Sukses: `storage/logs/laravel.log`
- Error: `storage/logs/laravel.log`

## Biaya

Fonnte menggunakan sistem kredit:
- Pesan domestik: ~Rp 150-300 per pesan
- Periksa pricing terbaru di dashboard Fonnte

## Security

- Token API disimpan di environment variable
- Nomor telepon di-format dan divalidasi
- Error handling untuk mencegah crash aplikasi
- Rate limiting di level API Fonnte
