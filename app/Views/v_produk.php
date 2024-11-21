<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Memanggil file CSS Bootstrap untuk styling halaman -->
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.0.2-dist/css/bootstrap.min.css') ?>">
    <!-- Memanggil font-awesome untuk ikon-ikon pada tombol -->
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome-free-6.6.0-web/css/all.min.css') ?>">
    <!-- Memanggil SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Memanggil jQuery untuk mempermudah manipulasi DOM dan AJAX -->
    <script src="<?= base_url('assets/jquery-3.7.1.min.js') ?>"></script>
    <!-- Menambahkan CDN untuk SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.css" rel="stylesheet">

    <title>Tabel Produk</title>
</head>

<body>
    <!-- Kontainer utama untuk layout -->
    <div class="container">
        <div class="row mt-3">
            <div class="col-12">
                <h3 class="text-center">Data Produk</h3>
                <!-- Tombol untuk membuka modal tambah produk -->
                <button type="button" class="btn btn-success float-end" data-bs-toggle="modal"
                    data-bs-target="#modalTambahProduk">
                    <i class="fa-solid fa-cart-plus"></i> Tambah Data
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="container mt-5">
                <table class="table table-bordered" id="produkTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data produk akan dimasukkan melalui AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal untuk menambah produk -->
    <div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-labelledby="modalLabelTambah">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalLabelTambah">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3 row">
                            <label for="produkNama" class="col-sm-3 col-form-label">Nama Produk</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="namaProduk" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="harga" class="col-sm-3 col-form-label">Harga</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="hargaProduk" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="stok" class="col-sm-3 col-form-label">Stok</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="stokProduk" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="gambar" class="col-sm-3 col-form-label">Gambar Produk</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="gambarProduk" accept="image/*">
                            </div>
                        </div>
                        <button type="button" id="simpanProduk" class="btn btn-primary float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal untuk mengedit produk -->
    <div class="modal fade" id="modalEditProduk" tabindex="-1" aria-labelledby="modalLabelEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalLabelEdit">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditProduk">
                        <input type="hidden" id="editProdukId">
                        <div class="mb-3 row">
                            <label for="editNamaProduk" class="col-sm-3 col-form-label">Nama Produk</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="editNamaProduk" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="editHarga" class="col-sm-3 col-form-label">Harga</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="editHarga" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="editStok" class="col-sm-3 col-form-label">Stok</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="editStok" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="gambar" class="col-sm-3 col-form-label">Gambar Produk</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="gambarProduk" accept="image/*">
                            </div>
                        </div>
                        <button type="button" id="updateProduk" class="btn btn-primary float-end">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Menampilkan produk dalam tabel
            function tampilProduk() {
                $.ajax({
                    url: '<?= base_url('produk/tampil') ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function (hasil) {
                        if (hasil.status == 'success') {
                            var produkTable = $('#produkTable tbody');
                            produkTable.empty();
                            var produk = hasil.produk;
                            var no = 1;

                            produk.forEach(function (item) {
                                var row = '<tr>' +
                                    '<td>' + no + '</td>' +
                                    '<td>' + item.nama_produk + '</td>' +
                                    '<td>' + item.harga + '</td>' +
                                    '<td>' + item.stok + '</td>' +
                                    '<td>' + item.gambar + '</td>' +
                                    '<td>' +
                                    '<button class="btn btn-warning btn-sm editProduk" data-bs-toggle="modal" data-bs-target="#modalEditProduk" data-id="' + item.produk_id + '"><i class="fa-solid fa-pencil"></i> Edit</button>' +
                                    '  <button class="btn btn-danger btn-sm hapusProduk" id="hapusProduk" data-id="' + item.produk_id + '"><i class="fa-solid fa-trash-can"></i> Hapus</button>' +
                                    '</td>' +
                                    '</tr>';
                                produkTable.append(row);
                                no++;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal mengambil data.',
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan',
                            text: 'Terjadi kesalahan: ' + error,
                        });
                    }
                });
            }

            tampilProduk();

            $("#simpanProduk").on("click", function () {
                var formData = new FormData();
                formData.append("nama_produk", $("#namaProduk").val());
                formData.append("harga", $("#hargaProduk").val());
                formData.append("stok", $("#stokProduk").val());
                var gambar = $("#gambarProduk")[0].files[0];
                if (gambar) {
                    formData.append("gambar", gambar);
                }

                $.ajax({
                    url: '<?= base_url('produk/simpan') ?>',
                    type: 'POST',
                    data: formData,
                    processData: false, // Jangan memproses data
                    contentType: false, // Jangan set contentType secara otomatis
                    dataType: 'json',
                    success: function (hasil) {
                        if (hasil.status == 'success') {
                            $("#modalTambahProduk").modal("hide");
                            tampilProduk();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Produk berhasil disimpan.',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal menyimpan produk: ' + JSON.stringify(hasil.errors),
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan',
                            text: 'Terjadi kesalahan: ' + error,
                        });
                    }
                });
            });


            $(document).on("click", ".editProduk", function () {
                var id = $(this).data("id");

                $.ajax({
                    url: '<?= base_url('produk/tampil/') ?>' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (hasil) {
                        if (hasil.status == 'success') {
                            var produk = hasil.produk;

                            $("#editProdukId").val(produk.produk_id);
                            $("#editNamaProduk").val(produk.nama_produk);
                            $("#editHarga").val(produk.harga);
                            $("#editStok").val(produk.stok);
                            $("#editGambar").val(produk.gambar);

                            $("#modalEditProduk").modal("show");
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal mengambil data untuk diedit.',
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan',
                            text: 'Terjadi kesalahan: ' + error,
                        });
                    }
                });
            });

            $("#updateProduk").on("click", function () {
                var formData = new FormData();
                formData.append("id", $("#editProdukId").val());
                formData.append("nama_produk", $("#editNamaProduk").val());
                formData.append("harga", $("#editHarga").val());
                formData.append("stok", $("#editStok").val());

                var gambar = $("#gambarProduk")[0].files[0];
                if (gambar) {
                    formData.append("gambar", gambar);
                }

                $.ajax({
                    url: '<?= base_url('produk/update') ?>',
                    type: 'POST',
                    data: formData,
                    processData: false, // Jangan memproses data
                    contentType: false, // Jangan set contentType secara otomatis
                    dataType: 'json',
                    success: function (hasil) {
                        if (hasil.status == 'success') {
                            $("#modalEditProduk").modal("hide");
                            tampilProduk();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data produk berhasil diperbarui.',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal memperbarui data: ' + JSON.stringify(hasil.errors),
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan',
                            text: 'Terjadi kesalahan: ' + error,
                        });
                    }
                });
            });


            $(document).on("click", ".hapusProduk", function () {
                var id = $(this).data("id");
                if (confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
                    $.ajax({
                        url: '<?= base_url('produk/hapus') ?>/' + id,
                        type: 'DELETE',
                        dataType: 'json',
                        success: function (hasil) {
                            if (hasil.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses!',
                                    text: 'Produk berhasil dihapus.',
                                });
                                tampilProduk();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Gagal menghapus produk: ' + hasil.message,
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi kesalahan',
                                text: 'Terjadi kesalahan: ' + error,
                            });
                        }
                    });
                }
            });
        });
    </script>

    <!-- Menambahkan CDN untuk SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.all.min.js"></script>

    <script src="<?= base_url('assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>