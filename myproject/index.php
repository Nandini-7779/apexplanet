<?php
include 'config.php';
$result = mysqli_query($conn, "
    SELECT users.id, users.name, users.email, 
           users.created_at, roles.role_name 
    FROM users 
    JOIN roles ON users.role_id = roles.id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <style>
        body { font-family: Arial; max-width: 900px; margin: 40px auto; }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #4CAF50; color: white; padding: 10px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #ddd; }
        tr:hover { background: #f5f5f5; }
        .btn { padding: 6px 12px; border: none; cursor: pointer; border-radius: 4px; text-decoration: none; font-size: 13px; }
        .btn-edit   { background: #2196F3; color: white; }
        .btn-delete { background: #f44336; color: white; }
        .btn-add    { background: #4CAF50; color: white; padding: 10px 20px; display: inline-block; margin-bottom: 10px; border-radius: 4px; text-decoration: none; }
        .badge-admin { background: #ff9800; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; }
        .badge-user  { background: #2196F3; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; }
    </style>
</head>
<body>
    <h2>👥 User Management System</h2>
    <a class="btn-add" href="add_user.php">+ Add New User</a>

    <table>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td>
                    <span class="badge-<?= $row['role_name'] ?>">
                        <?= ucfirst($row['role_name']) ?>
                    </span>
                </td>
                <td><?= $row['created_at'] ?></td>
                <td>
                    <a class="btn btn-edit" 
                       href="edit_user.php?id=<?= $row['id'] ?>">Edit</a>
                    <a class="btn btn-delete" 
                       href="delete_user.php?id=<?= $row['id'] ?>"
                       onclick="return confirm('Are you sure you want to delete <?= $row['name'] ?>?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align:center; color:#999;">
                    No users found. <a href="add_user.php">Add one!</a>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>