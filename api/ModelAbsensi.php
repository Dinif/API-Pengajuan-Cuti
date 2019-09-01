<?php

    date_default_timezone_set('Asia/Jakarta');

    class Absensi
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
                $query = "SELECT id, nama, nip, keterangan, deskripsi, photo, DATE_FORMAT(tanggal, '%d %b %Y') AS 'tanggal' FROM tb_absensi";
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

        function insertData($nama, $nip, $ket, $deskripsi)
        {
            try {
                $query = "INSERT INTO tb_absensi (id, nama, nip, keterangan, deskripsi, photo, tanggal) VALUES ('', '$nama', '$nip', '$ket', '$deskripsi', '-', NOW())";
                $insert_stmt = $this->con->prepare($query);
                $insert_stmt->execute();

                $this->data = array(
                    "result" => "",
                    "status" => "inserted",
                    "pesan" => "Data berhasil diinput",
                    "url" => "",
                    "time" => date('Y-m-d H:i:s')
                );

                return $this->data;
            } catch (PDOException $e) {
                $this->data = array(
                    "result" => "",
                    "status" => "ERROR",
                    "pesan" => "Data gagal diinput",
                    "url" => "",
                    "time" => date('Y-m-d H:i:s')
                );

                return $this->data;
            }
        }

        function insertDataSakit($nama, $nip, $ket, $deskripsi, $photo)
        {
            try {
                $path = "upload/";
                $server_ip = gethostbyname(gethostname());
                $upload_url = "http://".$server_ip."/AplikasiPengajuanCutidanLembur/api/upload/";
                $file_info = pathinfo($photo['name']);
                $extension = $file_info['extension'];
                $file_url = $upload_url . $this->getFileName() . '.' . $extension;
                $file_path = $path . $this->getFileName() . '.' . $extension;

                move_uploaded_file($photo['tmp_name'], $file_path);

                $query = "INSERT INTO tb_absensi (id, nama, nip, keterangan, deskripsi, photo, tanggal) VALUES ('', '$nama', '$nip', '$ket', '$deskripsi', '$file_url', NOW())";
                $insert_stmt = $this->con->prepare($query);
                $insert_stmt->execute();

                $this->data = array(
                    "result" => "",
                    "status" => "inserted",
                    "pesan" => "Data berhasil diinput",
                    "url" => "",
                    "time" => date('Y-m-d H:i:s')
                );

                return $this->data;
            } catch (PDOException $e) {
                $this->data = array(
                    "result" => "",
                    "status" => "ERROR",
                    "pesan" => "Data gagal diinput",
                    "url" => "",
                    "time" => date('Y-m-d H:i:s')
                );

                return $this->data;
            }
        }

        function getFileName()
        {
            try {
                $query = "SELECT MAX(id) AS 'id' FROM tb_absensi";
                $select_stmt = $this->con->prepare($query);
                $select_stmt->execute();

                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    if ($row['id'] == null) {
                        return 1;
                    }
                    else {
                        return ++$row['id'];
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        function fetchSingle($id)
        {
            try {
                $query = "SELECT id, nama, nip, keterangan, deskripsi, photo, DATE_FORMAT(tanggal, '%d %b %Y') AS 'tanggal' FROM tb_absensi WHERE id='$id'";
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
        
        function fetchByNip($nip)
        {
            try {
                $query = "SELECT id, nama, nip, keterangan, deskripsi, photo, DATE_FORMAT(tanggal, '%d %b %Y') AS 'tanggal' FROM tb_absensi WHERE nip='$nip'";
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
    }

?>