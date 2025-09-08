<?php require "includes/header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <?php if(isset($_SESSION['username'])): ?>
        <h1>Hello <?php echo $_SESSION['username']; ?></h1>
    <?php else : ?>
        <h1>Hello Guest User</h1>
    <?php endif; ?>
</body>
</html>

<?php require "includes/footer.php"; ?>