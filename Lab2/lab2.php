<?php
session_start();

$error_list = array(); 
$db = mysqli_connect('localhost', 'root', 'password', 'lab2');

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

if (isset($_POST['login'])) {
    $username = stripslashes($_REQUEST['username']);
    $password = stripslashes($_REQUEST['password']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

  if(empty($username)){
  	array_push($error_list, "Must enter a username");
  }
  if(empty($password)){
  	array_push($error_list, "Must enter a password");
  }

  if (empty($error_list)) {
  	//$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query) or die(mysql_error());
  	if (mysqli_num_rows($results) == 1) {
        
            echo "<div><h3>You are logged in successfully.</h3></div>";

  	  $_SESSION['username'] = $username;  	  
  	  header("Location: indexLogin.php");
  	}else {        
  		array_push($error_list, "Entered invalid Username or Password");
  	}
  }
}

//if condition for when the user clicks the register yourself etc. button
if (isset($_POST['reg'])) {
    $username = stripslashes($_REQUEST['username']);
    $password = stripslashes($_REQUEST['password']);
    $username = mysqli_real_escape_string($db, $_POST['username']);  
    $password = mysqli_real_escape_string($db, $_POST['password']);

  //form checking to ensure text fields have proper entries
  if(empty($username)){
      array_push($error_list, "Must enter a username"); 
  }
  if(empty($password)){ 
      array_push($error_list, "Must enter a password"); 
  }
  
  //check for duplicate usernames
    $sql_u = "SELECT * FROM users WHERE username='$username'";
    $res_u = mysqli_query($db, $sql_u);
   
    if (mysqli_num_rows($res_u) > 0){ 
         // Username already taken
         array_push($error_list, "Username already exists");
    } else {
        $query = "INSERT into `users` (username, password)
             VALUES ('$username', '".$password."')";    
         $results = mysqli_query($db, $query);
  	     $_SESSION['username'] = $username;
  	     $_SESSION['success'] = "You are now logged in";
  	     header('Location: indexLogin.php');        
    } 
} ?>
<!DOCTYPE html>
<html>
<head>
  <title>Torres Industries Login/Registration</title>
  <link rel="stylesheet" type="text/css" href="style.css">
    <script>        
        var count = 0;
        function colorChange(){
            if(count >= 3){
                count = 0;
                document.body.style.backgroundImage = "url('torresIndustries.png')";
            } else if(count === 0){
                count++;
                document.body.style.backgroundImage = "url('COOLtorresIndustries.png')";
            } else if(count === 1){
                count++;
                document.body.style.backgroundImage = "url('WARMtorresIndustries.png')";
            } else if(count == 2){
                count++;
                document.body.style.backgroundImage = "url('RetrotorresIndustries.png')";
            }
        }
    </script>
</head>
<body>    
  <div class="header">
  	<h2>Torres Industries Registration/Login</h2>
  </div>
	
  <form method="post">
  	<?php if (count($error_list) > 0) : ?>
        <div class="error">
  	     <?php foreach ($error_list as $error) : ?>
  	         <p><?php echo $error ?></p>
  	     <?php endforeach ?>
        </div>
    <?php  endif ?>
  	<div class="field">
  	  <label>Username</label>
  	  <input type="text" name="username">
      </div>
  	<div class="field">
  	  <label>Password</label>
  	  <input type="password" name="password">
  	</div>
  	
  	<div class="field">
  	  <button type="submit" class="button" name="reg">Register Yourself For The Future Of Mankind</button>
        <br>Already a member?<br>  
         <button type="submit" class="button" name="login">Sign in</button>
  	</div>
      <button type="button" class="buttoncolors" name="colorBtn" onclick="colorChange()">Keep Clicking To Alternate Through Themes</button>
  </form>        
</body>
</html>