<?php 
    session_start();     
  ?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
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
	<h2>Home Page</h2>
</div>    
<div class="content">
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
        
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>    	
    <?php endif ?>
    <?php 
    $user = $_SESSION['username'];
    $admin = "Administrator";
    if($user == $admin){
        $db = mysqli_connect('localhost', 'root', 'password', 'lab2');

        if (mysqli_connect_errno())
          {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }
        $query = "SELECT username, password FROM users ORDER BY username ASC";
        $result = mysqli_query($db, $query);
        echo "<table border='1'>
            <tr>
            <th>Username</th>
            <th>Password</th>
            </tr>";
        while($row = mysqli_fetch_array($result))
        {
        echo "<tr>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['password'] . "</td>";
        echo "</tr>";
        }
        echo "</table>";
    } ?>
    <img id = "successImg" src="torresLab2Success.png" alt="TorresSuccessImage">
    <p> <a href="lab2.php?logout='1'" style="color: red;">logout</a> </p>
    <button type="button" class="buttoncolors" name="colorBtn" onclick="colorChange()">Keep Clicking To Alternate Through Themes</button>
</div>
     </body>
</html>