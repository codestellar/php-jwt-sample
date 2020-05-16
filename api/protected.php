<?php
include_once './config/database.php';

include_once './config/post.php';
include_once './config/config.php';

$jwt = null;
$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();

$data = json_decode(file_get_contents("php://input"));

try{

    $authHeader = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION']: null;

    if(!$authHeader){
        echo json_encode(array('message' => "Token not presented"));
        exit();
    }

    $arr = explode(" ", $authHeader);
    
    $jwt = $arr[1];    
    
}catch(Exception $e){
    http_response_code(401);

    echo json_encode(array(
        "message" => "Access denied. Token is not presented",
        "error" => $e->getMessage()
    ));    
    exit();
}

if($jwt){

    try {

        $decoded = ConfigService::decodeSecret($jwt);

        // Access is granted. Add code of the operation here 

        echo json_encode(array(
            "message" => "Access granted:"
        ));

    }catch (Exception $e){

        http_response_code(401);

        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
        }
}
else{
    echo json_encode(array(
        "message" => "Token Validation failed"
    ));    
}
?>