<?php

include_once '../connection.php';
session_start();

if (isset($_POST['submit'])) {
	$type_of_registration = $_POST['type_of_registration'];
	$first_name = $_POST['f_name'];
	$last_name = $_POST['l_name'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	if($_POST['password']!=$_POST['confirm-password']){
		echo "<script>alert('Woops! Password Doest Match Confirm Password.')</script>";
	}else{
        if (empty($type_of_registration)) {
            echo "<script>alert('Woops! Plz Be Sure To select Type Of Registration.')</script>";
            return;
        }
        $sql = "SELECT * FROM staffs WHERE c_e_mail='$email'";
        $result = mysqli_query($conn, $sql);
        if (!$result->num_rows > 0) {
            $date = date("Y-m-d");
            $sql = "INSERT INTO staffs (s_type_id,s_f_name, s_l_name,s_e_mail,s_status, s_password,s_created_at) VALUES ('$type_of_registration','$first_name','$last_name', '$email', '0','$password','$date')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('Wow! Staff Registration Completed.')</script>";
                header("Location: login.php");
            } else {
				print_r(mysqli_error($conn));
                echo "<script>alert('Woops! Something Wrong Went.')</script>";
            }
        } else {
            echo "<script>alert('Woops! Email Already Exists.')</script>";
        }
    }
}
if (isset($_SESSION['staff'])) {
	header("Location: admin.php");
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="../style.css">

	<title>Registration</title>
</head>

<body>
	<div class="container">
		<div class="row" style="padding-left: 200px;padding-right: 200px;;">
			<div class="containers">
				<form action="" method="POST" class="login-email">
					<p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
					<div class="row">
						<div class="col-md-6">
							<div class="input-group">
								<input type="text" placeholder="First Name*" name="f_name" value="" required pattern="[a-zA-Z]+" title="Please Enter First Name In Correct Format">
							</div>
							<div class="input-group">
								<input type="text" placeholder="Last Name*" name="l_name" value="" required pattern="[a-zA-Z]+" title="Please Enter Last Name In Correct Format">
							</div>
							<div class="input-group">
								<select id="type_of_registration" name="type_of_registration" class="form-control custom-select bg-white border-left-0 border-md select-box">
									<option value="">Enter Type Of Registration&#42</option>
									<option value="2">Room Staff</option>
									<option value="3">Food Staff</option>
									<option value="9">Complaint Admin</option>
								</select>
							</div>

							<!-- <div class="input-group">
								<input type="text" placeholder="Enter Mobile" name="mobile" value="" required>
							</div>
							<div class="input-group">
								<input type="date" placeholder="Enter DOB" name="dob" value="" required>
							</div> -->
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<input type="email" placeholder="Email*" name="email" value="" required>
							</div>
							<div class="input-group">
								<input type="password" placeholder="Password*" name="password" value="" required>
							</div>
							<div class="input-group">
								<input type="password" placeholder="Confirm Password*" name="confirm-password" value="" required>
							</div>
							<!-- <div class="input-group">
								<input type="number" placeholder="Enter NIC" name="nic" value="" required>
							</div>
							<div class="input-group">
								<input type="text" placeholder="Enter Postal Code" name="postal_code" value="" required>
							</div>
							<div class="input-group">
								<input type="text" placeholder="Enter City" name="city" value="" required>
							</div>
							<div class="input-group">
								<select id="gender" name="gender" class="form-control custom-select bg-white border-left-0 border-md select-box">
									<option value="">Enter Gender</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
									<option value="Transgender">Transgender</option>
								</select>
							</div> -->

						</div>
						<!-- <div class="input-group">
							<input type="text" placeholder="Enter Address" name="address" value="" required>
						</div> -->
						<div class="input-group">
							<button name="submit" class="btn">Register</button>
						</div>
						<p class="login-register-text">Have an account? <a href="login.php">Login Here</a>.</p>
					</div>
				</form>
			</div>

		</div>
	</div>
</body>

</html>