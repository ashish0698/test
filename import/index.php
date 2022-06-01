<?php
$con=mysqli_connect('localhost','root','','youtube');

 $squery = mysqli_query($con,"SELECT * FROM user");
 $re = mysqli_fetch_array($squery);
 ?>
 <input type="text" name="ok" value="<?php echo $re['name'];?>">
  <input type="text" name="ok" value="img/<?php echo $re['photo'];?>.jpg">
  <img src="img/<?php echo $re['photo'];?>">

 <?php
// if ($squery) {
// 	echo "sucessfuly databse";
// }else{
// 	echo "failed";
// }

if(isset($_POST['submit'])){
	$file=$_FILES['doc']['tmp_name'];
	
	$ext=pathinfo($_FILES['doc']['name'],PATHINFO_EXTENSION);
	if($ext=='xlsx'){
		require('PHPExcel/PHPExcel.php');
		require('PHPExcel/PHPExcel/IOFactory.php');
		
		
		$obj=PHPExcel_IOFactory::load($file);
		foreach($obj->getWorksheetIterator() as $sheet){
			$getHighestRow=$sheet->getHighestRow();
			for($i=0;$i<=$getHighestRow;$i++){
				$name=$sheet->getCellByColumnAndRow(0,$i)->getValue();
				$email=$sheet->getCellByColumnAndRow(1,$i)->getValue();
				$img=$sheet->getCellByColumnAndRow(2,$i)->getValue();

				if($email!=''){
					mysqli_query($con,"insert into user(name,email,photo) values('$name','$email','$img')");
				}
			}
		}
	}else{
		echo "Invalid file format";
	}
}



?>

<form method="post" enctype="multipart/form-data">
	<input type="file" name="doc"/>
		<input type="text" name="fname"/>

	<input type="submit" name="submit"/>
</form>

