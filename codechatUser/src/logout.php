<?php
session_start();
session_destroy();
header("location: ../login.php?msg=You have been disconnected successfully !");