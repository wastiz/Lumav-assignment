<?php
$config = json_decode(file_get_contents('selectors.json'), true);

if (!$config["url"]) {
    echo json_encode(['error' => 'URL list is empty']);
    exit;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $config["url"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
curl_close($ch);

if (!$response) {
    echo json_encode(['error' => 'Failed to fetch the URL']);
    exit;
}

$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($response);
libxml_clear_errors();

$xpath = new DOMXPath($dom);

$categoryNodes = $xpath->query("//div[@data-content-type]/a");
$categories = [];

foreach ($categoryNodes as $node) {
    $name = trim(preg_replace('/\s+/', ' ', html_entity_decode(trim($node->textContent), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    $url = str_replace('\/', '/', $node->getAttribute('href'));
    $categories[] = [
        'name' => $name,
        'url' => $url,
    ];
}

echo json_encode($categories, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);