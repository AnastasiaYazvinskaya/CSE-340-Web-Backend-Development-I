<?php 
    if(!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 2){
        header('Location: /phpmotors/');
        exit;
    }

    if(isset($invInfo['invMake'])){ 
        $title = "Delete $invInfo[invMake] $invInfo[invModel]";}

    require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; 
?>

<form method="post" class="addItemForm" action="/phpmotors/vehicles/index.php">
    <?php
    if (isset($message)) {
        echo $message;
    }
    ?>
    <h1><?php if(isset($invInfo['invMake'])){ 
	echo "Delete $invInfo[invMake] $invInfo[invModel]";} ?></h1>
    
    <p>Confirm Vehicle Deletion. The delete is permanent.</p>

    <ul>
        <li>
            <label for="invMake">Make:</label><br>
            <input type="text" id="invMake" name="invMake" 
                <?php if(isset($invInfo['invMake'])){echo "value='$invInfo[invMake]'";}  ?>
                readonly>
        </li>
        <li>
            <label for="invModel">Model:</label><br>
            <input type="text" id="invModel" name="invModel" 
                <?php if(isset($invInfo['invModel'])){echo "value='$invInfo[invModel]'";}  ?>
                readonly>
        </li>
        <li>
            <label for="invDescription">Description:</label><br>
            <textarea name="invDescription" id="invDescription" rows="3" readonly><?php if(isset($invInfo['invDescription'])){echo $invInfo['invDescription'];} ?></textarea>
        </li>
    </ul>
    <input type="submit" name="submit" class="deleteItem" value="Delete Vehicle">
    <!-- Add the action name - value pair -->
    <input type="hidden" name="action" value="deleteVehicle">
    <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} ?>">

</form>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>