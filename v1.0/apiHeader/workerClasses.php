<?php 
header('Content-Type: application/json; charset=utf-8');

class config {
    private $host = 'localhost';
    private $database = 'api';
    private $username = 'root';
    private $password = '';

function connection($query,$id='',$lastName='' , $default="") {
    $dsn = 'mysql:host ='. $this->host .';dbname='.$this->database;
    $sql = new PDO($dsn , $this->username,$this->password);
    $sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $stmnt = $sql ->prepare($query);
    $stmnt->execute();
    $response = $stmnt->fetchAll(PDO::FETCH_OBJ);

    foreach($response as $data) {
        echo json_encode($data);
    }
    
}
}

class updateProfile{
    //fields/properties
 function profileUpdate($lastName,$id){
    $conn = new config;
    $realStatement = 'UPDATE profile  SET  lastName = :lastName WHERE  accountNumber = :id';
    $stmnt = $conn -> connection($realStatement,$id,$lastName);
 }
}
class returnData{
    function returnData(){
        $conn = new config;
        $realStatement = 'SELECT * FROM  profile';
        $stmnt = $conn -> connection($realStatement);
     }
}