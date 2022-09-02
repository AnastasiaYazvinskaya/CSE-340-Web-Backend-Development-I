<?php 
    if(!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 2){
        header('Location: /phpmotors/');
        exit;
    }

    $title = 'Add classification';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php';
?>

<form method="post" class="addItemForm" action="/phpmotors/vehicles/index.php">
    <?php
    if (isset($message)) {
    echo $message;
    }
    ?>

    <h1>Add Classification</h1>
    
    <ul>
        <li>
            <label for="classificationName">Car Classification Name: </label><span>is limited to 30 characters</span><br>
            <input type="text" id="classificationName" name="classificationName"
                maxlength="30"
                placeholder="Car Classification Name" required>
        </li>
    </ul>
    <input type="submit" name="submit" class="addItem" value="Add Classification">
    <!-- Add the action name - value pair -->
    <input type="hidden" name="action" value="newClassification">

</form>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>