<?php
require_once './reusable/connection.php';

// Number of records per page
$records_per_page = 10;

// Get the current page number
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($page - 1) * $records_per_page;

// Query to get the total number of records
$total_query = "SELECT COUNT(*) as total FROM movies";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];

// Calculate the total number of pages
$total_pages = ceil($total_records / $records_per_page);

// Query to get the records for the current page
$sql = "SELECT * FROM movies ORDER BY release_date DESC LIMIT $offset, $records_per_page";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Database</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="header">
        <h1>Movie Database</h1>
    </div>

    <div class="container">


        <div class="movies-grid">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='movie'>";
                    if (!empty($row["thumbnail_url"])) {
                        echo "<img src='" . htmlspecialchars($row["thumbnail_url"]) . "' alt='" . htmlspecialchars($row["title"]) . "'>";
                    }
                    echo "<div class='movie-info'>";
                    echo "<h2>" . htmlspecialchars($row["title"]) . "</h2>";
                    echo "<p><strong>Release Date:</strong> " . htmlspecialchars($row["release_date"]) . "</p>";
                    echo "<p><strong>Director:</strong> " . htmlspecialchars($row["director"]) . "</p>";
                    echo "<p><strong>Genre:</strong> " . htmlspecialchars($row["genre"]) . "</p>";
                    echo "<p><strong>Rating:</strong> <span class='rating'>" . htmlspecialchars($row["rating"]) . "/10</span> (" . htmlspecialchars($row["rating_count"]) . " votes)</p>";
                    echo "<p>" . substr(htmlspecialchars($row["description"]), 0, 100) . "...</p>";
                    echo "</div></div>";
                }
            } else {
                echo "<p>No movies found.</p>";
            }
            ?>
        </div>
        <?php
        // Display pagination links
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo "<span class='active'>$i</span>";
            } else {
                echo "<a href='?page=$i'>$i</a>";
            }
        }
        echo "</div>";
        $conn->close();
        ?>
    </div>
</body>

</html>