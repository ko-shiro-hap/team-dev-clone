<?php
session_start();

  if(!isset($_SESSION['admin_token'])) {
    header('Location: ./auth/login.php');
    exit();
  }

  $now = date('Y/m/d');
?>

<script>
  const loginUserId = "<?= $_SESSION['login_user_id']; ?>";
</script>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRAFT for Admin | エージェント一覧</title>
  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/6c20dffe37.js" crossorigin="anonymous"></script>
  <!-- google-fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Eczar:wght@400;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <!-- css -->
  <link rel="stylesheet" href="../assets/styles/reset.css">
  <link rel="stylesheet" href="../assets/styles/common.css">
  <link rel="stylesheet" href="../assets/styles/admin/style.css">
  <!-- js -->
  <script src="../assets/js/db/fetchData.js" defer></script>
  <script src="../assets/js/admin/index.js" defer></script>
</head>
<body>
  <?php include("../components/admin/header.php"); ?>
  <section class="entries">
    <div class="entries-header">
      <div class="entries-header-title">
        <h2>クライアント一覧</h2>
      </div>
      <div class="entries-header-num">
        <p><?= $now ?>時点</p>
        <div class="entries-header-num-bottom">
          <p>クライアント数<span id="client-count">?</span>社</p>
          <p>掲載中<span id="active-count">?</span>社</p>
          <a href="./invalid-application/" class="show-invalidations-button">無効申請を承認する</a>
        </div>
      </div>
    </div>
    <div class="client-add">
      <a href="./client/create.php" class="client-add-button">クライアント追加</a>
    </div>
    </div>
    <div class="clients-tablebox">
      <table class="clients-table" id="client-list-table">
        <tr>
          <th class="clients-table-enterprize">企業名</th>
          <th class="clients-table-service">サービス名</th>
          <th class="clients-table-period">掲載期間</th>
          <th class="clients-table-status">掲載ステータス</th>
          <th class="clients-table-entry">今月のエントリー</th>
        </tr>
      </table>
    </div>
  </section>
</body>
</html>
