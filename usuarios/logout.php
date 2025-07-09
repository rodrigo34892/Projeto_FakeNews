<?php
session_start();
session_destroy();
header("Location: ../pagina/index.php");
exit;