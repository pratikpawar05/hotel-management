<?php
include 'connection.php';
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');
session_start();
if (!isset($_SESSION['email'])) {
  header("Location: login.php");
}
$sql = "SELECT * FROM clients WHERE c_e_mail='" . $_SESSION['email'] . "'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$cid=$row['c_id'];
function Complaint($conn,$cid)
{
  $type_of_complaint = $_POST['type_of_complaint'];
  $complaints = $_POST['complaint'];
  $date = date("Y-m-d");
  $sql = "INSERT INTO `complaints`(`Complaint_Desc`, `Complaint_type`, `C_id`, `status`) VALUES ('$complaints','$type_of_complaint','$cid','pending')";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "<script>alert('Your Complaint sent to Our complaint Manager. We will resolve your complaint as soon as possible.')</script>";
  } else {
    echo "<script>alert('Woops! Something Wrong Went.')</script>";
  }
}
function Changepass($conn,$cid)
{
  $npass = $_POST['newpass'];
  $cpass = $_POST['confirmpass'];
  if($npass==$cpass)
  {
  $pass=md5($npass);
  $sql = "UPDATE `clients` SET `c_password`='$pass' WHERE c_id='$cid'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "<script>alert('Your Password Changed successfully.')</script>";
  } else {
    echo "<script>alert('Woops! Something Wrong Went.')</script>";
  }
}
else{
  echo "<script>alert('New Password and Confirm Password must be same!')</script>";
}
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  switch ($_POST['request']) {
    case 'logout':
      # code...
      session_destroy();
      header("Location: index.php");
      break;
    case 'Complaint':
      # code...
      Complaint($conn,$cid);
      break;
    case 'change':
      # code...
      Changepass($conn,$cid);
      break;
    default:
      # code...
      break;
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Morris Hostel
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="./assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="./assets/demo/demo.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
        <a href="https://www.creative-tim.com" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="./assets/img/logo-small.png">
          </div>
          <!-- <p>CT</p> -->
        </a>
        <a href="https://www.creative-tim.com" class="simple-text logo-normal">
            <?php echo $row['c_f_name']." ".$row['c_l_name']; ?>
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <!-- <li>
            <a href="./dashboard.html">
              <i class="nc-icon nc-bank"></i>
              <p>Dashboard</p>
            </a>
          </li> -->
          <li class="">
            <a href="./index.php">
              <i class="nc-icon nc-single-02"></i>
              <p>Home</p>
            </a>
          </li>
          <li class="">
            <a href="./user.php">
              <i class="nc-icon nc-single-02"></i>
              <p>User Profile</p>
            </a>
          </li>
          <li class="">
            <a href="./complaints.php">
              <i class="nc-icon nc-single-02"></i>
              <p>Complaints</p>
            </a>
          </li>
          <li class="">
            <a href="./mybookings.php">
              <i class="nc-icon nc-single-02"></i>
              <p>My Bookings</p>
            </a>
          </li>
          <li class="">
            <a href="./changepass.php">
              <i class="nc-icon nc-single-02"></i>
              <p>Change Password</p>
            </a>
          </li>
          <li class="">
            <form action="" method="post">
              <input type="submit" class="form-control" name="request" value="logout">
            </form>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:;">Moris Hostel</a>
          </div>
          <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button> -->
          <!-- <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="nc-icon nc-zoom-split"></i>
                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link btn-magnify" href="javascript:;">
                  <i class="nc-icon nc-layout-11"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li>
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-bell-55"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link btn-rotate" href="javascript:;">
                  <i class="nc-icon nc-settings-gear-65"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
                </a>
              </li>
            </ul>
          </div> -->
        </div>
      </nav>
      <!-- End Navbar -->