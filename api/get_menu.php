<?php
header("Content-Type: application/json");

require_once "../db/database.php";

$sql = "
SELECT 
    p.product_id,
    p.name,
    p.description,
    p.price,
    p.kcal AS calories,
    c.name AS category,
    i.filename AS image_filename
FROM products p
JOIN categories c 
    ON p.category_id = c.category_id
LEFT JOIN images i
    ON p.image_id = i.image_id
WHERE p.available = 1
ORDER BY c.category_id, p.product_id
";

$stmt = $pdo->query($sql);
$menu = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($menu);