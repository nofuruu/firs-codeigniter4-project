<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
    <title>Form Pendaftaran MyInternet</title>


    <style>
        body {
            background-color: #f9f9fa;
            margin: 2rem;
        }


        .container {
            margin-top: 50px;

        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .modal-footer {
            backgoround-color: #f1f1f1;
        }

        .form-check-label {
            margin-left: 10px;
        }

        .card-header {
            color: white;
            padding: 10px;
            border-radius: 5px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .table {
            margin-top: 20px;
        }

        .btn-primary, .btn-warning{
            margin-right: 10px;
        }
        .btn-close {
            background-color: white;
        }


    </style>



</head>


<body>



    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Form Pendaftaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registrationForm" method="POST">
                        <input type="hidden" name="id" id="form-id" value="">

                        <!-- Username -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="username" id="form-username" placeholder="Username" required>
                            <label>Username</label>
                        </div>

                        <!-- Password -->
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" id="form-password" placeholder="Password" required>
                            <label>Password</label>
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="nama_lengkap" id="form-nama_lengkap" placeholder="Nama Lengkap" required>
                            <label>Nama Lengkap</label>
                        </div>

                        <!-- Status -->
                        <label>Status Saat Ini</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="form-aktif" value="Aktif">
                            <label class="form-check-label" for="aktif">Aktif</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="form-non_aktif" value="Non-Aktif">
                            <label class="form-check-label" for="non_aktif">Non-Aktif</label>
                        </div>

                        <!-- Paket Dropdown -->
                        <div class="mb-4">
                            <label for="paket_select">Pilih Paket</label>
                            <select class="form-select" name="paket_select" id="form-paket_select" onchange="showPaketOptions()">
                                <option value="" disabled>Pilih paket yang ingin digunakan</option>
                                <option value="Standart">Standart</option>
                                <option value="Reguler">Reguler</option>
                                <option value="Premium">Premium</option>
                            </select>
                        </div>

                        <!-- Paket Options -->
                        <div id="standart_options" style="display:none;">
                            <h4>Opsi Standart</h4>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="paket_detail[]" value="Standart 20Mbps 30Hari">
                                <label>Standart 20Mbps 30Hari</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="paket_detail[]" value="Standart 20Mbps 60Hari">
                                <label>Standart 20Mbps 60Hari</label>
                            </div>
                        </div>

                        <div id="reguler_options" style="display:none;">
                            <h4>Opsi Reguler</h4>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="paket_detail[]" value="Reguler 30Mbps 30Hari">
                                <label>Reguler 30Mbps 30Hari</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="paket_detail[]" value="Reguler 30Mbps 60Hari">
                                <label>Reguler 30Mbps 60Hari</label>
                            </div>
                        </div>

                        <div id="premium_options" style="display:none;">
                            <h4>Opsi Premium</h4>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="paket_detail[]" value="Premium 50Mbps 30Hari">
                                <label>Premium 50Mbps 30Hari</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="paket_detail[]" value="Premium 50Mbps 60Hari">
                                <label>Premium 50Mbps 60Hari</label>
                            </div>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary mt-4" id="submitButton">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Menampilkan Data Langganan -->
    <div class="card-header mt-5">
    <form id="searchForm" autocomplete="off">
        <div class="input-group">
            <input
                type="text"
                name="keyword"
                class="form-control"
                style="width:155pt;"
                placeholder="Search Here"
                value="">
        </div>
    </form>
</div>



    <h3>Daftar Pelanggan</h3>
    <div class="mt-3">
        <a href="<?= base_url('userController/export') ?>" class="btn btn-success">Export to Excel</a>
        <button class="btn btn-primary" id="openModalButton">Daftar</button>
        <button class="btn btn-warning" id="truncateButton">Truncate Table</button>

    </div>

    <div class="mt-3">
        <form action="<?= base_url('userController/import') ?>" method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <input type="file" name="file" class="form-control" accept=".xlsx, .xls" required>
                <button type="submit" class="btn btn-primary">Import from Excel</button>
            </div>
        </form>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Status</th>
                <th>Detail Paket</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
   

</body>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
    $(document).ready(function() {
        // Load table data on page load
        loadTable();

        $('#registrationForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            $.ajax({
                url: '<?= base_url('userController/tambah') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $('#formModal').modal('hide'); // Hide the modal
                        $('#registrationForm')[0].reset(); // Reset the form
                        loadTable(); // Reload the table data
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error); // Debug log
                }
            });
        });

        $(document).on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '<?= base_url('userController/edit') ?>/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#form-id').val(response.data.id);
                        $('#form-username').val(response.data.username);
                        $('#form-password').val(''); // Clear password field for security
                        $('#form-nama_lengkap').val(response.data.nama_lengkap);
                        $('input[name="status"][value="' + response.data.status + '"]').prop('checked', true);
                        $('#form-paket_select').val(response.data.paket_select);
                        showPaketOptions();

                        // Clear and set paket_detail checkboxes
                        $('input[name="paket_detail[]"]').prop('checked', false);
                        response.data.paket_detail.split(', ').forEach(function(detail) {
                            $('input[name="paket_detail[]"][value="' + detail + '"]').prop('checked', true);
                        });

                        // Change modal header and button text for edit mode
                        $('#formModalLabel').text('Form Edit Data');
                        $('#submitButton').text('Edit').removeClass('btn-primary').addClass('btn-warning');

                        var myModal = new bootstrap.Modal(document.getElementById('formModal'));
                        myModal.show();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error); // Debug log
                }
            });
        });

        // Reset modal to default state when opening for adding new data
        $('#openModalButton').on('click', function() {
            $('#formModalLabel').text('Form Pendaftaran MyInternet');
            $('#submitButton').text('Submit').removeClass('btn-warning').addClass('btn-primary');
            $('#registrationForm')[0].reset();
            $('#form-id').val('');
            showPaketOptions();

            var myModal = new bootstrap.Modal(document.getElementById('formModal'));
            myModal.show();
        });

        $('#truncateButton').on('click', function() {
            if (confirm('Are you sure you want to truncate the table? This action cannot be undone.')) {
                $.ajax({
                    url: '<?= base_url('userController/truncate') ?>',
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        console.log('AJAX response:', response); // Debug log
                        if (response.success) {
                            alert(response.message);
                            loadTable(); // Reload the table data
                        } else {
                            alert('Failed to truncate table.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error); // Debug log
                    }
                });
            }
        });

        // Add event listener to search input
        $('input[name="keyword"]').on('input', function() {
            loadTable($(this).val());
        });

        // Add event listener for delete buttons
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this data?')) {
                $.ajax({
                    url: '<?= base_url('userController/delete') ?>/' + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Data berhasil dihapus!');
                            loadTable(); // Reload the table data
                        } else {
                            alert('Gagal menghapus data: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Gagal menghapus data: ' + error);
                    }
                });
            }
        });
    });

    function loadTable(keyword = '') {
        $.ajax({
            url: '<?= base_url('userController/getData') ?>',
            type: 'GET',
            data: { keyword: keyword },
            dataType: 'json',
            success: function(response) {
                var tableBody = $('table tbody');
                tableBody.empty(); // Clear the table body

                response.data.forEach(function(subscription, index) {
                    var newRow = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${subscription.username}</td>
                            <td>${subscription.nama_lengkap}</td>
                            <td>${subscription.status}</td>
                            <td>${subscription.paket_detail}</td>
                            <td>
                                <button class="btn btn-warning edit-btn" data-id="${subscription.id}">Edit</button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${subscription.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                    tableBody.append(newRow);
                });
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error); // Debug log
            }
        });
    }

    function showPaketOptions() {
        let paket = document.getElementById("form-paket_select").value;

        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });

        document.getElementById("standart_options").style.display = "none";
        document.getElementById("reguler_options").style.display = "none";
        document.getElementById("premium_options").style.display = "none";

        if (paket === 'Standart') {
            document.getElementById("standart_options").style.display = "block";
        } else if (paket === 'Reguler') {
            document.getElementById("reguler_options").style.display = "block";
        } else if (paket === 'Premium') {
            document.getElementById("premium_options").style.display = "block";
        }
    }
</script>
</html>