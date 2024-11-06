<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./view/assets/fav.png" type="image/png">
    <link rel="stylesheet" href="./view/style/login.css">
    <link rel="stylesheet" href="./view/bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/81aebbec1d.js" crossorigin="anonymous"></script>
    <title>Login page</title>
</head>
<body> 
    <div class='login-body'>
        <div class="wrapper">
            <form action="./models/security.php" method="post">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" placeholder="id" id="id" name="id" class="<?php echo isset($_GET['error']) && $_GET['error'] == 'id' ? 'border-danger' : '' ?>" required >
                    <i class="fa-solid fa-user <?= isset($_GET['error']) && $_GET['error'] == 'id' ? 'text-danger' : '' ?>"></i>
                </div>
                <div class="input-box">
                    <input type="password" id="password" placeholder="Password" name="password" class="<?php echo isset($_GET['error']) && $_GET['error'] == 'password' ? 'border-danger' : '' ?>" required >
                    <i class="fa-solid fa-lock <?= isset($_GET['error']) && $_GET['error'] == 'password' ? 'text-danger' : '' ?>"></i>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox" name="rememberme">Remember Me</label>
                </div>
                <button type="submit" class="btn" style="margin-bottom: 10px;" name="login">Login</button>
                <button class="btn" type="button" style="margin-bottom: 10px;" onclick="fillAdmin()">admin</button>
                <button class="btn" type="button" style="margin-bottom: 10px;" onclick="fillFormateur()">formateur</button>
            </form>
        </div>
    </div>
    <script>
        const id = document.getElementById("id")
        const password = document.getElementById("password")
        const fillAdmin = () => {
            id.value = '123'
            password.value = '123'
        }
        const fillFormateur = () => {
            id.value = '111'
            password.value = '111'
        }
    </script>
</body>
</html>