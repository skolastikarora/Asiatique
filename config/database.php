<?php
$conn = mysqli_connect("localhost", "root", "", "asiatique");

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
