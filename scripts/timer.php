<?php
$fh = fopen('time.txt', 'w');
while (true) {
    if (!fwrite($fh, time()))
        break;
    sleep(1);
    if (!file_exists('time.txt'))
        break;
}

fclose($fh);
exit(0);
