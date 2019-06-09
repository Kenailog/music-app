<?php
include_once("includes/includedFiles.php");
?>

<h1 class="pageHeadingBig">You may also like</h1>

<div class="gridViewContainer">

    <?php
    $albums = $conn->query("SELECT * FROM albums ORDER BY RAND() LIMIT 10") or die($conn->error);
    while ($row = $albums->fetch_array()) {
        echo "<div class='gridViewItem'>
                <span role='link' tabindex='0' onclick='loadContent(\"album.php?id=" . $row['id'] . "\")'>
                    <img src=" . $row['artworkPath'] . " alt='cover'>
                    <div class='artworkInfo'>" . $row['title'] . "</div>
                </span>
              </div>";
    }
    ?>

</div>