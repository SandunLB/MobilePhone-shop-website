<?php
include 'config.php';
include 'admin_header.php';
$category_id = '';
$name = '';
$description = '';
$image = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $image = basename($_FILES['image']['name']);
            $target_dir = "../uploads/categories/";
            $target_file = $target_dir . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        }

        if ($category_id) {
            if ($image) {
                $stmt = $conn->prepare("UPDATE categories SET name=?, description=?, image=? WHERE category_id=?");
                $stmt->bind_param("sssi", $name, $description, $image, $category_id);
            } else {
                $stmt = $conn->prepare("UPDATE categories SET name=?, description=? WHERE category_id=?");
                $stmt->bind_param("ssi", $name, $description, $category_id);
            }
        } else {
            $stmt = $conn->prepare("INSERT INTO categories (name, description, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $description, $image);
        }
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['edit'])) {
        $category_id = $_POST['category_id'];
        $stmt = $conn->prepare("SELECT * FROM categories WHERE category_id=?");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_assoc();
        $name = $category['name'];
        $description = $category['description'];
        $image = $category['image'];
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $category_id = $_POST['category_id'];
        $stmt = $conn->prepare("DELETE FROM categories WHERE category_id=?");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $stmt->close();
    }
}

$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Categories</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Manage Categories</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="category_id" value="<?= $category_id ?>">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= $name ?>" required>
            
            <label for="description">Description</label>
            <textarea id="description" name="description" required><?= $description ?></textarea>
            
            <label for="image">Image</label>
            <input type="file" id="image" name="image" <?= $category_id ? '' : 'required' ?>>
            
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
                <?php while($row = $categories->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['category_id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td><img src="../uploads/categories/<?= $row['image'] ?>" alt="<?= $row['name'] ?>" width="50"></td>
                        <td>
                            <div class="action-buttons">
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="category_id" value="<?= $row['category_id'] ?>">
                                    <button type="submit" name="edit">Edit</button>
                                </form>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="category_id" value="<?= $row['category_id'] ?>">
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
