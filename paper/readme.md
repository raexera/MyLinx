# LaTeX Setup Guide (MiKTeX + VS Code)

Panduan ini menjelaskan cara menginstall dan menggunakan LaTeX dengan MiKTeX serta Visual Studio Code untuk membuat dokumen LaTeX.

---

## 📦 Requirements

* MiKTeX
* Visual Studio Code
* Extension: LaTeX Workshop

---

## 🚀 Installation Steps

### 1. Install MiKTeX

1. Download MiKTeX dari website resmi
2. Jalankan installer
3. Pilih:

   * Install for all users
   * Paper size: A4
   * Install missing packages on-the-fly: **Yes**
4. Selesai → Restart komputer

### 2. Verifikasi Instalasi

Buka terminal / CMD:

```bash
pdflatex --version
```

Jika muncul versi → instalasi berhasil ✅

---

### 3. Install Visual Studio Code

1. Download dan install VS Code
2. Pastikan opsi **Add to PATH** dicentang

---

### 4. Install Extension LaTeX

Buka Extensions di VS Code, lalu install:

```
LaTeX Workshop (by James Yu)
```

Fitur utama:

* Auto build PDF
* Preview PDF langsung
* Auto-complete LaTeX

---

## ⚙️ Configuration (Optional)

Buka `settings.json` di VS Code, tambahkan:

```json
{
  "latex-workshop.latex.autoBuild.run": "onSave",
  "latex-workshop.view.pdf.viewer": "tab"
}
```

---

## 📝 Create First Document

Buat file `main.tex`:

```latex
\documentclass{article}

\begin{document}

Hello World!

\end{document}
```

---

## ▶️ Compile PDF

Gunakan salah satu:

* `Ctrl + Alt + B`
* Save file (auto compile)

PDF akan muncul di tab VS Code 📄

---

## 🛠️ Troubleshooting

### ❌ pdflatex tidak ditemukan

* Restart VS Code / PC
* Pastikan MiKTeX sudah masuk PATH

### ❌ Package error

* Pastikan opsi **on-the-fly install** aktif

### ❌ PDF tidak muncul

* Jalankan command:

  ```
  LaTeX Workshop: View LaTeX PDF
  ```

---

## 💡 Tips

* Gunakan template IEEE untuk paper
* Simpan semua file dalam satu folder project
* Gunakan `.bib` untuk manajemen referensi

---

## 📚 License

Free to use for learning and documentation purposes.
