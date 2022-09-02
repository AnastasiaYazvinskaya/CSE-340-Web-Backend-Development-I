<?php 
    if(!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 2){
        header('Location: /phpmotors/');
        exit;
    }

    $title = 'Add vehicle';
    
    //Build the select list
    $selectList = '<select size="1" id="classificationId" name="classificationId"><option disabled>Choose Car Classification</option>';
    foreach ($classifications as $classification) {
        $selectList .= "<option value='$classification[classificationId]'";
        if(isset($classificationId)){
            if($classification['classificationId'] === $classificationId){
            $selectList .= ' selected';
            }
        }
        $selectList .= ">$classification[classificationName]</option>";
    }
    $selectList .= '</select>';
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>

<form method="post" class="addItemForm" action="/phpmotors/vehicles/">
    <?php
    if (isset($message)) {
        echo $message;
    }
    ?>
    <h1>Add Vehicle</h1>
    
    <h3>*Note all Fields are Required</h3>

    <ul>
        <li>
            <label for="classificationId">Car Classification:</label><br>
            <?php 
                if (!empty($selectList)) {
                    echo $selectList;
                }
            ?>
        </li>
        <li>
            <label for="invMake">Make:</label><br>
            <input type="text" id="invMake" name="invMake" 
                <?php if(isset($invMake)){echo "value='$invMake'";}  ?>
                required>
        </li>
        <li>
            <label for="invModel">Model:</label><br>
            <input type="text" id="invModel" name="invModel" 
                <?php if(isset($invModel)){echo "value='$invModel'";}  ?>
                required>
        </li>
        <li>
            <label for="invDescription">Description:</label><br>
            <textarea name="invDescription" id="invDescription" rows="3" required><?php if(isset($invDescription)){echo $invDescription;}  ?></textarea>
        </li>
        <li>
            <label for="invImage">Image:</label><br>
            <input type="text" id="invImage" name="invImage" value="/phpmotors/images/no-image.png" 
                <?php if(isset($invImage)){echo "value='$invImage'";}  ?>
                required>
        </li>
        <li>
            <label for="invThumbnail">Thumbnail:</label><br>
            <input type="text" id="invThumbnail" name="invThumbnail" value="/phpmotors/images/no-image.png" 
                <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";}  ?>
                required>
        </li>
        <li>
            <label for="invPrice">Price:</label><br>
            <input type="number" id="invPrice" name="invPrice" 
                <?php if(isset($invPrice)){echo "value='$invPrice'";}  ?>
                required>
        </li>
        <li>
            <label for="invStock">Stock:</label><br>
            <input type="number" id="invStock" name="invStock" 
                <?php if(isset($invStock)){echo "value='$invStock'";}  ?>
                required>
        </li>
        <li>
            <label for="invColor">Color:</label><br>
            <input type="text" id="invColor" name="invColor" 
                <?php if(isset($invColor)){echo "value='$invColor'";}  ?>
                required>
        </li>
        
    </ul>
    <input type="submit" name="submit" class="addItem" value="Add Vehicle">
    <!-- Add the action name - value pair -->
    <input type="hidden" name="action" value="newVehicle">

</form>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>