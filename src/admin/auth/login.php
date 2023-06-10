<?php
require_once "../../db/pdo.php";
session_reset();
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST["email"];
  $password = $_POST["password"];
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $sql = "SELECT id, email, password FROM administrators WHERE email = :email";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(":email", $email);
  $stmt->execute();
  $user = $stmt->fetch();

  if (!$user || !password_verify($password, $user["password"])) {
    $message = "認証情報が正しくありません";
  } else {
    $_SESSION['admin_token'] = bin2hex(random_bytes(32));
    $_SESSION['login_user_id'] = $user["id"];

    $_SESSION['email'] = $user["email"];
    $_SESSION['password'] = $user["password"];
    $message = "ログインに成功しました";
    header('Location: ../');
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRAFT for Admin | ログイン</title>
  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/6c20dffe37.js" crossorigin="anonymous"></script>
  <!-- google-fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Eczar:wght@400;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <!-- css -->
  <link rel="stylesheet" href="../../assets/styles/reset.css">
  <link rel="stylesheet" href="../../assets/styles/common.css">
</head>
<body>
<form method="POST" class="login">
  <?php if (isset($message)) { ?>
      <p class="failed-message"><?=$message ?></p>
  <?php } ?>
  <fieldset>
    <legend class="legend">ログイン</legend>
    <div class="input">
      <input name="email" type="email"placeholder="メールアドレス" required >
    </div>
    <div class="input">
      <input name="password" type="password" placeholder="パスワード" required />
    </div>
    <button type="submit" class="submit"><i class="fa fa-long-arrow-right"></i></button>
  </fieldset>
</form>
</body>
</html>
