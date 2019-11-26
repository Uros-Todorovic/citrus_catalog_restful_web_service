<?php
header("Content-Type:application/json");
require_once("includes/class_loader.php");
$database = Database::get_connection();
$connection = $database->connect();

$request_method = strtolower($_SERVER['REQUEST_METHOD']);

switch ($request_method) {
    case 'get':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM product WHERE id = :id";
            $params = [
                ":id"=>$id
            ]; 
            $result =  $database->get_row($sql,$params);
        } else { 
            $sql = "select * from product";
            $result = $database->get_rows($sql);
        }
        echo json_encode($result);
        break;
    
    case 'post':
        $body = file_get_contents("php://input");
        $body = json_decode($body);
        $title = $body->title;
        $picture = $body->picture;
        $description = $body->description;

        $sql = "INSERT INTO product VALUES(null,:title,:picture,:description)";
        $params = [":title"=>$title,":picture"=>$picture,":description"=>$description];
        $output = new stdClass;
        $result = $database->insert_row($sql, $params);
        $output->success = $result ? 1 : 0;
        echo json_encode($output);
        break;

    case 'put':
        $body = file_get_contents("php://input");
        $body = json_decode($body);
        $title = $body->title;
        $picture = $body->picture;
        $description = $body->description;
        $id = $body->id;

        $sql = "UPDATE product SET title=:title, picture=:picture, description=:description WHERE id=:id";
        $params = [":title"=>$title,":picture"=>$picture,":description"=>$description,":id"=>$id];
        $output = new stdClass;
        $result = $database->update_row($sql, $params);
        $output->success = $result ? 1 : 0;
        echo json_encode($output);
        break;
    
    case 'delete':
        if (isset($_GET['id']) && $_GET['id'] != "") {
           $id = $_GET['id'];
           $sql = "DELETE FROM product WHERE id=:id";
           $params = [":id"=>$id];
           $output = new stdClass;
           $result = $database->delete_row($sql, $params);
           $output->success = $result ? 1 : 0;
           echo json_encode($output);
        }
}

