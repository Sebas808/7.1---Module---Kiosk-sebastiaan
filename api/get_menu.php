<?php
header("Content-Type: application/json");

require_once "../db/database.php";

$sql = "
SELECT 
    c.name AS category,
    p.product_id,
    p.name,
    p.description,
    p.price,
    p.kcal AS calories,
    p.image_id
FROM products p
JOIN categories c 
    ON p.category_id = c.category_id
WHERE p.available = 1
ORDER BY c.category_id, p.product_id
";

$stmt = $pdo->query($sql);
$menu = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($menu);
