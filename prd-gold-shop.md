# PRD — Website Manajemen Inventori Toko Emas

## 1. Informasi Produk

### 1.1 Nama Produk

**Gold Inventory Management System**

Nama alternatif dalam bahasa Indonesia:

**Sistem Manajemen Pembelian dan Inventori Toko Emas**

---

### 1.2 Ringkasan Produk

Website ini adalah aplikasi internal untuk membantu toko emas mengelola proses pembelian emas dari penjual, pencatatan data penjual, pengambilan foto produk emas, pengambilan foto KTP penjual, pembuatan dokumen PDF otomatis, pencetakan dokumen, serta manajemen inventori barang emas.

Setiap barang emas yang dibeli dari penjual akan otomatis masuk ke inventori toko. Ketika barang dijual kembali kepada pembeli, sistem akan mencatat transaksi penjualan dan mengubah status barang menjadi **sold**.

Sistem ini dirancang untuk **satu toko** dan **satu jenis role pengguna**, yaitu **admin**. Tidak ada fitur multi-cabang, multi-role, atau permission kompleks pada versi awal ini.

---

### 1.3 Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel |
| Frontend | Inertia.js |
| UI | React + TypeScript |
| Database | MySQL |
| Styling | Tailwind CSS |
| Component UI | shadcn/ui |
| Authentication | Laravel Auth / Laravel Breeze Inertia |
| PDF Generation | DomPDF / Browsershot / Snappy PDF |
| File Storage | Laravel Storage |
| Validation | Laravel Form Request |
| Date Handling | Carbon |
| Table UI | TanStack Table / shadcn table component |
| Form UI | React Hook Form + Zod / Inertia form helper |

---

## 2. Latar Belakang

Proses operasional toko emas sering melibatkan pencatatan manual, seperti mencatat identitas penjual, data barang emas, harga per gram, berat emas, nominal transaksi, serta pembuatan nota atau surat pernyataan. Jika dilakukan secara manual, proses ini rawan terjadi kesalahan, data sulit dicari kembali, dan dokumen harus dibuat ulang satu per satu.

Website ini dibuat untuk mengubah proses tersebut menjadi digital. Admin dapat mencatat pembelian emas, menyimpan foto KTP dan foto produk, menghitung total transaksi secara otomatis, membuat PDF invoice atau surat kerja sama, lalu mencetak dokumen untuk ditandatangani oleh penjual.

Selain itu, barang emas yang sudah dibeli akan langsung masuk ke inventori. Dengan begitu, toko dapat mengetahui barang mana yang masih tersedia dan barang mana yang sudah terjual.

---

## 3. Tujuan Produk

Tujuan utama sistem ini adalah:

1. Mempercepat proses pencatatan transaksi pembelian emas.
2. Mengurangi pencatatan manual menggunakan kertas atau Excel.
3. Menyimpan data penjual dan bukti KTP secara digital.
4. Menyimpan foto barang emas sebagai bukti visual.
5. Menghitung total transaksi pembelian secara otomatis.
6. Membuat dokumen PDF yang sudah terisi otomatis berdasarkan data transaksi.
7. Mempermudah admin mencetak dokumen untuk ditandatangani.
8. Menjadikan barang hasil pembelian sebagai stok inventori.
9. Memudahkan pencarian barang berdasarkan SKU, jenis barang, karat, berat, dan status.
10. Mencatat transaksi penjualan barang emas.
11. Mengubah status barang menjadi **sold** ketika barang terjual.
12. Menyediakan dashboard ringkas untuk melihat kondisi inventori dan transaksi.

---

## 4. Scope Produk

### 4.1 In Scope

Fitur yang termasuk dalam versi ini:

1. Login admin.
2. Logout admin.
3. Dashboard ringkasan.
4. Manajemen data seller atau penjual emas.
5. Upload atau capture foto KTP penjual.
6. Input transaksi pembelian emas.
7. Input satu atau beberapa barang emas dalam satu transaksi pembelian.
8. Upload atau capture foto produk emas.
9. Perhitungan otomatis nilai barang:
   - estimated price
   - deduction
   - final price
   - subtotal transaction
   - total transaction
10. Barang otomatis masuk ke inventori setelah transaksi pembelian selesai.
11. Manajemen data inventori.
12. Edit harga jual barang.
13. Update status barang.
14. Pencarian dan filter inventori.
15. Input transaksi penjualan.
16. Pilih barang dari inventori yang statusnya **available**.
17. Hitung total penjualan.
18. Update status barang menjadi **sold** setelah penjualan selesai.
19. Manajemen template dokumen.
20. Generate PDF dari template dokumen.
21. Simpan riwayat dokumen yang sudah digenerate.
22. Print dokumen PDF.
23. Tandai dokumen sebagai printed atau signed.
24. Soft delete untuk data utama.
25. Validasi input pada backend dan frontend.
26. Laporan sederhana pembelian, penjualan, dan inventori.

---

### 4.2 Out of Scope

Fitur berikut tidak termasuk pada versi awal:

1. Multi-role.
2. Multi-cabang.
3. Permission management kompleks.
4. Integrasi payment gateway.
5. Integrasi e-commerce publik.
6. Integrasi barcode scanner fisik secara khusus.
7. Integrasi OCR KTP.
8. Deteksi otomatis berat emas dari alat timbang.
9. Perhitungan pajak kompleks.
10. Akuntansi lengkap.
11. Integrasi WhatsApp.
12. Approval berlapis.
13. Mobile app native.
14. Buyer management terpisah.
15. Audit log kompleks.
16. Stock opname lanjutan.
17. Inventory movement table.
18. Multi-currency.

---

## 5. Target Pengguna

### 5.1 Admin

Admin adalah satu-satunya user yang menggunakan sistem.

Admin dapat:

1. Login ke dashboard.
2. Mengelola data penjual.
3. Mencatat transaksi pembelian emas.
4. Mengambil atau mengupload foto KTP penjual.
5. Mengambil atau mengupload foto produk emas.
6. Menghasilkan PDF invoice atau surat.
7. Mencetak PDF.
8. Mengelola inventori emas.
9. Mencatat penjualan barang.
10. Melihat laporan sederhana.

---

## 6. User Flow Utama

### 6.1 Flow Pembelian Emas dari Penjual

1. Admin login ke sistem.
2. Admin membuka menu **Purchase Transactions**.
3. Admin klik tombol **Create Purchase**.
4. Admin memilih seller lama atau membuat seller baru.
5. Admin mengisi data seller:
   - nama
   - NIK
   - nomor telepon
   - alamat
   - foto KTP
   - catatan
6. Admin mengisi data transaksi pembelian:
   - tanggal transaksi
   - metode pembayaran
   - catatan
7. Admin menambahkan satu atau beberapa barang emas:
   - nama barang
   - jenis barang
   - karat emas
   - berat gram
   - harga per gram
   - potongan
   - kondisi
   - deskripsi
   - foto produk
8. Sistem menghitung:
   - estimated price = berat gram × harga per gram
   - final price = estimated price - deduction amount
   - subtotal amount = total final price semua item
   - total amount = subtotal amount - deduction transaction
9. Admin menyimpan transaksi.
10. Sistem membuat `purchase_transactions`.
11. Sistem membuat `purchase_items`.
12. Sistem membuat `inventory_items` dari setiap `purchase_items`.
13. Sistem memberikan SKU unik untuk setiap inventory item.
14. Admin dapat generate dokumen PDF.
15. Admin dapat print dokumen.
16. Dokumen ditandatangani oleh penjual.
17. Admin dapat menandai dokumen sebagai **signed**.

---

### 6.2 Flow Barang Masuk Inventori

1. Transaksi pembelian disimpan dengan status **completed**.
2. Setiap item pembelian otomatis dibuatkan data di `inventory_items`.
3. Barang memiliki status awal **available**.
4. Barang memiliki SKU unik.
5. Barang dapat dilihat pada halaman inventori.
6. Admin dapat mengubah selling price sebelum barang dijual.
7. Admin dapat mencari barang berdasarkan SKU, nama, jenis, karat, berat, status, dan tanggal masuk.

---

### 6.3 Flow Penjualan Barang

1. Admin membuka menu **Sales Transactions**.
2. Admin klik tombol **Create Sale**.
3. Admin mengisi data pembeli sederhana:
   - buyer name
   - buyer phone
