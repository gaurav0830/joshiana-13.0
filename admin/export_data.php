<?php
include_once("config/db.php");

// SQL query to fetch all data from 'events' and 'event_details' tables
$sql_query = "
    SELECT e.college, e.email, e.phone1, e.phone2, e.degree, e.department, e.order_id, e.payment_id, e.total_amount, d.event_name, d.participants
    FROM events e
    JOIN event_details d ON e.order_id = d.order_id
";

$resultset = mysqli_query($conn, $sql_query);

if (!$resultset) {
    die("Database error: " . mysqli_error($conn));
}

// Array to hold the data
$developer_records = array();

// Fetch data and store in the array
while ($rows = mysqli_fetch_assoc($resultset)) {
    $developer_records[] = $rows;
}

// Check if the export button was clicked
if (isset($_POST["export_data"])) {
    // Set the file name for the download
    $filename = "joshiana-reg-data_" . date('Y-m-d') . ".csv";

    // Set headers to force download of the CSV file
    header("Content-Type: text/csv; charset=UTF-8");
    header("Content-Disposition: attachment; filename=\"$filename\"");

    // Open a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // Output the column headings (starting from A1 in Excel)
    if (!empty($developer_records)) {
        // Output the column headings
        fputcsv($output, array_keys($developer_records[0]));

        // Output the rows of data
        foreach ($developer_records as $record) {
            fputcsv($output, $record);
        }
    }

    fclose($output);
    exit;
}
?>