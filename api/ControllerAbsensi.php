<?php

    require_once 'ModelAbsensi.php';

    $lib = new Absensi;
    $action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];

    switch ($action) {
        case 'read':
            $data = $lib->fetchData();
            break;

        case 'create':
            $data = $lib->insertData($_POST['tfNama'], $_POST['tfNip'], $_POST['opsKet'], $_POST['taDeskripsi']);
            break;

        case 'createSakit':
            $data = $lib->insertDataSakit($_POST['tfNama'], $_POST['tfNip'], $_POST['opsKet'], $_POST['taDeskripsi'], $_FILES['fPhoto']);
            break;

        case 'fetchSingle':
            $data = $lib->fetchSingle($_POST['id']);
            break;

        case 'fetchByNip':
            $data = $lib->fetchByNip($_POST['nip']);
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