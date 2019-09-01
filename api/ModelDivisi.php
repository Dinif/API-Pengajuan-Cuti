<?php

    class Divisi
    {
        var $con;
        var $result = array();
        var $data;

        function __construct()
        {
            require_once 'Connection.php';

            $lib = new Connection;
            $this->con = $lib->dbConnection();
        }

        function fetchData()
        {
            try {
                $query = "SELECT * FROM tb_divisi ORDER BY id_divisi";
                $select_stmt = $this->con->prepare($query);
                $select_stmt->execute();

                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->result[] = $row;
                }

                if (!$this->result) {
                    $this->data = array(
                        "result" => $this->result,
                        "status" => "ERROR",
                        "pesan" => "Tidak ada data",
                        "url" => "",
                        "time" => date('Y-m-d H:i:s')
                    );
                }
                else {
                    $this->data = array(
                        "result" => $this->result,
                        "status" => "OK",
                        "pesan" => "",
                         "url" => "",
                         "time" => date('Y-m-d H:i:s')
                    );
                }

                return $this->data;
            }
            catch (PDOException $e) {
                $this->data = array(
                    "result" => "",
                    "status" => "ERROR",
                    "pesan" => "",
                    "url" => "",
                    "time" => date('Y-m-d H:i:s')
                );

                return $this->data;
            }
        }

        function insertData($id, $nama, $pj)
        {
            try {
                $query = "INSERT INTO tb_divisi (id_divisi, nama_divisi, penanggung_jawab) VALUES ('$id', '$nama', '$pj')";
                $insert_stmt = $this->con->prepare($query);
                $insert_stmt->execute();

                $this->data = array(
                    "result" => "",
                    "status" => "inserted",
                    "pesan" => "Data berhasil diinput",
                    "url" => "",
                    "time" => date("Y-m-d H:i:s")
                );

                return $this->data;
            } catch (PDOException $e) {
                $this->data = array(
                    "result" => "",
                    "status" => "ERROR",
                    "pesan" => "Data gagal diinput",
                    "url" => "",
                    "time" => date("Y-m-d H:i:s")
                );

                return $this->data;
            }
        }

        function fetchSingle($id)
        {
            try {
                $query = "SELECT * FROM tb_divisi WHERE id_divisi='$id'";
                $select_stmt = $this->con->prepare($query);
                $select_stmt->execute();

                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->result[] = $row;
                }

                if (!$this->result) {
                    $this->data = array(
                        "result" => $this->result,
                        "status" => "ERROR",
                        "pesan" => "Tidak ada data",
                        "url" => "",
                        "time" => date("Y-m-d H:i:s")
                    );
                }
                else {
                    $this->data = array(
                        "result" => $this->result,
                        "status" => "OK",
                        "pesan" => "",
                        "url" => "",
                        "time" => date("Y-m-d H:i:s")
                    );
                }

                return $this->data;
            } catch (PDOException $e) {
                $this->data = array(
                    "result" => "",
                    "status" => "ERROR",
                    "pesan" => "",
                    "url" => "",
                    "time" => date("Y-m-d H:i:s")
                );

                return $this->data;
            }
        }

        function updateData($id, $nama, $pj)
        {
            try {
                $query = "UPDATE tb_divisi SET nama_divisi='$nama', penanggung_jawab='$pj' WHERE id_divisi='$id'";
                $update_stmt = $this->con->prepare($query);
                $update_stmt->execute();

                $this->data = array(
                    "result" => "",
                    "status" => "updated",
                    "pesan" => "Data berhasil diubah",
                    "url" => "",
                    "time" => date("Y-m-d H:i:s")
                );

                return $this->data;
            } catch (PDOException $e) {
                $this->data = array(
                    "result" => "",
                    "status" => "ERROR",
                    "pesan" => "Data gagal diubah",
                    "url" => "",
                    "time" => date("Y-m-d H:i:s")
                );

                return $this->data;
            }
        }

        function deleteData($id)
        {
            try {
                $query = "DELETE FROM tb_divisi WHERE id_divisi='$id'";
                $delete_stmt = $this->con->prepare($query);
                $delete_stmt->execute();

                $this->data = array(
                    "result" => "",
                    "status" => "deleted",
                    "pesan" => "Data berhasil dihapus",
                    "url" => "",
                    "time" => date("Y-m-d H:i:s")
                );

                return $this->data;
            } catch (PDOException $e) {
                $this->data = array(
                    "result" => "",
                    "status" => "ERROR",
                    "pesan" => "Data gagal dihapus",
                    "url" => "",
                    "time" => date("Y-m-d H:i:s")
                );
            }
        }

        function autoIncrement()
        {
            try {
                $query = "SELECT right(id_divisi, 3) AS no FROM tb_divisi ORDER BY id_divisi DESC LIMIT 1";
                $select_stmt = $this->con->prepare($query);
                $select_stmt->execute();
                $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
                $angka = intval($row['no']);
                $angka++;
                $huruf = sprintf($angka);
                $panjang = strlen($huruf);

                switch ($panjang) {
                    case 1:
                        $huruf2 = "00".$huruf;
                        break;

                    case 2:
                        $huruf2 = "0".$huruf;
                        break;

                    case 3:
                        $huruf2 = "".$huruf;
                        break;
                }

                $gabung = "DVS-".$huruf2;

                $this->data = array(
                    "result" => $gabung,
                    "status" => "OK",
                    "pesan" => "",
                    "url" => "",
                    "time" => date("Y-m-d H:i:s")
                );

                return $this->data;
            } catch (PDOException $e) {
                $this->data = array(
                    "result" => "",
                    "status" => "ERROR",
                    "pesan" => "",
                    "url" => "",
                    "time" => date("Y-m-d H:i:s")
                );

                return $this->data;
            }
        }

        function fetchId()
        {
            try {
                $query = "SELECT id_divisi FROM tb_divisi ORDER BY id_divisi DESC LIMIT 1";
                $select_stmt = $this->con->prepare($query);
                $select_stmt->execute();

                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->result[] = $row;
                }

                $this->data = array(
                    "result" => $this->result,
                    "status" => "OK",
                    "pesan" => "",
                     "url" => "",
                     "time" => date('Y-m-d H:i:s')
                );

                return $this->data;
            } catch (PDOException $e) {
                $this->data = array(
                    "result" => "",
                    "status" => "ERROR",
                    "pesan" => "",
                    "url" => "",
                    "time" => date('Y-m-d H:i:s')
                );

                return $this->data;
            }
        }
    }
?>