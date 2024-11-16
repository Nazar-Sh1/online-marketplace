<?php
header('Content-Type: application/json');

// Получаем параметры категории и подкатегории из URL
$category = $_GET['category'] ?? null;
$subcategory = $_GET['subcategory'] ?? null;

if ($category && $subcategory) {
    // Чтение данных из JSON-файла
    $jsonData = file_get_contents('data/products.json');
    $products = json_decode($jsonData, true);

    // Проверка наличия нужной категории и подкатегории
    if (isset($products[$category][$subcategory]['Models'])) {
        echo json_encode($products[$category][$subcategory]['Models']);
        exit;
    }
}

// Если категория или подкатегория не найдены, возвращаем сообщение об ошибке
echo json_encode(["error" => "Category or subcategory not found"]);
?>