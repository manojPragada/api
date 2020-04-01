<?php
class Database{
	
	public function connectd(){
	
		$dbhost = "localhost";
		$dbname = "covid";
		$dbuser = "root";
		$dbpass = "";
		try{
			$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
			return $conn;

		}
		catch(PDOException $e){
			echo "Connection Error: ".$e->getMessage();
		}
	}

	public function response($data)
	{
		header('Content-Type: application/json');
		header("Access-Control-Alow-Headers: content-type");
		echo json_encode($data);
	}
	public function mysqli_num_row($arr){
		if($arr!=false){
			$len = sizeof($arr);			
		}
		else{
			$len = 0;
		}
		return $len;
	}
	public function query($query){
		$db = new Database();
		$db = $db->connectd();
		$data=array();
		if($db){
			$quer = mysqli_query($db,$query);
			if($quer){
				// echo $query;
				// echo strpos($query,'SELECT');
				if(strpos($query,'SELECT')===0){
					while($row = mysqli_fetch_assoc($quer)) {
				    	array_push($data, $row);
					}
					// echo $data;
					return $data;
				}
				else{
					return true;
				}
				
			}else{
				return false;
			}
		}
		else {
			echo "Error :".mysql_errno();
		}
		return $query;
	}
}

?>