4. Admin memilih barang dari inventory yang statusnya **available**.
5. Admin mengisi harga jual dan diskon jika ada.
6. Sistem menghitung:
   - final price = selling price - discount amount
   - subtotal amount = total final price semua item
   - total amount = subtotal amount - discount transaction
7. Admin menyimpan transaksi penjualan.
8. Sistem membuat `sales_transactions`.
9. Sistem membuat `sales_items`.
10. Sistem mengubah `inventory_items.status` menjadi **sold**.
11. Sistem mengisi `inventory_items.sold_at`.
12. Barang tidak boleh dijual lagi setelah statusnya **sold**.
13. Admin dapat generate invoice penjualan jika diperlukan.

---

### 6.4 Flow Generate PDF

1. Admin membuka detail purchase transaction atau sales transaction.
2. Admin klik tombol **Generate Document**.
3. Admin memilih jenis template dokumen.
4. Sistem mengambil data transaksi, seller, item, dan admin.
5. Sistem mengganti placeholder pada template HTML.
6. Sistem membuat PDF.
7. Sistem menyimpan file PDF.
8. Sistem mencatat data ke `generated_documents`.
9. Admin dapat membuka, mengunduh, atau mencetak PDF.
10. Admin dapat menandai dokumen sebagai:
    - generated
    - printed
    - signed

---

## 7. Fitur Produk

## 7.1 Authentication

### Deskripsi

Admin harus login sebelum dapat mengakses sistem.

### Functional Requirements

1. Admin dapat login menggunakan email dan password.
2. Admin dapat logout.
3. Admin yang belum login tidak dapat mengakses halaman dashboard.
4. Password disimpan dalam bentuk hash.
5. Sistem menggunakan session authentication Laravel.
6. Tidak ada fitur register publik.
7. User admin dibuat melalui seeder atau command internal.

### Halaman

- Login Page
- Dashboard setelah login

### Acceptance Criteria

- Jika email dan password benar, admin diarahkan ke dashboard.
- Jika email atau password salah, sistem menampilkan pesan error.
- Jika admin logout, admin diarahkan ke halaman login.
- URL internal tidak bisa dibuka tanpa login.

---

## 7.2 Dashboard

### Deskripsi

Dashboard menampilkan ringkasan data toko secara sederhana.

### Data yang Ditampilkan

1. Total barang tersedia.
2. Total barang terjual.
3. Total transaksi pembelian.
4. Total transaksi penjualan.
5. Total nilai pembelian.
6. Total nilai penjualan.
7. Total estimasi profit:
   - total penjualan - total harga beli barang terjual
8. Transaksi pembelian terbaru.
9. Transaksi penjualan terbaru.
10. Inventori terbaru.

### UI Components

- Card statistik
- Recent purchases table
- Recent sales table
- Recent inventory table
- Badge status
- Button shortcut:
  - Create Purchase
  - Create Sale
  - View Inventory

### Acceptance Criteria

- Dashboard hanya dapat diakses oleh admin yang login.
- Data statistik tampil sesuai data di database.
- Status barang ditampilkan dengan badge yang mudah dibaca.
- Admin dapat klik shortcut menuju halaman terkait.

---

## 7.3 Seller Management

### Deskripsi

Seller adalah orang yang menjual emas ke toko. Data seller digunakan pada transaksi pembelian emas.

### Functional Requirements

1. Admin dapat melihat daftar seller.
2. Admin dapat mencari seller berdasarkan nama, NIK, atau nomor telepon.
3. Admin dapat membuat seller baru.
4. Admin dapat mengubah data seller.
5. Admin dapat menghapus seller menggunakan soft delete.
6. Admin dapat melihat detail seller.
7. Admin dapat mengupload foto KTP.
8. Admin dapat menggunakan kamera device untuk mengambil foto KTP jika browser mendukung.
9. Admin dapat melihat riwayat transaksi pembelian dari seller tersebut.

### Fields

Berdasarkan tabel `sellers`:

| Field | Keterangan |
|---|---|
| name | Nama penjual |
| nik | Nomor identitas penjual |
| phone | Nomor HP penjual |
| address | Alamat penjual |
| ktp_photo_url | Foto KTP |
| notes | Catatan tambahan |

### Validation Rules

| Field | Rule |
|---|---|
| name | required, max 150 |
| nik | nullable, max 30 |
| phone | nullable, max 30 |
| address | nullable |
| ktp_photo_url | nullable, image, jpg/png/webp, max 5MB |
| notes | nullable |

### UI Requirements

- Seller list menggunakan table.
- Terdapat search input.
- Terdapat action button:
  - View
  - Edit
  - Delete
- Form seller menggunakan shadcn/ui:
  - Input
  - Textarea
  - Button
  - Card
  - Dialog untuk konfirmasi delete
- Preview foto KTP setelah upload.

### Acceptance Criteria

- Seller baru dapat disimpan jika nama terisi.
- Foto KTP dapat diupload dan ditampilkan ulang.
- Data seller dapat diperbarui.
- Seller yang dihapus tidak tampil di list default.
- Detail seller menampilkan data dan riwayat purchase transactions.

---

## 7.4 Purchase Transaction Management

### Deskripsi

Purchase transaction adalah transaksi saat toko membeli emas dari seller.

### Functional Requirements

1. Admin dapat melihat daftar transaksi pembelian.
2. Admin dapat mencari transaksi berdasarkan purchase number, seller name, NIK, atau tanggal.
3. Admin dapat membuat transaksi pembelian baru.
4. Admin dapat memilih seller lama atau membuat seller baru saat transaksi.
5. Admin dapat menambahkan satu atau beberapa item emas.
6. Admin dapat mengupload foto produk untuk setiap item.
7. Admin dapat menghitung total secara otomatis.
8. Admin dapat menyimpan transaksi sebagai:
   - draft
   - completed
9. Jika transaksi statusnya **completed**, sistem membuat inventory item.
10. Admin dapat melihat detail transaksi.
11. Admin dapat membatalkan transaksi jika barang belum dijual.
12. Admin dapat menghapus transaksi menggunakan soft delete.
13. Admin dapat generate dokumen dari transaksi.

### Purchase Transaction Fields

Berdasarkan tabel `purchase_transactions`:

| Field | Keterangan |
|---|---|
| seller_id | Penjual emas |
| admin_id | Admin yang membuat transaksi |
| purchase_number | Nomor transaksi pembelian |
| transaction_date | Tanggal transaksi |
| subtotal_amount | Total nilai item sebelum potongan transaksi |
| deduction_amount | Potongan transaksi |
| total_amount | Total akhir transaksi |
| payment_method | Metode pembayaran |
| status | Status transaksi |
| notes | Catatan |

### Purchase Item Fields

Berdasarkan tabel `purchase_items`:

| Field | Keterangan |
|---|---|
| purchase_transaction_id | Relasi ke transaksi pembelian |
| item_name | Nama barang |
| item_type | Jenis barang |
| gold_carat | Karat emas |
| weight_gram | Berat gram |
| price_per_gram | Harga per gram |
| estimated_price | Estimasi harga sebelum potongan |
| deduction_amount | Potongan item |
| final_price | Harga akhir item |
| condition | Kondisi barang |
| description | Deskripsi barang |
| product_photo_url | Foto barang |

### Calculation Rules

Untuk setiap item:

```text
estimated_price = weight_gram × price_per_gram
final_price = estimated_price - deduction_amount
```

Untuk transaksi:

```text
subtotal_amount = sum(final_price semua purchase_items)
total_amount = subtotal_amount - deduction_amount transaksi
```

Jika `deduction_amount` kosong, nilainya dianggap 0.

### Purchase Status

| Status | Keterangan |
|---|---|
| draft | Transaksi masih draft dan belum masuk inventori |
| completed | Transaksi selesai dan barang masuk inventori |
| cancelled | Transaksi dibatalkan |

### Payment Method

Nilai yang disarankan:

| Value | Keterangan |
|---|---|
| cash | Tunai |
| transfer | Transfer |
| qris | QRIS |
| debit | Debit |
| other | Lainnya |

### Business Rules

