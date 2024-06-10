<?php
session_start(); 
require '../functions/functions.php'; 
$message = '';

// Establish database connection
$koneksi = connectDB();

if (isset($_POST['submit'])) {
    // Retrieve data from the form
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Basic input validation
    if (empty($nama) || empty($email) || empty($password)) {
        $message = "<div class='alert alert-danger' role='alert'>Please fill all fields.</div>";
    } else {
        // Check if the email already exists
        $check_sql = "SELECT email FROM users WHERE email = ?";
        $check_stmt = $koneksi->prepare($check_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $message = "<div class='alert alert-danger' role='alert'>Email is already registered. Please use another email.</div>";
        } else {
            // Set a default role ID for new users
            $default_role_id = 2; 
            
            // Hash the password before storing it
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Prepare and execute the SQL statement to insert user data
            $sql = "INSERT INTO users (nama, email, password, id_role) VALUES (?, ?, ?, ?)";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("sssi", $nama, $email, $hashed_password, $default_role_id);
            
            if ($stmt->execute()) {
                $message = "<div class='alert alert-success' role='alert'>Registration successful. Redirecting to login page...</div>";
                echo "<script>window.setTimeout(function(){ window.location.href = 'login.php'; }, 3000);</script>"; // Redirect to login.php after 3 seconds
            } else {
                $message = "<div class='alert alert-danger' role='alert'>Error: " . $stmt->error . "</div>";
            }
            
            // Close the statement
            $stmt->close();
        }
        
        $check_stmt->close();
    }
}

$koneksi->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Registration | ☆Library</title>
    <style>
        body {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .register-container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-in-out;
        }
        .register-container h3 {
            margin-bottom: 20px;
            color: #1e3c72;
            font-weight: bold;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #1e3c72;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2a5298;
        }
        .login-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #1e3c72;
        }
        .login-link:hover {
            color: #2a5298;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center">Registration | ☆Library</h3>
                
                <?php
                if (!empty($message)) {
                    echo $message;
                }
                ?>
                
                <form action="register.php" method="post">
                    <div class="mb-3">
                        <label for="exampleInputName1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" name="nama" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" autocomplete="off" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="submit">Register</button>
                    <a href="login.php" class="login-link">Already Have An Account? Login!</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>