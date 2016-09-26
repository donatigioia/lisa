<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

include 'classes/PortalConnection.class.php';

$data=json_decode(file_get_contents("php://input"));
print_r($data);
//$username=$data->name;
//$pwd=$data->pw;
//$login = new login($username,$pwd);


/*class login
{
	public function __construct($username,$pwd)
	{
		$this->pdo = PortalConnection::getConnection();
		$this->compare($username,$pwd);
		

	}

	public function compare($username,$pwd)
	{
		
		$q = $this->pdo->prepare("SELECT * FROM gv_review_user WHERE username = '$username' and password = '$pwd'");
		$q->execute();
		if( $q->fetchAll() != false){
			$result="ok";
		}
		else{
			$result="not_exist";
		}

		echo json_encode($result);

	}

}*/

 

?>