1. `purchase_number` harus unik.
2. `purchase_number` dibuat otomatis oleh sistem.
3. Format nomor disarankan: `PUR-YYYYMMDD-0001`.
4. Minimal satu purchase item harus ada sebelum transaksi bisa completed.
5. Jika transaksi masih draft, inventory belum dibuat.
6. Jika transaksi completed, sistem membuat inventory item untuk setiap purchase item.
7. Jika inventory item sudah dibuat, purchase item tidak boleh dihapus sembarangan.
8. Jika inventory item sudah sold, transaksi pembelian tidak boleh dibatalkan.
9. Foto produk bersifat opsional tetapi disarankan wajib secara UI.
10. Harga tidak boleh bernilai negatif.
11. Berat gram harus lebih besar dari 0.

### UI Requirements

Halaman create purchase harus memiliki:

1. Section seller:
   - pilih seller existing
   - tombol create seller baru
   - form seller cepat
   - upload foto KTP
2. Section transaction:
   - transaction date
   - payment method
   - transaction deduction
   - notes
3. Section purchase items:
   - dynamic item form
   - add item
   - remove item
   - upload product photo
   - preview photo
   - real-time calculation
4. Summary card:
   - subtotal
   - deduction
   - total amount
5. Action:
   - Save Draft
   - Complete Transaction
   - Cancel

### Acceptance Criteria

- Admin dapat membuat transaksi dengan satu item.
- Admin dapat membuat transaksi dengan banyak item.
- Sistem menghitung nilai item dan transaksi dengan benar.
- Saat transaksi completed, inventory item otomatis dibuat.
- SKU inventory dibuat otomatis dan unik.
- Admin dapat melihat detail transaksi beserta seller, item, foto, dan dokumen.
- Admin tidak dapat complete transaksi tanpa item.
- Admin tidak dapat memasukkan berat 0 atau harga negatif.

---

## 7.5 Inventory Management

### Deskripsi

Inventory item adalah barang emas yang tersedia di toko setelah dibeli dari seller.

Sistem menggunakan konsep:

```text
1 barang = 1 inventory item
```

Bukan sistem quantity seperti:

```text
Cincin 22K stock = 10
```

Karena setiap barang emas memiliki berat, karat, harga beli, kondisi, dan foto yang berbeda.

### Functional Requirements

1. Admin dapat melihat daftar inventory item.
2. Admin dapat mencari barang berdasarkan:
   - SKU
   - nama barang
   - jenis barang
   - karat
   - status
3. Admin dapat memfilter barang berdasarkan:
   - status
   - item type
   - gold carat
   - tanggal masuk
4. Admin dapat melihat detail barang.
5. Admin dapat mengubah selling price.
6. Admin dapat mengubah notes.
7. Admin dapat mengubah status tertentu secara manual.
8. Admin dapat melihat sumber pembelian barang.
9. Admin dapat melihat status apakah barang tersedia atau terjual.
10. Barang dengan status **sold** tidak boleh dipilih di transaksi penjualan.

### Fields

Berdasarkan tabel `inventory_items`:

| Field | Keterangan |
|---|---|
| purchase_item_id | Relasi ke purchase item asal |
| sku | Kode unik barang |
| item_name | Nama barang |
| item_type | Jenis barang |
| gold_carat | Karat emas |
| weight_gram | Berat |
| purchase_price | Harga beli |
| selling_price | Harga jual |
| status | Status barang |
| condition | Kondisi barang |
| product_photo_url | Foto produk |
| acquired_at | Tanggal masuk |
| sold_at | Tanggal terjual |
| notes | Catatan |

### Inventory Status

| Status | Keterangan |
|---|---|
| available | Barang tersedia dan bisa dijual |
| sold | Barang sudah terjual |
| lost | Barang hilang |
| damaged | Barang rusak |
| melted | Barang dilebur |
| cancelled | Barang dibatalkan dari transaksi pembelian |

Untuk MVP, status utama yang wajib:

1. available
2. sold

Status tambahan dapat disediakan untuk fleksibilitas.

### SKU Generation

Format SKU yang disarankan:

```text
GLD-YYYYMMDD-0001
```

Contoh:

```text
GLD-20260504-0001
```

### Business Rules

1. Inventory item dibuat otomatis dari purchase item.
2. Satu purchase item hanya boleh memiliki satu inventory item.
3. `purchase_item_id` bersifat unique.
4. SKU harus unik.
5. Barang status sold tidak bisa dijual lagi.
6. `sold_at` hanya diisi jika status sold.
7. Jika status diubah dari sold ke available, harus dilakukan secara hati-hati melalui fitur admin khusus.
8. Selling price boleh kosong saat barang baru masuk, tetapi harus terisi saat dijual.

### UI Requirements

Inventory list menampilkan:

1. Foto produk.
2. SKU.
3. Nama barang.
4. Jenis barang.
5. Karat.
6. Berat gram.
7. Harga beli.
8. Harga jual.
9. Status.
10. Tanggal masuk.
11. Action:
    - View
    - Edit
    - Mark as Lost/Damaged/Melted
    - Delete jika belum terkait transaksi penjualan

### Acceptance Criteria

- Inventory item otomatis muncul setelah transaksi pembelian completed.
- Admin dapat mencari barang berdasarkan SKU.
- Barang sold tidak muncul dalam pilihan barang pada transaksi penjualan.
- Detail inventory menampilkan data pembelian asal.
- Selling price dapat diubah.
- Status inventory tampil menggunakan badge.

---

## 7.6 Sales Transaction Management

### Deskripsi

Sales transaction adalah transaksi ketika toko menjual barang emas kepada pembeli.

### Functional Requirements

1. Admin dapat melihat daftar transaksi penjualan.
2. Admin dapat mencari transaksi berdasarkan sales number, buyer name, buyer phone, atau tanggal.
3. Admin dapat membuat transaksi penjualan baru.
4. Admin dapat memilih satu atau beberapa inventory item dengan status **available**.
5. Admin dapat mengisi nama dan nomor telepon pembeli.
6. Admin dapat mengisi harga jual.
7. Admin dapat memberi diskon per item.
8. Admin dapat memberi diskon transaksi.
9. Sistem menghitung total transaksi.
10. Setelah transaksi selesai, sistem mengubah status barang menjadi **sold**.
11. Admin dapat melihat detail transaksi penjualan.
12. Admin dapat generate invoice penjualan.
13. Admin dapat membatalkan transaksi penjualan jika diperlukan.
14. Jika transaksi dibatalkan, status barang dapat dikembalikan menjadi **available**.

### Sales Transaction Fields

Berdasarkan tabel `sales_transactions`:

| Field | Keterangan |
|---|---|
| admin_id | Admin pembuat transaksi |
| sales_number | Nomor transaksi penjualan |
| buyer_name | Nama pembeli |
| buyer_phone | Nomor HP pembeli |
| transaction_date | Tanggal transaksi |
| subtotal_amount | Subtotal |
| discount_amount | Diskon transaksi |
| total_amount | Total akhir |
| payment_method | Metode pembayaran |
| status | Status transaksi |
| notes | Catatan |

### Sales Item Fields

Berdasarkan tabel `sales_items`:

| Field | Keterangan |
|---|---|
| sales_transaction_id | Relasi transaksi penjualan |
| inventory_item_id | Barang yang dijual |
| item_name | Snapshot nama barang |
| sku | Snapshot SKU |
| gold_carat | Snapshot karat |
| weight_gram | Snapshot berat |
| purchase_price | Snapshot harga beli |
| selling_price | Harga jual |
| discount_amount | Diskon item |
| final_price | Harga akhir item |

### Calculation Rules

Untuk setiap sales item:

```text
final_price = selling_price - discount_amount
```

Untuk transaksi:

```text
subtotal_amount = sum(final_price semua sales_items)
total_amount = subtotal_amount - discount_amount transaksi
```

### Sales Status

| Status | Keterangan |
|---|---|
| draft | Transaksi belum selesai |
| completed | Transaksi selesai |
| cancelled | Transaksi dibatalkan |

### Business Rules

1. `sales_number` harus unik.
2. `sales_number` dibuat otomatis oleh sistem.
3. Format nomor disarankan: `SAL-YYYYMMDD-0001`.
4. Hanya inventory dengan status **available** yang bisa dipilih.
5. Inventory item tidak boleh dipilih dua kali dalam transaksi yang sama.
6. Inventory item tidak boleh dijual dua kali.
7. Saat sales completed, inventory status menjadi **sold**.
8. Saat sales completed, `sold_at` diisi dengan tanggal transaksi.
9. Jika sales cancelled, barang bisa dikembalikan ke status **available** jika belum ada proses lanjutan.
10. Sales item menyimpan snapshot data barang agar histori transaksi tidak berubah jika inventory diubah.

