<?php

while (true) {
    sleep(1);
    $time = time();
    echo "Демон выполняет код - $time" . PHP_EOL;
}
