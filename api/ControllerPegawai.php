<?php

    date_default_timezone_set('Asia/Jakarta');

    require_once 'ModelPegawai.php';

    $lib = new Pegawai();
    $action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];

    switch ($action) {
        case 'login':
            $data = $lib->login($_POST['tfUser'], $_POST['tfPass']);
            break;
        
        case 'read':
            $data = $lib->fetchData();
            break;

        case 'create':
            $data = $lib->insertData($_POST['tfNip'], $_POST['tfNama'], $_POST['tfAlamat'], $_POST['tfNoTelp'], $_POST['opsDiv'], $_POST['tfPass']);
            break;

        case 'fetchSingle':
            $data = $lib->fetchSingle($_POST['nip']);
            break;

        case 'update':
            $data = $lib->updateData($_POST['tfNip'], $_POST['tfNama'], $_POST['tfAlamat'], $_POST['tfNoTelp'], $_POST['opsDiv'], $_POST['tfPass']);
            break;

        case 'delete':
            $data = $lib->deleteData($_POST['nip']);
            break;
        
        case 'autoInc':
            $data = $lib->autoIncrement();
            break;

        case 'readNip':
            $data = $lib->fetchNip();
            break;

        default:
            $data = array(
                "result" => "",
                "status" => "ERROR",
                "pesan" => "",
                "url" => "",
                "time" => date('Y-m-d H:i:s')
            );
            break;
    }

    echo json_encode($data);

?>