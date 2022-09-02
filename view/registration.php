<?php 
    $title = 'Registration';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; 
?>

<?php
if (isset($message)) {
 echo $message;
}
?>

<form class="clientForm" id="registration" method="post" action="/phpmotors/accounts/">
    <h1>Registration</h1>
    
    <ul>
        <li>
            <label for="clientFirstname">Firstname:</label><br>
            <input type="text" id="clientFirstname" name="clientFirstname" 
                <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?>
                placeholder="Firstname" required>
        </li>
        <li>
            <label for="clientLastname">Lastname:</label><br>
            <input type="text" id="clientLastname" name="clientLastname" 
                <?php if(isset($clientLastname)){echo "value='$clientLastname'";}  ?>
                placeholder="Lastname" required>
        </li>
        <li>
            <label for="clientEmail">Email address:</label><br>
            <input type="email" id="clientEmail" name="clientEmail" 
                <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>
                placeholder="Email address" required>
        </li>
        <li>
            <label for="clientPassword">Password:</label><br>
            <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
            <input type="password" id="clientPassword" name="clientPassword" 
                placeholder="Password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
        </li>
    </ul>
    <input type="submit" name="submit" id="regbtn" class="submit" value="Register">
    <!-- Add the action name - value pair -->
    <input type="hidden" name="action" value="registerUser">

</form>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>