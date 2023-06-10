<?php
session_start();

if (!isset($_SESSION['token'])) {
    header('Location: ./auth/login.php');
    exit();
}

if(isset($_GET['month'])) {
  $selected_month = $_GET['month'];
} else {
  $selected_month = date('Y-m');
}
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
  <title>CRAFT for Client | エントリー一覧</title>
  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/6c20dffe37.js" crossorigin="anonymous"></script>
  <!-- google-fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Eczar:wght@400;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <!-- css -->
  <link rel="stylesheet" href="../assets/styles/reset.css">
  <link rel="stylesheet" href="../assets/styles/common.css">
  <link rel="stylesheet" href="../assets/styles/client/style.css">
  <!-- js -->
  <script src="../assets/js/db/fetchData.js" defer></script>
  <script src="../assets/js/client/index.js" defer></script>
</head>
<body>
  <?php require('../components/client/header.php') ?>
  <section class="entries">
    <div class="entries-header">
      <div class="entries-header-title">
        <h2>エントリー一覧</h2>
        <p id="service-name-container"></p>
      </div>
      <div class="entries-header-month">
        <form method="GET">
          <input type="month" name="month" id="input-of-month"
          value="<?= $selected_month ?>">
          <button type="submit" class="selected-month-submit" id="selected-month-submit"></button>
        </form>
      </div>
      <div class="entries-header-num">
        <p><?= str_replace('-', '/', $selected_month) ?></p>
        <div class="entries-header-num-bottom">
          <div class="entries-header-nums">
            <p>エントリー件数<span id="entry-count">?</span>件</p>
            <p>無効件数<span id="invalid-count">?</span>件</p>
            <p class="billable-count">請求対象件数<span id="billable-count">?</span>件</p>
          </div>
          <p id="post-period">掲載期間: ???まで</p>
        </div>
      </div>
    </div>
    <div class="csv">
      <button class="csv-button" id="download-csv">CSVダウンロード</button>
      <label><input type="checkbox" class="csv-checkbox" id="active-filter" checked>無効者を除く</label>
      <a href="https://docs.google.com/forms/d/e/1FAIpQLSeLM82jQA3v2I-viLvHTH9ZQZbwSuomBQ9AaGP-faXV3e0-5g/viewform" class="invalidation-application-button" target="_blank">無効申請する</a>
    </div>
    <div class="not-active-label">無効者:</div>
    <div class="entries-tablebox">
      <table class="entries-table" id="entry-list-table">
        <tr>
          <th class="entries-table-id">エントリーID</th>
          <th class="entries-table-name">名前</th>
          <th class="entries-table-sex">性別</th>
          <th class="entries-table-mail">メールアドレス</th>
          <th class="entries-table-tel">電話番号</th>
          <th class="entries-table-prefecture">地域</th>
          <th class="entries-table-university">学校名・学部・学科</th>
          <th class="entries-table-graduation">卒業年度</th>
          <th class="entries-table-date">エントリー日時</th>
        </tr>
        <tr>
      </table>
    </div>
  </section>
</body>
</html>
