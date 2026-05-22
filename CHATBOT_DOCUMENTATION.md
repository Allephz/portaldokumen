# Chatbot File Search Assistant - Dokumentasi

## 📋 Fitur Chatbot

Chatbot ini membantu user mencari file di Portal ISO 9001 dengan cara yang mudah dan intuitif.

### ✅ Fitur yang Tersedia:

1. **Pencarian File** - Cari file berdasarkan nama atau deskripsi
   - Contoh: "Cari SOP", "Search proposal", "Find marketing files"

2. **Statistik** - Lihat jumlah total file dan kategori
   - Contoh: "Berapa file yang ada?", "Total statistik"

3. **File Terbaru** - Tampilkan file yang baru diupload
   - Contoh: "Tampilkan file terbaru", "Recent files"

4. **Kategori** - Lihat semua kategori file yang tersedia
   - Contoh: "Apa kategorinya?", "Show categories"

---

## 🛠️ File-File yang Ditambahkan

### 1. **Controller** 
- `app/Http/Controllers/ChatbotController.php`
  - Method: `searchFiles()` - Search file berdasarkan query
  - Method: `getStatistics()` - Get file statistics  
  - Method: `getCategories()` - Get all categories

### 2. **Routes**
- Di `routes/web.php`:
  ```
  POST /api/chatbot/search      - Search files
  GET  /api/chatbot/stats       - Get statistics
  GET  /api/chatbot/categories  - Get categories
  ```

### 3. **Views**
- `resources/views/components/chatbot.blade.php`
  - Modal dialog untuk chatbot UI
  - Floating button di kanan bawah

### 4. **JavaScript**
- `public/js/chatbot.js`
  - Class `ChatbotAssistant` untuk handle logic
  - Event listeners untuk user input
  - Message formatting dan display

### 5. **Layout Integration**
- Modified `resources/views/layouts/app.blade.php`
  - Include chatbot component
  - Include chatbot JavaScript

---

## 🚀 Cara Menggunakan

1. **Login ke Portal**
2. **Klik tombol chatbot** (bulat biru di kanan bawah) 💬
3. **Ketik pertanyaan** (contoh: "Cari SOP")
4. **Bot akan mencari** dan tampilkan hasilnya

---

## 📝 Contoh Pertanyaan

### Pencarian File:
```
"Cari file SOP"
"Search proposal"
"Cari file marketing"
"Find approval documents"
```

### Statistik:
```
"Berapa total file?"
"Statistik file"
"Total categories"
"Berapa kategori?"
```

### File Terbaru:
```
"Tampilkan file terbaru"
"Recent files"
"File terakhir"
"Latest uploads"
```

### Kategori:
```
"Apa saja kategorinya?"
"Show categories"
"Kategori file apa?"
"List all categories"
```

---

## 🔒 Security

✅ **Protected Routes** - Hanya user yang login bisa akses chatbot
✅ **CSRF Protection** - Semua request dilindungi CSRF token
✅ **Approved Files Only** - Chatbot hanya tampilkan file yang sudah diapprove
✅ **Error Handling** - Error messages jelas dan aman

---

## 📊 Database Queries

Chatbot menggunakan:
- `DepartmentFile` model untuk cari file
- `FileCategory` model untuk kategori
- `User` model untuk info uploader
- `Department` model untuk info departemen

### Fitur Query:
- Search by file name (LIKE)
- Search by description (LIKE)
- Search by category name (LIKE)
- Filter approved files only
- Limit hasil maksimal 20 file

---

## 💾 No Changes to Existing Files

✅ Tidak ada database schema yang diubah
✅ Tidak ada model yang diubah
✅ Tidak ada fitur yang dihapus
✅ Hanya menambah file baru dan minor update di layout

---

## 🎨 UI Design

- **Modal Dialog** - Chat interface dalam modal
- **Floating Button** - Tombol chatbot di kanan bawah
- **Responsive** - Works di desktop dan mobile
- **Bootstrap 5.3** - Sama styling dengan portal

---

## 🔧 Troubleshooting

**Q: Tombol chatbot tidak muncul?**
A: Clear browser cache atau restart server

**Q: Bot tidak merespons?**
A: Check console (F12) untuk error messages

**Q: Tidak ada hasil pencarian?**
A: Pastikan file sudah di-approve (status: approved)

---

## ✨ Future Enhancements (Optional)

- AI Natural Language Processing (OpenAI/Gemini)
- File preview sebelum download
- Download langsung dari chat
- Conversation history saving
- Multi-language support
- File upload assistant

---

**Dibuat:** 20 April 2026
**Status:** ✅ Live dan siap digunakan
**Maintenance:** No changes to existing system
