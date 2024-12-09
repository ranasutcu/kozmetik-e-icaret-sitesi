<?php
session_start();


$users = array(
    "rana" => array("password" => "123", "role" => "yönetici")
);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["Kullaniciadi"];
    $password = $_POST["password"];

    
    if (isset($users[$username]) && $users[$username]["password"] == $password) {
        $_SESSION["username"] = $username;
        $_SESSION["role"] = $users[$username]["role"];
        header("Location: index.php"); // Kullanıcıyı yönlendir
        exit;
    } else {
        $loginError = "Geçersiz kullanıcı adı veya şifre!";
    }
}
?>

<html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>yönetici Girişi</title>
</head>
<body>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color:#f4f4f4 ;
}

	 .login-form {
    background-color: #ffb6c1; /* Arka plan rengi */
    padding: 20px;
    border-radius: 10px; /* Köşeleri yuvarlatma */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Gölge */
}

.login-form h2 {
    margin-top: 0;
}

.login-form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.login-form button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

table {
    margin: 0 auto;
}

td {
    padding: 10px;
    text-align: center;
}
</style>
</body>
    
    <?php if(isset($loginError)) { ?>
        <p><?php echo $loginError; ?></p>
    <?php } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<div class="container">
        <h1>Rana Kozmetik</h1>
		
		<div class="login-form">
            <h2>yönetici Girişi</h2>
	<table>
	 <tr>
         <td>Kullanıcı Adı:</td>  
         <td><input type="text" id="username" name="Kullaniciadi" placeholder="Kullanıcı Adı" required></td>  
     </tr>
	 <tr>
          <td>Şifre:</td>
          <td><input type="password" name="password" placeholder="Şifre" required></td>
        
	</tr>
         <tr>
            <td></td>
            <td><button type="submit" name="login">Giriş</button></td>
         </tr>	
     
		 </table>
		 </form>
        
	
		</div>	
		</div>
    

</html>
