<?php
session_start(); // Start the session

// Check if there is any session data
if (!isset($_SESSION['events']) || empty($_SESSION['events'])) {
    echo '<p>No events found.</p>';
} else {
    echo '<h1>Event Details</h1>';
    echo '<table border="1">';
    echo '<tr><th>Event</th><th>Participants</th></tr>';

    // Iterate through each event and its participants
    foreach ($_SESSION['events'] as $index => $eventData) {
        $event = htmlspecialchars($eventData['event']);
        $participants = implode(', ', array_map('htmlspecialchars', $eventData['participants']));

        echo '<tr>';
        echo '<td>' . $event . '</td>';
        echo '<td>' . $participants . '</td>';
        echo '</tr>';
    }

    echo '</table>';
}
?>