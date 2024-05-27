<?php
require 'koneksi.php'; // Include your database connection file

if (isset($_POST['submit'])) {
    // Retrieve data from the form
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Basic input validation
    if (empty($nama) || empty($email) || empty($password)) {
        echo "Please fill all fields.";
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Set a default role for new users
        $default_role = "user";
        
        // Prepare and execute the SQL statement to insert user data
        $sql = "INSERT INTO user (nama, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("ssss", $nama, $email, $hashed_password, $default_role);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success' role='alert'>Registration Successful.</div>";
        } else {
            echo "Error: " . $koneksi->error;
        }
        
        // Close the statement
        $stmt->close();
    }
}

// Close the connection
$koneksi->close();
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Registration | ☆Library</title>
    <style>
        .register-container {
            max-width: 400px;
            margin: auto;
            padding-top: 100px;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center">Registration | ☆Library</h3>
                <!-- Menambahkan action dan method pada elemen form -->
                <form action="register.php" method="post">
                    <div class="mb-3">
                        <label for="exampleInputName1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" name="nama" autocomplete="off">
                        <!-- Menggunakan name="nama" untuk cocok dengan pengambilan data di PHP -->
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <a href="login.php">Already Have An Account? Login!</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="submit">Register</button>
                </form>
            </div>
        </div>
    </div>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>