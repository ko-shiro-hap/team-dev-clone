<?php
require_once "../../db/pdo.php";
session_start();

  if(!isset($_SESSION['admin_token'])) {
    header('Location: ../auth/login.php');
    exit();
  }

  $area_sql = "SELECT * FROM areas";
  $area_stmt = $dbh->prepare($area_sql);
  $area_stmt->execute();
  $areas = $area_stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $company_name =  $_POST["company_name"] ;
  $service_name =$_POST["service_name"] ;
  $remote_available = $_POST["remote_available"];
  $service_url =$_POST["service_url"] ;
  $email = $_POST["email"];
  $feature1 =$_POST["feature1"];
  $feature2 = $_POST["feature2"];
  $feature3 = $_POST["feature3"];
  $post_period = $_POST["post_period"];
  $password = $random_string = bin2hex(random_bytes(8));;
  $area_id=  $_POST["area_id"];
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $clients_email_sql = "SELECT email FROM clients";
  $clients_email_stmt = $dbh->prepare($clients_email_sql);
  $clients_email_stmt->execute();
  $clients_email = $clients_email_stmt->fetchAll();

  foreach ($clients_email as $client_email) {
    if ($client_email['email'] === $email) {
      $_SESSION['error'] = 'このメールアドレスは既に登録されています。';
      header('Location: create.php');
      exit();
    }
  }

  $ext = pathinfo($_FILES['service_image']['name'], PATHINFO_EXTENSION);
  $file_name = uniqid() . "." . $ext;
  move_uploaded_file($_FILES['service_image']['tmp_name'], "../../assets/img/service_images/$file_name");
  $service_image = $file_name;

  $sql = "INSERT INTO clients (company_name, service_name, remote_available, service_url, email, feature1, feature2, feature3, service_image, post_period, password, area_id ) VALUES (:company_name, :service_name, :remote_available, :service_url, :email, :feature1, :feature2, :feature3, :service_image, :post_period, :password, :area_id)";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':company_name', $company_name);
  $stmt->bindValue(':service_name', $service_name);
  $stmt->bindValue(':remote_available', $remote_available);
  $stmt->bindValue(':service_url', $service_url);
  $stmt->bindValue(':email', $email);
  $stmt->bindValue(':feature1', $feature1);
  $stmt->bindValue(':feature2', $feature2);
  $stmt->bindValue(':feature3', $feature3);
  $stmt->bindValue(':service_image', $service_image);
  $stmt->bindValue(':post_period', $post_period);
  $stmt->bindValue(':password', $hashedPassword);
  $stmt->bindValue(':area_id', $area_id);
  $stmt->execute();
  $user = $stmt->fetch();

  if ($remote_available == 1) {
    $remote_available_message = "リモート可";
  } else {
    $remote_available_message = "リモート不可";
  }

  $area = $areas[$area_id - 1]['name'];

  $to = $email;
  $subject = "【CRAFT】登録完了のお知らせ";
  $message = "サービス情報の登録が完了しました。\n\n";
  $message .= "会社名：" . $company_name . "\n";
  $message .= "サービス名：" . $service_name . "\n";
  $message .= "サービスURL：" . $service_url . "\n";
  $message .= "エリア：" . $area . "\n";
  $message .= "リモート可否：" . $remote_available_message . "\n";
  $message .= "特徴①：" . $feature1 . "\n";
  $message .= "特徴②：" . $feature2 . "\n";
  $message .= "特徴③：" . $feature3 . "\n";
  $message .= "掲載期間：" . $post_period . "\n\n";
  $message .= "ログイン情報\n";
  $message .= "メールアドレス：" . $email . "\n";
  $message .= "パスワード：" . $password . "\n\n";
  $message .= "パスワードはログイン後に変更できます。\n";

  mail($to, $subject, $message);

  header('Location: ../');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRAFT for Admin | クライアント追加</title>
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
  <section class="admin-client-add-hero">
      <div class="hero-top">
        <p class="hero-text-left">クライアント追加</p>
          <a href="../">戻る</a>
        </div>
      </div>
      <div><?php if(!empty($_SESSION['error'])) {$_SESSION['error'];} ?></div>
      <form method="POST" class="create" enctype="multipart/form-data">
        <table  class="all-entries-info-table">
          <tr>
            <th class="table-th">会社名</th>
            <th class="th-odd">
              <input name="company_name" class="admin-add-input-odd" type="text" placeholder="株式会社レバテック" required>
            </th>
          </tr>
          <tr>
            <th class="table-th">サービス名</th>
            <th class="th-even">
              <input name="service_name" class="admin-add-input-even" type="text" placeholder="レバテックルーキー" required>
            </th>
          </tr>
          <tr>
            <th class="table-th">対応可能エリア</th>
              <th class="th-odd">
                <select name="area_id" class="admin-add-select" required>対応可能エリア
                  <?php foreach ($areas as $area) { ?>
                    <option value="<?= $area['id'] ?>" class="th-odd"><?= $area['name'] ?></option>
                  <?php } ?>
                </th>
          </tr>
          <tr>
            <th class="table-th">リモート対応</th>
              <th class="th-even">
                <select name="remote_available" class="admin-add-select" required>リモート対応
                  <option value="1" class="th-even">可</option>
                  <option value="0" class="th-even">不可</option>
                </select>
              </th>
          </tr>
          <tr>
            <th class="table-th">サービスurl</th>
            <th class="th-odd">
              <input name="service_url" class="admin-add-input-odd" type="url" placeholder="https://example.com" required>
            </th>
          </tr>
          <tr>
            <th class="table-th">メールアドレス</th>
            <th class="th-even">
              <input name="email" class="admin-add-input-even" type="email" placeholder="xxxxxxxxxxxxx@example.com" required>
            </th>
          </tr>
          <tr>
            <th name="password" class="table-th">パスワード</th>
            <th class="th-odd"><p class="admin-add-text">自動割り当て</p></th>
          </tr>
          <tr>
            <th class="table-th">特徴1</th>
            <th class="th-even">
              <input name="feature1" class="admin-add-input-even" type="text" placeholder="自宅で簡単にオンラインカウンセリングが受けられる" required>
            </th>
          </tr>
          <tr>
            <th class="table-th">特徴2</th>
            <th class="th-odd">
              <input name="feature2" class="admin-add-input-odd" type="text" placeholder="選考対策してもらえるので内定率が高い" required>
            </th>
          </tr>
          <tr>
            <th class="table-th">特徴3</th>
            <th class="th-even">
              <input name="feature3" class="admin-add-input-even" type="text" placeholder="WEB業界に関して深い知識を持ったスタッフを多数抱えている" required>
            </th>
          </tr>
          <tr>
            <th class="table-th">掲載期間</th>
            <th class="th-odd">
              <input name="post_period" type="date" required>
            </th>
          </tr>
          <tr>
            <th class="table-th">サービス写真</th>
            <th class="th-even">
              <input name="service_image" type="file" required>
            </th>
          </tr>
        </table>
        <div class="button-container">
          <button class="add-button" type="submit">追加する</button>
          <a class="cancel-button" href="../index.php">キャンセル</a>
        </div>
      </form>
  </section>
</body>
</html>