### UI Requirements

Halaman create sale memiliki:

1. Buyer section:
   - buyer name
   - buyer phone
2. Transaction section:
   - transaction date
   - payment method
   - transaction discount
   - notes
3. Inventory selection:
   - searchable select inventory
   - filter available only
   - show SKU, name, weight, carat, selling price
4. Sales items table:
   - selected item
   - selling price
   - discount
   - final price
   - remove item
5. Summary:
   - subtotal
   - discount
   - total
6. Action:
   - Save Draft
   - Complete Sale

### Acceptance Criteria

- Admin dapat membuat transaksi penjualan dengan satu barang.
- Admin dapat membuat transaksi penjualan dengan beberapa barang.
- Barang yang sudah sold tidak bisa dipilih.
- Setelah transaksi completed, barang berubah menjadi sold.
- Total transaksi dihitung dengan benar.
- Detail transaksi menampilkan snapshot data barang.
- Invoice penjualan dapat digenerate.

---

## 7.7 Document Template Management

### Deskripsi

Document template digunakan untuk membuat dokumen PDF otomatis. Template disimpan dalam bentuk HTML dengan placeholder.

### Functional Requirements

1. Admin dapat melihat daftar template dokumen.
2. Admin dapat membuat template dokumen.
3. Admin dapat mengedit template dokumen.
4. Admin dapat mengaktifkan atau menonaktifkan template.
5. Admin dapat menghapus template menggunakan soft delete.
6. Template dapat digunakan untuk generate PDF pada purchase atau sales transaction.

### Fields

Berdasarkan tabel `document_templates`:

| Field | Keterangan |
|---|---|
| name | Nama template |
| code | Kode unik template |
| document_type | Jenis dokumen |
| html_content | Isi template HTML |
| is_active | Status aktif template |

### Document Type

Jenis dokumen yang disarankan:

| Type | Keterangan |
|---|---|
| purchase_invoice | Invoice pembelian emas |
| purchase_agreement | Surat pernyataan jual beli emas |
| goods_receipt | Tanda terima barang |
| sales_invoice | Invoice penjualan emas |

### Placeholder yang Disarankan

Untuk purchase document:

```text
{{ purchase_number }}
{{ purchase_date }}
{{ seller_name }}
{{ seller_nik }}
{{ seller_phone }}
{{ seller_address }}
{{ subtotal_amount }}
{{ deduction_amount }}
{{ total_amount }}
{{ payment_method }}
{{ admin_name }}
{{ items_table }}
```

Untuk item purchase:

```text
{{ item_name }}
{{ item_type }}
{{ gold_carat }}
{{ weight_gram }}
{{ price_per_gram }}
{{ estimated_price }}
{{ item_deduction_amount }}
{{ final_price }}
{{ condition }}
```

Untuk sales document:

```text
{{ sales_number }}
{{ sales_date }}
{{ buyer_name }}
{{ buyer_phone }}
{{ subtotal_amount }}
{{ discount_amount }}
{{ total_amount }}
{{ payment_method }}
{{ admin_name }}
{{ items_table }}
```

Untuk item sales:

```text
{{ sku }}
{{ item_name }}
{{ gold_carat }}
{{ weight_gram }}
{{ selling_price }}
{{ item_discount_amount }}
{{ final_price }}
```

### UI Requirements

1. Template list.
2. Template create/edit form.
3. HTML editor textarea.
4. Placeholder helper panel.
5. Preview template.
6. Toggle active/inactive.
7. Button save.

### Acceptance Criteria

- Admin dapat membuat template purchase invoice.
- Admin dapat membuat template sales invoice.
- Placeholder dapat diganti dengan data asli saat generate PDF.
- Template nonaktif tidak muncul saat generate dokumen.
- Template dapat diedit tanpa mengubah dokumen PDF lama yang sudah digenerate.

---

## 7.8 Generated Document Management

### Deskripsi

Generated document adalah dokumen PDF yang sudah dibuat dari template tertentu.

### Functional Requirements

1. Admin dapat generate dokumen dari detail purchase transaction.
2. Admin dapat generate dokumen dari detail sales transaction.
3. Admin dapat memilih template aktif.
4. Sistem membuat PDF.
5. Sistem menyimpan PDF URL.
6. Sistem mencatat generated document.
7. Admin dapat membuka PDF.
8. Admin dapat mengunduh PDF.
9. Admin dapat mencetak PDF.
10. Admin dapat menandai dokumen sebagai printed.
11. Admin dapat menandai dokumen sebagai signed.
12. Admin dapat melihat daftar dokumen yang pernah dibuat.

### Fields

Berdasarkan tabel `generated_documents`:

| Field | Keterangan |
|---|---|
| document_template_id | Template yang digunakan |
| generated_by | Admin yang generate |
| document_number | Nomor dokumen |
| document_type | Jenis dokumen |
| reference_type | Sumber data dokumen |
| reference_id | ID sumber data |
| pdf_url | URL file PDF |
| status | Status dokumen |
| generated_at | Waktu generate |
| printed_at | Waktu print |
| signed_at | Waktu signed |

### Reference Type

Nilai yang disarankan:

```text
purchase_transaction
sales_transaction
```

### Document Status

| Status | Keterangan |
|---|---|
| generated | PDF sudah dibuat |
| printed | PDF sudah dicetak |
| signed | PDF sudah ditandatangani |
| cancelled | Dokumen dibatalkan |

### Business Rules

1. `document_number` harus unik.
2. Format nomor disarankan:
   - `DOC-YYYYMMDD-0001`
   - `PINV-YYYYMMDD-0001`
   - `SINV-YYYYMMDD-0001`
3. PDF lama tidak boleh otomatis berubah ketika template diedit.
4. Jika ingin dokumen terbaru, admin harus generate ulang.
5. Generated document harus menyimpan relasi ke source transaction melalui `reference_type` dan `reference_id`.

### Acceptance Criteria

- Admin dapat generate PDF dari purchase transaction.
- Admin dapat generate PDF dari sales transaction.
- File PDF dapat dibuka dari browser.
- Status dokumen dapat berubah dari generated ke printed.
- Status dokumen dapat berubah dari printed ke signed.
- Riwayat dokumen muncul di detail transaksi.

---

## 7.9 Report Management

### Deskripsi

Laporan sederhana untuk membantu admin melihat performa pembelian, penjualan, dan inventori.

### Functional Requirements

1. Admin dapat melihat laporan pembelian.
2. Admin dapat melihat laporan penjualan.
3. Admin dapat melihat laporan inventori.
4. Admin dapat memfilter berdasarkan tanggal.
5. Admin dapat melihat total nilai pembelian.
6. Admin dapat melihat total nilai penjualan.
7. Admin dapat melihat estimasi profit.
8. Admin dapat melihat jumlah barang available dan sold.

### Laporan Pembelian

Data:

1. Purchase number.
2. Seller name.
3. Transaction date.
4. Total item.
5. Total amount.
6. Status.

Filter:

1. Date range.
2. Seller.
3. Status.

### Laporan Penjualan

Data:

1. Sales number.
2. Buyer name.
3. Transaction date.
4. Total item.
5. Total amount.
6. Status.

Filter:

1. Date range.
2. Buyer name.
3. Status.

### Laporan Inventori

Data:

1. SKU.
2. Item name.
3. Type.
4. Carat.
5. Weight.
6. Purchase price.
7. Selling price.
8. Status.
9. Acquired at.
10. Sold at.

Filter:

1. Status.
2. Item type.
3. Gold carat.
4. Date range.

### Acceptance Criteria

- Admin dapat filter laporan berdasarkan tanggal.
- Total pembelian dan penjualan tampil sesuai filter.
- Estimasi profit dihitung dari barang yang sudah sold.
- Laporan dapat ditampilkan dalam table.

---

## 8. Database Design

Database yang digunakan adalah rancangan berikut.

