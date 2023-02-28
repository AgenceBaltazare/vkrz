<?php

function to_discord($typeMessage, $data) {
  $data = json_encode($data);
  
  // shell_exec("/usr/bin/node /var/www/vainkeurz.com/web/index.js 2>&1 '$typeMessage' '$data'"); // PROD
  // shell_exec("/usr/local/bin/node /Applications/MAMP/htdocs/vkrz/index.js 2>&1 '$typeMessage' '$data'"); // MAMP 
  shell_exec("/usr/local/bin/node ./index.js '$typeMessage' '$data'"); // LOCAL
}
