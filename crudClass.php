<?php
include "dbconnect.php"; 
class Classcrud extends dbmodel
{
  public function __construct(){
	    parent::__construct();
		//echo"construct function is work";exit;
  }
  public function uploadImage($name,$direct){
	
	$target_dir = $direct;//fileToUpload 'uploads/';
	$target_file = $target_dir.basename($_FILES[$name]['name']);
	$uploadOk =1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$check = getImageSize($_FILES[$name]['tmp_name']);
		if($check !== false){
			$uploadOk =1;
		}else{
			
			$uploadOk =0;
		}
	
	  if(file_exists($target_file)){
		$uploadOk =0;
	}
	
	if($_FILES[$name]['size']>500000){
		
		$uploadOk = 0;
	}
	
	if($imageFileType != 'jpg'&& $imageFileType != 'jpeg'&& $imageFileType != 'png'
		&& $imageFileType != 'gif'){
			
			$uploadOk = 0;
		}
		
	if($uploadOk ==0){
		echo 'sorry file in not uploaded';
		
	}else{
		if(move_uploaded_file($_FILES[$name]['tmp_name'],$target_file)){
			echo "file uploaded successfully";	
		}else{
			echo "sorry file not uploaded, please try again";
			
			
		}
		
	}
	}
  public function getdata($table,$colname,$condition)
  {
	 if(!empty($table))
	 {
	    if(!empty($colname))
		  {
			if(TRUE)
			  {
				$sql="SELECT ".$colname." FROM ".$table." WHERE ".$condition;
				//print_r($sql);
				 if(empty($condition)||$condition == ''){
					$sql = substr($sql,0,strlen($sql)-strlen('WHERE '));   
				}
				//echo $sql;exit;
				$stmt = $this->db->prepare($sql);
				if( $stmt->execute() )
				{
				  if( $stmt->rowCount()>0 )
				    {
					  return $stmt;	
					}
				  else
				   {
					  return FALSE;  
				   }	
				}
				else
				{
				  return FALSE;	
				} 
			  }
			  else
			  {
				echo "Please Enter specific condition of your query";  
			  } 
	      }
		  else
		  {
			 echo"Please enter table column name"; 
		  }	 
	 }
	 else
	 {
       echo "Please Enter your Table Name";
	 }
  }
  
  
  
  	
  public function insert($tablename,$data_item,$condition)
  {
	//echo "model is working"; exit;
	
	if(!empty($tablename) && !empty($data_item) && is_array($data_item))
	{
	   $colname = implode(",",array_keys($data_item));
	   $colvalue = implode("','",array_values($data_item));
	   //print_r($colvalue);exit;
	   $sql="INSERT INTO ".$tablename."(".$colname.") VALUES ('".$colvalue."') WHERE ".$condition;
	   if(empty($condition)||$condition == ''){
			$sql = substr($sql,0,strlen($sql)-strlen('WHERE '));   
		}
	   //echo $sql;exit;
	   $q = $this->db->prepare($sql);
	   $insert = $q->execute();
		 if(!empty($insert))
		  {
			return TRUE;  
		  }
		  else
		  {
			return FALSE;  
		  }
	}
	else
	{
	  return false;	
	} 
  }	
  
  
  public function update($tablename,$data_item,$condition){
	$str = '';
	if(!empty($tablename)&&!empty($data_item) && is_array($data_item)){
	
	foreach($data_item as $x=>$x_value){
		$str = $str.$x." = '".$x_value."',";
			
	}	  
	$str = substr($str,0,strlen($str)-strlen(','));
	$sql = "UPDATE user SET ".$str." WHERE ".$condition;
	//echo $sql;exit;
	
	$q = $this->db->prepare($sql);
	$update = $q->execute();
	if(!empty($update)){
		return TRUE;	
	}else{
		
		return FALSE;	
	}
	}else{
		return FALSE;	
	}
	}
  public  function delrecord($table,$condition)
  {
	if(!empty($table))
	{ 
	   if(!empty($condition))
	   {
		  $sql="DELETE FROM ".$table." WHERE ".$condition;
		  //echo $sql;exit;
		  $stmt = $this->db->prepare($sql);
		  if( $stmt->execute() )
			{
			  return $stmt;	
			}
		  else
			{
			  return FALSE;	
			} 
	   }
	   else
	   {
		 echo"Please Enter The delete id ";   
	   }	
	}
	else
	{
	  echo"Please Enter the Table Name";	
	}  
  }
  
  public static function  getmaxid($table,$col)
  {
	$asrow="colid";
	//echo "Get max id success full";
	//echo $table."<br />".$col;  
    if(empty($table) || empty($col))
	{
	  echo"please fill table name and column name";	
	}
	else
	{
	  $sql ="SELECT MAX(".$col.") AS ".$asrow." FROM ".$table."";
	  $stmt = $this->db->prepare($sql);
	  $q = $stmt->execute();
	    if($q)
		{
		  return $stmt;	
		}
		else
		{
		  return false;
		}
	  //print_r($stmt);
	  
	}
  }
  
}

if(isset($_GET['delete'])){
	$obj = new Classcrud;
	//print_r($_GET);
	$condition = "img_id = '$_GET[delete]'";
	
	$obj->delrecord('images',$condition);
	echo "<script>window.location='gallery.php'</script>";
}
?>