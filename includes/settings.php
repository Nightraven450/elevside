<?php
$pagename = $_POST['page'] ?? $_GET['page'] ?? 'home';
$page = strtolower('pages/' . $pagename . '.php');