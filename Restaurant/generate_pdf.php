<?php
require_once('TCPDF-main/tcpdf.php'); // Include TCPDF library

include 'connection.php'; // Assuming this file contains database connection code
global $conn; // Access the global connection variable

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if reservationDay is set in POST
if (isset($_POST['reservationDay'])) {
    $reservationDay = $_POST['reservationDay'];

    // Prepare SQL statement with parameter binding to avoid SQL injection
    $sql = $conn->prepare("SELECT CONCAT(u.firstName, ' ', u.lastName) AS name, r.*
                           FROM user u
                           INNER JOIN reservation r ON u.userId = r.userId
                           WHERE r.reservationDay = ?
                           ORDER BY r.reservationTime ASC");
    $sql->bind_param("s", $reservationDay); // Bind parameter
    $sql->execute(); // Execute SQL query
    $result = $sql->get_result(); // Get result set

    // Create new TCPDF instance
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name'); // Set author name
    $pdf->SetTitle('Reservation Report for ' . $reservationDay); // Set document title
    $pdf->SetSubject('Reservation Report'); // Set document subject
    $pdf->SetKeywords('TCPDF, PDF, reservation, report'); // Set document keywords

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Add a title
    $pdf->Cell(0, 10, 'Reservation Report for ' . $reservationDay, 0, 1, 'C');
    $pdf->Ln(10); // Add line break

    // Check if there are reservations for the specified day
    if ($result->num_rows > 0) {
        // Initialize HTML variable for table
        $html = '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Table ID</th>
                            <th>Name</th>
                            <th>Reservation Time</th>
                            <th>Period</th>
                        </tr>
                    </thead>
                    <tbody>';

        // Loop through results and add rows to HTML table
        while ($row = $result->fetch_assoc()) {
            $html .= '<tr>
                        <td>' . $row['tableId'] . '</td>
                        <td>' . $row['name'] . '</td>
                        <td>' . $row['reservationTime'] . '</td>
                        <td>' . $row['period'] . '</td>
                      </tr>';
        }

        $html .= '</tbody></table>'; // Close HTML table
    } else {
        // No reservations message if no data found
        $html = '<h2>No reservations for ' . $reservationDay . '</h2>';
    }

    // Output HTML content to PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Close and output PDF document
    $pdf->Output('reservation_report_' . $reservationDay . '.pdf', 'I');

    // Close database connection
    $conn->close();
} else {
    // If reservationDay is not specified in POST
    echo "No reservation day specified.";
}
?>
