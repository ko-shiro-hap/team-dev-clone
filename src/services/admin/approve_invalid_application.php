<?php
declare(strict_types = 1);

require('../../db/pdo.php');

  try {
    session_start();
    $entry_id = $_POST['entry_id'];

    $sql = "UPDATE entries SET is_active = 0 WHERE id = :entry_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":entry_id", $entry_id);
    $stmt->execute();

    $_SESSION['flash_message'] = "エントリーID:$entry_id の無効申請を承認しました。";

    $sql = "SELECT client_id FROM entries WHERE id = :entry_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":entry_id", $entry_id);
    $stmt->execute();
    $client_id = $stmt->fetch(PDO::FETCH_ASSOC)['client_id'];

    $sql = "SELECT email FROM clients WHERE id = :client_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":client_id", $client_id);
    $stmt->execute();
    $client_email = $stmt->fetch(PDO::FETCH_ASSOC)['email'];

    $to = $client_email;
    $subject = '【エントリー通知】エントリーID:' . $entry_id . 'の無効申請が承認されました';
    $message = 'エントリーID:' . $entry_id . 'の無効申請が承認されました' . "\n" . 'エントリー内容をご確認ください。' . "\n" . 'http://localhost/client/auth/login.php';

    mail($to, $subject, $message);

    header('Location: ../../admin/invalid-application/');
    exit();

  } catch (PDOException $e) {
    echo $e->getMessage();
    die();
  }
?>
