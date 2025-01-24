<?php
header('Content-Type: application/json');

if (!isset($_GET['url']) || empty($_GET['url'])) {
    echo json_encode(['error' => 'Missing or empty category URL']);
    exit;
}

$categoryUrl = $_GET['url'];
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $categoryUrl . "?p=" . $page);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$html = curl_exec($ch);
if (curl_errno($ch)) {
    echo json_encode(['error' => 'Failed to fetch the page: ' . curl_error($ch)]);
    curl_close($ch);
    exit;
}
curl_close($ch);

libxml_use_internal_errors(true);
$dom = new DOMDocument();
$dom->loadHTML($html);
libxml_clear_errors();

$xpath = new DOMXPath($dom);
$productNodes = $xpath->query("//div[contains(@class, 'product-item-info')]");

$products = [];

foreach ($productNodes as $product) {
    $imgNode = $xpath->query(".//img[contains(@class, 'product-image-photo')]", $product)->item(0);
    $titleNode = $xpath->query(".//a[contains(@class, 'product-item-link')]", $product)->item(0);
    $priceNode = $xpath->query(".//span[contains(@class, 'price')]", $product)->item(0);

    $products[] = [
        'img' => $imgNode ? $imgNode->getAttribute('src') : null,
        'title' => $titleNode ? trim($titleNode->textContent) : null,
        'url' => $titleNode ? $titleNode->getAttribute('href') : null,
        'price' => $priceNode ? trim($priceNode->textContent) : null,
    ];
}

echo json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
