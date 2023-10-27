<?php 

if (!(isset($_SESSION['username']) && $_SESSION['username'] === $username)) {
    header("Location:/webauth/app/views/unauthorized-access.php");
    exit();
}


if (isset($_SESSION['usersData'])) {
    $users=$_SESSION['usersData'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Welcome to the Dashboard  <span class="text-success"><?php echo $_SESSION['username'] ?></span></h2>
        <p>You are logged in! <a href="index.php?page=logout">Logout</a></p> 

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Your Details:</h5>
                <p class="card-text">

                    <?php foreach ($users as $user): ?>
                        <strong>Username: </strong> <?php echo $user['username']; ?><br>
                        <strong>Email:</strong> <?php echo $user['email']; ?><br>
                        <strong>Address</strong> <?php echo $user['address']; ?><br>
                        <strong>Balance</strong> <?php echo $user['balance']; ?><br>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS (Optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
