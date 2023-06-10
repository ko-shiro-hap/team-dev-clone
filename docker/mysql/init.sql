/* データベース */
DROP
    DATABASE IF EXISTS craft;
CREATE DATABASE craft; USE
    craft;

 /* テーブル */
 /* areas */
DROP TABLE IF EXISTS
    areas;
CREATE TABLE areas(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
) CHARSET = utf8; INSERT INTO areas(NAME)
VALUES ('北海道'),('東北'),('関東'),('中部'),('近畿'),('中国'),('四国'),('九州'), ('全国');

    /* clients */
DROP TABLE IF EXISTS
    clients;
CREATE TABLE clients(
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    service_name VARCHAR(255) NOT NULL,
    remote_available TINYINT(1) NOT NULL,
    service_url VARCHAR(2048) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    feature1 VARCHAR(255) NOT NULL,
    feature2 VARCHAR(255),
    feature3 VARCHAR(255),
    service_image VARCHAR(255) NOT NULL,
    post_period DATE NOT NULL,
    password VARCHAR(255) NOT NULL,
    area_id INT NOT NULL,
    FOREIGN KEY(area_id) REFERENCES areas(id)
) CHARSET = utf8; INSERT INTO clients(
    company_name,
    service_name,
    remote_available,
    service_url,
    email,
    feature1,
    feature2,
    feature3,
    service_image,
    post_period,
    password,
    area_id
)
VALUES(
    'Levtech レバテック株式会社',
    'レバテックルーキー',
    1,
    'https://www.levtech.jp/',
    'levetech@agent.com',
    '自宅で簡単にオンラインカウンセリングが受けられる',
    '選考対策してもらえるので内定率が高い',
    'WEB業界に関して深い知識を持ったスタッフを多数抱えている!',
    'revtech.png',
    '2023-12-31',
    "$2y$10$bY3m0fzVCgBc./.sJZc4oO2b/r.qDVYjqmEtOst6MsaCw6uQlVvSO",
    9
),(
    '株式会社リクルート',
    'リクナビ就活エージェント',
    1,
    'https://job.rikunabi.com/agent/',
    'rikunabi@agent.com',
    '履歴書一枚で複数の企業にエントリーできる！',
    '面接アドバイスや履歴書添削を何度でも受けられる',
    '企業の選考ポイントを独自に収集しているため適切なアドバイスを受けられる!',
    'rikunabi.png',
    '2023-12-31',
    "$2y$10$tTLEEYugGSEQtttqCRcXyOOZQExPj3Cj7253dr7er4HK4PeiRzDjO",
    9
),(
    '株式会社ネオキャリア',
    '就職エージェントneo',
    0,
    'https://www.s-agent.jp/form/lp/',
    'neocareer@agent.com',
    '最短約2週間で内定獲得可能!',
    '応募⼿続き、選考の⽇程調整を代⾏してもらえる',
    '内定獲得後のサポートもあるので安心して依頼できる!',
    'neo.png',
    '2023-12-31',
    "$2y$10$wEs6nrslc0ti1vNGwktNR.G3v2c5DaVQnAVpAObE0mKyEQhO60LY6",
    5
),(
    '株式会社ディスコ',
    'キャリタス就活エージェント',
    0,
    'https://agent.career-tasu.jp/',
    'kyaritasu@agent.com',
    'ホワイト企業と認定した企業を厳選して紹介してもらえる',
    '面接後もフィードバックをもらえるので、着実に成長できる',
    '創業以来40年以上の就活情報提供実績がある!',
    'kyaritasu.jpg',
    '2023-12-31',
    "$2y$10$NeGS/vKo/LDF0uwAtwB54.nNur4jfDwC.JA8tzs/.xXiETtgjPEk.",
    4
),(
    '株式会社システムリンク',
    'ITなび就活',
    1,
    'https://itnabi.com/shukatsu/lp/events',
    'itnabi@agent.com',
    '東京のIT中小企業に特化しているのでIT業界への就職を希望する就活生におすすめ',
    '書類選考なしでいきなり複数の企業と面談できる!',
    'LINEでいつでも就活について相談できる!',
    'itnabi.png',
    '2023-12-31',
    "$2y$10$YZ9Omj6tIgxe8DzmrtMGvu2f8N7YRn.TFX0QuzZFk7aV2TAYwqmL.",
    9
);

