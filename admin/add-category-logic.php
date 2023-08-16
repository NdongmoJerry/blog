<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require 'config/database.php';

//get add-user form data if add-user button was clicked
if (isset($_POST['submit'])) {
$title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//validate input values
  if (!$title) {
    $_SESSION['add-category'] = "Please enter the title";
  } elseif (!$description) {
    $_SESSION['add-category'] = "Please enter description";
  }
  // redirect back to category page if there was invalid input

  if (isset($_SESSION['add-category'])) {
    $_SESSION['add-category-data'] = $_POST;
    header('location: ' . ROOT_URL . 'admin/add-category.php');
    die();
} else {
      // insert into category database
    $query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
    $result = mysqli_query($connection, $query);
    if(mysqli_errno($connection)) {
      $_SESSION['add-category'] = "Couldn't add category";
      header('location: ' . ROOT_URL . 'admin/add-category.php');
      die();
    } else {
      $_SESSION['add-category-success'] = "$title category added successfully";
      header('location: ' . ROOT_URL . 'admin/manage-categories.php');
      die();
    }
}
}