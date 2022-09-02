<?php 
    $title = 'Log in';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; 
?>

<?php

if (isset($message)) {
    echo $message;
}

if (isset($_SESSION['message'])) {
 echo $_SESSION['message'];
}
//echo $clientData;
//echo '<pre>' . print_r($_SESSION, true) . '</pre>';
?>

<form class="clientForm" id="login" method="post" action="/phpmotors/accounts/">
    <h1>Login</h1>
    
    <ul>
        <li>
            <label for="clientEmail">Login:</label><br>
            <input type="email" id="clientEmail" name="clientEmail" 
                <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>
                required>
        </li>
        <li>
            <label for="clientPassword">Password:</label><br>
            <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
            <input type="password" id="clientPassword" name="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
        </li>
    </ul>
    
    <input type="submit" name="submit" id="loginbtn" class="submit" value="Login">
    <input type="hidden" name="action" value="loginUser">
    
    <p>No account? <a href="/phpmotors/accounts/index.php?action=register" id="register">Sign-up</a></p>
</form>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>