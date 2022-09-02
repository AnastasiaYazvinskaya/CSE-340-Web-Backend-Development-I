<?php 
    $title = 'Home';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; 
?>

<h1>Welcome to PHP Motors!</h1>
<div id="content">
    <div id="delorean">
        <div id="info">
            <h3>DMC Delorean</h3>
            <p>3 Cup holders</p>
            <p>Superman doors</p>
            <p>Fuzzy dice!</p>
        </div>
        <img src="/phpmotors/images/vehicles/delorean.jpg" alt="DeLorean image" id="car">
        <img src="/phpmotors/images/site/own_today.png" alt="Own today" id="ownToday">
    </div>
    <div id="flex-large">
        <div id="reviews">
            <h2>DMC Delorean Reviews</h2>
            <ul>
                <li>"So fast its almost like traveling in time." (4/5)</li>
                <li>"Coolest ride on the rode." (4/5)</li>
                <li>"I'm feeling Marty McFly!" (5/5)</li>
                <li>"The most futuristic ride of our day." (4.5/5)</li>
                <li>"80's livin and I love it!" (5/5)</li>
            </ul>
        </div>
        <div id="delorean_upgrades">
            <h2>Delorean Upgrades</h2>
            <div id="upgrades">
                <div id="upgrade1">
                    <img src="/phpmotors/images/upgrades/flux-cap.png" alt="Flux Capacitor">
                    <p>Flux Capacitor</p>
                </div>
                <div id="upgrade2">
                    <img src="/phpmotors/images/upgrades/flame.jpg" alt="Flame Decals">
                    <p>Flame Decals</p>
                </div>
                <div id="upgrade3">
                    <img src="/phpmotors/images/upgrades/bumper_sticker.jpg" alt="Bumper Strickers">
                    <p>Bumper Strickers</p>
                </div>
                <div id="upgrade4">
                    <img src="/phpmotors/images/upgrades/hub-cap.jpg" alt="Hub Caps">
                    <p>Hub Caps</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>