<?php
session_start();
include 'connection.php';
$date=date("Y-m-d");
// PHP code to find the number of days 
// between two given dates 
  
// Function to find the difference  
// between two dates. 
function dateDiffInDays($date1, $date2)  
{ 
    // Calculating the difference in timestamps 
    $diff = strtotime($date2) - strtotime($date1); 
      
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 
    return abs(round($diff / 86400)); 
} 
  
// Start date 
$date1 = $_POST['checkin']; 
// echo $date1;
  
// End date 
$date2 = $_POST['checkout']; 
// echo $date2;
// Function call to find date difference 
$dateDiff = dateDiffInDays($date1, $date2); 
// echo $dateDiff;
$month= abs(round($dateDiff/30));
// echo "month";
// echo $month;
$day=$dateDiff%30;
  if($_POST['checkin']<$_POST['checkout']&&$_POST['checkin']>=$date&&$_POST['no_of_rooms']>0)
  {
  	$checkin=mysqli_real_escape_string($conn, htmlspecialchars($_POST['checkin']));
    $a=date_create($checkin);
    $chi=date_format($a,"Y-m-d 01:00:00");
  	$checkout=mysqli_real_escape_string($conn, htmlspecialchars($_POST['checkout']));
    $b=date_create($checkout);
    $cho=date_format($b,"Y-m-d");
    //$cho1 = date('Y-m-d', strtotime($cho .' -1 day'));
    //echo $cho1;
    //echo $cho;
  	$type=mysqli_real_escape_string($conn, htmlspecialchars($_POST['type']));
    echo $type;
  	$no_of_rooms=mysqli_real_escape_string($conn, htmlspecialchars($_POST['no_of_rooms']));
    echo $no_of_rooms;
  	 $get_data = mysqli_query($conn,"SELECT * FROM `rooms` where `room_no` NOT in (SELECT `room_no` FROM `bookings` WHERE ((checkin_date <= '$chi' AND checkin_date <= '$cho') AND (checkout_date >= '$chi' AND checkout_date >= '$cho')) OR (checkin_date BETWEEN '$chi' AND '$cho' OR checkout_date BETWEEN '$chi' AND '$cho')) AND room_type_id='$type'");
    // $row=mysqli_fetch_array($get_data);
    //  print_r($get_data);
    //  while($row=mysqli_fetch_array($get_data))
    //  {
    //    print_r($row);
    //  }
     if(mysqli_num_rows($get_data) > 0) {
      if(mysqli_num_rows($get_data) >= $no_of_rooms){
       $get_prize= mysqli_query($conn,"SELECT `daily_rate`,`monthly_rate` FROM `room_type` WHERE `room_type_id`='$type' LIMIT 1");
       while ($row = mysqli_fetch_assoc($get_prize)) {
          $daily_price=$row['daily_rate'];
          $monthly_price=$row['monthly_rate'];
          //echo $rn;
          // echo $daily_price;
          // echo $monthly_price;
          
        }
        $daily_total=$daily_price*$day*$no_of_rooms;
        $monthly_total=$monthly_price*$month*$no_of_rooms;
        $total=$daily_total+$monthly_total;
        // echo $total;
        // echo $monthly_total;
        // $pri=$price*$dateDiff;
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">

	<title>Login Form</title>
</head>

<body>
	<div class="row">
		<div class="containers col-md-6 container-fluid">
			<form action="book_now.php" method="POST" class="login-email">
      <div>
				<p class="login-text" style="font-size: 2rem; font-weight: 800;">Room Available</p>
        <?php
        if (isset($_SESSION['email'])) {
          $email=$_SESSION['email'];
          $sql="SELECT * FROM `clients` WHERE c_e_mail='$email'";
          $result=mysqli_query($conn,$sql);
          while($row = mysqli_fetch_assoc($result)) {
          ?>
          <div style="display:none;">
            <div class="input-group">
            <input type="text" name="name" value="<?php echo $row['c_f_name'];?>" required>
            </div>
            <div class="input-group">
            <input type="email"  name="email" value="<?php echo $row['c_e_mail'];?>" required>
            </div>
            <div class="input-group">
              <input type="text"  name="mobile" value="<?php echo $row['c_mobile'];?>" required>
            </div>
            <div class="input-group">
              <input type="number"  name="cid" value="<?php echo $row['c_id'];?>" required>
            </div>
            <div class="col-md-6 form-group">
              <label class="text-black font-weight-bold" for="checkin_date">Date Check In</label>
              <input type="date" id="checkin_date1" value="<?php echo $_POST['checkin']?>" class="form-control" name="checkin" readonly>
            </div>
            <div class="col-md-6 form-group">
              <label class="text-black font-weight-bold" for="checkout_date">Date Check Our</label>
              <input type="date" id="checkout_date1"value="<?php echo $_POST['checkout']?>" class="form-control" name="checkout"readonly>
            </div>
            <div class="col-md-6 form-group">
              <label for="adults" class="font-weight-bold text-black">ROOM TYPE</label>
              <div class="field-icon-wrap">
                <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                <input name="type" id="types" value="<?php echo $_POST['type']?>"class="form-control" name="type" readonly> 
              </div>
            </div>
            <div class="col-md-6 form-group">
              <label for="children" class="font-weight-bold text-black">No_Of_Rooms</label>
              <div class="field-icon-wrap">
                <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                <input name="no_of_rooms" id="room_no" value="<?php echo $_POST['no_of_rooms']?>"class="form-control" name="no_of_rooms" readonly>
              </div>
            </div>
            <div class="col-md-12 form-group">
              <label for="children" class="font-weight-bold text-black">Total Payment</label>
              <div class="field-icon-wrap">
                <input name="total" id="total" value="<?php echo $total?>"class="form-control" name="no_of_rooms" readonly>
              </div>
            </div>
            <div class="col-md-12 form-group">
              <label for="children" class="font-weight-bold text-black">days</label>
              <div class="field-icon-wrap">
                <input name="days" id="days" value="<?php echo $dateDiff?>"class="form-control" name="no_of_rooms" readonly>
              </div>
            </div>
          </div>
          <p class="login-msg" style="font-size: 1rem;text-align:center;">Click on Book Now to book rooms</p>
          <br>
          <div class="input-group">
            <button name="submit" class="btn">Book Now</button>
          </div>
          <div class="input-group">
              <a href="login.php" class="btn" style="background:#d9534f	;">Back</a>
          </div>
        <?php
        }
      }
        else{
          ?>
        <p class="login-msg" style="font-size: 1rem;text-align:center;">First login to book rooms</p>
        <br>
        <div class="input-group">
					<a href="login.php" class="btn">Login</a>
				</div>
        <div class="input-group">
					<a href="login.php" class="btn" style="background:#d9534f	;">Back</a>
				</div>
        <?php
        }
        ?>
        </div>
				
			</form>
		</div>
	</div>
</body>

</html>
<?php
    }
  }
}
?>