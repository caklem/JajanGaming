# Git Workflow untuk Tim

## Mencegah Conflict

### 1. Workflow Dasar (Untuk File Berbeda)

Jika kalian bekerja di file yang berbeda:

```bash
# Sebelum mulai coding
git pull origin master

# Setelah selesai coding
git add .
git commit -m "deskripsi perubahan"
git pull origin master    # PENTING: Pull dulu sebelum push
git push origin master
```

### 2. Workflow dengan Branch (RECOMMENDED)

Cara paling aman untuk kolaborasi:

```bash
# Buat branch baru untuk fitur/task Anda
git checkout -b fitur-nama-anda

# Coding di branch ini
# ... edit files ...

# Commit perubahan
git add .
git commit -m "deskripsi perubahan"

# Update master terbaru
git checkout master
git pull origin master

# Merge branch Anda ke master
git checkout fitur-nama-anda
git merge master          # Resolve conflict di sini jika ada

# Push ke master
git checkout master
git merge fitur-nama-anda
git push origin master

# Hapus branch (optional)
git branch -d fitur-nama-anda
```

### 3. Jika Terjadi Conflict

Conflict terjadi jika 2 orang edit file yang sama di baris yang sama.

```bash
# Saat pull/merge muncul conflict
git status    # Lihat file yang conflict

# Buka file yang conflict, cari marker:
# <<<<<<< HEAD
# kode Anda
# =======
# kode teman
# >>>>>>> branch-name

# Edit manual, pilih mana yang mau dipakai atau gabungkan

# Setelah resolve
git add .
git commit -m "resolve conflict"
git push origin master
```

### 4. Tips Mencegah Conflict

1. **Komunikasi**: Beritahu tim file apa yang sedang dikerjakan
2. **Pull sering**: Selalu `git pull` sebelum mulai coding dan sebelum push
3. **Commit kecil**: Jangan commit terlalu banyak perubahan sekaligus
4. **Gunakan branch**: Buat branch untuk setiap fitur/task
5. **Pembagian file**: Usahakan tidak edit file yang sama secara bersamaan

### 5. Command Berguna

```bash
# Lihat status
git status

# Lihat perubahan
git diff

# Lihat history
git log --oneline

# Batalkan perubahan yang belum di-commit
git checkout -- nama-file

# Lihat siapa yang edit baris terakhir
git blame nama-file

# Simpan perubahan sementara (jika perlu pull tapi belum mau commit)
git stash
git pull origin master
git stash pop
```

## Scenario Praktis

### Scenario 1: Anda & Teman Edit File Berbeda

✅ Tidak akan conflict, langsung push saja (tapi tetap pull dulu)

### Scenario 2: Anda & Teman Edit File Sama, Baris Berbeda

✅ Git otomatis merge, tidak akan conflict

### Scenario 3: Anda & Teman Edit File Sama, Baris Sama

⚠️ CONFLICT! Harus resolve manual

**Solusi:** Gunakan branch atau komunikasi untuk tidak edit file sama bersamaan

## Rekomendasi untuk Tim Kecil (2-3 orang)

1. Bagi tugas berdasarkan file/folder:

    - Person A: Frontend (views, css)
    - Person B: Backend (controllers, models)
    - Person C: Database (migrations, seeders)

2. Atau gunakan branch untuk setiap fitur:

    - Branch: fitur-login
    - Branch: fitur-payment
    - Branch: fitur-cart

3. Daily sync:
    - Pagi: `git pull origin master` (sync dengan tim)
    - Sore: `git push origin master` (share progress)

## Git Config (Setup Awal)

```bash
# Set nama dan email
git config --global user.name "Nama Anda"
git config --global user.email "email@example.com"

# Set editor default
git config --global core.editor "code --wait"

# Set auto CRLF (untuk Windows)
git config --global core.autocrlf true
```
