<?php

    date_default_timezone_set('Asia/Jakarta');

    class Pengajuan
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
                $query = "SELECT ta.id_pengajuan, tp.nip, tp.nama_pegawai, td.nama_divisi, td.penanggung_jawab, DATE_FORMAT(ta.mulai_cuti, '%d %b %Y') AS 'mulai_cuti', ta.hari_mulai, DATE_FORMAT(ta.selesai_cuti, '%d %b %Y') AS 'selesai_cuti', ta.hari_selesai, ta.jumlah_cuti, ta.keterangan, DATE_FORMAT(ta.tanggal_diajukan, '%d %b %Y') AS 'tanggal_diajukan', ta.status FROM tb_pengajuan ta INNER JOIN tb_pegawai tp ON ta.nip=tp.nip INNER JOIN tb_divisi td ON tp.divisi=td.id_divisi ORDER BY ta.id_pengajuan";
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

        function insertData($id, $nip, $ket, $mulai, $hariMulai, $selesai, $hariSelesai, $aju)
        {
            try {
                $date1 = date("Y-m-d", strtotime($mulai));
                $date2 = date("Y-m-d", strtotime($selesai));
                $date3 = date("Y-m-d", strtotime($aju));

                $query = "INSERT INTO tb_pengajuan (id_pengajuan, nip, keterangan, mulai_cuti, hari_mulai, selesai_cuti, hari_selesai, jumlah_cuti, tanggal_diajukan, status) VALUES ('$id', '$nip', '$ket', '$date1', '$hariMulai', '$date2', '$hariSelesai', (DATEDIFF(selesai_cuti, mulai_cuti)+1), '$date3', 'Menunggu')";
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
                $query = "SELECT ta.id_pengajuan, tp.nip, tp.nama_pegawai, td.nama_divisi, td.penanggung_jawab, DATE_FORMAT(ta.mulai_cuti, '%d %b %Y') AS 'mulai_cuti', ta.hari_mulai, DATE_FORMAT(ta.selesai_cuti, '%d %b %Y') AS 'selesai_cuti', ta.hari_selesai, ta.jumlah_cuti, ta.keterangan, DATE_FORMAT(ta.tanggal_diajukan, '%d %b %Y') AS 'tanggal_diajukan', ta.status FROM tb_pengajuan ta INNER JOIN tb_pegawai tp ON ta.nip=tp.nip INNER JOIN tb_divisi td ON tp.divisi=td.id_divisi WHERE ta.id_pengajuan='$id'";
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
                $query = "SELECT ta.id_pengajuan, tp.nip, tp.nama_pegawai, td.nama_divisi, td.penanggung_jawab, DATE_FORMAT(ta.mulai_cuti, '%d %b %Y') AS 'mulai_cuti', ta.hari_mulai, DATE_FORMAT(ta.selesai_cuti, '%d %b %Y') AS 'selesai_cuti', ta.hari_selesai, ta.jumlah_cuti, ta.keterangan, DATE_FORMAT(ta.tanggal_diajukan, '%d %b %Y') AS 'tanggal_diajukan', ta.status FROM tb_pengajuan ta INNER JOIN tb_pegawai tp ON ta.nip=tp.nip INNER JOIN tb_divisi td ON tp.divisi=td.id_divisi WHERE tp.nip='$nip'";
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

        function terimaPengajuan($id, $nip)
        {
            try {
                $status = "Diterima";

                $this->updateStatus($id, $status);
                $this->updateCuti($id, $nip);

                $this->data = array(
                    "result" => "",
                    "status" => "OK",
                    "pesan" => "Anda telah menerima pengajuan ini",
                    "url" => "",
                    "time" => date("Y-m-d H:i:s")
                );
                
                return $this->data;
            } catch (PDOException $e) {
                $this->data = array(
                    "result" => "",
                    "status" => "ERROR",
                    "pesan" => "Anda gagal menerima pengajuan ini",
                    "url" => "",
                    "time" => date("Y-m-d H:i:s")
                );
                
                return $this->data;
            }
        }

        function tolakPengajuan($id)
        {
            try {
                $status = "Ditolak";

                $this->updateStatus($id, $status);

                $this->data = array(
                    "result" => "",
                    "status" => "OK",
                    "pesan" => "Anda telah menolak pengajuan ini",
                    "url" => "",
                    "time" => date("Y-m-d H:i:s")
                );
                
                return $this->data;
            } catch (PDOException $e) {
                $this->data = array(
                    "result" => "",
                    "status" => "ERROR",
                    "pesan" => "Anda gagal menolak pengajuan ini",
                    "url" => "",
                    "time" => date("Y-m-d H:i:s")
                );
                
                return $this->data;
            }
        }

        function updateStatus($id, $status)
        {
            try {
                $query = "UPDATE tb_pengajuan SET status='$status' WHERE id_pengajuan='$id'";
                $update_stmt = $this->con->prepare($query);
                $update_stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        function updateCuti($id, $nip)
        {
            try {
                $query = "SELECT sisa_cuti FROM tb_cuti WHERE nip='$nip'";
                $select_stmt = $this->con->prepare($query);
                $select_stmt->execute();
                $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
                $sisa = intval($row['sisa_cuti']);

                $query = "SELECT jumlah_cuti FROM tb_pengajuan WHERE id_pengajuan='$id'";
                $select_stmt = $this->con->prepare($query);
                $select_stmt->execute();
                $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
                $jumlah = intval($row['jumlah_cuti']);

                $sisa_baru = $sisa-$jumlah;

                $query = "UPDATE tb_cuti SET sisa_cuti='$sisa_baru' WHERE nip='$nip'";
                $update_stmt = $this->con->prepare($query);
                $update_stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        function fetchMenunggu(){
            try {
                $query = "SELECT ta.id_pengajuan, tp.nip, tp.nama_pegawai, td.nama_divisi, td.penanggung_jawab, DATE_FORMAT(ta.mulai_cuti, '%d %b %Y') AS 'mulai_cuti', ta.hari_mulai, DATE_FORMAT(ta.selesai_cuti, '%d %b %Y') AS 'selesai_cuti', ta.hari_selesai, ta.jumlah_cuti, ta.keterangan, DATE_FORMAT(ta.tanggal_diajukan, '%d %b %Y') AS 'tanggal_diajukan', ta.status FROM tb_pengajuan ta INNER JOIN tb_pegawai tp ON ta.nip=tp.nip INNER JOIN tb_divisi td ON tp.divisi=td.id_divisi WHERE ta.status='Menunggu'";
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

                $this->data;
            }
            
        }

        function fetchAcc()
        {
            try {
                $query = "SELECT ta.id_pengajuan, tp.nip, tp.nama_pegawai, td.nama_divisi, td.penanggung_jawab, DATE_FORMAT(ta.mulai_cuti, '%d %b %Y') AS 'mulai_cuti', ta.hari_mulai, DATE_FORMAT(ta.selesai_cuti, '%d %b %Y') AS 'selesai_cuti', ta.hari_selesai, ta.jumlah_cuti, ta.keterangan, DATE_FORMAT(ta.tanggal_diajukan, '%d %b %Y') AS 'tanggal_diajukan', ta.status FROM tb_pengajuan ta INNER JOIN tb_pegawai tp ON ta.nip=tp.nip INNER JOIN tb_divisi td ON tp.divisi=td.id_divisi WHERE ta.status='Diterima' OR ta.status='Ditolak'";
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

        function fetchMenungguByNip($nip)
        {
            try {
                $query = "SELECT ta.id_pengajuan, tp.nip, tp.nama_pegawai, td.nama_divisi, td.penanggung_jawab, DATE_FORMAT(ta.mulai_cuti, '%d %b %Y') AS 'mulai_cuti', ta.hari_mulai, DATE_FORMAT(ta.selesai_cuti, '%d %b %Y') AS 'selesai_cuti', ta.hari_selesai, ta.jumlah_cuti, ta.keterangan, DATE_FORMAT(ta.tanggal_diajukan, '%d %b %Y') AS 'tanggal_diajukan', ta.status FROM tb_pengajuan ta INNER JOIN tb_pegawai tp ON ta.nip=tp.nip INNER JOIN tb_divisi td ON tp.divisi=td.id_divisi WHERE ta.status='Menunggu' AND tp.nip='$nip'";
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

        function fetchAccByNip($nip)
        {
            try {
                $query = "SELECT ta.id_pengajuan, tp.nip, tp.nama_pegawai, td.nama_divisi, td.penanggung_jawab, DATE_FORMAT(ta.mulai_cuti, '%d %b %Y') AS 'mulai_cuti', ta.hari_mulai, DATE_FORMAT(ta.selesai_cuti, '%d %b %Y') AS 'selesai_cuti', ta.hari_selesai, ta.jumlah_cuti, ta.keterangan, DATE_FORMAT(ta.tanggal_diajukan, '%d %b %Y') AS 'tanggal_diajukan', ta.status FROM tb_pengajuan ta INNER JOIN tb_pegawai tp ON ta.nip=tp.nip INNER JOIN tb_divisi td ON tp.divisi=td.id_divisi WHERE (ta.status='Diterima' OR ta.status='Ditolak') AND tp.nip='$nip'";
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

        function fetchPerBulan($bulan)
        {
            try {
                $query = "SELECT ta.id_pengajuan, tp.nip, tp.nama_pegawai, td.nama_divisi, td.penanggung_jawab, DATE_FORMAT(ta.mulai_cuti, '%d %b %Y') AS 'mulai_cuti', ta.hari_mulai, DATE_FORMAT(ta.selesai_cuti, '%d %b %Y') AS 'selesai_cuti', ta.hari_selesai, ta.jumlah_cuti, ta.keterangan, DATE_FORMAT(ta.tanggal_diajukan, '%d %b %Y') AS 'tanggal_diajukan', ta.status FROM tb_pengajuan ta INNER JOIN tb_pegawai tp ON ta.nip=tp.nip INNER JOIN tb_divisi td ON tp.divisi=td.id_divisi WHERE (ta.status='Diterima' OR ta.status='Ditolak') AND MONTH(ta.tanggal_diajukan)='$bulan'";
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

        function autoIncrement()
        {
            try {
                $query = "SELECT right(id_pengajuan, 3) AS no FROM tb_pengajuan ORDER BY id_pengajuan DESC LIMIT 1";
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

                $gabung = "PNG-".$huruf2;

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
            }
        }

        function fetchId()
        {
            try {
                $query = "SELECT id_pengajuan FROM tb_pengajuan ORDER BY id_pengajuan DESC LIMIT 1";
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

        function fetchSisaCuti($nip)
        {
            try {
                $query = "SELECT * FROM tb_cuti WHERE nip='$nip'";
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