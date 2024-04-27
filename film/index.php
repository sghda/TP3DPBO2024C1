<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Film.php');
include('classes/Sutradara.php');
include('classes/Genre.php');
include('classes/Template.php');

// buat instance pengurus
$listFilm = new Film($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$listFilm->open();
$listFilm->getFilmJoin();


// cari pengurus
if (isset($_POST['btn-cari'])) {
    // methode mencari data pengurus
    $listFilm->searchFilm($_POST['cari']);
} else {
    // method menampilkan data Film
    $listFilm->getFilmJoin();
}

$data = null;

// ambil data pengurus
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listFilm->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 film-thumbnail">
        <a href="detail.php?id=' . $row['id'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $row['foto'] . '" class="card-img-top" alt="' . $row['foto'] . '">
            </div>
            <div class="card-body">
                <p class="card-text film-nama my-0">' . $row['judul_film'] . '</p>
                <p class="card-text divisi-nama">' . $row['nama_sutradara'] . '</p>
                <p class="card-text jabatan-nama my-0">' . $row['nama_genre'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}

// tutup koneksi
$listFilm->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_FILM', $data);
$home->write();
