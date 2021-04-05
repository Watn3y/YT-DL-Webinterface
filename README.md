## YT-DL-Webinterface
A simple and fast web interface for downloading music using [youtube-dl](https://github.com/ytdl-org/youtube-dl)

Copyright (C) 2021 [Watn3y](https://github.com/Watn3y/)

> Licensed under [EUPL v1.2](https://github.com/Watn3y/YT-DL-Webinterface/blob/master/LICENSE)
> 
![image](https://user-images.githubusercontent.com/64812615/113526977-43ded780-95bc-11eb-8111-cb9cd0054ba8.png)

The design is not finalized. See [this](https://github.com/Watn3y/YT-DL-Webinterface/issues/1)

## How it works
We take the users input from __index.php__. Then, in __api.php__, we check if the YouTube URL and audioformat are valid. If the requested file is already saved it get's served. If it isn't we download it using youtube-dl and serve it.
A log of all requests is stored in __log.txt__.

Make sure to set appropriate permission for the __log.txt__

### How it doesn't work
Downloading Playlists is currently not supported.

## Minimum requirements
- Web server
- PHP (Tested on >=PHP7.3)
- youtube-dl
- FFmpeg

You can set a contact email, Name or whatever you want in the __footer__ of the __index.php__.
  
### Special thanks

-  [AlexZorzi](https://github.com/AlexZorzi), for his massive help during developement
