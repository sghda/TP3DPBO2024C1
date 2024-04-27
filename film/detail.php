<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Film.php');
include('classes/Sutradara.php');
include('classes/Genre.php');
include('classes/Template.php');

$film = new Film($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$film->open();

$data = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $film->getFilmById($id);
        $row = $film->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['judul_film'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['foto'] . '" class="img-thumbnail" alt="' . $row['foto'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Judul</td>
                                    <td>:</td>
                                    <td>' . $row['judul_film'] . '</td>
                                </tr>
                                <tr>
                                    <td>Tahun</td>
                                    <td>:</td>
                                    <td>' . $row['tahun'] . '</td>
                                </tr>
                                <tr>
                                    <td>Sutradara</td>
                                    <td>:</td>
                                    <td>' . $row['nama_sutradara'] . '</td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td>' . $row['nama_genre'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="update_film.php?id=' . $row['id'] . '"><button type="button" class="btn btn-success text-white">Ubah Data</button></a>
                <a href="hapus_film.php?id=' . $row['id'] . '"><button type="button" class="btn btn-danger">Hapus Data</button></a>
            </div>';
    }
}

$film->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_PENGURUS', $data);
$detail->write();
?>
