<?php
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

logF(date("Y-m-d h:i:sa").": ip: ".$_SERVER['REMOTE_ADDR']." AF: ".(!$errFormat ? $_POST["audioformat"] : "null")." URL: ".(!$errURL ? $_POST["URL"] : "null"));
if ($errFormat || $errURL) {
    header("Location: index.php");
}
$audioFormat = $_POST["audioformat"];
$URL = $_POST["URL"];


switch ($audioFormat) {
    case 'mp3':
        $query = "youtube-dl --no-playlist --max-filesize 200m --add-metadata --prefer-ffmpeg --output \"files/%(id)s.%(ext)s\" --format bestaudio --extract-audio --audio-quality 4 --audio-format mp3";
        $audioFormat = 'mp3';
        break;

    case 'm4a':
        $query = "youtube-dl --no-playlist --max-filesize 200m --add-metadata --prefer-ffmpeg --output \"files/%(id)s.%(ext)s\" --format \"bestaudio[ext=m4a]\"";
        $audioFormat = 'm4a';
        break;

    case 'opus':
        $query = "youtube-dl --no-playlist --max-filesize 200m --add-metadata --prefer-ffmpeg --output \"files/%(id)s.ogg\" --format \"bestaudio[ext=webm]\"";
        $audioFormat = 'ogg';
        break;

    default:
        $query = "youtube-dl --no-playlist --max-filesize 200m --add-metadata --prefer-ffmpeg --output \"files/%(id)s.ogg\" --format \"bestaudio[ext=webm]\"";
        $audioFormat = 'ogg';
        break;
}

$isLinkValid = preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $URL);
if ($isLinkValid) {
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $URL, $match);
    $youtube_id = $match[1];
    $file = "./files/$youtube_id.$audioFormat";
    if(!file_exists($file)){
        exec($query . " " . $URL);
    }
    header("Content-type: octet/stream");
    header("Content-disposition: attachment; filename=" . $file . ";");
    header("Content-Length: " . filesize($file));
    readfile($file);
    exit;

} else {
    $_SESSION["error_URL"] = '<script>alert("Please specify a valid URL")</script>'; 
    header("Location: index.php");
}

function logF($text){
    file_put_contents('log.txt', $text.PHP_EOL , FILE_APPEND | LOCK_EX);

}