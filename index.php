<?php
require 'functions/functions.php'; 

checkLoggedIn();

$koneksi = connectDB();

$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$result = fetchBooksFromDatabase($search, $koneksi);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>☆Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(to right, #1c3a63, #274a7d);
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .navbar {
            background-color: #0f1b34;
            color: white;
        }

        .navbar-brand {
            font-weight: bold;
            color: white !important;
        }

        .form-control {
            border-color: #1c3a63;
            color: white;
        }

        .btn-outline-success {
            color: white;
            border-color: white;
        }

        .btn-outline-success:hover {
            background-color: white;
            color: #1c3a63;
        }

        .btn-danger {
            background-color: #ff4b5c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #ff1e36;
        }

        .card {
            background-color: #f8f9fa;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-title {
            color: #1c3a63;
            font-weight: bold;
        }

        .card-text {
            color: #274a7d;
        }

        .text-muted {
            color: #6c757d !important;
        }

        h1 {
            color: #ffffff;
        }

        .alert-top {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 300px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand">☆Library</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <form id="search-form" class="d-flex mx-auto" role="search" method="GET" action="">
                    <input id="search-input" class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger text-white" href="authentication/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php
    if (isset($_SESSION['alert'])) {
        echo "<div class='alert alert-danger alert-dismissible fade show alert-top' role='alert'>
                <strong>Alert!</strong> {$_SESSION['alert']}
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        unset($_SESSION['alert']); 
    }
    ?>

    <div class="text-center mb-4">
        <h1>Books List</h1>
    </div>
    <div class="container">
        <div class="row" id="result">
            <?php
            // Display search results
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
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
            $koneksi->close();
            ?>
        </div>
    </div>

    <script>
        document.getElementById("search-input").addEventListener("input", function() {
            var keyword = this.value.trim();
            sendAjaxRequest(keyword);
        });

        document.getElementById("search-form").addEventListener("submit", function(event) {
            event.preventDefault();
            var keyword = document.getElementById("search-input").value.trim();
            sendAjaxRequest(keyword);
        });

        function sendAjaxRequest(keyword) {
            var xhr = new XMLHttpRequest();
            var url = "ajax/ajax.php?keyword=" + encodeURIComponent(keyword);
            xhr.open("GET", url, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("result").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>

    <script>
        const alertCloseButtons = document.querySelectorAll('.alert .btn-close');
        alertCloseButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const alert = button.closest('.alert');
                alert.classList.remove('show');
                setTimeout(() => {
                    alert.remove();
                }, 200); // Remove the alert after 200ms to match the CSS transition duration
            });
        });
    </script>
</body>

</html>