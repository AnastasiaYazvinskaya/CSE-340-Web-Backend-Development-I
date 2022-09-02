<?php 
    $title = "vehicle";//$invInfo['invMake'] $invInfo['invModel'] . ' | PHP Motors, Inc.';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; 
?>

<?php 
    if(isset($message)){
        echo $message; 
    }
?>

<?php 
    if(isset($invInfoDisplay)){
        echo $invInfoDisplay;
    }
?>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>