<?php

use App\Core\Contrib\Flash;

$flashes = Flash::get();

if ($flashes) {
  foreach ($flashes as $flash_key => $flash) {
    $msg = $flash['message'];
    $level = $flash['level'];
    echo "
<div class='alert alert-$level alert-dismissible'>$msg
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>
";
  }
}
