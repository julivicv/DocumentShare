<?php

session_start();


session_destroy();

header("Location: ../controller/login_user_page.php");
