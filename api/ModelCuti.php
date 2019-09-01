<?php

    class Cuti
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
                $query = "SELECT tp.nip, tp.nama_pegawai, tc.sisa_cuti FROM tb_cuti tc INNER JOIN tb_pegawai tp ON tc.nip=tp.nip ORDER BY tp.nip";
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

        function fetchSingle($nip)
        {
            try {
                $query = "SELECT tp.nip, tp.nama_pegawai, tc.sisa_cuti FROM tb_cuti tc INNER JOIN tb_pegawai tp ON tc.nip=tp.nip WHERE tp.nip='$nip'";
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

        function updateData($nama, $sisaCuti)
        {
            try {
                $query = "UPDATE tb_cuti tc, tb_pegawai tp SET tc.sisa_cuti='$sisaCuti' WHERE tc.nip=tp.nip AND tp.nama_pegawai='$nama'";
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
    }
    

?>