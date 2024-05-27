<?php
require 'koneksi.php';

// Initialize search query variable
$search = "";

// Check if the search form is submitted
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Fetch data from the database with search filtering
$sql = "SELECT * FROM buku";
if (!empty($search)) {
    $sql .= " WHERE judul LIKE '%$search%' OR deskripsi LIKE '%$search%' OR penerbit LIKE '%$search%' OR kategori LIKE '%$search%'";
}

$result = $koneksi->query($sql);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>☆Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar bg-light">
        <div class="container">
            <a class="navbar-brand">☆Library</a>
            <form class="d-flex" role="search" method="GET" action="">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-success" type="submit">Search</button>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger mx-4" style="color: whi;" href="logout.php">Logout</a>
                    </li>
                </ul>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1>Books List</h1>
        </div>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="uploads/' . $row["gambar"] . '" class="card-img-top" alt="Book Image">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row["judul"] . '</h5>';
                    echo '<p class="card-text">' . $row["deskripsi"] . '</p>';
                    echo '<p class="card-text"><small class="text-muted">Penerbit: ' . $row["penerbit"] . '</small></p>';
                    echo '<p class="card-text"><small class="text-muted">Kategori: ' . $row["kategori"] . '</small></p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-center">No books found.</p>';
            }
            $koneksi->close();
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>