<?php
include 'db.php';

header('Contaent-type: application/json');
header('Access-control-allow-origin: *');

try{
    $sql = "SELECT * FROM product";
    $result = $conn->query($sql);
    $products = [];
    if($result && $result->num_rows > 0);
    while($row = $result->fetch_assoc()){
          $products[] = $row;

    }
    
    echo json_encode($products);

} catch(Exception $e){
    http_response_code(500);
    echo json_encode($e->getMessage());
}
$conn->close();

