<?php
header("Content-Type: application/json");

require_once "../db/database.php";

// Get raw POST data
$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData, true);

if (!$data || !isset($data['cart']) || empty($data['cart'])) {
    echo json_encode(["success" => false, "message" => "Geen items in mandje"]);
    exit;
}

$cart = $data['cart'];
$totalPrice = 0;
foreach ($cart as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

try {
    $pdo->beginTransaction();

    // 1. Get last pickup number
    $stmt = $pdo->query("SELECT pickup_number FROM orders ORDER BY order_id DESC LIMIT 1");
    $lastOrder = $stmt->fetch(PDO::FETCH_ASSOC);

    $lastNum = $lastOrder ? (int) $lastOrder['pickup_number'] : 0;
    $nextNum = ($lastNum % 99) + 1;
    $pickupNumber = str_pad($nextNum, 2, "0", STR_PAD_LEFT);

    // 2. Insert order
    $stmt = $pdo->prepare("INSERT INTO orders (order_status_id, pickup_number, price_total, datetime) VALUES (?, ?, ?, NOW())");
    $stmt->execute([1, $pickupNumber, $totalPrice]); // Assuming 1 is 'Pending/Busy'
    $orderId = $pdo->lastInsertId();

    // 3. Insert products
    $stmtProd = $pdo->prepare("INSERT INTO order_product (order_id, product_id, price) VALUES (?, ?, ?)");
    foreach ($cart as $item) {
        // Since order_product doesn't have a quantity according to our DESCRIBE, 
        // we might need to insert multiple rows if quantity > 1, 
        // OR check if we missed something. 
        // Let's check the schema again carefully.
        for ($i = 0; $i < $item['quantity']; $i++) {
            $stmtProd->execute([$orderId, $item['product_id'], $item['price']]);
        }
    }

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "order_id" => $orderId,
        "pickup_number" => $pickupNumber
    ]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(["success" => false, "message" => "Database fout: " . $e->getMessage()]);
}
?>