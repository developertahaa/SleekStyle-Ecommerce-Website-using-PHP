<?php session_start(); ?>
<?php include('dbcon.php'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>


        <title>Sleek style - Admin Panel</title>

        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- Custom CSS -->
        <link href="css/startmin.css" rel="stylesheet">

    
        <nav class="navbar navbar-inverse">
              <div class="container-fluid">
                <div class="navbar-header">
                <a class="navbar-brand"</i>SleekStyle Admin Dashboard</a>
                </div>
                </nav>
				

        <div class="container">
		 <form action="#" method="post">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><center>Admin Login</center></h3>
                        </div>
                        <div class="panel-body">
                            <form role="form">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Username" name="user" type="text" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="pass" type="password" value="">
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        </label>
                                    </div>
                                     
                                    <input type="submit" class="btn btn-info btn-block" style="border-radius:0%;" title="Log In" name="login" value="Login"></input>
                                </fieldset>
                                
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
			</form>
			
			<?php
				if (isset($_POST['login']))
					{
						$username = mysqli_real_escape_string($conn, $_POST['user']);
						$password = mysqli_real_escape_string($conn, $_POST['pass']);
						
						$query 		= mysqli_query($conn, "SELECT * FROM admin WHERE  password='$password' and username='$username'");
						$row		= mysqli_fetch_array($query);
						$num_row 	= mysqli_num_rows($query);
						
						if ($num_row > 0) 
							{			
                                $_SESSION['admin_id'] = $row['id'];
                                $_SESSION['admin_login'] = $row['email'];
                                header("location: admin/index.php");
                                exit();
								
							}
						else
							{
								echo ' <div class="row"> <div class="col-md-4 col-md-offset-4">
								<div class="alert alert-danger alert-dismissible">
                                        Username & Password didnot match! Try Again.
                                    </div> </div> </div> ';
									
									
							}
					}
			  ?>
			
        </div> 