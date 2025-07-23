# Notifikasi WhatsApp untuk Emergency Reports

## Fitur Otomatis WhatsApp untuk Update Status Laporan Darurat

### Kapan Notifikasi Dikirim?
Notifikasi WhatsApp akan otomatis dikirim kepada pengguna (pelapor) ketika:
1. ✅ **Status laporan diubah** oleh admin/supervisor
2. ✅ **Catatan admin ditambahkan atau diubah**
3. ✅ **Kombinasi keduanya** (status + catatan)

### Format Pesan WhatsApp

```
📝 UPDATE LAPORAN DARURAT

📝 Laporan: [Judul Laporan]
📊 Status Baru: [Status]
📋 Status Sebelumnya: [Status Lama] (jika berubah)
📅 Diupdate: 23/07/2025 14:30

💬 Catatan Admin:
[Catatan dari admin]

[Pesan Aksi berdasarkan Status]

🏢 Tim Sinergia
```

### Pesan Aksi Berdasarkan Status:

#### 🔍 **Sedang Ditinjau (under_review)**
> "Laporan Anda sedang dalam proses peninjauan oleh tim kami."

#### ✅ **Diselesaikan (resolved)**
> "Laporan Anda telah diselesaikan. Terima kasih atas laporannya!"

#### 🔒 **Ditutup (closed)**
> "Laporan ini telah ditutup. Jika ada pertanyaan lebih lanjut, silakan hubungi admin."

#### ⏳ **Tertunda (pending)**
> (Tidak ada pesan khusus)

### Preview Real-time
Di halaman admin, tersedia **preview real-time** yang menampilkan:
- Format pesan yang akan dikirim
- Update otomatis saat status atau catatan diubah
- Indikator visual jika user memiliki WhatsApp

### Logging dan Monitoring
System akan mencatat:
- ✅ **Berhasil mengirim**: Log INFO
- ❌ **Gagal mengirim**: Log WARNING  
- 📵 **User tanpa WhatsApp**: Log WARNING
- 🚫 **Error sistem**: Log ERROR

### Troubleshooting

#### User Tidak Menerima Notifikasi?
1. Cek apakah user memiliki nomor WhatsApp di profil
2. Pastikan FONNTE_TOKEN aktif di `.env`
3. Cek log Laravel untuk error: `tail -f storage/logs/laravel.log`
4. Verifikasi saldo Fonnte mencukupi

#### Format Nomor WhatsApp
- Input: `081234567890` → Output: `6281234567890`
- Input: `+6281234567890` → Output: `6281234567890`
- System otomatis menformat ke format internasional

### Penggunaan

1. **Login sebagai Admin/Supervisor**
2. **Buka Emergency Reports** → **Detail Laporan**
3. **Update Status dan/atau Catatan**
4. **Preview Pesan** akan muncul jika user memiliki WhatsApp
5. **Klik "Update Status"** → Notifikasi otomatis terkirim

### Fitur Keamanan
- ✅ Notifikasi hanya dikirim jika ada perubahan status atau catatan
- ✅ Rollback jika pengiriman WhatsApp gagal
- ✅ Logging lengkap untuk audit trail
- ✅ Validasi nomor WhatsApp sebelum mengirim

---

*Dokumentasi ini menjelaskan integrasi WhatsApp untuk memberikan update real-time kepada pengguna tentang status laporan darurat mereka.*
