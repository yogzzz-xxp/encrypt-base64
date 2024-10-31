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

// Fungsi untuk mengenkripsi email
function encryptEmail($email) {
    return base64_encode($email);
}

// Fungsi untuk mendekripsi email
function decryptEmail($encrypted_email) {
    return base64_decode($encrypted_email);
}

// Fungsi untuk mengenkripsi password
function encryptPassword($password) {
    return base64_encode($password);
}

// Fungsi untuk mendekripsi password
function decryptPassword($encrypted_password) {
    return base64_decode($encrypted_password);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Enkripsi email
    $encrypted_email = encryptEmail($email);

    // Enkripsi password
    $encrypted_password = encryptPassword($password);

    // Simpan ke database
    $sql = "INSERT INTO users (nama, email, password) VALUES ('$name', '$encrypted_email', '$encrypted_password')";

    if (mysqli_query($conn, $sql)) {
        echo "Registrasi berhasil!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Mengambil data dari database
$sql = "SELECT id, nama, email, password FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Registrasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('rodrigo_souza.jpg') no-repeat center center fixed;
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
        input[type="text"], input[type="email"], input[type="password"] {
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
        <h2>Form Registrasi</h2>
        <form method="POST" action="">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" name="register" value="Register">
        </form>
        <a href="login.php">Login</a>
    </div>
</body>
</html>
