<?php

    require_once 'ModelNotifikasi.php';

    $lib = new Notifikasi;
    $action = (isset($_GET['action']) ? $_GET['action'] : $_POST['action']);

    switch ($action) {
        case 'register':
            $data = $lib->register($_POST['idReg'], $_POST['device'], $_POST['idDevice'], $_POST['nip']);
            break;

        case 'send':
            $data = $lib->send($_POST['title'], $_POST['nip'], $_POST['message']);
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