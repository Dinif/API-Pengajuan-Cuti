<?php

    require_once 'ModelDivisi.php';
    
    $lib = new Divisi;
    $action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];
    
    switch ($action) {
        case 'read':
            $data = $lib->fetchData();
            break;

        case 'create':
            $data = $lib->insertData($_POST['tfId'], $_POST['tfNama'], $_POST['tfPj']);
            break;

        case 'fetchSingle':
            $data = $lib->fetchSingle($_POST['id']);
            break;

        case 'update':
            $data = $lib->updateData($_POST['tfId'], $_POST['tfNama'], $_POST['tfPj']);
            break;

        case 'delete':
            $data = $lib->deleteData($_POST['id']);
            break;
        
        case 'autoInc':
            $data = $lib->autoIncrement();
            break;
        
        case 'readId':
            $data = $lib->fetchId();
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