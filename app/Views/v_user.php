<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Form Pendaftaran MyInternet</title>
    <script>
        function showPaketOptions() {
            let paket = document.getElementById("paket_select").value;

            // Sembunyikan semua opsi paket
            document.getElementById("standart_options").style.display = "none";
            document.getElementById("reguler_options").style.display = "none";
            document.getElementById("premium_options").style.display = "none";

            if (paket === "Standart") {
                document.getElementById("standart_options").style.display = "block";
            } else if (paket === "Reguler") {
                document.getElementById("reguler_options").style.display = "block";
            } else if (paket === "Premium") {
                document.getElementById("premium_options").style.display = "block";
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Pendaftaran MyInternet</h1>
        <form method="POST" action="<?= base_url('userController/tambah'); ?>"required>
        <input type="hidden" name="id" value="<?= esc($id ?? '') ?>">
        <!-- Username -->
        <div class="form-floating mb-3">
        <input type="text" class="form-control" name="username" placeholder="Username" value="<?= esc($username ?? '') ?>"required>
        <label>Username</label>
        </div>

    <!-- Password -->
    <div class="form-floating mb-3">
        <input type="password" class="form-control" name="password" placeholder="Password" value="<?= esc($password ?? '') ?>" required>
        <label>Password</label>
    </div>

    <!-- Nama Lengkap -->
    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap" value="<?= esc($nama_lengkap ?? '') ?>" required>
        <label>Nama Lengkap</label>
    </div>

    <label for="status">Status Saat ini</label>
    <div class="form-check">
    <input class="form-check-input" type="radio" name="status" id="aktif" value="Aktif">
    <label class="form-check-label" for="aktif">
        Aktif
    </label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="status" id="non_aktif" value="Non-Aktif" checked>
    <label class="form-check-label" for="non_aktif">
        Non-Aktif
    </label>
</div>


   <!-- Paket Dropdown -->
<!-- Paket Dropdown -->
<div class="mb-4">
    <label for="paket_select">Pilih Paket</label>
    <select class="form-select" name="paket_select" id="paket_select" onchange="showPaketOptions()">
        <!-- Opsi Default (Pilih Paket) -->
        <option value="" disabled <?= !isset($paket_select) ? 'selected' : '' ?>>Pilih paket yang ingin digunakan</option>
        
        <!-- Opsi Paket -->
        <option value="Standart" <?= isset($paket_select) && $paket_select === 'Standart' ? 'selected' : '' ?>>Standart</option>
        <option value="Reguler" <?= isset($paket_select) && $paket_select === 'Reguler' ? 'selected' : '' ?>>Reguler</option>
        <option value="Premium" <?= isset($paket_select) && $paket_select === 'Premium' ? 'selected' : '' ?>>Premium</option>
    </select>
</div>

<!-- Paket Options -->
<div id="standart_options" style="display:none;">
    <h4>Opsi Standart</h4>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="paket_detail[]" value="Standart 20Mbps 30Hari" <?= isset($paket_detail) && in_array('Standart 20Mbps 30Hari', $paket_detail) ? 'checked' : '' ?>>
        <label>Standart 20Mbps 30Hari</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="paket_detail[]" value="Standart 20Mbps 60Hari" <?= isset($paket_detail) && in_array('Standart 20Mbps 60Hari', $paket_detail) ? 'checked' : '' ?>>
        <label>Standart 20Mbps 60Hari</label>
    </div>
</div>

<div id="reguler_options" style="display:none;">
    <h4>Opsi Reguler</h4>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="paket_detail[]" value="Reguler 30Mbps 30Hari" <?= isset($paket_detail) && in_array('Reguler 30Mbps 30Hari', $paket_detail) ? 'checked' : '' ?>>
        <label>Reguler 30Mbps 30Hari</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="paket_detail[]" value="Reguler 30Mbps 60Hari" <?= isset($paket_detail) && in_array('Reguler 30Mbps 60Hari', $paket_detail) ? 'checked' : '' ?>>
        <label>Reguler 30Mbps 60Hari</label>
    </div>
</div>

<div id="premium_options" style="display:none;">
    <h4>Opsi Premium</h4>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="paket_detail[]" value="Premium 50Mbps 30Hari" <?= isset($paket_detail) && in_array('Premium 50Mbps 30Hari', $paket_detail) ? 'checked' : '' ?>>
        <label>Premium 50Mbps 30Hari</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="paket_detail[]" value="Premium 50Mbps 60Hari" <?= isset($paket_detail) && in_array('Premium 50Mbps 60Hari', $paket_detail) ? 'checked' : '' ?>>
        <label>Premium 50Mbps 60Hari</label>
    </div>
</div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary mt-4">Submit</button>
        </form>

       <!-- Menampilkan Data Langganan -->
<div class="card-header mt-4">
    <form action="" method="get" autocomplete="off">
        <div class="input-group">
            <input 
                type="text" 
                name="keyword" 
                class="form-control" 
                style="width:155pt;" 
                placeholder="Search Here" 
                value="<?= esc($keyword ?? '') ?>">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>
</div>


<h3>Daftar Pelanggan</h3>
<div class="mt-3">
            <a href="<?= base_url('userController/export') ?>" class="btn btn-success">Export to Excel</a>
        </div>

        <!-- Import Excel Button -->
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
            <th>Status</th> <!-- Kolom baru untuk status -->
            <th>Detail Paket</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($subscriptions)): ?>
        <?php foreach ($subscriptions as $subscription): ?>
            <tr>
                <td><?= esc($subscription['id']) ?></td>
                <td><?= esc($subscription['username']) ?></td>
                <td><?= esc($subscription['nama_lengkap']) ?></td>
                <td><?= esc($subscription['status']) ?></td> <!-- Menampilkan status -->
                <td><?= esc($subscription['paket_detail']) ?></td>

                <td>
                    <a href="<?= base_url('/userController/edit/') ?><?= esc($subscription['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= base_url('/userController/delete/') ?><?= esc($subscription['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="6">No subscriptions found.</td></tr> <!-- Sesuaikan colspan -->
    <?php endif; ?>
    </tbody>
</table>

</body>
<script>
    function showPaketOptions() {
        let paket = document.getElementById("paket_select").value;

        // Reset semua checkbox saat paket diubah
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });

        // Sembunyikan semua opsi paket
        document.getElementById("standart_options").style.display = "none";
        document.getElementById("reguler_options").style.display = "none";
        document.getElementById("premium_options").style.display = "none";

        // Tampilkan opsi paket yang dipilih
        if (paket === "Standart") {
            document.getElementById("standart_options").style.display = "block";
        } else if (paket === "Reguler") {
            document.getElementById("reguler_options").style.display = "block";
        } else if (paket === "Premium") {
            document.getElementById("premium_options").style.display = "block";
        }
    }

    // Panggil fungsi saat halaman dimuat untuk memastikan status paket tetap benar
    document.addEventListener("DOMContentLoaded", function() {
        showPaketOptions();
    });
</script>

</script>

</html>
