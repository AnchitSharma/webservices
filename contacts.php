<?php


/*$myArr = array("John", "Mary", "Peter", "Sally");
$myJSON = array( array("Name"=>"John","Age"=>21,"Subject"=>"Science")
			, array("Name"=>"Marry","Age"=>23,"Subject"=>"Commerce"),
			array("Name"=>"Peter","Age"=>25,"Subject"=>"Arts"));

$myJSON = json_encode($myJSON);

echo $myJSON;*/
include 'crudClass.php';
$obj = new Classcrud;

$myJSON = array();
$baseurl = 'http://192.168.56.1/project/';

	
if(isset($_GET['source'])){

	$where = $_GET['source'];
	$condition = "source = '$where'";
	$selectdata = $obj->getdata('contacts','*',$condition);
	if($selectdata != FALSE){
		
		foreach($selectdata as $row){
			$temp = array("Name"=>$row['fullname']
		,"image"=>$baseurl.$row['cimage'],"phone"=>$row['phone']
		,"email"=>$row['email'],"source"=>$row['source']);
		array_push($myJSON,$temp);
		}
		header('Content-type:application/json');
		echo json_encode($myJSON);
	}
}else if(isset($_GET['search'])){
	$con = $_GET['search'];
	$where = "fullname like '".$con."%'";
	$selectdata = $obj->getdata('contacts','*',$where);
	if($selectdata != FALSE){
		foreach($selectdata as $row){
		$temp = array("Name"=>$row['fullname']
		,"image"=>$baseurl.$row['cimage'],"phone"=>$row['phone']
		,"email"=>$row['email'],"source"=>$row['source']);
		array_push($myJSON,$temp);
		}
		header('Content-type:application/json');
		echo json_encode($myJSON);
	}
}else{
	$selectdata = $obj->getdata("contacts","*","");
	if($selectdata != FALSE){
	foreach($selectdata as $row){
		$temp = array("Name"=>$row['fullname']
		,"image"=>$baseurl.$row['cimage'],"phone"=>$row['phone']
		,"email"=>$row['email'],"source"=>$row['source']);
		array_push($myJSON,$temp);
		}
		header('Content-type:application/json');
		echo json_encode($myJSON);
	}
}


?>

