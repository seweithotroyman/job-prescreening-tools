# 🔍 AI Job Fit Pre-Screening Tool

Proyek ini adalah sistem **AI-powered pre-screening** yang membantu pelamar kerja untuk:
- Mengevaluasi kecocokan antara **CV** dan **Job Description**
- Mendapatkan feedback otomatis dari GPT
- Menghasilkan **Tailored CV** dan **Cover Letter**
- Melakukan **tracking pengiriman ke HRD**
- Melakukan **follow-up cerdas** berdasarkan skor prioritas AI

---

## 🚀 Fitur Utama

- ✅ Upload **Job Description** dan **Resume**
- ✅ Analisis kecocokan otomatis dengan GPT (fit score 1–10)
- ✅ Highlight keyword match & keyword gap
- ✅ AI summary + saran peningkatan CV
- ✅ Auto-generate tailored CV & CL (Coming Soon)
- ✅ Kirim ke HRD via Email / WhatsApp / Telegram
- ✅ Reminder otomatis dan notifikasi Livewire
- ✅ Statistik efektivitas CV dan prioritas follow-up

---

## 🧰 Tech Stack

| Layer        | Teknologi                 |
|--------------|---------------------------|
| Framework    | Laravel 12 + Livewire     |
| Front-End    | Tailwind CSS              |
| AI Backend   | OpenAI GPT-4 API          |
| Auth         | Jetstream (Sanctum + Verified) |
| PDF Export   | DOMPDF                    |
| Notifikasi   | SweetAlert / Livewire Toast |
| DB           | MySQL / SQLite (testing)  |

---


## ⚙️ Cara Menjalankan Proyek

1. **Clone repo:**
```bash
git clone https://github.com/username/nama-project.git
cd nama-project
```

2. **Install dependency:**
```bash
composer install
npm install && npm run dev
```

3. **Setup `.env`:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Tambahkan API Key OpenAI:**
```env
OPENAI_API_KEY=sk-xxx
```

5. **Jalankan database & migrasi:**
```bash
php artisan migrate
```

6. **Jalankan Laravel server:**
```bash
php artisan serve
