<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection function
function connectDB()
{
    $host = 'localhost'; 
    $user = 'root';
    $password = '';
    $database = 'pw2024_tubes_233040101';

    $koneksi = new mysqli($host, $user, $password, $database);

    if ($koneksi->connect_error) {
        die("Connection failed: " . $koneksi->connect_error);
    }

    return $koneksi;
}

// Check if the user is logged in
function checkLoggedIn()
{
    if (!isset($_SESSION['email'])) {
        $_SESSION['alert'] = "Please login to access the dashboard.";
        header("Location: ../authentication/login.php");
        exit();
    }
}

// Check if the user is an admin
function checkAdmin()
{
    if ($_SESSION['role'] !== 'admin') {
        $_SESSION['alert'] = "Access denied. Admins only.";
        header("Location: ../index.php");
        exit();
    }
}

// Login function
function loginUser($email, $password, $koneksi) 
{
    $error_message = '';

    if (empty($email) || empty($password)) {
        $error_message = "Please fill in all fields.";
    } else {
        $sql = "SELECT users.*, roles.role 
                FROM users 
                INNER JOIN roles ON users.id_role = roles.id_role 
                WHERE email = ?";
        $stmt = $koneksi->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    if ($user['role'] == 'admin') {
                        header("Location: ../crud/dashboard.php");
                        exit();
                    } else {
                        header("Location: ../index.php");
                        exit();
                    }
                } else {
                    $error_message = "Invalid email or password.";
                }
            } else {
                $error_message = "Invalid email or password.";
            }
            $stmt->close();
        } else {
            $error_message = "Database error: Unable to prepare statement.";
        }
    }

    return $error_message;
}


// Session management functions
function redirectIfNotLoggedIn()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['email'])) {
        header('Location: ../index.php');
        exit();
    }
}

// Function to fetch books from the database with optional search filtering
function fetchBooksFromDatabase($search, $koneksi)
{
    $sql = "SELECT * FROM buku";
    if (!empty($search)) {
        $sql .= " WHERE judul LIKE '%$search%' OR deskripsi LIKE '%$search%' OR penerbit LIKE '%$search%' OR kategori LIKE '%$search%'";
    }
    return $koneksi->query($sql);
}


// Insert book function
function insertBook($judul, $deskripsi, $penerbit, $kategori, $gambar)
{
    $koneksi = connectDB();
    $sql = "INSERT INTO buku (judul, deskripsi, penerbit, kategori, gambar) VALUES (?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("sssss", $judul, $deskripsi, $penerbit, $kategori, $gambar);
    $stmt->execute();
    $stmt->close();
    $koneksi->close();
}

// Delete book function
function deleteBook($id)
{
    $koneksi = connectDB();
    $sql = "DELETE FROM buku WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $koneksi->close();
}

// Function to handle book editing
function handleBookEditing($koneksi)
{
    $alert_message = '';
    $row = [];
    // Check if book ID is provided in the URL
    if (isset($_GET['id'])) {
        $book_id = $_GET['id'];
        // Fetch book details from the database
        $sql = "SELECT * FROM buku WHERE id = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            $alert_message = "Book not found.";
        }
        $stmt->close();
    }

    // Check if the form is submitted for updating the book
    if (isset($_POST['submit'])) {
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];
        $penerbit = $_POST['penerbit'];
        $kategori = $_POST['kategori'];
        $gambar = $_FILES['gambar']['name'];
        // Move uploaded file to uploads directory
        $uploadPath = '../uploads/';
        $fileTmp = $_FILES['gambar']['tmp_name'];
        $uploadedFile = $uploadPath . $gambar;
        move_uploaded_file($fileTmp, $uploadedFile);
        // Update book data in the database
        $sql = "UPDATE buku SET judul=?, deskripsi=?, penerbit=?, kategori=?, gambar=? WHERE id=?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("sssssi", $judul, $deskripsi, $penerbit, $kategori, $gambar, $book_id);
        if ($stmt->execute()) {
            $alert_message = "Book updated successfully.";
        } else {
            $alert_message = "Error updating book: " . $stmt->error;
        }
        $stmt->close();
    }
    if (!empty($alert_message)) {
        echo '<div class="alert alert-success">' . $alert_message . '</div>';
    }
}

// ajax function
function cari($keyword)
{
    $koneksi = connectDB(); 
    $sql = "SELECT * FROM buku
            WHERE judul LIKE '%$keyword%' OR
                  deskripsi LIKE '%$keyword%' OR
                  penerbit LIKE '%$keyword%' OR
                  kategori LIKE '%$keyword%'";
    $result = $koneksi->query($sql);
    if ($result) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $rows = [];
    }
    $koneksi->close();
    return $rows;
}

// Fetch users from the database along with their roles
function fetchUsersFromDatabase($koneksi)
{
    $sql = "SELECT users.*, roles.role
            FROM users
            INNER JOIN roles ON users.id_role = roles.id";
    $result = $koneksi->query($sql);
    return $result;
}
