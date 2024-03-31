<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

  <?php
    include('connection.php');
    session_start();

    if (isset($_POST['username'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $sql = "SELECT * FROM useraccount WHERE username = '$username' AND password = '$password'";
      $result = mysqli_query($connection, $sql);

      // Check if there is a matching user
      if (mysqli_num_rows($result) == 1) {
      // Fetch user information
      $row = mysqli_fetch_assoc($result);
      $_SESSION['username'] = $username;
      $_SESSION['emp_type'] = $row['emp_type'];
      $_SESSION['name'] = $row['name'];
  
        // Determine the home page based on emp_type
        if ($_SESSION['emp_type'] == 'region store') {
          // Redirect admins to admin home page
          header('Location: reg_home.php');
          exit();
        } elseif ($_SESSION['emp_type'] == 'contractor') {
          // Redirect employees to employee home page
          header('Location: con_home.php');
          exit();
        } elseif ($_SESSION['emp_type'] == 'lab tester') {
          // Redirect employees to employee home page
          header('Location: lab_home.php');
          exit();

        } else {
        // Redirect other to inventory department home page
        header('Location: inv_mag_home.php');
        exit();
      }

    } else {
          // User does not exist, show error message
          echo "<script>
                  alert('The username and the password is not match. Pleas try again');
                  window.location='login.php';
                </script>";
          exit();
      }
  }
  ?>

  </head>
  <body>
    <div>
        <form method="post" action="login.php">
            <div>
              <label>User Name</label>
              <input type="text" class="form-control" name= "username" placeholder="Enter your username">
            
            </div>
            <div>
              <label >Password</label>
              <input type="password" name="password" placeholder="Enter your password">
            </div>
            <button type="submit" >Login</button>
        </form>
    </div>


  </body>
</html>