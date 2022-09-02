<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen">
        <title><?php echo $title;?> | PHP Motors</title>
    </head>
    <body>
        <div id="wrapper">
            <header>
                <img src="/phpmotors/images/site/logo.png" alt="PHP Motorl logo" id="logo">
                <div id="account">
                    <?php 
                        if(isset($_SESSION['loggedin'])){
                            echo "<a href='/phpmotors/accounts/' id='welcomeMsg'>Welcome ".$_SESSION['clientData']['clientFirstname']."</a> | <a href='/phpmotors/accounts/index.php?action=logout' id='logout'>Logout</a>";
                        }
                        /*if(isset($cookieFirstname)){
                            echo "<span>Welcome $cookieFirstname</span>";
                        }*/
                        else{
                            echo '<a href="/phpmotors/accounts/?action=login" id="myAccount">My Account</a>';
                        }
                    ?>
                </div>
                <a id="search" href="/phpmotors/search/?action=search">&#128269;</a>
            </header>
            <nav>
                <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/navigation.php'; ?>
            </nav>
            <main>
