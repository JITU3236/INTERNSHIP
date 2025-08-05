<?php
session_start();
session_unset();
session_destroy();

// Redirect to login page with unauthorized message
header("Location: index.php?unauthorized=1");
exit();
