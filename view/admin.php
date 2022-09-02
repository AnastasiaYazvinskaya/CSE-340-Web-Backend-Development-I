<?php 
    if(!isset($_SESSION['loggedin'])){
        header('Location: /phpmotors/');
        exit;
    }

    $title = $_SESSION['clientData']['clientFirstname'] . ' ' . $_SESSION['clientData']['clientLastname'];
    require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; 
?>

<h1><?php echo print_r($_SESSION['clientData']['clientFirstname'], true) . ' ' . print_r($_SESSION['clientData']['clientLastname'], true);?><span>(logged in)</span></h1>

<?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
    }
?>

<ul>
    <li>First name: <?php echo print_r($_SESSION['clientData']['clientFirstname'], true);?></li>
    <li>Last name: <?php echo print_r($_SESSION['clientData']['clientLastname'], true);?></li>
    <li>Email: <?php echo print_r($_SESSION['clientData']['clientEmail'], true);?></li>
</ul>

<h3>Account Management</h3>
<p>If you need to update your personal information, use the <a <?php echo "href='/phpmotors/accounts?action=mod&clientId=" . print_r($_SESSION['clientData']['clientId'], true) . "'";?> title='Click to modify'>Account Management (Update)</a></p>

<?php 
    if($_SESSION['clientData']['clientLevel'] > 1) {
        echo '<h3>Inventory Management</h3>';
        echo '<p>Because your client level is greater than 1, you can use the <a href="/phpmotors/vehicles/">Vehicle Management</a>.</p>';
    }
?>


<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>