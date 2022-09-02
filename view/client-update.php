<?php 
    if(!isset($_SESSION['loggedin'])){
        header('Location: /phpmotors/');
        exit;
    }

    $title = 'Client Update';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; 
?>

<h1>Modify <?php echo $_SESSION['clientData']['clientFirstname'] . ' ' . $_SESSION['clientData']['clientLastname'];?></h1>

<form method="post" action="/phpmotors/accounts/">
    <h2>Account Update</h2> 
    <?php
        if (isset($accountMessage)) {
            echo $accountMessage;
        }
    ?>
    <ul>
        <li>
            <label for="clientFirstname">Firstname:</label><br>
            <input type="text" id="clientFirstname" name="clientFirstname" 
                <?php if(isset($clientFirstname)) {echo "value='$clientFirstname'"; } elseif(isset($clientInfo['clientFirstname'])){echo "value='".$clientInfo['clientFirstname']."'";} elseif(isset($_SESSION['clientData']['clientFirstname'])){echo "value='".$_SESSION['clientData']['clientFirstname']."'";} ?>
                placeholder="Firstname" required>
        </li>
        <li>
            <label for="clientLastname">Lastname:</label><br>
            <input type="text" id="clientLastname" name="clientLastname" 
                <?php if(isset($clientLastname)) {echo "value='$clientLastname'"; } elseif(isset($clientInfo['clientLastname'])){echo "value='".$clientInfo['clientLastname']."'";} elseif(isset($_SESSION['clientData']['clientLastname'])){echo "value='".$_SESSION['clientData']['clientLastname']."'";} ?>
                placeholder="Lastname" required>
        </li>
        <li>
            <label for="clientEmail">Email address:</label><br>
            <input type="email" id="clientEmail" name="clientEmail" 
                <?php if(isset($clientEmail)) {echo "value='$clientEmail'"; } elseif(isset($clientInfo['clientEmail'])){echo "value='".$clientInfo['clientEmail']."'";} elseif(isset($_SESSION['clientData']['clientEmail'])){echo "value='".$_SESSION['clientData']['clientEmail']."'";} ?>
                placeholder="Email address" required>
        </li>
    </ul>
    <input type="submit" name="submit" class="submitForm" value="Update Client Info">
    <!-- Add the action name - value pair -->
    <input type="hidden" name="action" value="updateUser">
    <input type="hidden" name="accClientId" value="<?php if(isset($_SESSION['clientData']['clientId'])){ echo $_SESSION['clientData']['clientId'];} 
        elseif(isset($clientInfo['clientId'])){ echo $clientInfo['clientId']; } ?>">
</form>

<form method="post" action="/phpmotors/accounts/">
    <h2>Change Password</h2>
    <?php
        if (isset($passwordMessage)) {
            echo $passwordMessage;
        }
    ?>
    <ul>
        <li>
            <label for="clientPassword">New password:</label><br>
            <span>By entering a password it will change the current password. Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
            <input type="password" id="clientPassword" name="clientPassword" 
                placeholder="Password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
        </li>
    </ul>
    <input type="submit" name="submit" class="submitForm" value="Update Password">
    <!-- Add the action name - value pair -->
    <input type="hidden" name="action" value="changePassword">
    <input type="hidden" name="pasClientId" value="<?php if(isset($_SESSION['clientData']['clientId'])){ echo $_SESSION['clientData']['clientId'];} 
        elseif(isset($clientInfo['clientId'])){ echo $clientInfo['clientId']; } ?>">
</form>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>