<div id="navBarContainer">
    <nav class="navBar">
        <span role="link" tabindex="0" onclick="loadContent('index.php')" class="logo"><img src="assets/images/icons/logo.png" alt="logo"></span>

        <div class="group">
            <div class="navItem">
            <span role="link" tabindex="0" onclick="loadContent('search.php')" class="navItemLink">Search</span>
                    <img src="assets/images/icons/search.png" alt="search" class="icon">
                </a>
            </div>
        </div>

        <div class="group">
            <div class="navItem">
            <span role="link" tabindex="0" onclick="loadContent('browse.php')" class="navItemLink">Browse</span>
            </div>

            <div class="navItem">
            <span role="link" tabindex="0" onclick="loadContent('yourMusic.php')" class="navItemLink">Your music</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="loadContent('profile.php')" class="navItemLink"><?= $username ?> </span>
            </div>
        </div>
    </nav>
</div>