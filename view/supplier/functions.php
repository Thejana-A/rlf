<?php 

session_start();

function signup($data)
{
	$errors = array();
 
	//validate 
	if(!preg_match('/^[a-zA-Z]+$/', $data['first_name'])){
		$errors[] = "Please enter a valid name";
	}
	if(!preg_match('/^[a-zA-Z]+$/', $data['last_name'])){
		$errors[] = "Please enter a name";
	}
	if(strlen(trim($data['password'])) < 4){
		$errors[] = "Password must be atleast 4 chars long";
	}

	if($data['password'] != $data['password2']){
		$errors[] = "Passwords must match";
	}
	
	if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
		$errors[] = "Please enter a valid email";
	}
	$check = database_run("select * from users where email = :email limit 1",['email'=>$data['email']]);
	if(is_array($check)){
		$errors[] = "That email already exists";
	}

	//save
	if(count($errors) == 0){

		$arr['first_name'] = $data['first_name'];
		$arr['last_name'] = $data['last_name'];
		$arr['password'] = hash('sha256',$data['password']);
		$arr['NIC'] = $data['NIC'];
		$arr['email'] = $data['email'];
		$arr['contact_no'] = $data['contact_no'];
		$arr['city'] = $data['city'];

		$query = "insert into supplier (first_name,last_name,password,NIC,email,contact_no,city) values 
		(:first_name,:last_name,:password,:NIC,:email,:contact_no,:city)";

		database_run($query,$arr);
	}
	return $errors;
}

function login($data)
{
	$errors = array();
 
	//validate 
	if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
		$errors[] = "Please enter a valid email";
	}

	if(strlen(trim($data['password'])) < 4){
		$errors[] = "Password must be atleast 4 chars long";
	}
 
	//check
	if(count($errors) == 0){

		$arr['email'] = $data['email'];
		$password = hash('sha256', $data['password']);

		$query = "select * from supplier where email = :email limit 1";

		$row = database_run($query,$arr);

		if(is_array($row)){
			$row = $row[0];

			if($password === $row->password){
				
				$_SESSION['USER'] = $row;
				$_SESSION['LOGGED_IN'] = true;
			}else{
				$errors[] = "wrong email or password";
			}

		}else{
			$errors[] = "wrong email or password";
		}
	}
	return $errors;
}

function database_run($query,$vars = array())
{
	$string = "mysql:host=localhost;dbname=rlf";
	$con = new PDO($string,'root','');

	if(!$con){
		return false;
	}

	$stm = $con->prepare($query);
	$check = $stm->execute($vars);

	if($check){
		
		$data = $stm->fetchAll(PDO::FETCH_OBJ);
		
		if(count($data) > 0){
			return $data;
		}
	}

	return false;
}

function check_login($redirect = true){

	if(isset($_SESSION['USER']) && isset($_SESSION['LOGGED_IN'])){

		return true;
	}

	if($redirect){
		header("Location: login.php");
		die;
	}else{
		return false;
	}
	
}


 	

