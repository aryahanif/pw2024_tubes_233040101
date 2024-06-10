<?php
require '../Functions/functions.php';

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$books = cari($keyword);

if (count($books) > 0) { 
    foreach ($books as $row) {
        ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="uploads/<?php echo htmlspecialchars($row["gambar"]); ?>" class="card-img-top" alt="Book Image">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row["judul"]); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($row["deskripsi"]); ?></p>
                    <p class="card-text"><small class="text-muted">Penerbit: <?php echo htmlspecialchars($row["penerbit"]); ?></small></p>
                    <p class="card-text"><small class="text-muted">Kategori: <?php echo htmlspecialchars($row["kategori"]); ?></small></p>
                </div>
            </div>
        </div>
    <?php
    }
} else {
    ?>
    <div class="col text-center">
        <p>No books found.</p>
    </div>
<?php
}
?>
