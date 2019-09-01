<?php

    class Notifikasi
    {
        private $con;
        private $url;
        private $key;
        private $client;
        private $data;

        function __construct()
        {
            require_once 'Connection.php';

            $lib = new Connection;
            $this->con = $lib->dbConnection();
            $this->url = "https://fcm.googleapis.com/fcm/send";
            $this->key = "AAAAK2svtE4:APA91bHVYt0rFnuV17hWB06z0tZLxx76vIGlL85ao2R8uPVB0JxwYNzDvzzdTtz7krTOh5KJMofUpKy6Ef8vEq1o1S3wUOKeOpxMoVC3yEp2976jcxxRaXe-p-ZN5Kk0ynAgQ1CQ5jJP";
            $this->client = "APC";
        }

        function register($idReg, $device, $idDevice, $nip)
        {
            try {
                $idClient = $this->client;

                if ($this->getRegister($idReg, $idClient, $nip)) {
                    $query = "UPDATE tb_registrasi SET waktu_registrasi=NOW() WHERE id_registrasi='$idReg' AND id_client='$idClient' AND nip='$nip'";
                    $update_stmt = $this->con->prepare($query);
                    $update_stmt->execute();
                }
                else {
                    $query = "INSERT INTO tb_registrasi (id_registrasi, device, id_device, id_client, nip, waktu_registrasi) VALUES ('$idReg', '$device', '$idDevice', '$idClient', '$nip', NOW())";
                    $insert_stmt = $this->con->prepare($query);
                    $insert_stmt->execute();
                }

                $this->data = array(
                    "result" => "",
                    "status" => "OK",
                    "pesan" => "Data berhasil didaftarkan",
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

        function getRegister($idReg, $idClient, $nip)
        {
            $query = "SELECT COUNT(id) AS 'total' FROM tb_registrasi WHERE id_registrasi='$idReg' AND id_client='$idClient' AND nip='$nip'";
            $select_stmt = $this->con->prepare($query);
            $select_stmt->execute();

            while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $result = $row['total'] > 0 ? true : false;
            }

            return $result;
        }

        function send($title, $nip, $pesan)
        {
            $query = "SELECT id AS 'no' FROM tb_request_log ORDER BY id DESC LIMIT 1";
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

            $idPush = "PID-".$huruf2;
            $messageTitle = "New Submission";

            $message['title'] = $messageTitle;
            $message['message'] = $pesan;

            $idReg = $this->getIdReg($this->client, $nip);

            if ($idReg != "") {
                $this->request($idReg, $title, json_encode($message), $nip, $idPush);
            }
        }

        function request($idReg, $title, $msg, $nip, $idPush)
        {
            $idRegs[] = $idReg;

            $fields = array(
                'registration_ids' => $idRegs,
                'data' => array(
                    'title' => $title,
                    'message' => $msg
                )
            );

            $headers = array(
                'Authorization: key='.$this->key,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $response = curl_exec($ch);
            curl_close($ch);

            $this->requestLog($title.' : '.$msg, $response, $idReg, $nip, $idPush);
        }

        function requestLog($msg, $response, $idReg, $nip, $idPush)
        {
            try {
                    if ($this->getRequestLog($idReg, $idPush)) {
                        $query = "UPDATE tb_request_log SET message='".addslashes($msg)."', response='".addslashes($response)."', waktu_request=NOW() WHERE id_registrasi='$idReg' AND id_push='$idPush'";
                        $update_stmt = $this->con->prepare($query);
                        $update_stmt->execute();
                    }
                    else {
                        $query = "INSERT INTO tb_request_log (message, response, id_registrasi, nip, id_push, waktu_request) VALUES ('".addslashes($msg)."', '".addslashes($response)."', '$idReg', '$nip', '$idPush', NOW())";
                        $insert_stmt = $this->con->prepare($query);
                        $insert_stmt->execute();
                    }

                $this->data = array(
                    "result" => "",
                    "status" => "OK",
                    "pesan" => "Request berhasil",
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

        function getIdReg($client, $nip)
        {
            $query = "SELECT * FROM tb_registrasi WHERE id_client='$client' AND nip='$nip' ORDER BY waktu_registrasi DESC LIMIT 1";
            $select_stmt = $this->con->prepare($query);
            $select_stmt->execute();

            while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                return $row['id_registrasi'];
            }
        }

        function getRequestLog($idReg, $idPush)
        {
            $query = "SELECT COUNT(id) AS 'total' FROM tb_request_log WHERE id_registrasi='$idReg' AND id_push='$idPush'";
            $select_stmt = $this->con->prepare($query);
            $select_stmt->execute();

            while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $result = $row['total'] > 0 ? true : false;
            }

            return $result;
        }
    }
    

?>