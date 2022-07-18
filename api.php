<?php
ini_set('memory_limit', '-1');
session_start();
$errFormat = false;
$errURL = false;
if (isset($_POST["audioformat"]) && $_POST["audioformat"] == "") {
    $_SESSION["error_audioformat"] = '<script>alert("Please specify a valid audioformat")</script>';
    $errFormat = true;
}

if (isset($_POST["URL"]) && $_POST["URL"] == "") {
    $_SESSION["error_URL"] = '<script>alert("Please specify a valid URL")</script>';
    $errURL = true;
}

logF(date("Y-m-d h:i:sa") . ": ip: " . $_SERVER['REMOTE_ADDR'] . " AF: " . (!$errFormat ? $_POST["audioformat"] : "null") . " URL: " . (!$errURL ? $_POST["URL"] : "null"));
if ($errFormat || $errURL) {
    header("Location: index.php");
}
$audioFormat = $_POST["audioformat"];
$URL = $_POST["URL"];

if ($audioFormat == 'link'){
    error_log("this is a link");
}

switch ($audioFormat) {
    case 'm4a':
        $query = "yt-dlp --no-playlist --max-filesize --add-metadata --prefer-ffmpeg --print title --no-simulate --quiet --output \"files/%(id)s.%(ext)s\" --format \"bestaudio[ext=m4a]\"";
        $audioFormat = 'm4a';
        break;
    case 'link':
        $query = "yt-dlp --no-playlist --quiet --get-url --format \"bestaudio[ext=m4a]\"";
        break;

    case 'mp4':
        $query = "yt-dlp --no-playlist --max-filesize --add-metadata --prefer-ffmpeg --print title --no-simulate --quiet --output \"files/%(id)s.%(ext)s\" --format \"bestvideo[ext=mp4]+bestaudio[ext=m4a]\"";
        $audioFormat = 'mp4';
        break;
}

$isLinkValid = preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $URL);
if ($isLinkValid) {
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $URL, $match);
    $youtube_id = $match[1];
    if ($audioFormat == 'link'){
        $linkURL =  exec($query . " " . $URL);
        header("Location: ". $linkURL);
    } else {
        $output = glob("files/$youtube_id.$audioFormat");
        if (count($output) == 0) {
            $title =  exec($query . " " . $URL);
        } else {
            $title =  exec("yt-dlp --print title --quiet $youtube_id" );
        }
        $filename = "files/$youtube_id.$audioFormat";
        header("Content-type: octet/stream; charset=utf-8");
        header("Content-disposition: attachment; filename=" . "$title" . "." . "$audioFormat");
        header("Content-Length: " . filesize($filename));
        readfile($filename);
    }


} else {
    $_SESSION["error_URL"] = '<script>alert("Please specify a valid URL")</script>';
    header("Location: index.php");
}

function logF($text): void
{
    file_put_contents('log.txt', $text . PHP_EOL, FILE_APPEND | LOCK_EX);
}
