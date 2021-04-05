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
    <select id="format" name="audioformat">
      <option value="opus" default>opus</option>>opus</option>
      <option value="mp3">mp3</option>
      <option value="m4a">m4a</option>
    </select>
    <input type="text" id="URL" name="URL" placeholder="URL..." />
    <br />
    <input type="reset" name="Reset">
    <input type="button" onclick="send()" value="Download" />
    </div>
  </form>
  <footer class="footer">
    <p></p>


    <script>
      function send() {
        document.getElementById("form").submit();
        document.getElementById("form").reset();

      }
    </script>
</body>

</html>