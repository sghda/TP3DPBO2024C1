<?php

class Film extends DB
{
    function getFilmJoin(){
        $query = "SELECT * FROM film JOIN genre ON film.id_genre=genre.id_genre JOIN sutradara ON film.id_sutradara=sutradara.id_sutradara ORDER BY film.id";
        return $this->execute($query);
    }

    function getFilm(){
        $query = "SELECT * FROM film";
        return $this->execute($query);
    }

    function getFilmById($id){
        $query = "SELECT * FROM film JOIN genre ON film.id_genre=genre.id_genre JOIN sutradara ON film.id_sutradara=sutradara.id_sutradara WHERE id=$id";
        return $this->execute($query);
    }

    function searchFilm($keyword){

    }

    function addData($data, $file){
        $film_judul = $data['film_judul'];
        $film_genre = $data['id_genre'];
        $film_sutradara = $data['id_sutradara'];
        $film_tahun = $data['film_tahun'];
        $film_durasi = $data['film_durasi'];
        $film_sinopsis = $data['film_sinopsis'];
        $foto = $file['film_foto']['name'];
        $film_foto = $file['film_foto']['tmp_name'];

        $dir = 'assets/images/'. $foto;
        move_uploaded_file($film_foto, $dir);

        $query = "INSERT INTO film VALUES ('', '$foto', '$film_judul', '$film_genre', '$film_sutradara', '$film_tahun', '$film_durasi', '$film_sinopsis')";

        return $this->executeAffected($query);
    }

    function updateData($id, $data, $file){
        $query = "UPDATE film SET 
                    film_judul='" . $data['film_judul'] . "', 
                    id_genre='" . $data['id_genre'] . "', 
                    id_sutradara='" . $data['id_sutradara'] . "', 
                    film_tahun='" . $data['film_tahun'] . "', 
                    film_durasi='" . $data['film_durasi'] . "', 
                    film_sinopsis='" . $data['film_sinopsis'] . "'";

        // Jika ada file baru diunggah, perbarui juga kolom foto
        if ($file['film_foto']['name'] != "") {
            $foto = $file['film_foto']['name'];
            $film_foto = $file['film_foto']['tmp_name'];

            $dir = 'assets/images/'. $foto;
            move_uploaded_file($film_foto, $dir);

            $query .= ", film_foto='$foto'";
        }

        $query .= " WHERE id=$id";

        return $this->executeAffected($query);
    }

    function deleteData($id){
        $query = "DELETE FROM film WHERE id=$id";
        return $this->executeAffected($query);
    }

    function getGenre(){
        $query = "SELECT * FROM genre";
        return $this->execute($query);
    }

    function getSutradara(){
        $query = "SELECT * FROM sutradara";
        return $this->execute($query);
    }
}