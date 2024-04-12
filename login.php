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

<header>
<?php 
include 'header.php';
include 'nav.php';
?>

</header>
    
<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php" title='Home'>Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">LogIn</li>
  </ol>
</nav>

    <div class='login-container'>
        <form method="post" action="loginProcess.php">

        <h2>Please Log in</h2>
        <p>Log in to access your account and get start with water meter.</p>
            <div class="enter">
              <label>User Name</label>
              <input type="text" class="form-control" name= "username" placeholder="Enter your username" require>
            
            </div>
            <br>

            <div class="enter">
              <label >Password</label>
              <input type="password" class="form-control" name="password" placeholder="Enter your password" require>
            </div>
            <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">Remember me</label>
            </div>
            <br>
            <button type="submit" class="btn btn-light">Log in</button>
        </form>
    </div>

</body>

<footer>
	<?php include 'footer.php';?>
</footer>	

</html>