```dbml
Table users {
  id bigint [pk, increment]
  name varchar(150) [not null]
  email varchar(191) [not null, unique]
  password varchar(255) [not null]
  phone varchar(30)
  avatar_url varchar(255)
  remember_token varchar(100)
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table sellers {
  id bigint [pk, increment]
  name varchar(150) [not null]
  nik varchar(30)
  phone varchar(30)
  address text
  ktp_photo_url varchar(255)
  notes text
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table purchase_transactions {
  id bigint [pk, increment]
  seller_id bigint [not null]
  admin_id bigint [not null]

  purchase_number varchar(100) [not null, unique]
  transaction_date datetime [not null]

  subtotal_amount decimal(15,2) [default: 0]
  deduction_amount decimal(15,2) [default: 0]
  total_amount decimal(15,2) [default: 0]

  payment_method varchar(50)
  status varchar(50) [default: 'completed']

  notes text
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table purchase_items {
  id bigint [pk, increment]
  purchase_transaction_id bigint [not null]

  item_name varchar(150) [not null]
  item_type varchar(100)
  gold_carat decimal(5,2)
  weight_gram decimal(10,3) [not null]
  price_per_gram decimal(15,2) [not null]

  estimated_price decimal(15,2) [default: 0]
  deduction_amount decimal(15,2) [default: 0]
  final_price decimal(15,2) [default: 0]

  condition varchar(100)
  description text
  product_photo_url varchar(255)

  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table inventory_items {
  id bigint [pk, increment]
  purchase_item_id bigint [unique]

  sku varchar(100) [not null, unique]

  item_name varchar(150) [not null]
  item_type varchar(100)
  gold_carat decimal(5,2)
  weight_gram decimal(10,3)

  purchase_price decimal(15,2) [default: 0]
  selling_price decimal(15,2)

  status varchar(50) [default: 'available']
  condition varchar(100)
  product_photo_url varchar(255)

  acquired_at datetime
  sold_at datetime

  notes text
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table sales_transactions {
  id bigint [pk, increment]
  admin_id bigint [not null]

  sales_number varchar(100) [not null, unique]
  buyer_name varchar(150)
  buyer_phone varchar(30)

  transaction_date datetime [not null]

  subtotal_amount decimal(15,2) [default: 0]
  discount_amount decimal(15,2) [default: 0]
  total_amount decimal(15,2) [default: 0]

  payment_method varchar(50)
  status varchar(50) [default: 'completed']

  notes text
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table sales_items {
  id bigint [pk, increment]
  sales_transaction_id bigint [not null]
  inventory_item_id bigint [not null]

  item_name varchar(150) [not null]
  sku varchar(100)
  gold_carat decimal(5,2)
  weight_gram decimal(10,3)

  purchase_price decimal(15,2) [default: 0]
  selling_price decimal(15,2) [not null]
  discount_amount decimal(15,2) [default: 0]
  final_price decimal(15,2) [default: 0]

  created_at timestamp
  updated_at timestamp
}

Table document_templates {
  id bigint [pk, increment]

  name varchar(150) [not null]
  code varchar(100) [not null, unique]
  document_type varchar(100) [not null]

  html_content longtext
  is_active boolean [default: true]

  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table generated_documents {
  id bigint [pk, increment]
  document_template_id bigint [not null]
  generated_by bigint [not null]

  document_number varchar(100) [not null, unique]
  document_type varchar(100) [not null]

  reference_type varchar(100) [not null]
  reference_id bigint [not null]

  pdf_url varchar(255)

  status varchar(50) [default: 'generated']

  generated_at datetime
  printed_at datetime
  signed_at datetime

  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Ref: purchase_transactions.seller_id > sellers.id
Ref: purchase_transactions.admin_id > users.id
Ref: purchase_items.purchase_transaction_id > purchase_transactions.id

Ref: inventory_items.purchase_item_id > purchase_items.id

Ref: sales_transactions.admin_id > users.id
Ref: sales_items.sales_transaction_id > sales_transactions.id
Ref: sales_items.inventory_item_id > inventory_items.id

Ref: generated_documents.document_template_id > document_templates.id
Ref: generated_documents.generated_by > users.id
```

---

## 9. Rekomendasi Index Database

### users

```text
email unique
deleted_at index
```

### sellers

```text
name index
nik index
phone index
deleted_at index
```

### purchase_transactions

```text
purchase_number unique
seller_id index
admin_id index
transaction_date index
status index
deleted_at index
```

### purchase_items

```text
purchase_transaction_id index
item_type index
gold_carat index
deleted_at index
```

### inventory_items

```text
purchase_item_id unique
sku unique
status index
item_type index
gold_carat index
acquired_at index
sold_at index
deleted_at index
```

### sales_transactions

```text
sales_number unique
admin_id index
buyer_name index
buyer_phone index
transaction_date index
status index
deleted_at index
```

### sales_items

```text
sales_transaction_id index
inventory_item_id index
```

### document_templates

```text
code unique
document_type index
is_active index
deleted_at index
```

### generated_documents

```text
document_number unique
document_template_id index
generated_by index
document_type index
reference_type + reference_id composite index
status index
deleted_at index
```

---

## 10. Struktur Halaman

## 10.1 Public Pages

### Login

Path:

```text
/login
```

Fitur:

1. Form email.
2. Form password.
3. Remember me.
4. Submit login.
5. Error message.

---

## 10.2 Protected Admin Pages

Semua halaman berikut hanya bisa diakses setelah login.

### Dashboard

Path:

```text
/dashboard
```

Isi:

1. Statistik inventori.
2. Statistik pembelian.
3. Statistik penjualan.
4. Recent purchases.
5. Recent sales.
6. Recent inventory.

---

### Sellers

Path:

```text
/sellers
/sellers/create
/sellers/{id}
/sellers/{id}/edit
```

Isi:

1. List seller.
2. Create seller.
3. Detail seller.
4. Edit seller.
5. Delete seller.
6. Riwayat transaksi seller.

---

### Purchase Transactions

Path:

```text
/purchases
/purchases/create
/purchases/{id}
/purchases/{id}/edit
```

Isi:

1. List purchase.
2. Create purchase.
3. Detail purchase.
4. Edit purchase draft.
5. Cancel purchase.
6. Generate document.

---

### Inventory

Path:

```text
/inventory
/inventory/{id}
/inventory/{id}/edit
```

Isi:

1. List inventory.
2. Detail inventory.
3. Edit selling price.
4. Edit notes.
5. Update status.

---

### Sales Transactions

Path:

```text
/sales
/sales/create
/sales/{id}
/sales/{id}/edit
```

Isi:

1. List sales.
2. Create sale.
3. Detail sale.
4. Edit sales draft.
5. Cancel sale.
6. Generate invoice.

---

### Document Templates

Path:

```text
/document-templates
/document-templates/create
/document-templates/{id}/edit
```

Isi:

1. List template.
2. Create template.
3. Edit template.
4. Toggle active.
5. Delete template.

---

### Generated Documents

Path:

```text
/documents
/documents/{id}
```

Isi:

1. List generated documents.
2. Open PDF.
3. Download PDF.
4. Mark as printed.
5. Mark as signed.

---

### Reports

Path:

```text
/reports/purchases
/reports/sales
/reports/inventory
```

Isi:

1. Purchase report.
2. Sales report.
3. Inventory report.

---

## 11. UI/UX Requirements

### 11.1 Design Style

Tampilan website harus:

1. Clean.
2. Modern.
3. Professional.
4. Mudah digunakan kasir/admin.
5. Tidak terlalu ramai.
6. Fokus pada kecepatan input transaksi.
7. Responsif untuk desktop dan tablet.

---

### 11.2 Component Guidelines

Gunakan shadcn/ui untuk:

1. Button.
2. Input.
3. Textarea.
4. Select.
5. Dialog.
6. Alert Dialog.
7. Card.
8. Badge.
9. Table.
10. Dropdown Menu.
11. Tabs.
12. Separator.
13. Form.
14. Calendar / Date Picker.
15. Toast.
16. Sheet jika diperlukan.

---

### 11.3 Layout

Gunakan layout admin:

1. Sidebar navigation.
2. Topbar.
3. Main content area.
4. Breadcrumb.
5. Page title.
6. Action button di kanan atas.
7. Card-based layout.
8. Table dengan filter dan pagination.

Menu sidebar:

1. Dashboard.
2. Sellers.
3. Purchases.
4. Inventory.
5. Sales.
6. Document Templates.
7. Generated Documents.
8. Reports.

---

