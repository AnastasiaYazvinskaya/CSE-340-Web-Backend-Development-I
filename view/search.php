<?php 
    $title = 'Template';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; 
?>

<h1>Search</h1>

<?php 
    if(isset($message)){
        echo $message; 
    }
?>

<form method="post" action="/phpmotors/search/">
    <label for="searchInput">What are you looking for?</label><br>
    <input type="text" name="search" id="searchInput"
        <?php if(isset($invMake)){echo "value='$invMake'";}  ?>
        required>
    <input type="submit" name="submit" value="Search">
    <input type="hidden" name="action" value="searchResult">
</form>

<?php 
    if(isset($result)){
        echo array_slice($result, ($page-1)*10, 10);
    }
?>

<?php 
    if(isset($searchResultsDisplay)){
        echo $searchResultsDisplay;
    }
?>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>