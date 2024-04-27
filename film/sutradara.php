<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Sutradara.php');
include('classes/Template.php');

$sutradara = new Sutradara($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$sutradara->open();
$sutradara->getSutradara();


if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($sutradara->addSutradara($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'sutradara.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'sutradara.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Sutradara';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Sutradara</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'sutradara';

while ($sut = $sutradara->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $sut['nama_sutradara'] . '</td>
    <td style="font-size: 22px;">
        <a href="sutradara.php?id=' . $sut['id_sutradara'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="sutradara.php?hapus=' . $sut['id_sutradara'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($sutradara->updateSutradara($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'sutradara.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'sutradara.php';
            </script>";
            }
        }

        $sutradara->getSutradaraById($id);
        $row = $sutradara->getResult();

        $dataUpdate = $row['nama_sutradara'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($sutradara->deleteSutradara($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'sutradara.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'sutradara.php';
            </script>";
        }
    }
}


$sutradara->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();
