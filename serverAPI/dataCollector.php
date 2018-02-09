<?php
$conn = new mysqli('hostName','userName','password','dataBase');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function insertData()
	{
		global $conn;
		global $j;

        $hValue=$j->{"hValue"};
		$tValue=$j->{"tValue"};
   
        $stmt = $conn->prepare("INSERT INTO home (hValue, tValue) VALUES (?, ?)");
        $stmt->bind_param("dd",$hValue, $tValue);
                
        if($stmt->execute())
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Added Successfully.'
			);
		}
		else
		{
            $response=array(
                'status' => 0,
                'error' => $stmt->error,
				'status_message' =>'Addition Failed.'
			);
		}
        
        header('Content-Type: application/json');
        echo json_encode($response);
    
        $stmt->close();
	    
	}


$request_method=$_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'POST':
        $j = json_decode(file_get_contents('php://input'));
        $auth =$j->{"auth"};
        
        // Check Auth code and insert data
        if ($auth == 'secretCode'){
            insertData();            
            break;    
        }

        else {
            header("HTTP/1.0 405 Auth error");
            break;
        }
    
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}


$conn->close();

?>