### 11.4 Status Badge

Warna badge disarankan:

| Status | Style |
|---|---|
| available | Green |
| sold | Blue/Gray |
| draft | Yellow |
| completed | Green |
| cancelled | Red |
| generated | Blue |
| printed | Purple |
| signed | Green |
| lost | Red |
| damaged | Orange |
| melted | Gray |

---

## 12. Backend Architecture

### 12.1 Laravel Layers

Struktur backend disarankan:

```text
app/
  Actions/
    Purchases/
      CompletePurchaseAction.php
      CancelPurchaseAction.php
    Sales/
      CompleteSaleAction.php
      CancelSaleAction.php
    Documents/
      GenerateDocumentAction.php

  Services/
    PurchaseService.php
    InventoryService.php
    SaleService.php
    DocumentService.php
    PdfService.php
    NumberGeneratorService.php
    FileUploadService.php

  Http/
    Controllers/
      DashboardController.php
      SellerController.php
      PurchaseTransactionController.php
      InventoryItemController.php
      SalesTransactionController.php
      DocumentTemplateController.php
      GeneratedDocumentController.php
      ReportController.php

    Requests/
      SellerStoreRequest.php
      SellerUpdateRequest.php
      PurchaseTransactionStoreRequest.php
      PurchaseTransactionUpdateRequest.php
      SalesTransactionStoreRequest.php
      SalesTransactionUpdateRequest.php
      InventoryItemUpdateRequest.php
      DocumentTemplateStoreRequest.php
      DocumentTemplateUpdateRequest.php

  Models/
    User.php
    Seller.php
    PurchaseTransaction.php
    PurchaseItem.php
    InventoryItem.php
    SalesTransaction.php
    SalesItem.php
    DocumentTemplate.php
    GeneratedDocument.php
```

---

### 12.2 Service Responsibility

#### PurchaseService

Bertanggung jawab untuk:

1. Membuat purchase transaction.
2. Membuat purchase items.
3. Menghitung subtotal dan total.
4. Menyimpan foto produk.
5. Mengubah status purchase.
6. Memanggil inventory service saat purchase completed.

#### InventoryService

Bertanggung jawab untuk:

1. Membuat inventory item dari purchase item.
2. Generate SKU.
3. Update selling price.
4. Update inventory status.
5. Menandai barang sold.
6. Mengecek apakah barang available.

#### SaleService

Bertanggung jawab untuk:

1. Membuat sales transaction.
2. Membuat sales items.
3. Menghitung subtotal dan total.
4. Validasi barang available.
5. Update inventory menjadi sold.
6. Cancel sales dan restore inventory jika dibutuhkan.

#### DocumentService

Bertanggung jawab untuk:

1. Mengambil template.
2. Mapping data transaksi ke placeholder.
3. Generate document number.
4. Menyimpan generated document.
5. Update status printed dan signed.

#### PdfService

Bertanggung jawab untuk:

1. Convert HTML ke PDF.
2. Simpan PDF ke storage.
3. Return file URL.

#### NumberGeneratorService

Bertanggung jawab untuk membuat:

1. Purchase number.
2. Sales number.
3. SKU.
4. Document number.

---

## 13. Frontend Architecture

### 13.1 Struktur Folder React Inertia

Struktur disarankan:

```text
resources/js/
  Components/
    AppLogo.tsx
    DeleteConfirmationDialog.tsx
    ImageUpload.tsx
    CameraCapture.tsx
    MoneyInput.tsx
    StatusBadge.tsx
    DataTable.tsx
    PageHeader.tsx
    FormError.tsx

  Layouts/
    AuthLayout.tsx
    AdminLayout.tsx

  Pages/
    Auth/
      Login.tsx

    Dashboard/
      Index.tsx

    Sellers/
      Index.tsx
      Create.tsx
      Show.tsx
      Edit.tsx
      Partials/
        SellerForm.tsx

    Purchases/
      Index.tsx
      Create.tsx
      Show.tsx
      Edit.tsx
      Partials/
        PurchaseForm.tsx
        PurchaseItemForm.tsx
        PurchaseSummary.tsx
        SellerSection.tsx

    Inventory/
      Index.tsx
      Show.tsx
      Edit.tsx
      Partials/
        InventoryForm.tsx

    Sales/
      Index.tsx
      Create.tsx
      Show.tsx
      Edit.tsx
      Partials/
        SaleForm.tsx
        SaleItemSelector.tsx
        SaleSummary.tsx

    DocumentTemplates/
      Index.tsx
      Create.tsx
      Edit.tsx
      Partials/
        DocumentTemplateForm.tsx
        PlaceholderHelp.tsx

    GeneratedDocuments/
      Index.tsx
      Show.tsx

    Reports/
      Purchases.tsx
      Sales.tsx
      Inventory.tsx

  types/
    user.ts
    seller.ts
    purchase.ts
    inventory.ts
    sale.ts
    document.ts

  utils/
    formatCurrency.ts
    formatDate.ts
    calculatePurchase.ts
    calculateSale.ts
```

---

### 13.2 Reusable Components

#### ImageUpload

Fitur:

1. Upload image.
2. Preview image.
3. Remove selected image.
4. Validate type.
5. Validate size.

#### CameraCapture

Fitur:

1. Buka kamera browser.
2. Capture image.
3. Preview captured image.
4. Convert ke file upload.
5. Fallback ke upload manual jika kamera tidak tersedia.

#### MoneyInput

Fitur:

1. Format Rupiah.
2. Tetap mengirim numeric value ke backend.
3. Support decimal jika diperlukan.

#### StatusBadge

Fitur:

1. Menerima status string.
2. Menampilkan badge dengan style sesuai status.

#### DataTable

Fitur:

1. Search.
2. Filter.
3. Pagination.
4. Empty state.
5. Loading state.

---

## 14. API / Route Requirements

Karena menggunakan Laravel Inertia, route utama adalah web routes.

### Auth Routes

```text
GET    /login
POST   /login
POST   /logout
```

### Dashboard

```text
GET    /dashboard
```

### Sellers

```text
GET    /sellers
GET    /sellers/create
POST   /sellers
GET    /sellers/{seller}
GET    /sellers/{seller}/edit
PUT    /sellers/{seller}
DELETE /sellers/{seller}
```

### Purchases

```text
GET    /purchases
GET    /purchases/create
POST   /purchases
GET    /purchases/{purchase}
GET    /purchases/{purchase}/edit
PUT    /purchases/{purchase}
POST   /purchases/{purchase}/complete
POST   /purchases/{purchase}/cancel
DELETE /purchases/{purchase}
POST   /purchases/{purchase}/documents
```

### Inventory

```text
GET    /inventory
GET    /inventory/{inventoryItem}
GET    /inventory/{inventoryItem}/edit
PUT    /inventory/{inventoryItem}
POST   /inventory/{inventoryItem}/mark-lost
POST   /inventory/{inventoryItem}/mark-damaged
POST   /inventory/{inventoryItem}/mark-melted
```

### Sales

```text
GET    /sales
GET    /sales/create
POST   /sales
GET    /sales/{sale}
GET    /sales/{sale}/edit
PUT    /sales/{sale}
POST   /sales/{sale}/complete
POST   /sales/{sale}/cancel
DELETE /sales/{sale}
POST   /sales/{sale}/documents
```

### Document Templates

```text
GET    /document-templates
GET    /document-templates/create
POST   /document-templates
GET    /document-templates/{template}/edit
PUT    /document-templates/{template}
DELETE /document-templates/{template}
POST   /document-templates/{template}/toggle-active
```

### Generated Documents

```text
GET    /documents
GET    /documents/{document}
GET    /documents/{document}/download
POST   /documents/{document}/mark-printed
POST   /documents/{document}/mark-signed
```

### Reports

```text
GET    /reports/purchases
GET    /reports/sales
GET    /reports/inventory
```

---

## 15. Validation Requirements

### 15.1 Seller Validation

```text
name: required|string|max:150
nik: nullable|string|max:30
phone: nullable|string|max:30
address: nullable|string
ktp_photo: nullable|image|mimes:jpg,jpeg,png,webp|max:5120
notes: nullable|string
```

---

### 15.2 Purchase Transaction Validation

