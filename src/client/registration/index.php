<?php
require('../../db/pdo.php');

session_start();

if (!isset($_SESSION['token'])) {
    header('Location: ../auth/login.php');
    exit();
}

$login_user_id = intval($_SESSION['login_user_id']);

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
  <title>CRAFT for Client | 登録情報確認</title>
  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/6c20dffe37.js" crossorigin="anonymous"></script>
  <!-- google-fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Eczar:wght@400;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <!-- css -->
  <link rel="stylesheet" href="../../assets/styles/common.css">
  <link rel="stylesheet" href="../../assets/styles/client/style.css">
  <link rel="stylesheet" href="../../assets/styles/reset.css">

</head>
<body>
  <?php require('../../components/client/header.php') ?>
  <section class="entry-info-hero">
    <div class="hero-top">
      <p class="hero-text-left">登録情報</p>
      <div class="hero-textbox">
        <a href="https://docs.google.com/forms/d/e/1FAIpQLSejeC7sOMEXtywWL44ejIoKwNilnbksRXOYMppf0TY8A01X3A/viewform" class="hero-text-right" target="_blank">登録情報の編集を申請する</a>
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
        <th class="th-odd"><a href="../auth/regen-pass.php">変更</a></th>
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
</body>
</html>
