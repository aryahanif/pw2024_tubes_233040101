<?php
require '../functions/functions.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

redirectIfNotLoggedIn();

$koneksi = connectDB();

$alert_message = handleBookEditing($koneksi); 

$row = [];
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $sql = "SELECT * FROM buku WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    $stmt->close();
}

$koneksi->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Book | ☆Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
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
                        <a class="nav-link btn btn-danger" href="../authentication/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Display Alert -->
    <?php if (!empty($alert_message)) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Alert!</strong> <?php echo $alert_message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="container mt-3">
        <h2 class="text-center">Edit Book</h2>
        <form action="editdashboard.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id'] ?? ''); ?>">
            <div class="mb-3">
                <label for="judul" class="form-label">Title</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($row['judul'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Image</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)">
                <span id="selectedImageFeedback" style="color: #6c757d;"></span>
                <?php if (!empty($row['gambar'])) : ?>
                    <img id="imagePreview" src="../uploads/<?php echo htmlspecialchars($row['gambar']); ?>" style="max-width: 100px; margin-top: 10px;">
                <?php else : ?>
                    <img id="imagePreview" src="" style="max-width: 100px; margin-top: 10px; display: none;">
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Description</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo htmlspecialchars($row['deskripsi'] ?? ''); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="penerbit" class="form-label">Publisher</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo htmlspecialchars($row['penerbit'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Category</label>
                <select class="form-select" id="kategori" name="kategori" required>
                    <option value="Fiction" <?php if (($row['kategori'] ?? '') == 'Fiction') echo 'selected'; ?>>Fiction</option>
                    <option value="Non-Fiction" <?php if (($row['kategori'] ?? '') == 'Non-Fiction') echo 'selected'; ?>>Non-Fiction</option>
                    <option value="Religion" <?php if (($row['kategori'] ?? '') == 'Religion') echo 'selected'; ?>>Religion</option>
                    <option value="Novel" <?php if (($row['kategori'] ?? '') == 'Novel') echo 'selected'; ?>>Novel</option>
                    <option value="Comic" <?php if (($row['kategori'] ?? '') == 'Comic') echo 'selected'; ?>>Comic</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Update</button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block';
                document.getElementById('selectedImageFeedback').innerText = event.target.files[0].name;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
