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
            $sql = "SELECT * FROM comments WHERE id = :id";
            $params = [
                ":id"=>$id
            ]; 
            $result =  $database->get_row($sql,$params);
        } else { 
            $sql = "select * from comments";
            $result = $database->get_rows($sql);
        }
        echo json_encode($result);
        break;
    
    case 'post':
        $body = file_get_contents("php://input");
        $body = json_decode($body);
        $name = $body->name;
        $email = $body->email;
        $text = $body->text;

        $sql = "INSERT INTO comments (name, email, text) VALUES(:name,:email,:text)";
        $params = [":name"=>$name,":email"=>$email,":text"=>$text];
        $output = new stdClass;
        $result = $database->insert_row($sql, $params);
        $output->success = $result ? 1 : 0;
        echo json_encode($output);
        break;

    case 'put':
        $body = file_get_contents("php://input");
        $body = json_decode($body);
        
        $id = $body->id;

        $sql = "UPDATE comments SET aprooved = 1 WHERE id=:id";
        $params = [":id"=>$id];
        $output = new stdClass;
        $result = $database->update_row($sql, $params);
        $output->success = $result ? 1 : 0;
        echo json_encode($output);
        break;
    
    case 'delete':
        if (isset($_GET['id']) && $_GET['id'] != "") {
           $id = $_GET['id'];
           $sql = "DELETE FROM comments WHERE id=:id";
           $params = [":id"=>$id];
           $output = new stdClass;
           $result = $database->delete_row($sql, $params);
           $output->success = $result ? 1 : 0;
           echo json_encode($output);
        }
}

