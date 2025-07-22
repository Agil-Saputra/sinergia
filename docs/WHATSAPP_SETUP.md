# Setup WhatsApp untuk Fitur Lupa Password

## Langkah-langkah Setup

### 1. Daftar ke Fonnte
1. Kunjungi [https://fonnte.com](https://fonnte.com)
2. Daftar akun baru atau login
3. Hubungkan nomor WhatsApp Anda
4. Dapatkan token API dari dashboard

### 2. Konfigurasi Environment
Tambahkan konfigurasi berikut ke file `.env`:

```bash
# WhatsApp API Configuration
FONNTE_TOKEN=your-fonnte-token-here
FONNTE_URL=https://api.fonnte.com/send

# Emergency Contact
SUPERVISOR_PHONE=628123456789
```

### 3. Testing
1. Pastikan token Fonnte sudah aktif
2. Test dengan fitur "Lupa Password" di halaman login
3. Periksa log Laravel untuk debugging jika diperlukan

## Format Nomor Telepon
- Sistem otomatis mengkonversi format nomor
- Input: `081234567890` → Output: `6281234567890`
- Input: `+6281234567890` → Output: `6281234567890`

## Troubleshooting

### Error: "Fonnte token not configured"
- Pastikan `FONNTE_TOKEN` sudah diset di `.env`
- Restart server setelah update `.env`

### Error: "Target or message is empty"
- Pastikan user memiliki nomor telepon di database
- Cek format nomor telepon

### Error: WhatsApp API Response tidak berhasil
- Cek saldo Fonnte
- Pastikan nomor WhatsApp sudah terverifikasi
- Cek status API di dashboard Fonnte

## Format Pesan yang Dikirim
```
🔐 *PASSWORD BARU SINERGIA*

Halo *[Nama User]*,

Password baru Anda untuk sistem absensi Sinergia:
🔑 *[Password]*

📝 *Kode Karyawan:* [Employee Code]
📱 *Password Baru:* [Password]

✅ Silakan login dengan kode karyawan dan password ini.
⚠️ Disarankan untuk mengganti password setelah login.

🏢 *Tim Sinergia*
```
