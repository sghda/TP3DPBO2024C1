<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Film.php');
include('classes/Sutradara.php');
include('classes/Genre.php');
include('classes/Template.php');

$film = new Film($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$film->open();

$data = '';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Ambil data yang diinputkan dari formulir
            $film_id = $_POST['id'];
            $judul = $_POST['judul_film'];
            $tahun = $_POST['tahun'];
            $sut_id = $_POST['id_sutradara'];
            $gen_id = $_POST['id_genre'];
            
            // Panggil metode updateData() untuk memperbarui data pengurus
            $result = $film->updateData($film_id, [
                'judul_film' => $judul,
                'tahun' => $tahun,
                'id_sutradara' => $sut_id,
                'id_genre' => $gen_id
            ], null);

            // Periksa apakah pembaruan berhasil
            if ($result) {
                echo "Data pengurus berhasil diperbarui.";
            } else {
                echo "Gagal memperbarui data pengurus.";
            }
        } else {
            // Jika bukan metode POST, tampilkan formulir edit
            $film->getFilmById($id);
            $row = $film->getResult();

            // Ambil data divisi dan jabatan dari database
            $sutradara_list = $film->getSutradara();
            $genre_list = $film->getGenre();

            // Buat dropdown list untuk sutradara
            $sutradaraDropdown = '<select class="form-control" name="sutradara_film">';
            foreach ($sutradara_list as $sutradara) {
                $selected = ($sutradara['id_sutradara'] == $row['id_sutradara']) ? 'selected' : '';
                $sutradaraDropdown .= '<option value="' . $sutradara['id_sutradara'] . '" ' . $selected . '>' . $sutradara['nama_sutradara'] . '</option>';
            }
            $sutradaraDropdown .= '</select>';

            // Buat dropdown list untuk genre
            $genreDropdown = '<select class="form-control" name="genre_film">';
            foreach ($genre_list as $genre) {
                $selected = ($genre['id_genre'] == $row['id_genre']) ? 'selected' : '';
                $genreDropdown .= '<option value="' . $genre['id_genre'] . '" ' . $selected . '>' . $genre['nama_genre'] . '</option>';
            }
            $genreDropdown .= '</select>';

            echo $sutradaraDropdown;
            echo $genreDropdown;



            // Tampilkan formulir edit dengan dropdown list divisi dan jabatan
            $data .= '<form action="" method="post">
                        <input type="hidden" name="id" value="' . $row['id'] . '">
                        <div class="card-header text-center">
                            <h3 class="my-0">Edit ' . $row['judul_film'] . '</h3>
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
                                                <td><input type="text" class="form-control" name="judul_film" value="' . $row['judul_film'] . '"></td>
                                            </tr>
                                            <tr>
                                                <td>Tahun</td>
                                                <td>:</td>
                                                <td><input type="text" class="form-control" name="tahun" value="' . $row['tahun'] . '"></td>
                                            </tr>
                                            <tr>
                                                <td>Sutradara</td>
                                                <td>:</td>
                                                <td>' . $sutradaraDropdown . '</td> 
                                            </tr>
                                            <tr>
                                                <td>Genre</td>
                                                <td>:</td>
                                                <td>' . $genreDropdown . '</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success text-white">Simpan Perubahan</button>
                            <a href="#"><button type="button" class="btn btn-danger">Hapus Data</button></a>
                        </div>
                    </form>';
        }
    }
}

$film->close();

$view = new Template('templates/skin.html');
$view->replace('DATA_FILM', $data);
$view->write();
