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
      <li class="breadcrumb-item active" aria-current="page">Login</li>
    </ol>
  </nav>

  <div class="modal modal-sheet position-static d-block bg-body-secondary" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header p-5 pb-4 border-bottom-0">
          <h2 class="fw-bold mb-0 fs-2">Please Log In</h2>
        </div>

        <div class="modal-body p-5 pt-0">
          <form method='post' action="loginProcess.php">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" name= "username" placeholder="Enter your username" required>
              <label for="floatingInput">User Name</label>
            </div>
            <div class="form-floating mb-3">
              <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
              <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Log in</button>        
            <small class="text-body-secondary">By clicking Log in, you agree to the terms of use.</small>
            <hr class="my-4">
          </form>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <?php include 'footer.php';?>
  </footer>	

</body>
</html>