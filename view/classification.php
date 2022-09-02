<?php 
    $title = $classificationName . ' vehicles | PHP Motors, Inc.';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; 
?>

<h1><?php echo $classificationName; ?> vehicles</h1>

<?php 
    if(isset($message)){
        echo $message; 
    }
?>

<?php 
    if(isset($vehicleDisplay)){
        echo $vehicleDisplay;
    }
?>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>