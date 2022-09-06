<?php

$debut = microtime(true);

define("DS", DIRECTORY_SEPARATOR);
define("WEBROOT", __DIR__ . DS);
define("ROOT", dirname(WEBROOT) . DS);
define("CORE", ROOT . "core" . DS);
define("BASE_URL", dirname(dirname($_SERVER["SCRIPT_NAME"])) . DS);

require CORE . "includes.php";
new Dispatcher();
?>

<!-- <div style="position:fixed; bottom:0; text-align:right; padding-right:30px; background:red; color:#EEE; width:100%; line-height:30px"> -->
<div style="position:fixed; bottom:0; text-align:right; background:#A8FFD2; color:#000; line-height:30px; height:30px; left:0; right:0; padding-right:15px">
  <?php
  echo "Page generee en " . round(microtime(true) - $debut, 5) . " secondes";
  ?>
</div>



<!-- // var_dump(BASE_URL);

// echo "<pre>";
// var_dump($_SERVER);
// echo "<pre>"; -->