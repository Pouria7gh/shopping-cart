<?php

$con = mysqli_connect('localhost', 'root', '', 'shop');

if (mysqli_connect_errno()) {
    die('cannot connect to database');
}