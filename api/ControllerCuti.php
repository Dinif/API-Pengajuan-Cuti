<?php

    require_once 'ModelCuti.php';
    
    $lib = new Cuti;
    $action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];
    
    switch ($action) {
        case 'read':
            $data = $lib->fetchData();
            break;

        case 'fetchSingle':
            $data = $lib->fetchSingle($_POST['nip']);
            break;

        case 'update':
            $data = $lib->updateData($_POST['opsNama'], $_POST['tfSisaCuti']);
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