```text
seller_id: required|exists:sellers,id
transaction_date: required|date
deduction_amount: nullable|numeric|min:0
payment_method: nullable|string|max:50
status: required|in:draft,completed,cancelled
notes: nullable|string
items: required|array|min:1
items.*.item_name: required|string|max:150
items.*.item_type: nullable|string|max:100
items.*.gold_carat: nullable|numeric|min:0|max:24
items.*.weight_gram: required|numeric|min:0.001
items.*.price_per_gram: required|numeric|min:0
items.*.deduction_amount: nullable|numeric|min:0
items.*.condition: nullable|string|max:100
items.*.description: nullable|string
items.*.product_photo: nullable|image|mimes:jpg,jpeg,png,webp|max:5120
```

---

### 15.3 Inventory Update Validation

```text
selling_price: nullable|numeric|min:0
status: required|in:available,sold,lost,damaged,melted,cancelled
notes: nullable|string
```

---

### 15.4 Sales Transaction Validation

```text
buyer_name: nullable|string|max:150
buyer_phone: nullable|string|max:30
transaction_date: required|date
discount_amount: nullable|numeric|min:0
payment_method: nullable|string|max:50
status: required|in:draft,completed,cancelled
notes: nullable|string
items: required|array|min:1
items.*.inventory_item_id: required|exists:inventory_items,id
items.*.selling_price: required|numeric|min:0
items.*.discount_amount: nullable|numeric|min:0
```

Additional backend validation:

1. `inventory_item_id` must have status **available**.
2. Same inventory item cannot be submitted twice.
3. Selling price must be greater than or equal to discount amount.

---

### 15.5 Document Template Validation

```text
name: required|string|max:150
code: required|string|max:100|unique:document_templates,code
document_type: required|string|max:100
html_content: required|string
is_active: boolean
```

For update:

```text
code: required|string|max:100|unique:document_templates,code,{id}
```

---

## 16. File Storage Requirements

### 16.1 Storage Paths

KTP seller:

```text
storage/app/public/sellers/ktp
```

Product photos:

```text
storage/app/public/purchase-items/products
```

Generated PDFs:

```text
storage/app/public/documents/generated
```

Avatar:

```text
storage/app/public/users/avatars
```

---

### 16.2 Public Access

Laravel command:

```bash
php artisan storage:link
```

File URL disimpan di database sebagai relative/public path.

Contoh:

```text
storage/sellers/ktp/filename.jpg
storage/purchase-items/products/filename.jpg
storage/documents/generated/file.pdf
```

---

### 16.3 File Naming

Gunakan format unik:

```text
{type}-{date}-{uuid}.{extension}
```

Contoh:

```text
ktp-20260504-a1b2c3.jpg
product-20260504-f4e5d6.jpg
purchase-invoice-20260504-0001.pdf
```

---

## 17. PDF Requirements

### 17.1 PDF Generation

Sistem harus bisa membuat PDF dari HTML template.

Data yang dapat digunakan:

1. Purchase transaction.
2. Purchase items.
3. Seller.
4. Admin.
5. Sales transaction.
6. Sales items.
7. Inventory items.

### 17.2 PDF Output

PDF harus:

1. Memiliki layout rapi.
2. Bisa dibuka di browser.
3. Bisa di-download.
4. Bisa di-print.
5. Menampilkan data yang sesuai.
6. Memiliki area tanda tangan penjual dan pihak toko jika dokumen purchase.
7. Memiliki nomor dokumen unik.

### 17.3 PDF Template Recommendation

Gunakan HTML + CSS sederhana agar kompatibel dengan PDF renderer.

Contoh layout:

1. Header toko.
2. Nomor dokumen.
3. Tanggal.
4. Data seller/buyer.
5. Table item.
6. Total amount.
7. Notes.
8. Signature area.

---

## 18. Business Rules Detail

### 18.1 Purchase Completion Rule

Ketika purchase completed:

1. Simpan purchase transaction.
2. Simpan purchase items.
3. Hitung amount.
4. Untuk setiap purchase item:
   - buat inventory item
   - generate SKU
   - copy item_name
   - copy item_type
   - copy gold_carat
   - copy weight_gram
   - set purchase_price = final_price
   - set selling_price = null
   - set status = available
   - copy condition
   - copy product_photo_url
   - set acquired_at = transaction_date
5. Pastikan semua proses berjalan dalam database transaction.

---

### 18.2 Sale Completion Rule

Ketika sale completed:

1. Validasi semua inventory item available.
2. Simpan sales transaction.
3. Simpan sales items.
4. Untuk setiap sales item:
   - copy snapshot inventory data
   - set purchase_price
   - set selling_price
   - set discount_amount
   - set final_price
5. Update inventory:
   - status = sold
   - sold_at = transaction_date
6. Pastikan semua proses berjalan dalam database transaction.

---

### 18.3 Cancel Purchase Rule

Purchase bisa dibatalkan jika:

1. Status purchase bukan cancelled.
2. Semua inventory item dari purchase tersebut belum sold.
3. Jika cancelled:
   - purchase status menjadi cancelled
   - inventory item status menjadi cancelled

Purchase tidak boleh dibatalkan jika salah satu barang sudah sold.

---

### 18.4 Cancel Sale Rule

Sale bisa dibatalkan jika:

1. Status sale bukan cancelled.
2. Jika cancelled:
   - sales status menjadi cancelled
   - inventory item dari sales dikembalikan ke available
   - sold_at dikosongkan

---

### 18.5 Soft Delete Rule

Data yang menggunakan soft delete:

1. users
2. sellers
3. purchase_transactions
4. purchase_items
5. inventory_items
6. sales_transactions
7. document_templates
8. generated_documents

Data yang tidak memiliki deleted_at pada schema:

1. sales_items

Jika ingin konsisten, dapat dipertimbangkan menambahkan soft delete ke `sales_items`, tetapi karena schema final tidak menyertakannya, sistem mengikuti schema yang diberikan.

---

## 19. Security Requirements

1. Semua halaman internal harus dilindungi middleware auth.
2. Password harus di-hash.
3. File upload harus divalidasi.
4. Hanya file image yang boleh diupload untuk KTP dan produk.
5. File PDF hanya dibuat oleh sistem.
6. Input HTML template perlu dibatasi untuk admin saja.
7. Gunakan CSRF protection dari Laravel.
8. Gunakan validation request di backend.
9. Jangan percaya kalkulasi dari frontend; backend harus menghitung ulang semua amount.
10. Gunakan database transaction untuk purchase dan sale.
11. Jangan expose file private tanpa kebutuhan.
12. Jangan simpan password atau data sensitif dalam plain text.

---

## 20. Error Handling

Sistem harus menampilkan error yang jelas untuk kasus:

1. Login gagal.
2. Upload file gagal.
3. File terlalu besar.
4. Format file tidak didukung.
5. Seller tidak ditemukan.
6. Purchase transaction tidak ditemukan.
7. Inventory item tidak tersedia.
8. Barang sudah terjual.
9. Transaksi tidak bisa dibatalkan.
10. Template dokumen tidak aktif.
11. Generate PDF gagal.
12. Database transaction gagal.

Gunakan toast notification untuk feedback cepat:

1. Data berhasil disimpan.
2. Data berhasil diperbarui.
3. Data berhasil dihapus.
4. PDF berhasil dibuat.
5. Dokumen ditandai printed.
6. Dokumen ditandai signed.
7. Transaksi berhasil diselesaikan.

---

## 21. Empty State Requirements

Setiap table harus memiliki empty state.

Contoh:

### Sellers Empty State

```text
Belum ada data penjual. Tambahkan penjual pertama untuk mulai mencatat transaksi pembelian emas.
```

### Purchase Empty State

```text
Belum ada transaksi pembelian. Buat transaksi pembelian pertama.
```

### Inventory Empty State

```text
Belum ada barang di inventori. Barang akan otomatis masuk setelah transaksi pembelian selesai.
```

### Sales Empty State

```text
Belum ada transaksi penjualan. Buat transaksi penjualan setelah ada barang tersedia.
```

### Document Template Empty State

```text
Belum ada template dokumen. Buat template invoice atau surat terlebih dahulu.
```

---

## 22. Pagination, Search, and Filter

### Pagination

Semua halaman list menggunakan pagination.

Default:

```text
10 data per halaman
```

Opsi:

```text
10, 25, 50, 100
```

### Search

Search minimal tersedia pada:

