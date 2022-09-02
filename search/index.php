<?php
// The Search controller

    //Create or access a Session
    session_start();

    // Get the database connection file
    require_once '../library/connections.php';
    // Get the PHP Motors model for use as needed
    require_once '../model/main-model.php';
    // Get the Vehicle Model
    require_once '../model/search-model.php';
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
        case 'search':
            include '../view/search.php';
            break;
        case 'searchResult':
            // Filter and store the data
            $str = trim(filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            // Check for missing data
            if(empty($str)){
                $message = '<p class="messageError">You must provide a search string.</p>';
                include '../view/search.php';
                exit;
            }
            // Send the data to the search model
            $searchResultsDisplay = searchResults($str, 1);

            include '../view/search.php';
            break;
        case 'result':
            $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
            $str = filter_input(INPUT_GET, 'str', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Send the data to the search model
            $searchResultsDisplay = searchResults($str, $page);

            include '../view/search.php';
            break;
        default:
            include '../view/search.php';
            break;
    }
