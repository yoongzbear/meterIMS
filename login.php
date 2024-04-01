<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTTO Aqua</title>
    <link href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
	<?php include 'header.php';?>


    <div class='container'>
        <form method="post" action="loginProcess.php">

        <h2>Please Log in</h2>
        <p>Log in to access your account and get start with water meter.</p>
            <div class="mb-3">
              <label>User Name</label>
              <input type="text" class="form-control" name= "username" placeholder="Enter your username" require>
            
            </div>
            <br>

            <div class="mb-3">
              <label >Password</label>
              <input type="password" class="form-control" name="password" placeholder="Enter your password" require>
            </div>
            <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">Remember me</label>
            </div>
            <br>
            <br>
            <button type="submit" >Log in</button>
        </form>
    </div>

</body>

<footer>
	<?php 'footer.php';?>
</footer>	

</html>

