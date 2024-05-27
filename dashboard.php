<?php
// Sertakan file koneksi
require 'koneksi.php';

// // Check if the user is logged in
// if (!isset($_SESSION['email'])) {
//     // If not logged in, redirect to the login page
//     header("Location: login.php");
//     exit();
// }

// // Check if the logged-in user is an admin
// if ($_SESSION['role'] !== 'admin') {
//     // If the user is not an admin, deny access and redirect to the index page
//     echo "Access denied. Admins only.";
//     header("Location: index.php");
//     exit();
// }

// Tangani form submission untuk menambah buku baru
if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $penerbit = $_POST['penerbit'];
    $kategori = $_POST['kategori'];
    $gambar = $_FILES['gambar']['name'];
    move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $gambar);

    $sql = "INSERT INTO buku (judul, deskripsi, penerbit, kategori, gambar) VALUES ('$judul', '$deskripsi', '$penerbit', '$kategori', '$gambar')";
    $koneksi->query($sql);

    header('Location: dashboard.php');
    exit();
}

// Tangani permintaan untuk menghapus buku
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM buku WHERE id = $id";
    $koneksi->query($sql);

    header('Location: dashboard.php');
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | ☆Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">☆Library</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger" href="logo">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        <h2 class="text-center">Welcome to Dashboard</h2>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add +
        </button>

        <!-- Modal Tambah Buku -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add A New Book</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="dashboard.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Title</label>
                                <input type="text" class="form-control" id="judul" name="judul" required>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Image</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Description</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="penerbit" class="form-label">Publisher</label>
                                <input type="text" class="form-control" id="penerbit" name="penerbit" required>
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Category</label>
                                <select class="form-select" id="kategori" name="kategori" required>
                                    <option selected disabled>Select Kategori</option>
                                    <option value="Fiksi">Fiction</option>
                                    <option value="Non-Fiksi">Non-Fiction</option>
                                    <option value="Agama">Religion</option>
                                    <option value="Novel">Novel</option>
                                    <option value="Komik">Comic</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Buku -->
        <table class="table mt-5">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Image</th>
                    <th scope="col">Description</th>
                    <th scope="col">Publisher</th>
                    <th scope="col">Category</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query untuk mengambil data buku
                $query = "SELECT * FROM buku";
                $result = $koneksi->query($query);

                // Tampilkan data dalam tabel
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['judul'] . "</td>";
                        echo "<td><img src='uploads/" . $row['gambar'] . "' style='max-width: 100px;' /></td>";
                        echo "<td>" . $row['deskripsi'] . "</td>";
                        echo "<td>" . $row['penerbit'] . "</td>";
                        echo "<td>" . $row['kategori'] . "</td>";
                        echo "<td>";
                        echo "<a href='editdashboard.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a>";
                        echo "<a href='dashboard.php?delete_id=" . $row['id'] . "' class='btn btn-danger btn-sm ms-2'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>There's no book data.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>