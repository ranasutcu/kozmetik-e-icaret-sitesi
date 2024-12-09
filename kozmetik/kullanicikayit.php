<?php
session_start();
$userDataFile = 'users.json';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (!empty($username) && !empty($password)) {
  
        if (!isUsernameExists($username)) {
          
            $userData = array("username" => $username, "password" => $password);
            saveUserData($userData);
            $_SESSION["username"] = $username;
            $_SESSION["role"] = "user";
            header("Location: index.php"); 
            exit;
        } else {
            $registerError = "Bu kullanıcı adı zaten kullanılıyor!";
        }
    } else {
        $registerError = "Kullanıcı adı ve şifre gereklidir!";
    }
}


function isUsernameExists($username) {
    global $userDataFile;
    $usersData = getUsersData();
    foreach ($usersData as $userData) {
        if ($userData['username'] == $username) {
            return true;
        }
    }
    return false;
}

function saveUserData($userData) {
    global $userDataFile;
    $usersData = getUsersData();
    $usersData[] = $userData;
    file_put_contents($userDataFile, json_encode($usersData));
}


function getUsersData() {
    global $userDataFile;
    if (file_exists($userDataFile)) {
        $usersData = file_get_contents($userDataFile);
        return json_decode($usersData, true);
    } else {
        return array();
    }
}
?>

<html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
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
	<div class="container">
        <h1>Rana Kozmetik</h1>
    
    <?php if(isset($registerError)) { ?>
        <p><?php echo $registerError; ?></p>
    <?php } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<div class="login-form">
        <h2>Kayıt Ol</h2> 
	<table>
	<tr>
        <td><label for="username">Kullanıcı Adı:</label></td>
        <td><input type="text" id="username" name="username"></td>
	</tr>	
	<tr>
        <td><label for="password">Şifre:</label></td>
        <td><input type="password" id="password" name="password"></td>
	</tr>	
       <tr>
            <td></td>
            <td><button type="submit" name="login">kayıt ol </button></td>
         </tr>	
			 </table>
    </form>
	</div>
     </div>
</html>