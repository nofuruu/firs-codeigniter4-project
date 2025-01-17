<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Form Pendaftaran MyInternet</title>


    <style>
        body {
            background-color: #f9f9fa;
        }


        .container {
            margin-top: 50px;

        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .modal-footer {
            background-color: #f1f1f1;
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

        .btn-primary,
        .btn-warning {
            margin-right: 10px;
        }

        .btn-close {
            background-color: white;
        }

        #dataTittle {
            text-transform: uppercase;
            font-weight: bold;
            font: bold;
            font-size: 2rem;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

       

    </style>



</head>
<body>

        <?= $this->include('template/navbar') ?>

        <div class="card-header" style="width: 40rem; height:auto;">
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
    </nav>


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



    <div class="data-tittle">
        <h1 class="text-center mt-2" id="dataTittle">Data Pelanggan</h1>
    </div>
   
 <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <button class="btn btn-primary" id="openModalButton"><i class="bx bx-plus-circle margin-r-2"></i> 
                <span class="fw-normal fs-7">Daftar</span>
            </button>
                <form id="logoutForm" action="<?= base_url('logout') ?>" method="POST" style="display:inline;">
                    <button type="submit" class="btn btn-danger" id="logoutButton">
                    <i class='bx bx-exit'></i>
                    <span class="fw-normal fs-7">Logout</span>
                </button>
                </form>
            </div>

            <form id="exportForm" action="<?= base_url('userController/export') ?>" method="GET" style="display:inline;">
                <button type="submit" class="btn btn-success" id="exportButton">
                <i class='bx bx-download'></i>
                <span class="fw-normal fs-7">Export to Excel</span>
                </button>
            </form>
        </div>

        <div class="mt-3">
            <form action="<?= base_url('userController/import') ?>" method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <input type="file" name="file" class="form-control" accept=".xlsx, .xls" required>
                    <button type="submit" class="btn btn-primary">
                    <i class='bx bxs-folder-open'></i>
                    <span class="fw-normal fs-7">Import from Excel</span>
                    </button>
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
            <tbody id="tableBody">

            </tbody>
        </table>


</body>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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

        
        $('#logoutButton').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Apakah anda yakin untuk logout?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#73EC8B",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Logout"
                }).then((result) => {
                    if(result.isConfirmed){
                        $('#logoutForm').submit();
                    }
             });
        });

        $('exportButton').on('click', function(e){
            e.preventDefault();
            Swal.fire({
                tittle: "Export ke excel?",
                html: '<i class="bx bx-file"></i>',
                iconHtml: '<i class="bx bx-file"></i>',
                showCancelButton: true,
                confirmButtonColor: "#73EC8B",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Export",
                cancelButtonText: "Batal"
            }).then((result)=> {
                if(result.isConfirmed){
                    $('#exportForm').submit();
                }
            });
        });
    


        // Add event listener to search input
        $('input[name="keyword"]').on('input', function() {
            loadTable($(this).val());
        });

        // Add event listener for delete buttons
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            Swal.fire({
                tittle: "Are you sure?",
                text: "Data yang dihapus tidak dapat dipulihkan",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus"
            }).then((result) => {
                 if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('userController/delete') ?>/' + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Data anda sukses dihapus",
                                icon: "success"
                            });
                            loadTable(); // Reload the table data
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title:'Error',
                            text: 'Terjadi error : ' + error
                        });
                    }
                });
            }
        });
        });
    });

    function loadTable(keyword = '') {
        $.ajax({
            url: '<?= base_url('userController/getData') ?>',
            type: 'GET',
            data: {
                keyword: keyword
            },
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
                                <button class="btn btn-warning edit-btn" data-id="${subscription.id}"><i class='bx bx-edit' ></i> 
                                Edit
                                </button>
                                <button class="btn btn-danger delete-btn" data-id="${subscription.id}"><i class='bx bx-trash' ></i> Delete</button>
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