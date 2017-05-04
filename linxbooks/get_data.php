<?php
$user_url = (isset($_GET['url']) ? $_GET['url'] : 0);
echo file_get_contents($user_url); 
?>