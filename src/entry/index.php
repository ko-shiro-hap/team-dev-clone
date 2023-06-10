<?php
$keep_ids = $_GET['keepIds'];

if(empty($keep_ids)) {
  header('Location: ../');
  exit();
}

if(strpos($keep_ids,',') !== false) {
  $keep_ids_array = explode(',', $keep_ids);
  $keep_ids = $keep_ids_array;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRAFT | エントリー</title>
  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/6c20dffe37.js" crossorigin="anonymous"></script>
  <!-- google-fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Eczar:wght@400;700&family=Noto+Sans+JP:wght@400;500;700&display=swap"
    rel="stylesheet">
  <!-- css -->
  <link rel="stylesheet" href="../assets/styles/reset.css">
  <link rel="stylesheet" href="../assets/styles/common.css">
  <link rel="stylesheet" href="../assets/styles/user/style.css">
  <!-- js -->
  <script src="../assets//js/user/entry.js" defer></script>
</head>
<body>
  <?php require('../components/header.php') ?>
  <section class="entry">
    <div class="entry-inner">
      <div class="entry-header-box">
        <div class="entry-header-content">
          <h2>エントリー</h2>
          <div class="entry-header-content-right">
            <a href="../">トップへ戻る</a>
          </div>
        </div>
      </div>
      <div class="entry-body-box">
        <div class="entry-body-content">
          <form method="POST" action="../services/create_entry.php" class="entry-body-contentin" id="entry-form">
            <div class="entry-name">
              <div class="entry-common-title">
                <i class="fa-solid fa-pen"></i>
                <h3>お名前</h3>
              </div>
              <input name="student_name" class="entry-common-form" type="text" placeholder="山田太郎" required>
            </div>
            <div class="entry-sex">
              <div class="entry-common-title">
                <i class="fa-solid fa-user"></i>
                <h3>性別</h3>
              </div>
              <div class="entry-sex-radio">
                <input type="radio" name="sex" value="1" checked>
                <p>男性</p>
                <input class="entry-sex-radio-woman" type="radio" name="sex" value="2">
                <p>女性</p>
                <input class="entry-sex-radio-woman" type="radio" name="sex" value="3">
                <p>その他</p>
              </div>
            </div>
            <div class="entry-mail">
              <div class="entry-common-title">
                <i class="fa-solid fa-envelope"></i>
                <h3>メールアドレス</h3>
              </div>
              <input name="email" class="entry-common-form" type="email" placeholder="xxxxxxxxx@example.com"
              required>
            </div>
            <div class="entry-phonenumber">
              <div class="entry-common-title">
                <i class="fa-solid fa-phone"></i>
                <h3>電話番号</h3>
              </div>
              <input name="phone_number" class="entry-common-form" type="number" placeholder="08012345678" required>
            </div>
            <div class="entry-prefecture">
              <div class="entry-common-title">
                <i class="fa-solid fa-map-location-dot"></i>
                <h3>お住まいの都道府県</h3>
              </div>
              <input name="residence_prefecture" class="entry-common-form" type="text" placeholder="東京都" required>
            </div>
            <div class="entry-school">
              <div class="entry-common-title">
                <i class="fa-solid fa-building"></i>
                <h3>学校名・学部・学科</h3>
              </div>
              <input name="univ_dept_major" type="text" class="entry-common-form" placeholder="xx大学・xx学部・xxxxxxx学科" required>
            </div>
            <div class="entry-name">
              <div class="entry-common-title">
                <i class="fa-sharp fa-solid fa-graduation-cap"></i>
                <h3>卒業予定年度</h3>
              </div>
              <select class="entry-select" name="graduation_year">
                <option value="2024">2024年</option>
                <option value="2025">2025年</option>
                <option value="2026">2026年</option>
                <option value="2027">2027年</option>
              </select>
            </div>
            <div class="entry-send">
              <button type="submit" class="entry-send-button" id="entry-send-button">送信</button>
            </div>
            <div class="entry-caution">
              <p>※エージェントからの連絡はメール、<br>または電話での対応となります。</p>
              <p>※エージェントからの連絡には数日かかる場合がございます。<br>ご了承ください。</p>
            </div>
            <?php
            if(is_array($keep_ids)) {
              foreach($keep_ids as $keep_id) {
                echo '<input type="hidden" name="agent-ids[]" value=' . $keep_id . '>';
              }
            } else {
              echo '<input type="hidden" name="agent-ids" value=' . $keep_ids . '>';
            }
            ?>
          </form>
        </div>
      </div>
    </div>
  </section>
  <?php require('../components/footer.php') ?>
</body>
</html>
