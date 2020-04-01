<?php

header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Allow-Origin: *");

include_once '../config/database.php';

$fun = $_GET['/'];
$test = new Api();
$db = new Database();
$test->$fun($db);

class Api{


//registration starts here


	public function register($db){
		$data = json_decode(file_get_contents("php://input"),true);
		$full_name = $data['full_name'] == null ? $_POST['full_name'] : $data['full_name'];
		$mobile = $data['mobile'] == null ? $_POST['mobile'] : $data['mobile'];
		$mobile_alt =  $data['mobile_alt'] == null ? $_POST['mobile_alt'] : $data['mobile_alt'];
		$address = $data['address'] == null ? $_POST['address'] : $data['address'];

		if($full_name!=null && $mobile!=null){
			$uID = "COVIDAPP-".md5($full_name.$mobile.rand(00000,99999));
			$check = $db->query("SELECT * FROM users WHERE user_id='$uID'");
			$check = $db->mysqli_num_row($check);
			if($check==0){
				$query = $db->query("INSERT INTO users(`full_name`,`mobile`,`mobile_alt`,`address`,`user_id`) VALUES('$full_name','$mobile','$mobile_alt','$address','$uID')");
				if ($query==true) {
					$message=[
						"status"=>1,
						"message"=> $uID
					];
				}else{
					$message=[
						"status"=>0,
						"message"=>"Failed to Register"
					];
				}
			}
			else{
				$message=[
					"status"=>0,
					"message"=>"E-Mail Already Exists",
				];
			}
		}

		$db->response($message);
	}



	public function getUserDetails($db){
		$data = json_decode(file_get_contents("php://input"),true);
		$user_id = $data['user_id'] == null ? $_POST['user_id'] : $data['user_id'];
		$check = $db->query("SELECT * FROM users WHERE user_id='$user_id'");
		if($check!=null){
			$message=[
				"status"=>1,
				"message"=> $check
			];
		}else{
			$message=[
				"status"=>0,
				"message"=> array()
			];
		}
		$db->response($message);


	}


	public function passChecker($db){
		$data = json_decode(file_get_contents("php://input"),true);
		$pass = sha1($data['pass'] == null ? $_POST['pass'] : $data['pass']);
		$check = $db->query("SELECT * FROM h_pass WHERE pass='$pass'");
		$check = $db->mysqli_num_row($check);
		if($check>0){
			$message=[
				"status"=>1,
				"message"=> true
			];
		}else{
			$message=[
				"status"=>0,
				"message"=> false
			];
		}
		$db->response($message);

	}



	//class ends HERE..!!!
}

?>