/* industries */
DROP TABLE IF EXISTS
    industries;
CREATE TABLE industries(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
) CHARSET = utf8; INSERT INTO industries(NAME)
VALUES('IT'),('金融'),('サービス'),('マスコミ'),('メーカー'),('商社'),('ソフトウェア・通信'),('官公庁・公社・団体'),('小売');

/* client_industry 中間テーブル*/
DROP TABLE IF EXISTS
    client_industry;
CREATE TABLE client_industry(
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    industry_id INT NOT NULL,
    FOREIGN KEY(client_id) REFERENCES clients(id),
    FOREIGN KEY(industry_id) REFERENCES industries(id)
) CHARSET = utf8; INSERT INTO client_industry(client_id, industry_id)
VALUES(1, 1),(1, 2),(2, 3),(3, 4),(3, 5),(4, 6),(4, 7),(4, 8),(3, 9);

/* sexes */
DROP TABLE IF EXISTS
    sexes;
CREATE TABLE sexes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    sex VARCHAR(255) NOT NULL
) CHARSET = utf8; INSERT INTO sexes(sex)
VALUES("男性"),("女性"),("その他");

/* entries */
DROP TABLE IF EXISTS
    entries;
CREATE TABLE entries(
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(255) NOT NULL,
    sex_id TINYINT(2) NOT NULL,
    univ_dept_major VARCHAR(255) NOT NULL,
    graduation_year YEAR NOT NULL,
    residence_prefecture VARCHAR(255) NOT NULL,
    phone_number VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    is_active TINYINT(1) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    client_id INT NOT NULL,
    /* FOREIGN KEY(sex_id) REFERENCES sexes(id), */
    FOREIGN KEY(client_id) REFERENCES clients(id)
) CHARSET = utf8;
INSERT INTO entries (student_name, sex_id, univ_dept_major, graduation_year, residence_prefecture, phone_number, email, is_active, created_at, updated_at, client_id)
VALUES
('山田花子', 2, '東京大学 経済学部', '2024', '神奈川県', '09098765432', 'hanako.yamada@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('田中太郎', 1, '京都大学 工学部', '2027', '京都府', '07012345678', 'taro.tanaka@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('佐藤さやか', 2, '一橋大学 社会学部', '2025', '埼玉県', '08087654321', 'sayaka.sato@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('加藤将之', 1, '東北大学 文学部', '2026', '宮城県', '08011112222', 'masayuki.kato@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('高橋由美', 2, '神戸大学 教育学部', '2024', '兵庫県', '09011112222', 'yumi.takahashi@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('渡辺光男', 1, '北海道大学 農学部', '2025', '北海道', '0111234567', 'mitsuo.watanabe@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('松本美穂', 2, '慶應義塾大学 法学部', '2027', '東京都', '08055556666', 'miho.matsumoto@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('岡田健太', 1, '名古屋大学 経済学部', '2026', '愛知県', '0521234567', 'kenta.okada@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('吉田千夏', 2, '早稲田大学 商学部', '2024', '東京都', '08022223333', 'chika.yoshida@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('小林美咲', 2, '立命館大学 文学部', '2026', '京都府', '0751234567', 'misaki.kobayashi@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('西村健太', 1, '大阪大学 工学部', '2024', '大阪府', '08044445555', 'kenta.nishimura@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('斉藤亜由美', 2, '東京理科大学 理学部', '2027', '東京都', '08077778888', 'ayumi.saito@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('木村裕子', 2, '広島大学 法学部', '2025', '広島県', '08088889999', 'yuko.kimura@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('石田雄介', 1, '九州大学 理学部', '2024', '福岡県', '0921234567', 'yusuke.ishida@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('宮本里佳', 2, '東京女子大学 教育学部', '2026', '東京都', '08099990000', 'rika.miyamoto@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('近藤直樹', 1, '神奈川大学 工学部', '2025', '神奈川県', '0451234567', 'naoki.kondo@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('岩崎美香', 2, '大阪市立大学 文学部', '2027', '大阪府', '08022225555', 'mika.iwasaki@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('渡部大輔', 1, '神戸大学 工学部', '2024', '兵庫県', '0781234567', 'daisuke.watabe@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('高田結衣', 2, '明治大学 理工学部', '2025', '東京都', '08044446666', 'yui.takada@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('山口正彦', 1, '京都府立大学 工学部', '2026', '京都府', '0751234567', 'masahiko.yamaguchi@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('中川千佳', 2, '関西大学 経済学部', '2024', '大阪府', '08055557777', 'chika.nakagawa@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('杉本浩太', 1, '神戸市外国語大学 言語文化学部', '2027', '兵庫県', '08033334444', 'kota.sugimoto@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('佐々木美咲', 2, '広島市立大学 法学部', '2025', '広島県', '08077778888', 'misaki.sasaki@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('内藤浩二', 1, '東京農工大学 農学部', '2026', '千葉県', '0431234567', 'koji.naito@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('小笠原真央', 2, '立教大学 法学部', '2024', '東京都', '08099992222', 'mao.ogasawara@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('小川幸介', 1, '北海道大学 経済学部', '2025', '北海道', '0111234567', 'kosuke.ogawa@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('上田里奈', 2, '東京大学 文学部', '2026', '東京都', '08088889999', 'rina.ueda@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('岡本健一', 1, '京都産業大学 商学部', '2024', '京都府', '0751234567', 'kenichi.okamoto@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('武田裕子', 2, '名城大学 社会学部', '2025', '愛知県', '0521234567', 'yuko.takeda@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('吉岡拓海', 1, '金沢大学 文学部', '2027', '石川県', '0761234567', 'takumi.yoshioka@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('山下真弓', 2, '東京都立大学 社会科学部', '2024', '東京都', '08022224444', 'mayumi.yamashita@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('石川拓也', 1, '大阪市立大学 工学部', '2025', '大阪府', '08033335555', 'takuya.ishikawa@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('中村亜希', 2, '同志社大学 社会学部', '2026', '京都府', '0751234567', 'aki.nakamura@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('大西孝太郎', 1, '九州工業大学 工学部', '2027', '福岡県', '0921234567', 'kotaro.onishi@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('高野美咲', 2, '神戸女学院大学 文学部', '2025', '兵庫県', '08044447777', 'misaki.takano@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('佐久間健一', 1, '明治学院大学 経済学部', '2026', '神奈川県', '0451234567', 'kenichi.sakuma@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('西川綾子', 2, '関東学院大学 法学部', '2024', '神奈川県', '09011110000', 'ayako.nishikawa@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('古川拓也', 1, '神奈川工科大学 工学部', '2025', '神奈川県', '0451234567', 'takuya.furukawa@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('村上真央', 2, '関西外国語大学 国際学部', '2026', '大阪府', '08099993333', 'mao.murakami@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('河野俊介', 1, '静岡大学 農学部', '2024', '静岡県', '0541234567', 'shunsuke.kono@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),('松本大輔', 1, '早稲田大学 商学部', '2026', '東京都', '08077779999', 'daisuke.matsumoto@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('水野まどか', 2, '明治大学 経済学部', '2024', '東京都', '08088881111', 'madoka.mizuno@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('中島健太', 1, '神戸大学 文学部', '2027', '兵庫県', '0781234567', 'kenta.nakajima@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('井上麻美', 2, '早稲田大学 社会科学部', '2025', '東京都', '08022228888', 'asami.inoue@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('小島隆太', 1, '九州大学 文学部', '2024', '福岡県', '0921234567', 'ryuta.kojima@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('高橋沙織', 2, '日本女子大学 文学部', '2026', '東京都', '08033336666', 'saori.takahashi@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('伊藤健一', 1, '九州大学 工学部', '2025', '福岡県', '0921234567', 'kenichi.ito@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('石井美穂', 2, '青山学院大学 社会情報学部', '2024', '東京都', '08099996666', 'miho.ishii@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('山田直樹', 1, '大阪府立大学 工学部', '2025', '大阪府', '08044449999', 'naoki.yamada@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('高柳桃子', 2, '北海道教育大学 教育学部', '2026', '北海道', '0111234567', 'momoko.takayanagi@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),('田中千春', 2, '京都大学 経済学部', '2025', '京都府', '0751234567', 'chiho.tanaka@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('大橋俊介', 1, '名古屋大学 理学部', '2026', '愛知県', '0521234567', 'shunsuke.ohashi@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('佐藤みなみ', 2, '中央大学 法学部', '2024', '東京都', '08088882222', 'minami.sato@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('福田康太', 1, '京都大学 工学部', '2025', '京都府', '0751234567', 'kota.fukuda@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('栗田智也', 1, '長崎大学 理学部', '2026', '長崎県', '0951234567', 'chiya.kurita@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('石塚美咲', 2, '大阪教育大学 教育学部', '2024', '大阪府', '08033337777', 'misaki.ishizuka@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('山内俊介', 1, '岡山大学 農学部', '2027', '岡山県', '0861234567', 'shunsuke.yamauchi@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('鈴木美穂', 2, '大阪市立大学 基礎工学部', '2025', '大阪府', '08022229999', 'miho.suzuki@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('松井太郎', 1, '北海道大学 工学部', '2026', '北海道', '0111234567', 'taro.matsui@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('岡崎結衣', 2, '神奈川大学 文学部', '2024', '神奈川県', '09022223333', 'yui.okazaki@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),('小野田和也', 1, '立命館大学 経済学部', '2026', '京都府', '0751234567', 'kazuya.onoda@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('高岡真梨子', 2, '慶應義塾大学 法学部', '2024', '東京都', '08011112222', 'mariko.takaoka@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('坂本勝己', 1, '名古屋工業大学 工学部', '2025', '愛知県', '0521234567', 'katsumi.sakamoto@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('今井明美', 2, '北海道大学 文学部', '2026', '北海道', '0111234567', 'akemi.imai@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('宮下健太', 1, '神戸大学 工学部', '2024', '兵庫県', '0781234567', 'kenta.miyashita@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('清水智之', 1, '金沢大学 理工学域', '2025', '石川県', '0761234567', 'tomoyuki.shimizu@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('木村真理子', 2, '関西大学 社会学部', '2026', '兵庫県', '08055552222', 'mariko.kimura@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('中村雄太', 1, '早稲田大学 教育学部', '2024', '東京都', '08088883333', 'yuta.nakamura@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('岡崎美穂', 2, '立教大学 経済学部', '2025', '東京都', '08011113333', 'miho.okazaki@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),('河野真央', 2, '東京都市大学 理学部', '2024', '東京都', '08033334444', 'mao.kono@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('渡辺慎也', 1, '神戸大学 経済学部', '2025', '兵庫県', '0781234567', 'shinya.watanabe@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('青木由美', 2, '中央大学 商学部', '2026', '東京都', '08022226666', 'yumi.aoki@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('菅原大輔', 1, '筑波大学 工学系', '2024', '茨城県', '0291234567', 'daisuke.sugawara@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('橋本恵子', 2, '京都教育大学 教育学部', '2025', '京都府', '0751234567', 'keiko.hashimoto@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('三浦拓海', 1, '東京大学 工学部', '2026', '東京都', '08044447777', 'takumi.miyaura@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('山口千晶', 2, '北海道大学 経済学部', '2024', '北海道', '0111234567', 'chiaki.yamaguchi@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('野村大介', 1, '大阪大学 文学部', '2027', '大阪府', '08055552222', 'daisuke.nomura@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('吉川美咲', 2, '名古屋大学 文学部', '2025', '愛知県', '0521234567', 'misaki.yoshikawa@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('佐々木大地', 1, '広島大学 工学部', '2026', '広島県', '0821234567', 'daichi.sasaki@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),('山田健太', 1, '九州大学 工学部', '2025', '福岡県', '0921234567', 'kenta.yamada@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('中川彩子', 2, '一橋大学 社会学部', '2026', '東京都', '08022228888', 'ayako.nakagawa@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('小松和也', 1, '名古屋大学 理学部', '2024', '愛知県', '0521234567', 'kazuya.komatsu@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('小山恵子', 2, '横浜国立大学 工学部', '2025', '神奈川県', '0451234567', 'keiko.koyama@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('鈴木宏樹', 1, '早稲田大学 政治経済学部', '2026', '東京都', '08077771111', 'hiroki.suzuki@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('小野寺美穂', 2, '日本大学 文理学部', '2024', '東京都', '08011114444', 'miho.onodera@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('伊藤翔太', 1, '東京工業大学 工学部', '2025', '東京都', '08088889999', 'shotaro.ito@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('鈴木健太', 1, '東京大学 経済学部', '2026', '東京都', '08066663333', 'kenta.suzuki@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('高木理沙', 2, '神戸大学 法学部', '2024', '兵庫県', '0781234567', 'risa.takagi@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('小林雄介', 1, '早稲田大学 商学部', '2025', '東京都', '08044448888', 'yusuke.kobayashi@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),('森下正和', 1, '名古屋大学 工学部', '2024', '愛知県', '0521234567', 'masakazu.morishita@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('松岡朋子', 2, '京都大学 文学部', '2025', '京都府', '0751234567', 'tomoko.matsuoka@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('山崎健太', 1, '大阪大学 経済学部', '2026', '大阪府', '08033332222', 'kenta.yamazaki@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('浜田佳奈', 2, '横浜市立大学 教育人間科学部', '2024', '神奈川県', '0451234567', 'kana.hamada@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('田中宏樹', 1, '九州大学 理学部', '2025', '福岡県', '0921234567', 'hiroki.tanaka@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('山田さゆり', 2, '東京都市大学 理工学部', '2026', '東京都', '08044445555', 'sayuri.yamada@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('杉山達也', 1, '名古屋大学 文学部', '2024', '愛知県', '0521234567', 'tatsuya.sugiyama@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('岩井美咲', 2, '北海道大学 理学部', '2025', '北海道', '0111234567', 'misaki.iwai@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('菊池晃司', 1, '神戸大学 工学部', '2026', '兵庫県', '0781234567', 'koji.kikuchi@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('山下真由美', 2, '横浜国立大学 文学部', '2024', '神奈川県', '0451234567', 'mayumi.yamashita@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),('大久保千晶', 2, '中央大学 法学部', '2026', '東京都', '08022223333', 'chiaki.okubo@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('福島優', 2, '神戸大学 文学部', '2024', '兵庫県', '0781234567', 'yuu.fukushima@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('伊藤康夫', 1, '東京工業大学 理学部', '2025', '東京都', '08066667777', 'yasuo.ito@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('吉田春菜', 2, '北海道大学 農学部', '2026', '北海道', '0111234567', 'haruna.yoshida@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('中島敦史', 1, '名古屋大学 理学部', '2024', '愛知県', '0521234567', 'atoshi.nakajima@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('森田舞', 2, '京都大学 教育学部', '2025', '京都府', '0751234567', 'mai.morita@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('松本秀夫', 1, '大阪大学 工学部', '2026', '大阪府', '08077772222', 'hideo.matsumoto@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('山崎直美', 2, '横浜市立大学 商学部', '2024', '神奈川県', '0451234567', 'naomi.yamazaki@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('吉田勇輝', 1, '早稲田大学 法学部', '2025', '東京都', '08011117777', 'yuuki.yoshida@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('渡辺幸恵', 2, '一橋大学 経済学部', '2026', '東京都', '08022227777', 'sachie.watanabe@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),('田中結花', 2, '京都大学 工学部', '2025', '京都府', '0751234567', 'yuka.tanaka@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('佐々木和也', 1, '東京工業大学 理学部', '2026', '東京都', '08033334444', 'kazuya.sasaki@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('金子麻衣', 2, '北海道教育大学 文学部', '2024', '北海道', '0111234567', 'mai.kaneko@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('伊藤蓮', 1, '九州大学 文学部', '2025', '福岡県', '0921234567', 'ren.ito@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('田辺裕也', 1, '早稲田大学 教育学部', '2026', '東京都', '08066665555', 'yuuya.tanabe@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('山本彩', 2, '神戸大学 文学部', '2024', '兵庫県', '0781234567', 'aya.yamamoto@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('清水洋一', 1, '名古屋大学 理学部', '2025', '愛知県', '0521234567', 'yoichi.shimizu@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('岡本真希', 2, '横浜市立大学 医学部', '2026', '神奈川県', '0451234567', 'maki.okamoto@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('小林拓海', 1, '一橋大学 商学部', '2024', '東京都', '08022229999', 'takumi.kobayashi@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1),
('田村愛', 2, '北海道大学 経済学部', '2025', '北海道', '0111234567', 'ai.tamura@example.com', 1, NOW(), NOW(), FLOOR(RAND() * 5) + 1);

/* administrators */
DROP TABLE IF EXISTS
    administrators;
CREATE TABLE administrators(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
) CHARSET = utf8;
INSERT INTO administrators(name, email, password)
VALUES("test", "admin@example.com", "$2y$10$qSod25g.sZn6Oj6fRQXvkeBmtrXkQQ.xOCw0v1SpeRgM7.YS879.O");
