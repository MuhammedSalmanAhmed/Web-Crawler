<?php

// Search variables
$searchString = isset($_POST['searchString']) ? $_POST['searchString'] : '';
$searchResult = array();

// Check if the form is already submitted and a JSON file exists
$filename = 'crawler_output.json';
if (file_exists($filename)) {
    // Read the existing JSON file
    $storedData = json_decode(file_get_contents($filename), true);

    if (!empty($searchString)) {
        // Function to search for a string in nested arrays
        // Function to search for a string in nested arrays with partial matching
function recursive_array_search_partial($needle, $haystack) {
    foreach ($haystack as $key => $value) {
        if (is_array($value)) {
            $result = recursive_array_search_partial($needle, $value);
            if ($result !== false) {
                return $key;
            }
        } else {
            // Perform a case-insensitive partial match
            if (stripos($value, $needle) !== false) {
                return $key;
            }
        }
    }
    return false;
}

// Perform the search with partial matching
$searchResultKey = recursive_array_search_partial($searchString, $storedData);
        if ($searchResultKey !== false) {
            $searchResult = array($searchResultKey => $storedData[$searchResultKey]);
        } else {
            $searchResult = array('error' => 'String not found in the stored data.');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Crawler-Search</title>
</head>

<body>

    <h1>Search in stored file</h1>
    <form method="post" action="">
        <label for="searchString">Enter Search String:</label>
        <input type="text" name="searchString" id="searchString" required>
        <button type="submit">Search</button>
    </form>

    <?php if (!empty($searchResult)) : ?>
        <h2>Search Result:</h2>
        <pre><?= json_encode($searchResult, JSON_PRETTY_PRINT) ?></pre>
    <?php endif; ?>

</body>

</html>
