<?php
include 'config.php';
include 'admin_header.php';

$service_id = '';
$name = '';
$description = '';
$image = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $image = basename($_FILES['image']['name']);
            $target_dir = "../uploads/services/";
            $target_file = $target_dir . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        }

        if ($service_id) {
            if ($image) {
                $stmt = $conn->prepare("UPDATE services SET name=?, description=?, image=? WHERE service_id=?");
                $stmt->bind_param("sssi", $name, $description, $image, $service_id);
            } else {
                $stmt = $conn->prepare("UPDATE services SET name=?, description=? WHERE service_id=?");
                $stmt->bind_param("ssi", $name, $description, $service_id);
            }
        } else {
            $stmt = $conn->prepare("INSERT INTO services (name, description, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $description, $image);
        }
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['edit'])) {
        $service_id = $_POST['service_id'];
        $stmt = $conn->prepare("SELECT * FROM services WHERE service_id=?");
        $stmt->bind_param("i", $service_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $service = $result->fetch_assoc();
        $name = $service['name'];
        $description = $service['description'];
        $image = $service['image'];
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $service_id = $_POST['service_id'];
        $stmt = $conn->prepare("DELETE FROM services WHERE service_id=?");
        $stmt->bind_param("i", $service_id);
        $stmt->execute();
        $stmt->close();
    }
}

$services = $conn->query("SELECT * FROM services");
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Services</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Manage Services</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="service_id" value="<?= $service_id ?>">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= $name ?>" required>
            
            <label for="description">Description</label>
            <textarea id="description" name="description" required><?= $description ?></textarea>
            
            <label for="image">Image</label>
            <input type="file" id="image" name="image" <?= $service_id ? '' : 'required' ?>>
            
            <button type="submit" name="save">Save</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $services->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['service_id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td><img src="../uploads/services/<?= $row['image'] ?>" alt="<?= $row['name'] ?>" width="50"></td>
                        <td>
                            <div class="action-buttons">
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="service_id" value="<?= $row['service_id'] ?>">
                                    <button type="submit" name="edit">Edit</button>
                                </form>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="service_id" value="<?= $row['service_id'] ?>">
                                    <button type="submit" name="delete" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
