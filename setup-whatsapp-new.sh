#!/bin/bash

echo "🚀 Setting up WhatsApp integration for Sinergia..."
echo ""

# Check if .env file exists
if [ ! -f .env ]; then
    echo "❌ .env file not found!"
    echo "Please copy .env.example to .env first:"
    echo "cp .env.example .env"
    exit 1
fi

# Check if FONNTE_TOKEN is already set
if grep -q "FONNTE_TOKEN=" .env; then
    echo "✅ FONNTE_TOKEN already exists in .env"
else
    echo "➕ Adding FONNTE_TOKEN to .env..."
    echo "" >> .env
    echo "# WhatsApp API Configuration" >> .env
    echo "FONNTE_TOKEN=your-fonnte-token-here" >> .env
    echo "FONNTE_URL=https://api.fonnte.com/send" >> .env
    echo "" >> .env
    echo "# Emergency Contact" >> .env
    echo "SUPERVISOR_PHONE=628123456789" >> .env
fi

echo ""
echo "📋 Setup steps:"
echo "1. Register at https://fonnte.com"
echo "2. Connect your WhatsApp number"
echo "3. Get your API token from dashboard"
echo "4. Update FONNTE_TOKEN in .env file"
echo "5. Update SUPERVISOR_PHONE in .env file"
echo ""
echo "🧪 Testing:"
echo "php artisan whatsapp:test 081234567890 \"Test message\""
echo ""
echo "📖 For detailed setup guide, see docs/WHATSAPP_SETUP.md"
echo ""
echo "✨ Setup complete! Don't forget to update your .env file with actual values."
