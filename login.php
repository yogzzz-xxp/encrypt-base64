<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "encrypt";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fungsi untuk mendekripsi email
function decryptEmail($encrypted_email) {
    return base64_decode($encrypted_email);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Cari pengguna berdasarkan email terenkripsi
    $encrypted_email = base64_encode($email);
    $sql = "SELECT * FROM users WHERE email = '$encrypted_email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Verifikasi password menggunakan base64_decode
        $stored_password = base64_decode($row["password"]);
        if ($password === $stored_password) {
            $_SESSION["user"] = $row["nama"];
            header("Location: welcome.php");
            exit();
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Email tidak ditemukan!";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('rodrigo-souza.jpg') no-repeat center center fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 2em;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }
        h2 {
            margin-bottom: 1em;
            color: #333;
        }
        label {
            display: block;
            margin: 0.5em 0 0.2em;
            color: #555;
        }
        input[type="email"], input[type="password"], input[type="text"] {
            width: 100%;
            padding: 0.5em;
            margin-bottom: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background: #007BFF;
            color: white;
            border: none;
            padding: 0.7em 2em;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
        .error-message {
            color: red;
            margin-bottom: 1em;
        }
        a {
            display: block;
            margin-top: 1em;
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" name="login" value="Login">
        </form>
        <a href="index.php">Registrasi</a>
    </div>
</body>
</html>
