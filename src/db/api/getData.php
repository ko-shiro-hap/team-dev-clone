<?php
header("Content-Type: application/json");
include '../pdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['sql'])) {
  $sql = $_POST['sql'];
  try {
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() == 0) {
      $result = 0;
    } else {
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    echo json_encode($result);
  } catch(PDOException $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
  }
} else {
  http_response_code(400);
  echo json_encode(['error' => 'SQL query is required.']);
}
?>
