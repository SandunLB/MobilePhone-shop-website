<?php
include 'config.php';
include 'admin_header.php';

$product_id = '';
$category_id = '';
$name = '';
$description = '';
$price = '';
$stock = '';
$image = '';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])) {
        $category_id = $_POST['category_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $image = basename($_FILES['image']['name']);
            $target_dir = "../uploads/";
            $target_file = $target_dir . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        }

        if ($product_id) {
            if ($image) {
                $stmt = $conn->prepare("UPDATE products SET category_id=?, name=?, description=?, price=?, stock=?, image=? WHERE product_id=?");
                $stmt->bind_param("issdisi", $category_id, $name, $description, $price, $stock, $image, $product_id);
            } else {
                $stmt = $conn->prepare("UPDATE products SET category_id=?, name=?, description=?, price=?, stock=? WHERE product_id=?");
                $stmt->bind_param("issdii", $category_id, $name, $description, $price, $stock, $product_id);
            }
        } else {
            $stmt = $conn->prepare("INSERT INTO products (category_id, name, description, price, stock, image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issdis", $category_id, $name, $description, $price, $stock, $image);
        }
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['edit'])) {
        $product_id = $_POST['product_id'];
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $category_id = $product['category_id'];
        $name = $product['name'];
        $description = $product['description'];
        $price = $product['price'];
        $stock = $product['stock'];
        $image = $product['image'];
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $product_id = $_POST['product_id'];
        try {
            $stmt = $conn->prepare("DELETE FROM products WHERE product_id=?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $error_message = "Cannot delete the product because it is referenced in existing orders.";
        }
    }
}

$products = $conn->query("SELECT * FROM products");
$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Products</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Manage Products</h2>
        <?php if ($error_message): ?>
            <div class="error-message">
                <?= $error_message ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?= $product_id ?>">
            <label for="category_id">Category</label>
            <select id="category_id" name="category_id" required>
                <option value="">Select Category</option>
                <?php while($row = $categories->fetch_assoc()): ?>
                    <option value="<?= $row['category_id'] ?>" <?= $row['category_id'] == $category_id ? 'selected' : '' ?>><?= $row['name'] ?></option>
                <?php endwhile; ?>
            </select>

            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= $name ?>" required>
            
            <label for="description">Description</label>
            <textarea id="description" name="description" required><?= $description ?></textarea>
            
            <label for="price">Price</label>
            <input type="number" id="price" name="price" value="<?= $price ?>" step="0.01" required>

            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" value="<?= $stock ?>" required>
            
            <label for="image">Image</label>
            <input type="file" id="image" name="image" <?= $product_id ? '' : 'required' ?>>
            
            <button type="submit" name="save">Save</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $products->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['product_id'] ?></td>
                        <td><?= $row['category_id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td><?= $row['price'] ?></td>
                        <td><?= $row['stock'] ?></td>
                        <td><img src="../uploads/<?= $row['image'] ?>" alt="<?= $row['name'] ?>" width="50"></td>
                        <td>
                            <div class="action-buttons">
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                                    <button type="submit" name="edit">Edit</button>
                                </form>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
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
