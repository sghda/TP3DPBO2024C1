<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Film.php');

$film = new Film($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$film->open();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $result = $film->deleteData($id);
        if ($result) {
            // Pesan berhasil dihapus sebagai alert
            echo '<script>alert("Data film berhasil dihapus."); window.location.href = "index.php";</script>';
        } else {
            // Pesan gagal dihapus sebagai alert
            echo '<script>alert("Gagal menghapus data film."); window.location.href = "index.php";</script>';
        }
    } else {
        // ID pengurus tidak valid
        echo '<script>alert("ID film tidak valid."); window.location.href = "index.php";</script>';
    }
} else {
    // ID pengurus tidak ditemukan
    echo '<script>alert("ID film tidak ditemukan."); window.location.href = "index.php";</script>';
}

$film->close();

?>
