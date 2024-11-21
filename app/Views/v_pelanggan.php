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

    <title>Tabel Pelanggan</title>
</head>

<body>
    <!-- Kontainer utama untuk layout -->
    <div class="container">
        <div class="row mt-3">
            <div class="col-12">
                <h3 class="text-center">Data Pelanggan</h3>
                <!-- Tombol untuk membuka modal tambah produk -->
                <button type="button" class="btn btn-success float-end" data-bs-toggle="modal"
                    data-bs-target="#modalTambahPelanggan">
                    <i class="fa fa-user-o"></i> Tambah Data
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
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>No. Telp</th>
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
    <div class="modal fade" id="modalTambahPelanggan" tabindex="-1" aria-labelledby="modalLabelTambah">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalLabelTambah">Tambah Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3 row">
                            <label for="namaPelanggan" class="col-sm-3 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="namaPelanggan" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="alamatPelanggan" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="nomerTelepon" class="col-sm-3 col-form-label">No. Telp</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="nomerTeleponPelanggan" required>
                            </div>
                        </div>
                        <button type="button" id="simpanPelanggan" class="btn btn-primary float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal untuk mengedit produk -->
    <div class="modal fade" id="modalEditPelanggan" tabindex="-1" aria-labelledby="modalLabelEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalLabelEdit">Edit Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditProduk">
                        <input type="hidden" id="editPelangganId">
                        <div class="mb-3 row">
                            <label for="namaPelanggan" class="col-sm-3 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="editNamaPelanggan" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="editAlamat" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="nomerTelepon" class="col-sm-3 col-form-label">No. Telp</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="editNomerTelepon" required>
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
                    url: '<?= base_url('pelanggan/tampil') ?>',
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
                                    '<td>' + item.nama_pelanggan + '</td>' +
                                    '<td>' + item.alamat + '</td>' +
                                    '<td>' + item.nomer_telepon + '</td>' +
                                    '<td>' +
                                    '<button class="btn btn-warning btn-sm editPelanggan" data-bs-toggle="modal" data-bs-target="#modalEditPelanggan" data-id="' + item.id_pelanggan + '"><i class="fa-solid fa-pencil"></i> Edit</button>' +
                                    '   <button class="btn btn-danger btn-sm hapusPelanggan" id="hapusPelanggan" data-id="' + item.id_pelanggan + '"><i class="fa-solid fa-trash-can"></i> Hapus</button>' +
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

            $("#simpanPelanggan").on("click", function () {
                var formData = new FormData();
                formData.append("nama_pelanggan", $("#namaPelanggan").val());
                formData.append("alamat", $("#alamatPelanggan").val());
                formData.append("nomer_telepon", $("#nomerTeleponPelanggan").val());

                $.ajax({
                    url: '<?= base_url('pelanggan/simpan') ?>',
                    type: 'POST',
                    data: formData,
                    processData: false, // Jangan memproses data
                    contentType: false, // Jangan set contentType secara otomatis
                    dataType: 'json',
                    success: function (hasil) {
                        if (hasil.status == 'success') {
                            $("#modalTambahPelanggan").modal("hide");
                            tampilProduk();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Pelanggan berhasil disimpan.',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal menyimpan pelanggan: ' + JSON.stringify(hasil.errors),
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


            $("#produkTable").on("click", ".editPelanggan", function () {
                var id = $(this).data("id");
                
                $.ajax({
                    url: '<?= base_url('pelanggan/tampil/') ?>' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (hasil) {
                        if (hasil.status == 'success') {
                            
                            var pelanggan = hasil.pelanggan;

                            $("#editPelangganId").val(pelanggan.id_pelanggan);
                            $("#editNamaPelanggan").val(pelanggan.nama_pelanggan);
                            $("#editAlamat").val(pelanggan.alamat);
                            $("#editNomerTelepon").val(pelanggan.nomer_telepon);
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
                var formData = {
                    id_pelanggan: $("#editPelangganId").val(),
                    nama_pelanggan: $("#editNamaPelanggan").val(),
                    alamat: $("#editAlamat").val(),
                    nomer_telepon: $("#editNomerTelepon").val()
                }             

                $.ajax({
                    url: '<?= base_url('pelanggan/update') ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (hasil) {
                        if (hasil.status == 'success') {
                            $("#modalEditPelanggan").modal("hide");
                            tampilProduk();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data pelanggan berhasil diperbarui.',
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


            $(document).on("click", ".hapusPelanggan", function () {
                var id = $(this).data("id");
                console.log(id);
                if (confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
                    $.ajax({
                        url: '<?= base_url('pelanggan/hapus') ?>/' + id,
                        type: 'POST',
                        dataType: 'json',
                        success: function (hasil) {
                            if (hasil.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses!',
                                    text: 'Pelanggan berhasil dihapus.',
                                });
                                tampilProduk();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Gagal menghapus pelanggan: ' + hasil.message,
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