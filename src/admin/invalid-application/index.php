<?php
session_start();
require('../../db/pdo.php');

  if(!isset($_SESSION['admin_token'])) {
    header('Location: ../auth/login.php');
    exit();
  }

$sql = 'SELECT id FROM entries WHERE is_active = 1 ORDER BY id ASC';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$entry_ids = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRAFT for Admin | 無効申請一覧</title>
  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/6c20dffe37.js" crossorigin="anonymous"></script>
  <!-- google-fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Eczar:wght@400;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <!-- css -->
  <link rel="stylesheet" href="../../assets/styles/reset.css">
  <link rel="stylesheet" href="../../assets/styles/common.css">
  <link rel="stylesheet" href="../../assets/styles/admin/style.css">
</head>
<body>
  <?php include('../../components/admin/header.php') ?>
  <section class="invalid-application">
    <div class="invalid-application-contents">
      <? if(isset($_SESSION['flash_message'])): ?>
        <p class="flash-message"><?= $_SESSION['flash_message']; ?></p>
        <?php unset($_SESSION['flash_message']); ?>
      <?php endif; ?>
      <?php if (empty($entry_ids)) : ?>
        <p>エントリーがありません。</p>
      <?php else : ?>
        <p>無効にするエントリーのIDを選択してください。</p>
        <form method="POST" action="../../services/admin/approve_invalid_application.php" class="invalid-application-form">
          <select name="entry_id" id="">
            <?php foreach($entry_ids as $entry_id): ?>
              <option value="<?= $entry_id['id']; ?>"><?= $entry_id['id']; ?></option>
            <?php endforeach; ?>
          </select>
          <button type="submit">承認</button>
        </form>
      <?php endif; ?>
    </div>
  </section>
</body>
</html>
