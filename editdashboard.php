<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Book | ☆Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php
    // Sertakan file koneksi
    require 'koneksi.php';
    

    // Ambil data buku berdasarkan ID
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM buku WHERE id = $id";
        $result = $koneksi->query($sql);
        $row = $result->fetch_assoc();
    }

    // Tangani form submission untuk mengupdate buku
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];
        $penerbit = $_POST['penerbit'];
        $kategori = $_POST['kategori'];
        $gambar = $_FILES['gambar']['name'];

        if ($gambar) {
            move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $gambar);
            $sql = "UPDATE buku SET judul='$judul', deskripsi='$deskripsi', penerbit='$penerbit', kategori='$kategori', gambar='$gambar' WHERE id=$id";
        } else {
            $sql = "UPDATE buku SET judul='$judul', deskripsi='$deskripsi', penerbit='$penerbit', kategori='$kategori' WHERE id=$id";
        }

        $koneksi->query($sql);

        header('Location: dashboard.php');
        exit();
    }
    ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">☆Library</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        <h2 class="text-center">Edit Book</h2>
        <form action="editdashboard.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="mb-3">
                <label for="judul" class="form-label">Title</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $row['judul']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Image</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                <img src="uploads/<?php echo $row['gambar']; ?>" style="max-width: 100px; margin-top: 10px;">
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Description</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo $row['deskripsi']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="penerbit" class="form-label">Publisher</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo $row['penerbit']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Category</label>
                <select class="form-select" id="kategori" name="kategori" required>
                    <option value="Fiksi" <?php if ($row['kategori'] == 'Fiksi') echo 'selected'; ?>>Fiksi</option>
                    <option value="Non-Fiksi" <?php if ($row['kategori'] == 'Non-Fiksi') echo 'selected'; ?>>Non-Fiksi</option>
                    <option value="Agama" <?php if ($row['kategori'] == 'Agama') echo 'selected'; ?>>Agama</option>
                    <option value="Novel" <?php if ($row['kategori'] == 'Novel') echo 'selected'; ?>>Novel</option>
                    <option value="Komik" <?php if ($row['kategori'] == 'Komik') echo 'selected'; ?>>Komik</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>