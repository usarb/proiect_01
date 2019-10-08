<?php
require "libs/rb.php";
R::setup('mysql:port=3306; dbname=magazin',
        'root');
		
session_start();