<?php

function crawlWebsite($url, $depth)
{
    if ($depth < 0) {
        return array();
    }

    $data = array();

    try {
        $html = @file_get_contents($url);

        if ($html === false) {
            throw new Exception("Failed to fetch content from $url");
        }

        $dom = new DOMDocument;
        libxml_use_internal_errors(true); // Disable warnings for malformed HTML
        $loaded = @$dom->loadHTML($html);

        if (!$loaded) {
            throw new Exception("Failed to parse HTML from $url");
        }
        libxml_clear_errors();

        // Extract paragraphs
        $paragraphs = $dom->getElementsByTagName('p');
        foreach ($paragraphs as $paragraph) {
            $data['paragraphs'][] = $paragraph->nodeValue;
        }

        // Extract buttons
        $buttons = $dom->getElementsByTagName('button');
        foreach ($buttons as $button) {
            $data['buttons'][] = $button->nodeValue;
        }

        // Extract links
        $links = $dom->getElementsByTagName('a');
        foreach ($links as $link) {
            $linkUrl = $link->getAttribute('href');
            $data['links'][] = $linkUrl;

            // Recursive call with reduced depth
            if ($depth > 0) {
                $data['subpages'][$linkUrl] = crawlWebsite($linkUrl, $depth - 1);
            }
        }

        // Extract forms
        $forms = $dom->getElementsByTagName('form');
        foreach ($forms as $form) {
            $data['forms'][] = $form->nodeValue;
        }

        // Extract tables
        $tables = $dom->getElementsByTagName('table');
        foreach ($tables as $table) {
            $data['tables'][] = $table->nodeValue;
        }

        // Extract spans
        $spans = $dom->getElementsByTagName('span');
        foreach ($spans as $span) {
            $data['spans'][] = $span->nodeValue;
        }
    } catch (Exception $e) {
        // Handle the exception
        $data['error'] = $e->getMessage();
    }

    return $data;
}

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted
    $userUrl = $_POST['url'];
    $depth = (int)$_POST['depth'];

    if (!empty($userUrl)) {
        $result = crawlWebsite($userUrl, $depth);

        // Convert the result to JSON
        $jsonData = json_encode($result, JSON_PRETTY_PRINT);

        // Save the JSON data to a file
        $filename = 'crawler_output.json';
        file_put_contents($filename, $jsonData);

        if (isset($result['error'])) {
            echo 'Crawling failed. Error: ' . $result['error'];
        } else {
            echo 'Crawling completed. Data saved to ' . $filename;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Crawler</title>
</head>

<body>

    <h1>Web Crawler</h1>

    <form method="post" action="">
        <label for="url">Enter Website URL:</label>
        <input type="url" name="url" id="url" required>
        <label for="depth">Enter Depth:</label>
        <input type="number" name="depth" id="depth" min="0" value="2" required>
        <button type="submit">Crawl</button>
    </form>

    <?php if ($result !== null && !isset($result['error'])) : ?>
        <h2>Results:</h2>
        <pre><?= $jsonData ?></pre>
    <?php endif; ?>

</body>

</html>
