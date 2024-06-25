<?php
include_once '../../../../config/config.php';
//backInformation
//get properties, intructions and execute

// cooker function

function forwader($endpoint,$properties) {
    //account
$getAccountInformation = 'getAccountInformation';
//transaction
$getAllTransactions;
$getTransactionStatus;
$getTransactionsCriteriaBased;

//password
$getNewPassword;
//exchange rates
$getExchangeRates;
//update account information
$updateAccountInformation;
$getAccountInformation;
$getAccountInformation;
$getAccountInformation;
$getAccountInformation;

if($endpoint == $getAccountInformation) {
$worker = new worker;

$worker -> getAccountInformation($properties);
}else {
   echo "invalid enpoint";
}
}
//worker class
class worker {
 

    //getAccountInformation
            function getAccountInformation($properties){
                $cooker = new cooker;
                $cooker -> cooker($properties);
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
    //getAccountInformation
    class getAccountInformation{
        //fields/properties
     function forwarder($pan){
        $worker = new worker;
        $identifier = 'getAccountInformation';
        $stmnt = $worker -> getAccountInformation($pan);
     }
    }
    class returnData{
        function returnData(){
      
         }
    }
    class endpoints {
        // will prepare params and call cooker 
        
    }

    //cooker class
    //cooks the connection
    class cooker {
//has access to config.php
        function cooker($properties) {
            $config = new config;
            $dsn = 'mysql:host ='. $config->host .';dbname='.$config->database;
            $sql = new PDO($dsn , $config->username,$config->password);
            $sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                $realStatement = 'SELECT * FROM  profile WHERE firstName = :firstName';
                $stmnt = $sql ->prepare($realStatement);
                $stmnt->execute(['firstName' => $properties['firstName']]);
                $response = $stmnt->fetchAll(PDO::FETCH_OBJ);
                $sql ->prepare($realStatement);
                               
                foreach($response as $data) {
                    echo( json_encode([ $data]) );
                }

        }
    }