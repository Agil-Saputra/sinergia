#!/bin/bash

# Sinergia WhatsApp Notification Setup Script
# Script ini membantu setup notifikasi WhatsApp untuk aplikasi Sinergia

echo "🚀 Sinergia WhatsApp Notification Setup"
echo "======================================="

# Check if .env exists
if [ ! -f .env ]; then
    echo "❌ File .env tidak ditemukan!"
    echo "   Salin .env.example ke .env terlebih dahulu"
    exit 1
fi

echo "✅ File .env ditemukan"

# Check if FONNTE_TOKEN is set
if ! grep -q "FONNTE_TOKEN=" .env; then
    echo ""
    echo "📝 Menambahkan konfigurasi WhatsApp ke .env..."
    echo "" >> .env
    echo "# WhatsApp Notification Configuration (Fonnte API)" >> .env
    echo "FONNTE_TOKEN=your-fonnte-token-here" >> .env
    echo "FONNTE_URL=https://api.fonnte.com/send" >> .env
    echo "" >> .env
else
    echo "✅ Konfigurasi FONNTE_TOKEN sudah ada di .env"
fi

# Check supervisor phone
if ! grep -q "SUPERVISOR_PHONE=" .env; then
    echo "📞 Menambahkan konfigurasi nomor supervisor..."
    echo "# Supervisor phone for notifications" >> .env
    echo "SUPERVISOR_PHONE=+6281234567890" >> .env
    echo "" >> .env
else
    echo "✅ Konfigurasi SUPERVISOR_PHONE sudah ada di .env"
fi

echo ""
echo "📋 Checklist Setup:"
echo "1. ✅ Service WhatsApp sudah dibuat"
echo "2. ✅ Controller sudah diupdate"
echo "3. ✅ Konfigurasi .env sudah siap"
echo ""
echo "📝 Yang perlu dilakukan selanjutnya:"
echo "1. 🌐 Daftar akun di https://fonnte.com"
echo "2. 📱 Verifikasi nomor WhatsApp Anda"
echo "3. 🔑 Copy token dari dashboard Fonnte"
echo "4. ✏️  Update FONNTE_TOKEN di file .env"
echo "5. 📞 Update SUPERVISOR_PHONE dengan nomor yang benar"
echo ""
echo "🧪 Test notifikasi dengan:"
echo "   
echo ""
echo "📚 Dokumentasi lengkap: docs/WHATSAPP_NOTIFICATIONS.md"
echo ""
echo "✅ Setup selesai! Happy coding! 🎉"
