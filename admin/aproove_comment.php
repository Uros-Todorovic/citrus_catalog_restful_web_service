<?php

require_once('includes/header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    Comment::aproove_comment($id);
    Helper::redirect('index.php');
}