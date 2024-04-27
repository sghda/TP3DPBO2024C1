<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Divisi.php');
include('classes/Jabatan.php');
include('classes/Pengurus.php');
include('classes/Template.php'); 

$pengurus = new Pengurus($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$pengurus->open();

// buat instance pengurus
$divisi = new Divisi($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$divisi->open();
$divisi->getDivisi();

$jabatan = new Jabatan($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$jabatan->open();
$jabatan->getJabatan();

$data = null;

if (isset($_POST['btn-simpan'])){
    $data = [
        'pengurus_foto' => $_FILES['foto']['name'],
        'pengurus_nama' => $_POST['nama'],
        'pengurus_nim' => $_POST['nim'],
        'pengurus_semester' => $_POST['semester'],
        'divisi_id' => $_POST['division'],
        'jabatan_id' => $_POST['jabatan']
    ];
    
    $file = $_FILES['foto'];

    $result = $pengurus->addData($data, $file);

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

$dataDivisi = null;
$dataJabatan = null;

while ($div = $divisi->getResult()) {
    $dataDivisi .= '<option value="' . $div['divisi_id'] . '">' . $div['divisi_nama'] . '</option>';
}

while ($jbt = $jabatan->getResult()) {
    $dataJabatan .= '<option value="' . $jbt['jabatan_id'] . '">' . $jbt['jabatan_nama'] . '</option>';
}

// buat instance template
$view = new Template('templates/skinform.html');

$view->replace('DATA_DIVISI', $dataDivisi);
$view->replace('DATA_JABATAN', $dataJabatan);
$view->replace('DATA_BTN', 'Tambah');

$view->write();

// tutup koneksi
$divisi->close();
$jabatan->close();
