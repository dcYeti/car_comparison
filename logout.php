<?php
setcookie('MP4', FALSE, time()-600);
session_start();
unset($_SESSION);
$_SESSION = array();
session_destroy();
$loggedIn = false;
include("template_head.html");
?>
<div class="carprofile">
<h4>You are now logged out!</h4>
</div></body></html>