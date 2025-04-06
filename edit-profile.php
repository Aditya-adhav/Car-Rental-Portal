<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['login'])==0) {  
    header('location:index.php');
} else {
    if(isset($_POST['update'])) {
        $fname=$_POST['fullname'];
        $mobileno=$_POST['mobileno'];
        $dob=$_POST['dob'];
        $address=$_POST['address'];
        $city=$_POST['city'];
        $country=$_POST['country'];
        $email=$_SESSION['login'];
        
        $sql="update tblusers set FullName=:fname,ContactNo=:mobileno,dob=:dob,Address=:address,City=:city,Country=:country where EmailId=:email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname',$fname,PDO::PARAM_STR);
        $query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
        $query->bindParam(':dob',$dob,PDO::PARAM_STR);
        $query->bindParam(':address',$address,PDO::PARAM_STR);
        $query->bindParam(':city',$city,PDO::PARAM_STR);
        $query->bindParam(':country',$country,PDO::PARAM_STR);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->execute();
        
        $msg="Profile Updated Successfully";
    }

    $useremail=$_SESSION['login'];
    $sql = "SELECT * from tblusers where EmailId=:useremail";
    $query = $dbh -> prepare($sql);
    $query -> bindParam(':useremail',$useremail, PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Car Rental Portal | Edit Profile</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/prettyPhoto.css" rel="stylesheet">
    <link href="assets/css/price-range.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">
    <style>
        /* Custom CSS for Edit Profile Page */
        .profile-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            position: relative;
        }
        
        .profile-header h2 {
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .profile-header:after {
            content: '';
            display: block;
            width: 80px;
            height: 3px;
            background: #4bc7ff;
            margin: 20px auto;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-control {
            height: 45px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-shadow: none;
            padding: 10px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #4bc7ff;
            box-shadow: 0 0 8px rgba(75, 199, 255, 0.2);
        }
        
        textarea.form-control {
            height: auto;
            min-height: 100px;
        }
        
        .btn-update {
            background: #4bc7ff;
            color: #fff;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            width: 100%;
            margin-top: 10px;
        }
        
        .btn-update:hover {
            background: #3aa8e0;
            transform: translateY(-2px);
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .profile-container {
                padding: 20px;
            }
            
            .profile-header h2 {
                font-size: 24px;
            }
        }
    </style>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="assets/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/ico/apple-touch-icon-57-precomposed.png">
</head>

<body>
    <?php include('includes/header.php');?>
    
    <section id="form"><!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="profile-container">
                        <div class="profile-header">
                            <h2>Edit Profile</h2>
                            <p>Update your personal information</p>
                        </div>
                        
                        <?php if(isset($msg)) { ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                        </div>
                        <?php } ?>
                        
                        <?php 
                        if($query->rowCount() > 0) {
                            foreach($results as $result) { ?>
                            <form method="post">
                                <div class="form-group">
                                    <label for="fullname">Full Name</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlentities($result->FullName);?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlentities($result->EmailId);?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="mobileno">Mobile Number</label>
                                    <input type="text" class="form-control" id="mobileno" name="mobileno" value="<?php echo htmlentities($result->ContactNo);?>" maxlength="10" required>
                                </div>
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlentities($result->dob);?>">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address"><?php echo htmlentities($result->Address);?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlentities($result->City);?>">
                                </div>
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" id="country" name="country" value="<?php echo htmlentities($result->Country);?>">
                                </div>
                                <button type="submit" name="update" class="btn btn-update">Update Profile</button>
                            </form>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/form-->
    
    <?php include('includes/footer.php');?>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.scrollUp.min.js"></script>
    <script src="assets/js/price-range.js"></script>
    <script src="assets/js/jquery.prettyPhoto.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
<?php } ?>