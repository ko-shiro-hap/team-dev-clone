<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRAFT | 就活エージェント比較</title>
  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/6c20dffe37.js" crossorigin="anonymous"></script>
  <!-- google-fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Eczar:wght@400;700&family=Noto+Sans+JP:wght@400;500;700&family=Zen+Maru+Gothic:wght@700&display=swap" rel="stylesheet">
  <!-- css -->
  <link rel="stylesheet" href="./assets/styles/reset.css">
  <link rel="stylesheet" href="./assets/styles/common.css">
  <link rel="stylesheet" href="./assets/styles/user/style.css">
  <!-- js -->
  <script src="./assets/js/db/fetchData.js" defer></script>
  <script src="./assets/js/user/index.js" defer></script>
</head>
<body id="body">
  <?php require('./components/header.php') ?>

  <!-- start hero -->
  <section class="hero">
    <div class="hero-img-container">
      <img src="./assets/img/undraw_career_progress_ivdb.svg" alt="">
    </div>
    <div class="hero-text-container">
      <h2>学生が作った<br>学生に寄り添った<br>就活エージェント比較</h2>
      <ul>
        <li>
          <div class="hero-checkbox">
            <span>✔︎</span>
          </div>
          <p>好みのエージェントを絞り込み可能！</p>
        </li>
        <li>
          <div class="hero-checkbox">
            <span>✔︎</span>
          </div>
          <p>複数のエージェントを比較できる！</p>
        </li>
        <li>
          <div class="hero-checkbox">
            <span>✔︎</span>
          </div>
          <p>一括で簡単に申し込みができる！</p>
        </li>
      </ul>
    </div>
  </section>
  <!-- end hero -->
  <main class="main">
    <!-- start sidebar -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-search-header" id="sidebar-header">
        <div>
          <div class="sidebar-search-header-icon" id="sidebar-icon"></div>
          <h2>絞り込み</h2>
        </div>
        <p id="agent-count"><span>?/?</span>件</p>
      </div>
      <div class="sidebar-body" id="sidebar-body">
        <div class="sidebar-search-body" id="search-body">
          <div class="sidebar-search-content">
            <h3>
              <i class="fa-solid fa-map-location-dot"></i>
              エリア
            </h3>
            <select name="area" id="area-select" class="sidebar-input">
              <option value=0>指定なし</option>
              <!-- jsで生成 -->
            </select>
          </div>
          <div class="sidebar-search-content">
            <h3>
              <i class="fa-solid fa-shapes"></i>
              業界
            </h3>
            <select name="industry" id="industry-select" class="sidebar-input">
              <option value=0>指定なし</option>
              <!-- jsで生成 -->
            </select>
          </div>
          <div class="sidebar-search-content">
            <h3>
              <i class="fa-solid fa-laptop-code"></i>
              リモート対応
            </h3>
            <label class="checkbox-wrap">
              <input type="checkbox" id="remote-available-checkbox" class="sidebar-input">
              <span class="checkmark"></span>
              可
            </label>
          </div>
          <div>
            <button class="sidebar-search-clear" id="clear-button">絞り込みクリア</button>
          </div>
        </div>
        <div class="sidebar-keep-header">
          <div class="sidebar-keep-header-title">
            <i class="fa-solid fa-list-check"></i>
            <h2>
              キープ
            </h2>
          </div>
          <div class="sidebar-keep-header-count">
            <span id="keep-count">0</span>
          </div>
        </div>
        <div class="sidebar-keep-body" id="keep-body">
          <p>キープ中のエージェントは<br>存在しません。</p>
        </div>
        <form method="get" action="./entry/">
          <input type="hidden" name="keepIds" id="keep-ids-input">
          <button type="submit" class="sidebar-keep-button" id="entry-button" disabled>
            エントリーする
            <span>✔︎</span>
          </button>
        </form>
      </div>
    </aside>
    <!-- end sidebar -->
    <!-- start agent-list -->
    <section class="agent-list" id="agent-list">
      <div class="agent-list-container">
        <div class="agent-list-header">
          <div>
            <h2 id="agent-list-headline">エージェント一覧</h2>
          </div>
        </div>
        <div class="agent-list-items" id="agent-container">
          <!-- jsで生成 -->
        </div>
      </div>
    </section>
    <!-- end agent-list -->
  </main>

  <?php require('./components/footer.php') ?>
</body>
</html>

