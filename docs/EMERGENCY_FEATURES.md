# Emergency Report Features - Update Documentation

## 🚀 Features Added

### 1. Emergency Contact Buttons
- **Quick Call Supervisor**: Button merah/orange untuk menghubungi supervisor
- **Quick Call Security**: Button merah untuk menghubungi security
- **Mobile Optimized**: Menggunakan `tel:` protocol untuk langsung membuka dialer di mobile
- **Desktop Support**: Copy nomor ke clipboard untuk desktop users

### 2. File Upload Support
- **Evidence Upload**: Users dapat upload bukti masalah (foto, video, dokumen)
- **File Types**: JPG, PNG, MP4, PDF, DOC, DOCX
- **Size Limit**: Maksimal 10MB per file
- **Preview**: Menampilkan nama file dan ukuran setelah dipilih
- **Remove Option**: User dapat menghapus file yang dipilih

### 3. Enhanced UI/UX
- **Step-by-step Form**: Form dengan 5 langkah yang jelas
- **Visual Feedback**: File preview dengan ukuran dan nama file
- **Emergency Section**: Section khusus untuk emergency calls
- **Responsive Design**: Optimized untuk mobile dan desktop

## 📁 Files Modified

### 1. View Layer
- **`resources/views/user/emergency-reports.blade.php`**
  - Added file upload input (Step 5)
  - Added emergency call buttons section
  - Added JavaScript for file handling
  - Added attachment display in report details
  - Added `enctype="multipart/form-data"` to form

### 2. Controller Layer
- **`app/Http/Controllers/EmergencyReportController.php`**
  - Added file validation rules
  - Added file upload handling
  - Store files in `storage/app/public/emergency-reports/`
  - Save file paths in attachments array

### 3. Configuration
- **`config/emergency.php`** (New file)
  - Emergency contact phone numbers
  - File upload configurations
  - Allowed file types and size limits

### 4. Environment Configuration
- **`.env.example`**
  - Added environment variables for phone numbers
  - SUPERVISOR_PHONE, SECURITY_PHONE, HR_PHONE

## 🔧 Setup Instructions

### 1. Environment Variables
Add to your `.env` file:
```bash
SUPERVISOR_PHONE=+6281234567890
SECURITY_PHONE=+6281234567891
HR_PHONE=+6281234567892
```

### 2. Storage Setup
Storage link already exists. Files will be stored in:
- **Storage Path**: `storage/app/public/emergency-reports/`
- **Public URL**: `public/storage/emergency-reports/`

### 3. Database Schema
The `emergency_reports` table already includes:
- `attachments` (JSON field) - Stores array of file paths

## 📱 Usage Guide

### For Users:
1. **Fill Report Form**: Complete the 5-step form
2. **Upload Evidence** (Optional): Attach photo/video/document evidence
3. **Submit Report**: Regular submission process
4. **Emergency Calls**: Use emergency buttons for immediate help

### Emergency Call Flow:
1. Click "HUBUNGI SUPERVISOR" or "HUBUNGI SECURITY"
2. Confirm the call action
3. **Mobile**: Automatically opens phone dialer
4. **Desktop**: Number copied to clipboard with alert

### File Upload Flow:
1. Click file input in Step 5
2. Select file (JPG, PNG, MP4, PDF, DOC, DOCX)
3. See file preview with name and size
4. Option to remove file if needed
5. File uploaded when form is submitted

## 🛡️ Security Features

- **File Type Validation**: Only allowed file types accepted
- **File Size Limit**: 10MB maximum per file
- **Secure Storage**: Files stored in protected directory
- **Access Control**: Files accessible only through proper URLs

## 🎨 UI Components

### Emergency Call Section:
- Gradient background (orange to red)
- Prominent call buttons with icons
- Hover effects and animations
- Clear instructions and confirmation dialogs

### File Upload Component:
- Modern file input styling
- File type and size information
- Preview with remove option
- Visual feedback for user actions

### Report Display:
- Attachment links in expandable details
- File type icons and external link indicators
- Clean, accessible file access

## 🔍 Technical Details

### File Storage:
```php
// Files stored with timestamp prefix
$filename = time() . '_' . $file->getClientOriginalName();
$path = $file->storeAs('emergency-reports', $filename, 'public');
```

### JavaScript Functions:
- `updateFileName()`: File preview handling
- `removeFile()`: File removal functionality
- `callSupervisor()`: Supervisor calling logic
- `callSecurity()`: Security calling logic

### Configuration Access:
```php
// In Blade templates
{{ config('emergency.supervisor_phone') }}
{{ config('emergency.security_phone') }}
```

This implementation provides a comprehensive emergency reporting system with immediate contact options and evidence upload capabilities, maintaining the existing UI design while adding powerful new functionality.
