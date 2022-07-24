<?php
session_start();

if (isset($_SESSION["error_audioformat"])) {
    echo $_SESSION["error_audioformat"];
}

if (isset($_SESSION["error_URL"])) {
    echo $_SESSION["error_URL"];
}

session_destroy();

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Youtube Music Downloader</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
<h1>Youtube Music Downloader</h1>
<p id="howto">Paste a URL and download your Music</p>
<form action="api.php" method="POST" id="form">
    <div class="form"></div>
    <button type="reset">Reset</button>
    <input type="text" id="URL" name="URL" placeholder="URL..." />
    <br />
    <button type="submit" id="submit" name="audioformat" value="mp4" onclick="send()">Video 🎥</button>
    <button type="submit" id="submit" name="audioformat" value="m4a">Audio 🔊</button>
</form>
<footer class="footer">
    <p><a href="https://github.com/Watn3y/YT-DL-Webinterface">Github</a></p>


</body>

</html>
