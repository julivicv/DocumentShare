<?php

session_start();
require("../model/User.php");

if (isset($_SESSION["auth"])) {
    header("location: ./home_page.php");
}