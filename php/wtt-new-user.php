<?php

  if (isset($_POST['signup-button'])) {

    require "db.php";

    $user_name = mysqli_real_escape_string($link, $_POST['name']);
    $user_last = mysqli_real_escape_string($link, $_POST['last']);
    $user_email = mysqli_real_escape_string($link, $_POST['email']);
    $user_uid = mysqli_real_escape_string($link, $_POST['login']);
    $user_pwd = mysqli_real_escape_string($link, $_POST['password']);

    if (empty($user_name) || empty($user_last) || empty($user_email) || empty($user_uid) || empty($user_pwd)) {
      header('Location: .././?error=empty-fields');
      exit();
    } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL) && !preg_match('/^[a-zA-Z\p{Cyrillic}\d\s\-]+$/u', $user_name)) {
      header('Location: .././?error=invalid-login-email');
      exit();
    } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
      header('Location: .././?error=invalid-email');
      exit();
    } elseif (!preg_match('/^[a-zA-Z\p{Cyrillic}\d\s\-]+$/u', $user_name)) {
      header('Location: .././?error=invalid-login');
      exit();
    } else {

      $sql = "SELECT * FROM users WHERE user_uid=? OR user_email=?";
      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: .././?error=sql-error');
        exit();
      } else {
        mysqli_stmt_bind_param($stmt, "ss", $user_name, $user_email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $result = mysqli_stmt_num_rows($stmt);
        if ($result > 0) {
          header('Location: .././?error=username-or-email-taken');
          exit();
        } else {

          $sql = "INSERT INTO users (user_name, user_last, user_uid, user_email, user_pwd) VALUES (?, ?, ?, ?, ?)";
          $stmt = mysqli_stmt_init($link);
          if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: .././?error=sql-error');
            exit();
          } else {
            $user_hashed_pwd = password_hash($user_pwd, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "sssss", $user_name, $user_last, $user_uid, $user_email, $user_hashed_pwd);
            mysqli_stmt_execute($stmt);

            header('Location: .././?signup=success');
            exit();
          }
        }
      }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);

  } else {
    header('Location: .././');
    exit();
  }

?>
