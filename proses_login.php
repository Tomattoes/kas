<?php
session_start();

include 'koneksi.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$data = mysqli_query($conn,
"SELECT * FROM admin
WHERE username='$username'
AND password='$password'");

$cek = mysqli_num_rows($data);

if($cek > 0){

    $_SESSION['login'] = true;
    $_SESSION['username'] = $username;

    header("Location:index.php");

} else {

    echo "
    <script>

        alert('Username atau Password salah');

        window.location='login.php';

    </script>
    ";
}
?>