<?php
// logout.php
session_start();
session_destroy();
header('Location: index.php'); // Redirect ke halaman beranda
exit();
?>