1. Sellers.
2. Purchases.
3. Inventory.
4. Sales.
5. Generated Documents.

### Filter

Filter minimal tersedia pada:

1. Purchase status.
2. Sales status.
3. Inventory status.
4. Item type.
5. Gold carat.
6. Date range.

---

## 23. Data Formatting

### Currency

Gunakan format Rupiah:

```text
Rp1.250.000
```

### Weight

Gunakan gram dengan 3 desimal jika diperlukan:

```text
3.250 gram
```

### Date

Format display:

```text
04 Mei 2026
```

Format datetime:

```text
04 Mei 2026 14:30
```

### Gold Carat

Format:

```text
22K
24K
18K
```

---

## 24. Testing Requirements

### 24.1 Feature Test Backend

Minimal test:

1. Admin can login.
2. Admin can create seller.
3. Admin can create purchase transaction.
4. Purchase completed creates inventory item.
5. Admin cannot complete purchase without items.
6. Admin can update inventory selling price.
7. Admin can create sales transaction.
8. Sales completed marks inventory as sold.
9. Sold inventory cannot be sold again.
10. Admin can create document template.
11. Admin can generate document.
12. Admin can mark document as printed.
13. Admin can mark document as signed.

---

### 24.2 Validation Test

Test validasi:

1. Seller name required.
2. Purchase item weight must be greater than 0.
3. Purchase item price cannot be negative.
4. Sales item inventory must be available.
5. Document template code must be unique.

---

### 24.3 UI Test Manual

Manual test:

1. Login works.
2. Sidebar navigation works.
3. Seller form works.
4. KTP upload preview works.
5. Product photo upload preview works.
6. Purchase item dynamic form works.
7. Purchase calculation works.
8. Inventory list updates after purchase.
9. Sale form can select available inventory.
10. Sold item disappears from available selector.
11. PDF can be opened and printed.

---

## 25. Seeder Requirements

Seeder awal:

### Admin User

```text
name: Admin
email: admin@example.com
password: password
```

### Document Templates

Template awal:

1. Purchase Invoice.
2. Purchase Agreement.
3. Goods Receipt.
4. Sales Invoice.

---

## 26. Recommended Development Phases

### Phase 1 — Project Setup & Auth

Fitur:

1. Laravel project setup.
2. Inertia React TypeScript setup.
3. Tailwind CSS setup.
4. shadcn/ui setup.
5. Auth login/logout.
6. Admin layout.
7. Dashboard layout kosong.

Deliverable:

- Admin bisa login dan masuk dashboard.

---

### Phase 2 — Seller Management

Fitur:

1. Migration sellers.
2. Model seller.
3. CRUD seller.
4. Upload KTP.
5. Seller detail.
6. Seller search.

Deliverable:

- Admin bisa mengelola data penjual.

---

### Phase 3 — Purchase Transaction

Fitur:

1. Migration purchase_transactions.
2. Migration purchase_items.
3. Create purchase form.
4. Dynamic purchase items.
5. Upload product photo.
6. Calculation frontend.
7. Calculation backend.
8. Save draft.
9. Complete purchase.

Deliverable:

- Admin bisa mencatat pembelian emas.

---

### Phase 4 — Inventory

Fitur:

1. Migration inventory_items.
2. Auto-create inventory after purchase completed.
3. Inventory list.
4. Inventory detail.
5. Edit selling price.
6. Update status.
7. Search and filter.

Deliverable:

- Barang pembelian otomatis masuk inventori.

---

### Phase 5 — Sales Transaction

Fitur:

1. Migration sales_transactions.
2. Migration sales_items.
3. Create sales form.
4. Select available inventory.
5. Sales calculation.
6. Complete sale.
7. Mark inventory as sold.
8. Sales detail.

Deliverable:

- Admin bisa menjual barang dan stok berubah sold.

---

### Phase 6 — Document Templates & PDF

Fitur:

1. Migration document_templates.
2. Migration generated_documents.
3. CRUD document templates.
4. Placeholder parser.
5. Generate PDF purchase.
6. Generate PDF sales.
7. Print document.
8. Mark printed/signed.

Deliverable:

- Admin bisa generate dan print PDF dokumen.

---

### Phase 7 — Reports & Polishing

Fitur:

1. Purchase report.
2. Sales report.
3. Inventory report.
4. Dashboard statistics.
5. UI polish.
6. Empty state.
7. Toast notification.
8. Error handling.

Deliverable:

- Sistem siap digunakan untuk MVP internal toko.

---

## 27. Acceptance Criteria Global

Produk dianggap selesai untuk MVP jika:

1. Admin dapat login.
2. Admin dapat mengelola seller.
3. Admin dapat mengupload foto KTP seller.
4. Admin dapat membuat transaksi pembelian emas.
5. Admin dapat menambahkan beberapa barang dalam satu transaksi pembelian.
6. Admin dapat mengupload foto produk emas.
7. Sistem menghitung total pembelian dengan benar.
8. Barang otomatis masuk inventory saat purchase completed.
9. Inventory memiliki SKU unik.
10. Admin dapat melihat daftar inventory.
11. Admin dapat mengubah selling price inventory.
12. Admin dapat membuat transaksi penjualan.
13. Admin hanya bisa menjual inventory status available.
14. Sistem mengubah inventory menjadi sold setelah sales completed.
15. Admin dapat membuat template dokumen.
16. Admin dapat generate PDF dari purchase transaction.
17. Admin dapat generate PDF dari sales transaction.
18. PDF dapat dicetak.
19. Admin dapat menandai dokumen printed dan signed.
20. Dashboard menampilkan statistik dasar.
21. Semua form memiliki validasi backend.
22. Semua halaman internal terlindungi auth.
23. Data utama menggunakan soft delete sesuai schema.
24. UI menggunakan Tailwind CSS dan shadcn/ui.
25. Sistem berjalan dengan Laravel, Inertia, React, TypeScript, dan MySQL.

---

## 28. Notes untuk Developer

1. Gunakan database transaction saat membuat purchase completed dan sale completed.
2. Jangan mengandalkan kalkulasi frontend.
3. Frontend boleh menghitung untuk preview, tetapi backend harus menghitung ulang.
4. Simpan snapshot data pada `sales_items`.
5. Jangan membuat inventory dari purchase draft.
6. Gunakan service/action agar controller tetap bersih.
7. Upload file sebaiknya diproses melalui service khusus.
8. Gunakan enum-like constants untuk status agar tidak typo.
9. Gunakan policy sederhana jika nanti diperlukan, meskipun saat ini hanya admin.
10. Pastikan sold inventory tidak dapat dijual dua kali.
11. PDF lama tidak perlu berubah walaupun template diedit.
12. Gunakan pagination untuk semua list.
13. Gunakan format Rupiah di frontend.
14. Gunakan decimal dengan presisi sesuai schema untuk berat dan harga.

---

## 29. Risiko dan Mitigasi

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Barang terjual dua kali | Data stok tidak valid | Lock row / validasi status available di backend |
| Kalkulasi frontend dimanipulasi | Nilai transaksi salah | Backend menghitung ulang |
| Upload file gagal | Bukti transaksi tidak tersimpan | Validasi dan error handling upload |
| PDF gagal dibuat | Dokumen tidak bisa dicetak | Simpan error dan tampilkan retry |
| Template HTML rusak | PDF berantakan | Sediakan preview dan template default |
| Purchase dibatalkan setelah barang sold | Data tidak konsisten | Blokir cancel purchase jika item sudah sold |
| File hilang dari storage | Bukti transaksi hilang | Backup storage secara berkala |

---

## 30. Kesimpulan

PRD ini mendefinisikan sistem manajemen inventori toko emas versi MVP dengan scope yang jelas: satu toko dan satu role admin.

Fokus utama sistem adalah:

1. Mencatat pembelian emas dari seller.
2. Menyimpan foto KTP dan foto produk.
3. Menghitung transaksi pembelian.
4. Membuat barang otomatis masuk inventori.
5. Mencatat penjualan barang.
6. Mengubah status barang menjadi sold.
7. Membuat dan mencetak dokumen PDF.
8. Menampilkan laporan dasar.

Dengan rancangan ini, developer dapat mulai membangun aplikasi secara bertahap menggunakan Laravel, Inertia, React, TypeScript, MySQL, Tailwind CSS, dan shadcn/ui.
