<?php

function to_discord($typeMessage, $data) {
  $data = json_encode($data);
  
  shell_exec("/usr/local/bin/node /Applications/MAMP/htdocs/vkrz/discord.js 2>&1 '$typeMessage' '$data'");
}
