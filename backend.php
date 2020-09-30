<?php
//CREATING DATABASE CONNECTION
    $dbserver="localhost";
	$dbusername="root";
	$dbpassword="";
	$database="hotel";

	$conn=mysqli_connect($dbserver,$dbusername,$dbpassword,$database);

    	if(isset($_POST['submit_reg'])){
			$fullname=$_POST['fullname'];
			$gender=$_POST['gender'];
			$id=$_POST['ID/Passport'];
			$phoneNo=$_POST['phoneNo'];
			$email=$_POST['email'];
			$from=$_POST['from'];
			$to=$_POST['to'];
			$roomType=$_POST['roomdescription'];
			$payment=$_POST['payment'];

			if(!$conn){
				die("Connection not successful");
			}
			else{
				$sql="INSERT INTO `registration`(`name`,`gender` ,`id`, `phoneNo`, `email`, `check_in`, `check_out`, `roomType`, `paymentMethod`)  VALUES ('$fullname','$gender','$id','$phoneNo','$email','$from','$to','$roomType','$payment')";
				
				mysqli_query($conn,$sql);
				//echo "Registration successful";

				session_start();
				$_SESSION['fullname']=$fullname;
				header("location: successful.php");
				//die();
				}

			/*PRODUCING CSV REPORT*/
			$error='';
			$name='';
		    $gender='';
		    $id_passport='';
			$phone='';
			$email='';
			$from='';
			$to='';
			$payment='';
			$room='';	

			function clean_text($string){
				//Removes white spaces
				$string=trim($string);
				//Removes backslashes
				$string=stripslashes($string);
				//Converts predefined characters to html
				$string=htmlspecialchars($string);

				return $string;
			}

			   $name=clean_text($_POST['fullname']);
			   $thegender=clean_text($_POST['gender']);
			   $theemail=clean_text($_POST['email']);
			   $phone=clean_text($_POST['phoneNo']);
			   $id_passport=clean_text($_POST['ID/Passport']);
		       $rfrom=clean_text($_POST['from']);
		       $rto=clean_text($_POST['to']);
			   $thepayment=clean_text($_POST['payment']);
			   $room=clean_text($_POST['roomdescription']);

				$file_open=fopen("report.csv","a");
				$no_rows=count(file("report.csv"));
				if($no_rows>1){
					$no_rows=($no_rows-1)+1;//Generates serial number
				}
				$form_data=array(
				'serial_no' =>$no_rows,
				'name' =>$name,
				'gender'=>$thegender,
				'id/passport' =>$id_passport,
				'phoneNo' =>$phone,
				'email' =>$theemail,
				'Reservation from' =>$rfrom,
				'Reservation to' =>$rto,
				'Mode of payment' =>$thepayment,
				'Type of room' =>$room
				);
				fputcsv($file_open,$form_data);

				$name='';
				$gender='';
				$id_passport='';
				$phone='';
				$email='';
				$from='';
				$to='';
				$payment='';
				$room='';	
			
}

	
		if(isset($_POST['submit_log'])){
			$name=$_POST['name'];
			$password=$_POST['password'];

			$hashpassword=sha1($password);

			$select="SELECT * FROM login WHERE Name='".$name."' AND Password='".$password."' limit 0,2";
			$result=mysqli_query($conn,$select);

			//name of cookie,value,expiry date,path,domain,security(1-secure or 0)

			if(mysqli_num_rows($result)==1){
				if(isset($_POST['remember'])){
					setcookie('name',$name,time()+3600);
				}
				session_start();
				$_SESSION['name']=$name;
				header("location: welcome.php");
				die();
			}
			else{
				echo "Incorrect username or password <br/> <a href='login.html'>Try Again</a>";
				die();
				}

		}
   



?>