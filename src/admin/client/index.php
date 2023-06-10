<?php
require('../../db/pdo.php');
session_start();

  if(!isset($_SESSION['admin_token'])) {
    header('Location: ../auth/login.php');
    exit();
  }

if(isset($_GET['id'])) {
  $login_user_id = $_GET['id'];
} else {
  header('Location: ../index.php');
}

if(isset($_GET['month'])) {
  $selected_month = $_GET['month'];
} else {
  $selected_month = date('Y-m');
}

// ログインユーザーの登録情報を取得
$agent_data = $dbh->prepare('SELECT * FROM clients WHERE id=?');
$agent_data->execute(array($login_user_id));
$agent_data = $agent_data->fetch();

$area_id = $agent_data['area_id'];

// エリアIDからエリア名を取得
$area_name = $dbh->prepare('SELECT name FROM areas WHERE id=?');
$area_name->execute(array($area_id));
$area_name = $area_name->fetch();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRAFT for Admin | クライアント詳細</title>
  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/6c20dffe37.js" crossorigin="anonymous"></script>
  <!-- google-fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Eczar:wght@400;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <!-- css -->
  <link rel="stylesheet" href="../../assets/styles/reset.css"></head>
  <link rel="stylesheet" href="../../assets/styles/common.css"></head>
  <link rel="stylesheet" href="../../assets/styles/admin/style.css">
  <!-- js -->
  <script src="../../assets/js/db/fetchData.js" defer></script>
  <script src="../../assets/js/admin/client/index.js" defer></script>

</head>

<body>
  <?php include('../../components/admin/header.php') ?>
  <section class="entry-info-hero">
    <div class="hero-top detail-head">
      <p class="hero-text-left">登録情報</p>
      <div class="hero-textbox">
        <a href="./edit.php?id=<?= $login_user_id ?>" class="hero-text-right">登録情報を編集する</a>
      </div>
    </div>
    <table  class="all-entries-info-table">
      <tr>
        <th class="table-th">会社名</th>
        <th class="th-odd"><?= $agent_data['company_name'] ?></th>
      </tr>
      <tr>
        <th class="table-th">サービス名</th>
        <th class="th-even"><?= $agent_data['service_name'] ?></th>
      </tr>
      <tr>
        <th class="table-th">対応可能エリア</th>
        <th class="th-odd"><?= $area_name['name'] ?></th>
      </tr>
      <tr>
        <th class="table-th">リモート対応</th>
        <th class="th-even"><?= $agent_data['remote_available'] == 1 ? '可' : '不可' ?></th>
      </tr>
      <tr>
        <th class="table-th">サービスurl</th>
        <th class="th-odd"><?= $agent_data['service_url'] ?></th>
      </tr>
      <tr>
        <th class="table-th">メールアドレス</th>
        <th class="th-even"><?= $agent_data['email'] ?></th>
      </tr>
      <tr>
        <th class="table-th">パスワード</th>
        <th class="th-odd">********</th>
      </tr>
      <tr>
        <th class="table-th">特徴1</th>
        <th class="th-even"><?= $agent_data['feature1'] ?></th>
      </tr>
      <tr>
        <th class="table-th">特徴2</th>
        <th class="th-odd"><?= $agent_data['feature2'] ?></th>
      </tr>
      <tr>
        <th class="table-th">特徴3</th>
        <th class="th-even"><?= $agent_data['feature3'] ?></th>
      </tr>
      <tr>
        <th class="table-th">掲載期間</th>
        <th class="th-odd"><?= $agent_data['post_period'] ?></th>
      </tr>
    </table>
  </section>
  <section class="entries">
  <div class="entries-header">
    <div class="entries-header-title">
      <h2>エントリー一覧</h2>
      <p id="service-name-container"></p>
    </div>
    <div class="entries-header-month">
      <form method="GET">
        <?php if (isset($_GET['id'])) : ?>
          <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
        <?php endif; ?>
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
      </div>
    </div>
  </div>
  <!-- 以下テーブルだよん -->
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
