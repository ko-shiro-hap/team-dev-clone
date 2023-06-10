<?php
require_once "../../db/pdo.php";

session_start();

if (!isset($_SESSION['token'])) {
    header('Location: ./login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_SESSION['login_user_id'];
  $currentPassword = $_POST["password_current"];
  $confirmPassword = $_POST["password_confirm"];
  $newPassword = $_POST["password_new"];
  $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

  $sql = "SELECT password FROM clients WHERE id = :id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(":id", $id);
  $stmt->execute();
  $userData = $stmt->fetch();

  if(password_verify($currentPassword, $userData["password"]) && $currentPassword === $confirmPassword) {
    $sql = "UPDATE clients SET password=:newPassword WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":newPassword", $hashedNewPassword);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    $message = "パスワードの変更が完了しました";
  } else {
    $message = "パスワードが間違っています";
  }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRAFT for Client | パスワード再設定</title>
  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/6c20dffe37.js" crossorigin="anonymous"></script>
  <!-- google-fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Eczar:wght@400;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <!-- css -->
  <link rel="stylesheet" href="../../assets/styles/reset.css">
  <link rel="stylesheet" href="../../assets/styles/common.css">
  <link rel="stylesheet" href="../../assets/styles/client/style.css">
</head>
<body>
  <?php require('../../components/client/header.php') ?>
  <form method="POST" class="login">
  <?php if (isset($message)) { ?>
    <p class="failed-message"><?= $message ?></p>
  <?php } ?>
    <fieldset>
      <legend class="legend">パスワード再設定</legend>
      <div class="input">
        <input name="password_current" type="password" placeholder="現在のパスワード" required />
      </div>
      <div class="input">
        <input name="password_confirm" type="password" placeholder="現在のパスワード(再確認)" required />
      </div>
      <div class="input">
        <input name="password_new" type="password" placeholder="新しいパスワード" required />
      </div>
      <button type="submit" class="submit"><i class="fa fa-long-arrow-right"></i></button>
    </fieldset>
  </form>
</body>
</html>
