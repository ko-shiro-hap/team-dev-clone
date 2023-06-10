<?php
declare(strict_types = 1);

require('../db/pdo.php');

$now = date('Y-m-d H:i:s');
$client_ids = $_POST['agent-ids'];

  try {
    $entries_sql = "INSERT INTO entries (student_name, sex_id, univ_dept_major, graduation_year, residence_prefecture, phone_number, email, is_active, created_at, updated_at, client_id) VALUES (:student_name, :sex_id, :univ_dept_major, :graduation_year, :residence_prefecture, :phone_number, :email, :is_active, :created_at, :updated_at, :client_id)";

    $entries_stmt = $dbh->prepare($entries_sql);
    $entries_stmt->bindParam(":student_name", $_POST['student_name']);
    $entries_stmt->bindParam(":sex_id", $_POST['sex']);
    $entries_stmt->bindParam(":univ_dept_major", $_POST['univ_dept_major']);
    $entries_stmt->bindParam(":graduation_year", $_POST['graduation_year']);
    $entries_stmt->bindParam(":residence_prefecture", $_POST['residence_prefecture']);
    $entries_stmt->bindParam(":phone_number", $_POST['phone_number']);
    $entries_stmt->bindParam(":email", $_POST['email']);
    $entries_stmt->bindValue(":is_active", 1);
    $entries_stmt->bindParam(":created_at", $now);
    $entries_stmt->bindParam(":updated_at", $now);

    $clients_sql = "SELECT id, email, service_name FROM clients WHERE id = :client_id";

    // idが複数の場合はその分だけ実行
    if(is_array($client_ids)) {
      foreach($client_ids as $client_id) {
        $entries_stmt->bindValue(":client_id", $client_id);
        $entries_stmt->execute();

        $clients_stmt = $dbh->prepare($clients_sql);
        $clients_stmt->bindValue(":client_id", $client_id);
        $clients_stmt->execute();
        $client = $clients_stmt->fetch(PDO::FETCH_ASSOC);

        $to = $client['email'];
        $subject = '【エントリー通知】エントリーがありました';
        $message =  $client['service_name'] . '様' . "\n" . "" . "\n" . '学生より新規エントリーがありましたのでお知らせいたします。' . "\n" . "" . "\n" . '以下のリンクよりエントリー内容をご確認ください' . "\n" . 'http://localhost/client/auth/login.php';


        mail($to, $subject, $message);

        $to = $_POST['email'];
        $subject = '【エントリー完了】エントリーが完了しました';
        $message =  $_POST['student_name'] . "様" ."\n" . "" . "\n" . "この度はお申し込みくださり誠にありがとうございます。" . "\n" . "" . "\n" . "エントリーが完了しました。" . "\n" ."エントリーしたエージェントからの連絡をお待ちください。\n" . "" . "\n" . "エントリーされたエージェント名: " . $client['service_name'];

        mail($to, $subject, $message);
      }
    } else {
      $entries_stmt->bindValue(":client_id", $client_ids);
      $entries_stmt->execute();

      $clients_stmt = $dbh->prepare($clients_sql);
      $clients_stmt->bindValue(":client_id", $client_ids);
      $clients_stmt->execute();
      $client = $clients_stmt->fetch(PDO::FETCH_ASSOC);

      $to = $client['email'];
      $subject = '【エントリー通知】エントリーがありました';
      $message = $client['service_name'] . '様' . "\n" . "" . "\n" . '学生より新規エントリーがありましたのでお知らせいたします。' . "\n" . "" . "\n" . '以下のリンクよりエントリー内容をご確認ください' . "\n" . 'http://localhost/client/auth/login.php';

      mail($to, $subject, $message);

      $to = $_POST['email'];
      $subject = '【エントリー完了】エントリーが完了しました';
      $message = $_POST['student_name'] . "様" ."\n" . "" . "\n" . "この度はお申し込みくださり誠にありがとうございます。" . "\n" . "" . "\n" . "エントリーが完了しました。" . "\n" ."エントリーしたエージェントからの連絡をお待ちください。\n" . "" . "\n" . "エントリーされたエージェント名: " . $client['service_name'];
      mail($to, $subject, $message);
    }

    header('Location: ../completed/');
    exit();

  } catch (PDOException $e) {
    echo $e->getMessage();
    die();
  }
?>
