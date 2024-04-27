<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Film.php');
include('classes/Sutradara.php');
include('classes/GEnre.php');
include('classes/Template.php'); 

$film = new Film($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$film->open();

// buat instance pengurus
$sutradara = new Sutradara($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$sutradara->open();
$sutradara->getSutradara();

$genre = new Genre($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$genre->open();
$genre->getGenre();

$data = null;

if (isset($_POST['btn-simpan'])){
    $data = [
        'judul_film' => $_POST['judul_film'],
        'tahun' => $_POST['tahun'],
        'sutradara_id' => $_POST['sutradara_id'],
        'genre_id' => $_POST['genre_id'],
        'foto' => $_FILES['foto']['name']

        
    ];
    
    $file = $_FILES['foto'];

    $result = $film->addData($data, $file);

    if ($result > 0) {
        echo "<script>
            alert('Data berhasil ditambah!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambah!');
            document.location.href = 'index.php';
        </script>";
    }
}

$dataSutradara = null;
$dataGenre = null;

while ($div = $sutradara->getResult()) {
    $dataSutradara .= '<option value="' . $div['id_sutradara'] . '">' . $div['nama_sutradara'] . '</option>';
}

while ($jbt = $genre->getResult()) {
    $dataGenre .= '<option value="' . $jbt['id_genre'] . '">' . $jbt['nama_genre'] . '</option>';
}

// buat instance template
$view = new Template('templates/skinform.html');

$view->replace('DATA_DIVISI', $dataSutradara);
$view->replace('DATA_JABATAN', $dataGenre);
$view->replace('DATA_BTN', 'Tambah');

$view->write();

// tutup koneksi
$sutradara->close();
$genre->close();
