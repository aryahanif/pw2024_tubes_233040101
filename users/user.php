<?php
$result = fetchUsersFromDatabase($koneksi);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["role_name"]) . "</td>"; // Display role name
        echo "<td>";
        echo "<a href='edit_user.php?id=" . $row["id"] . "' class='btn btn-primary'>Edit</a>";
        echo "<a href='delete_user.php?id=" . $row["id"] . "' class='btn btn-danger'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No users found.</td></tr>";
}
?>
