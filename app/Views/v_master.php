<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Master Form</title>
</head>

<style>
    #dataTittle {
        font-weight: bold;
        font-size: 2rem;
        text-transform: uppercase;
    }
</style>

<body>

    <?= $this->include('template/navbar') ?>

    <div class="card-header" style="width: 40rem; height:auto;">
        <form id="searchForm" autocomplete="off">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" style="width:155pt;" placeholder="Search Here" value="">
            </div>
        </form>
    </div>
    </nav>

    <div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="formModalUser" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalUser">Form User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="registerUser" method="POST">
                        <input type="hidden" name="id" id="form-id" value=" ">

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="form-username" name="username" placeholder="Username" required>
                            <label>Username</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" id="form-password" placeholder="Password">
                            <label>Password</label>

                            <button type="submit" class="btn btn-primary mt-4" id="submitButton">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="data-tittle">
            <h1 class="text-center mt-4" id="dataTittle">Data Pengguna Crudtest</h1>
        </div>

        <div class="container mt-5">
            <div class="justify-content-between mb-3">
                <div>
                    <button class="btn btn-primary" id="openModalButton"><i class="bx bx-plus-circle margin-r-2"></i>
                        <span class="fw-normal fs-7">Daftar</span>
                    </button>

                    <a href="<?= base_url('userController/export') ?>" class="btn btn-success">
                        <i class='bx bx-download'></i>
                        <span class="fw-normal fs-7">Export to Excel</span>
                    </a>

                    <form id="logoutForm" action="<?= base_url('logout') ?>" method="POST" style="display:inline;">
                        <button type="button" class="btn btn-danger" id="logoutButton">
                            <i class='bx bx-exit'></i>
                            <span class="fw-normal fs-7">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <form action="<?= base_url('userController/import') ?>" method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <input type="file" name="file" class="form-control" accept=".xlsx, .xls" required>
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bxs-folder-open'></i>
                        <span class="fw-normal fs-7">Import from Excel</button>
                </div>
            </form>
        </div>

        <table class="table table-bordered" id="tableUser">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Created Date</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- Table data will be loaded here -->
            </tbody>
        </table>
    </div>

</body>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- modal opener -->
<script>
    const openModalButton = document.getElementById('openModalButton');
    const modalUser = new bootstrap.Modal(document.getElementById('modalUser'));

    openModalButton.addEventListener('click', () => {
        $('#form-id').val(''); // Clear the form ID
        $('#form-username').val(''); // Clear the username field
        $('#form-password').val(''); // Clear the password field
        $('#formModalUser').text('Add User'); // Set modal title to Add User
        $('#registerUser').attr('data-mode', 'add'); // Set form mode to add
        modalUser.show();
    });
</script>

<!-- function -->
<script>
    $(document).ready(function() {
        loadTable();

        function loadTable(keyword = '', orderBy = 'userid', orderDir = 'ASC') {
            $.ajax({
                url: '<?= base_url('masterController/getData') ?>',
                type: 'GET',
                data: { keyword: keyword, orderBy: orderBy, orderDir: orderDir },
                dataType: 'json',
                success: function(response) {
                    var tableBody = $('#tableBody');
                    tableBody.empty(); // Clear the table body

                    response.forEach(function(subscription, index) {
                        var newRow = `
                            <tr id="row-${subscription.userid}">
                                <td>${subscription.userid}</td>
                                <td>${subscription.usernm}</td>
                                <td>${subscription.createddate}</td>
                                <td>
                                    <button class="btn btn-warning edit-btn" data-id="${subscription.userid}">
                                        <i class="bx bx-edit"></i>
                                    </button>
                                    <button class="btn btn-danger delete-btn" data-id="${subscription.userid}">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        tableBody.append(newRow);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                }
            });
        }

        $('#registerUser').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            const mode = $(this).attr('data-mode');
            const url = mode === 'edit' ? '<?= base_url('masterController/updateUser') ?>' : '<?= base_url('masterController/addUser') ?>';
            
            if (mode === 'edit') {
                Swal.fire({
                    title: "Are you sure to save the data?",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Save",
                    denyButtonText: `Don't save`
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitForm(url, formData);
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            } else {
                submitForm(url, formData);
            }
        });

        function submitForm(url, formData) {
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'User saved successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#modalUser').modal('hide'); // Hide the modal
                        $('#registerUser')[0].reset(); // Reset the form

                        // Reload the table data
                        loadTable();
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
                        title: 'Error',
                        text: 'An error occurred: ' + error
                    });
                }
            });
        }

        // Add event listener for delete buttons
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('masterController/deleteUser') ?>',
                        type: 'POST',
                        data: { id: id },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                });
                                // Remove the deleted user row from the table
                                $(`button[data-id="${id}"]`).closest('tr').remove();
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
                                title: 'Error',
                                text: 'An error occurred: ' + error
                            });
                        }
                    });
                }
            });
        });

        // Add event listener for edit buttons
        $(document).on('click', '.edit-btn', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            $.ajax({
                url: '<?= base_url('masterController/getUser') ?>',
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#form-id').val(response.data.userid);
                        $('#form-username').val(response.data.usernm);
                        $('#form-password').val(''); // Leave password field empty
                        $('#formModalUser').text('Edit User'); // Set modal title to Edit User
                        $('#registerUser').attr('data-mode', 'edit'); // Set form mode to edit
                        $('#modalUser').modal('show'); // Show the modal
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
                        title: 'Error',
                        text: 'An error occurred: ' + error
                    });
                }
            });
        });

        // Add event listener for search input
        $('input[name="keyword"]').on('input', function() {
            loadTable($(this).val());
        });

        // Add event listener for logout button
        $('#logoutButton').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure to logout?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, logout"
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#logoutForm').submit();
                }
            });
        });

    });
</script>

</html>