<?php

function to_discord($typeMessage, $data) {
  $data = json_encode($data);
  
  shell_exec("/usr/local/bin/node /var/www/vainkeurz.com/index.js 2>&1 '$typeMessage' '$data'");
}
