<?php
require 'koneksi.php'; // Include your database connection file

session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic input validation
    if (empty($email) || empty($password)) {
        echo "Please fill all fields.";
    } else {
        // Prepare and execute the SQL statement
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch user data
            $user = $result->fetch_assoc();
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // If user exists and password is correct, set session and redirect
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role']; // Assuming 'role' column exists

                if ($user['role'] == 'admin') {
                    // Redirect admin users to dashboard.php
                    header("Location: dashboard.php");
                    exit();
                } else {
                    // Redirect non-admin users to index.php
                    header("Location: index.php");
                    exit();
                }
            } else {
                echo "Invalid email or password.";
            }
        } else {
            echo "Invalid email or password.";
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
    <title>Login | ☆Library</title>
    <style>
        .login-container {
            max-width: 400px;
            margin: auto;
            padding-top: 100px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center">Login | ☆Library</h3>
                <form action="login.php" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <a href="register.php">Don't Have An Account? Register Now!</a>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
