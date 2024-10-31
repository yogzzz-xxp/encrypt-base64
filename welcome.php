<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

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

// Fungsi untuk mendekripsi password
function decryptPassword($encrypted_password) {
    return base64_decode($encrypted_password);
}

// Mengambil data dari database
$sql = "SELECT id, nama, email, password FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }
        h2 {
            color: #333;
        }
        a {
            color: #007BFF;
            text-decoration: none;
            margin-bottom: 2em;
        }
        a:hover {
            text-decoration: underline;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 1em;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Selamat Datang, <?php echo $_SESSION["user"]; ?></h2>
    <a href="logout.php">Logout</a>

    <h2>Data Pengguna</h2>
    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email (Encrypted)</th>
                    <th>Email (Decrypted)</th>
                    <th>Password (Encrypted)</th>
                    <th>Password (Decrypted)</th>
                </tr>";
        // Menampilkan data dalam bentuk tabel
        while($row = mysqli_fetch_assoc($result)) {
            $decrypted_email = decryptEmail($row["email"]);
            $decrypted_password = decryptPassword($row["password"]);

            // Menampilkan data dalam tabel
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["nama"] . "</td>
                    <td>" . $row["email"] . "</td>
                    <td>" . $decrypted_email . "</td>
                    <td>" . $row["password"] . "</td>
                    <td>" . $decrypted_password . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    mysqli_close($conn);
    ?>
    <a href="encrypt.php">Go to Base64 Encode/Decode</a>
</body>
</html>
