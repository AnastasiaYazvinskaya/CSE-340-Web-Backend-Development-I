<?php 
    if(!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 2){
        header('Location: /phpmotors/');
        exit;
    }

    $title = 'Vehicle Management';

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
    }
    require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php';
?>

<h1>Vehicle Management</h1>

<ul>
    <li><a href="/phpmotors/vehicles/index.php?action=addClassification">Add Classification</a></li>
    <li><a href="/phpmotors/vehicles/index.php?action=addVehicle">Add Vehicle</a></li>
</ul>

<?php
    if (isset($message)) { 
        echo $message; 
    } 
    if (isset($classificationList)) { 
        echo '<h2>Vehicles By Classification</h2>'; 
        echo '<p>Choose a classification to see those vehicles</p>'; 
        echo $classificationList; 
    }
?>
<noscript>
<p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
</noscript>

<table id="inventoryDisplay"></table>



<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>