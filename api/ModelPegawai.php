<?php

    session_start();

    date_default_timezone_set('Asia/Jakarta');

    class Pegawai
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

        function login($user, $pass)
        {
            try {
                $query = "SELECT tp.nip, tp.nama_pegawai, td.nama_divisi, td.penanggung_jawab, tl.user, tl.pass, tl.level, tc.sisa_cuti FROM tb_login tl INNER JOIN tb_pegawai tp ON tl.nip=tp.nip INNER JOIN tb_divisi td ON tp.divisi=td.id_divisi INNER JOIN tb_cuti tc ON tp.nip=tc.nip WHERE (tp.nip='$user' OR tl.user='$user') AND tl.pass='$pass'";
                $select_stmt = $this->con->prepare($query);
                $select_stmt->execute();

                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->result[] = $row;

                    $_SESSION['nip'] = $row['nip'];
                }

                if (!$this->result) {
                    $this->data = array(
                        "result" => $this->result,
                        "status" => "ERROR",
                        "pesan" => "Gagal login",
                        "url" => "",
                        "time" => date('Y-m-d H:i:s')
                    );
                }
                else {
                    $this->data = array(
                        "result" => $this->result,
                        "status" => "OK",
                        "pesan" => "Berhasil login",
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

        function fetchData()
        {
            try {
                $query = "SELECT tp.nip, tp.nama_pegawai, tp.alamat, tp.no_telp, td.id_divisi, td.nama_divisi, td.penanggung_jawab, tl.user, tl.pass, tl.level FROM tb_pegawai tp INNER JOIN tb_divisi td ON tp.divisi=td.id_divisi INNER JOIN tb_login tl ON tp.nip=tl.nip ORDER BY tp.nip";
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

        function insertData($nip, $nama, $alamat, $notelp, $divisi, $pass)
        {
            try {
                if ($divisi == "Android Developer") {
                    $id = "DVS-001";
                    $level = "KARYAWAN";
                }
                else if ($divisi == "Web Developer") {
                    $id = "DVS-002";
                    $level = "KARYAWAN";
                }
                else if ($divisi == "Keuangan") {
                    $id = "DVS-003";
                    $level = "KARYAWAN";
                }
                else if ($divisi == "HRD") {
                    $id = "DVS-004";
                    $level = "HRD";
                }
                else if ($divisi == "Atasan") {
                    $id = "DVS-005";
                    $level = "ATASAN";
                }

                $query = "INSERT INTO tb_pegawai (nip, nama_pegawai, alamat, no_telp, divisi) VALUES ('$nip', '$nama', '$alamat', '$notelp', '$id')";
                $insert_stmt = $this->con->prepare($query);
                $insert_stmt->execute();

                $this->insertLogin($nip, $nama, $pass, $level);
                $this->insertCuti($nip);

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
        
        function insertLogin($nip, $nama, $pass, $level)
        {
            try {
                $query = "INSERT INTO tb_login (nip, user, pass, level) VALUES ('$nip', '$nama', '$pass', '$level')";
                $insert_stmt = $this->con->prepare($query);
                $insert_stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        function insertCuti($nip)
        {
            try {
                $query = "INSERT INTO tb_cuti (nip, sisa_cuti) VALUES ('$nip', '12')";
                $insert_stmt = $this->con->prepare($query);
                $insert_stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        function fetchSingle($nip)
        {
            try {
                $query = "SELECT tp.nip, tp.nama_pegawai, tp.alamat, tp.no_telp, td.nama_divisi, td.penanggung_jawab, tl.user, tl.pass, tc.sisa_cuti FROM tb_pegawai tp INNER JOIN tb_login tl ON tp.nip=tl.nip INNER JOIN tb_divisi td ON tp.divisi=td.id_divisi INNER JOIN tb_cuti tc ON tp.nip=tc.nip WHERE tp.nip='$nip'";
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

        function updateData($nip, $nama, $alamat, $notelp, $divisi, $pass)
        {
            try {
                if ($divisi == "Android Developer") {
                    $id = "DVS-001";
                    $level = "KARYAWAN";
                }
                else if ($divisi == "Web Developer") {
                    $id = "DVS-002";
                    $level = "KARYAWAN";
                }
                else if ($divisi == "Keuangan") {
                    $id = "DVS-003";
                    $level = "KARYAWAN";
                }
                else if ($divisi == "HRD") {
                    $id = "DVS-004";
                    $level = "HRD";
                }
                else if ($divisi == "Atasan") {
                    $id = "DVS-005";
                    $level = "ATASAN";
                }

                $query = "UPDATE tb_pegawai tp, tb_login tl SET tp.nama_pegawai='$nama', tp.alamat='$alamat', tp.no_telp='$notelp', tp.divisi='$id', tl.user='$nama', tl.pass='$pass', tl.level='$level' WHERE tp.nip=tl.nip AND tp.nip='$nip'";
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

        function deleteData($nip)
        {
            try {
                $query = "DELETE FROM tb_pegawai WHERE nip='$nip'";
                $delete_stmt = $this->con->prepare($query);
                $delete_stmt->execute();

                $this->deleteLogin($nip);
                $this->deleteCuti($nip);

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

                return $this->data;
            }
        }

        function deleteLogin($nip)
        {
            try {
                $query = "DELETE FROM tb_login WHERE nip='$nip'";
                $delete_stmt = $this->con->prepare($query);
                $delete_stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        function deleteCuti($nip)
        {
            try {
                $query = "DELETE FROM tb_cuti WHERE nip='$nip'";
                $delete_stmt = $this->con->prepare($query);
                $delete_stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        function autoIncrement()
        {
            try {
                $query = "SELECT right(nip, 3) AS no FROM tb_pegawai ORDER BY nip DESC LIMIT 1";
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

                $gabung = "TTX-".$huruf2;

                $this->data = array(
                    "result" => $gabung,
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

        function fetchNip()
        {
            try {
                $query = "SELECT nip FROM tb_pegawai ORDER BY nip DESC LIMIT 1";
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
    }
    
?>