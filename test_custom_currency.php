<?php
// Test script to verify the custom currency function works correctly
include 'setup_database.php';
include 'currency_functions.php';

// Test the function with different cluster names
$testClusters = ['Addis Ababa', 'Woldiya', 'Test Cluster', ''];

echo "<h2>Testing isClusterCustomCurrencyEnabled function</h2>";

foreach ($testClusters as $cluster) {
    $result = isClusterCustomCurrencyEnabled($conn, $cluster);
    echo "<p>Cluster: '" . htmlspecialchars($cluster) . "' - Custom Currency Enabled: " . ($result ? 'Yes' : 'No') . "</p>";
}

echo "<h2>Database query to check cluster data</h2>";

// Show all clusters and their custom currency rate status
$stmt = $conn->prepare("SELECT id, cluster_name, custom_currency_rate FROM clusters WHERE is_active = 1 ORDER BY cluster_name");
$stmt->execute();
$result = $stmt->get_result();

echo "<table border='1'>";
echo "<tr><th>ID</th><th>Cluster Name</th><th>Custom Currency Rate</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . htmlspecialchars($row['cluster_name']) . "</td>";
    echo "<td>" . ($row['custom_currency_rate'] ? 'Enabled' : 'Disabled') . "</td>";
    echo "</tr>";
}

echo "</table>";
?>