<?php
// The Accounts controller

    //Create or access a Session
    session_start();

    // Get the database connection file
    require_once '../library/connections.php';
    // Get the PHP Motors model for use as needed
    require_once '../model/main-model.php';
    // Get the Accounts Model
    require_once '../model/accounts-model.php';
    // Get the functions library
    require_once '../library/functions.php';


    // Get the array of classifications
	$classifications = getClassifications();

    // Build a navigation bar using the $classifications array
    $navList = createNavlist($classifications);

    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }

    switch ($action){
        case 'login':
            include '../view/login.php';
            break;
        case 'register':
            include '../view/registration.php';
            break;
        case 'registerUser': // Registration process
            //echo 'You are in the register case statement.';

            // Filter and store the data
            $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            $clientEmail = checkEmail($clientEmail);
            $checkPassword = checkPassword($clientPassword);
            
            // Check for missing data
            if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
                $message = '<p>Please provide information for all empty form fields.</p>';
                include '../view/registration.php';
                exit; 
            }

            $existingEmail = checkExistingEmail($clientEmail);

            // Check for existing email address in the table
            if($existingEmail){
                $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
                include '../view/login.php';
                exit;
            }

            
            // Hash the checked password
            $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);


            // Send the data to the model
            $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

            // Check and report the result
            if($regOutcome === 1){
                setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
                $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
                //$message = "<p>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
                header('Location: /phpmotors/accounts/?action=login');
                //include '../view/login.php';
                exit;
            } else {
                $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
                include '../view/registration.php';
                exit;
            }

            break;
        case 'loginUser': // Login process
            // Filter and store the data
            $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            $clientEmail = checkEmail($clientEmail);
            $checkPassword = checkPassword($clientPassword);
            
            // Check for missing data
            if (empty($clientEmail) || empty($checkPassword)) {
                $message = '<p>Please provide information for all empty form fields.</p>';
                include '../view/login.php';
                exit; 
            }

            // A valid password exists, proceed with the login process
            // Query the client data based on the email address
            $clientData = getClient($clientEmail);
            // Compare the password just submitted against
            // the hashed password for the matching client
            $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
            // If the hashes don't match create an error
            // and return to the login view
            if(!$hashCheck) {
                $message = '<p class="notice">Please check your password and try again.</p>';
                include '../view/login.php';
                exit;
            }
            // A valid user exists, log them in
            $_SESSION['loggedin'] = TRUE;
            // Remove the password from the array
            // the array_pop function removes the last
            // element from an array
            array_pop($clientData);
            // Store the array into the session
            $_SESSION['clientData'] = $clientData;
            // Send them to the admin view
            include '../view/admin.php';
            exit;

            break;
        case 'logout':
            // The session data should be unset
            session_unset();
            // The session destroyed
            session_destroy();
            // The client is returned to the main phpmotors controller
            header('Location: /phpmotors/');
            break;
        case 'mod':
            $clientId = filter_input(INPUT_GET, 'clientId', FILTER_VALIDATE_INT);
            $clientInfo = getClientInfo($clientId);
            if(count($clientInfo)<1){
                $message = 'Sorry, no client information could be found.';
            }
            include '../view/client-update.php';
            exit;
            break;
        case 'updateUser':
            // Filter and store the data
            $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
            $clientId = filter_input(INPUT_POST, 'accClientId', FILTER_VALIDATE_INT);

            $clientEmail = checkEmail($clientEmail);

            // Check for missing data
            if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)) {
                $accountMessage = '<p class="messageError">Please provide information for all empty form fields.</p>';
                include '../view/client-update.php';
                exit; 
            }

            if($_SESSION['clientData']['clientEmail'] != $clientEmail){
                $existingEmail = checkExistingEmail($clientEmail);

                // Check for existing email address in the table
                if($existingEmail){
                    $accountMessage = '<p class="messageError">That email address already exists. Do you want to login instead?</p>';
                    include '../view/client-update.php';
                    exit;
                }
            }
            $updateResult = updateUser($clientFirstname, $clientLastname, $clientEmail, $clientId);
            if ($updateResult) {
                $_SESSION['clientData']['clientFirstname'] = $clientFirstname;
                $_SESSION['clientData']['clientLastname'] = $clientLastname;
                $_SESSION['clientData']['clientEmail'] = $clientEmail;
                $message = "<p class='messageSuccess'>Congratulations, the $clientFirstname $clientLastname was successfully updated.</p>";
                //include '../view/vehicle-update.php';
                $_SESSION['message'] = $message;
                header('location: /phpmotors/accounts/');
                exit;
            } else {
                $accountMessage = "<p class='messageError'>Error. The new client info was not updated.</p>";
                include '../view/client-update.php';
                exit;
            }
            include '../view/client-update.php';
            break;
        case 'changePassword':
            // Filter and store the data
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $clientId = filter_input(INPUT_POST, 'pasClientId', FILTER_VALIDATE_INT);

            $checkPassword = checkPassword($clientPassword);

            // Check for missing data
            if (empty($checkPassword)) {
                $passwordMessage = '<p class="messageError">Please provide information for all empty form fields.</p>';
                include '../view/client-update.php';
                exit; 
            }

            // Hash the checked password
            $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
            
            $updateResult = updatePassword($hashedPassword, $clientId);
            if ($updateResult) {
                $_SESSION['clientData']['clientPassword'] = $hashedPassword;
                $message = "<p class='messageSuccess'>Congratulations, the password was successfully updated.</p>";
                $_SESSION['message'] = $message;
                header('location: /phpmotors/accounts/');
                exit;
            } else {
                $passwordMessage = "<p class='messageError'>Error. The new password was not updated.</p>";
                include '../view/client-update.php';
                exit;
            }
            break;
        default:
            include '../view/admin.php';
            break;
    }

