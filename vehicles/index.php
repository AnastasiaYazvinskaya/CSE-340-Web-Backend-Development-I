<?php
// The Vehicle controller

    //Create or access a Session
    session_start();

    // Get the database connection file
    require_once '../library/connections.php';
    // Get the PHP Motors model for use as needed
    require_once '../model/main-model.php';
    // Get the Vehicle Model
    require_once '../model/vehicle-model.php';
    // Get the Uploads Model
    require_once '../model/uploads-model.php';
    // Get the functions library
    require_once '../library/functions.php';


    // Get the array of classifications
	$classifications = getClassifications();

    // Build a navigation bar using the $classifications array
    //$navList = '<ul>';
    //$navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
    //foreach ($classifications as $classification) {
    //    $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    //}
    //$navList .= '</ul>';
    $navList = createNavlist($classifications);

    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }

    switch ($action){
        case 'addClassification':
            include '../view/addClassification.php';
            break;
        case 'addVehicle':
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

            include '../view/addVehicle.php';
            break;
        case 'newClassification':
            // Filter and store the data
            $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            
            // Check for missing data
            if(empty($classificationName)){
                $message = '<p class="messageError">Please provide information for all empty form fields.</p>';
                include '../view/addClassification.php';
                exit; 
            }

            // Send the data to the model
            $addingOutcome = newClassification($classificationName, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Check and report the result
            if($addingOutcome === 1){
                $classifications = getClassifications();
                // Build a navigation bar using the $classifications array
                $navList = '<ul>';
                $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
                foreach ($classifications as $classification) {
                    $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
                }
                $navList .= '</ul>';
                include '../view/vehicleManagement.php';
                exit;
            } else {
                $message = "<p class='messageError'>Sorry, but adding the $classificationName failed. Please try again.</p>";
                include '../view/addClassification.php';
                exit;
            }

            break;
        case 'newVehicle':
            // Filter and store the data
            $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
            $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
            $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $classificationId = filter_input(INPUT_POST, 'classificationId');
            
            
            // Check for missing data
            if(empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)){
                $message = '<p class="messageError">Please provide information for all empty form fields.</p>';
                // Build a navigation bar using the $classifications array
                $selectList = '';
                foreach ($classifications as $classification) {
                    $selectList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
                }
                include '../view/addVehicle.php';
                exit; 
            }

            // Send the data to the model
            $addingOutcome = newVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

            // Check and report the result
            if($addingOutcome === 1){
                $message = "<p class='messageSuccess'> $invMake $invModel was successfuly added. </p>";
                include '../view/addVehicle.php';
                exit;
            } else {
                $message = "<p class='messageError'>Sorry, but adding the $invMake $invModel failed. Please try again.</p>";
                // Build a navigation bar using the $classifications array
                $selectList = '';
                foreach ($classifications as $classification) {
                    $selectList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
                }
                include '../view/addVehicle.php';
                exit;
            }

            break;
        /* * ********************************** 
        * Get vehicles by classificationId 
        * Used for starting Update & Delete process 
        * ********************************** */ 
        case 'getInventoryItems': 
            // Get the classificationId 
            $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
            // Fetch the vehicles by classificationId from the DB 
            $inventoryArray = getInventoryByClassification($classificationId); 
            // Convert the array to a JSON object and send it back 
            echo json_encode($inventoryArray); 
            break;
        case 'mod':
            $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
            $invInfo = getInvItemInfo($invId);
            if(count($invInfo)<1){
                $message = 'Sorry, no vehicle information could be found.';
            }
            include '../view/vehicle-update.php';
            exit;
            break;
        case 'updateVehicle':
            $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
            $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
            $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

            if (empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
                $message = '<p>Please complete all information for the updated item! Double check the classification of the item.</p>';
                include '../view/vehicle-update.php';
                exit;
            }
            $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
            if ($updateResult) {
                $message = "<p>Congratulations, the $invMake $invModel was successfully updated.</p>";
                //include '../view/vehicle-update.php';
                $_SESSION['message'] = $message;
                header('location: /phpmotors/vehicles/');
                exit;
            } else {
                $message = "<p>Error. The new vehicle was not updated.</p>";
                include '../view/vehicle-update.php';
                exit;
            }
            break;
        case 'deleteVehicle':
            $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //$invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

            $deleteResult = deleteVehicle($invId);
            if ($deleteResult) {
                $message = "<p>Congratulations, the $invMake $invModel was successfully deleted.</p>";
                //include '../view/vehicle-update.php';
                $_SESSION['message'] = $message;
                header('location: /phpmotors/vehicles/');
                exit;
            } else {
                $message = "<p class='notice'>Error: $invMake $invModel was not
            deleted.</p>";
                $_SESSION['message'] = $message;
                header('location: /phpmotors/vehicles/');
                exit;
            }
            break;
        case 'del':
            $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
            $invInfo = getInvItemInfo($invId);
            if(count($invInfo)<1){
                $message = 'Sorry, no vehicle information could be found.';
            }
            include '../view/vehicle-delete.php';
            exit;
            break;
        case 'classification':
            $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $vehicles = getVehiclesByClassification($classificationName);
            if(!count($vehicles)){
                $message = "<p class='notice'>Sorry, no $classificationName vehicles could be found.</p>";
            } else {
                $vehicleDisplay = buildVehiclesDisplay($vehicles);
            }

            // Test (next 2 lines)
            //echo $vehicleDisplay;
            //exit;

            include '../view/classification.php';
            break;
        case 'vehicle':
            $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invInfo = getInvInfo($invId);
            $secondaryImages = getSecondaryImages($invId);
            if(!$invInfo){
                $message = '<p class="notice">Sorry, no vehicle information could be found.</p>';
            }
            else {
                $invInfoDisplay = buildVehicleInfoDisplay($invInfo, $secondaryImages);
            }
            include '../view/vehicle.php';
            break;
        default:
            $classificationList = buildClassificationList($classifications);


            include '../view/vehicleManagement.php';
            break;
    }

