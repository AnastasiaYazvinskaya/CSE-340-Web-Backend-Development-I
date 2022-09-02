<?php
// The PHP Motors controller

    //Create or access a Session
    session_start();

    // Get the database connection file
    require_once 'library/connections.php';
    // Get the PHP Motors model for use as needed
    require_once 'model/main-model.php';
    // Get the functions library
    require_once 'library/functions.php';

    // Get the array of classifications
	$classifications = getClassifications();
    //var_dump($classifications);
	//    exit;

    // Build a navigation bar using the $classifications array
    //$navList = '<ul>';
    //$navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
    //foreach ($classifications as $classification) {
    //    $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    //}
    //$navList .= '</ul>';
    $navList = createNavlist($classifications);
    
    //echo $navList;
    //exit;

    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }

    // Check if the firstname cookie exists, get its value
    if(isset($_COOKIE['firstname'])){
        $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    switch ($action){
        case 'template':
            include 'view/template.php';
            break;
        default:
            include 'view/home.php';
            break;
    }

