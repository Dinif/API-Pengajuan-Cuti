<?php

    require_once 'ModelPengajuan.php';

    $lib = new Pengajuan;
    $action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];

    switch ($action) {
        case 'read':
            $data = $lib->fetchData();
            break;

        case 'create':
            $data = $lib->insertData($_POST['tfId'], $_POST['tfNip'], $_POST['tfKet'], $_POST['tglMulai'], $_POST['hariMulai'], $_POST['tglSelesai'], $_POST['hariSelesai'], $_POST['tglDiajukan']);
            break;

        case 'fetchSingle':
            $data = $lib->fetchSingle($_POST['id']);
            break;

        case 'fetchByNip':
            $data = $lib->fetchByNip($_POST['nip']);
            break;

        case 'terima':
            $data = $lib->terimaPengajuan($_POST['id'], $_POST['nip']);
            break;

        case 'tolak':
            $data = $lib->tolakPengajuan($_POST['id']);
            break;

        case 'fetchMenunggu':
            $data = $lib->fetchMenunggu();
            break;

        case 'fetchMenungguByNip':
            $data = $lib->fetchMenungguByNip($_POST['nip']);
            break;

        case 'fetchAcc':
            $data = $lib->fetchAcc();
            break;

        case 'fetchAccByNip':
            $data = $lib->fetchAccByNip($_POST['nip']);
            break;

        case 'fetchPerBulan':
            $data = $lib->fetchPerBulan($_POST['bulan']);
            break;

        case 'autoInc':
            $data = $lib->autoIncrement();
            break;
        
        case 'readId':
            $data = $lib->fetchId();
            break;

        case 'readSisaCuti':
            $data = $lib->fetchSisaCuti($_POST['nip']);
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