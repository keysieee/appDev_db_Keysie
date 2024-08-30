<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'product');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$id = '';
$name = '';
$description = '';
$quantity = '';
$price = '';
$barcode = '';

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $barcode = $_POST['barcode'];

    $conn->query("INSERT INTO tbl_product (name, description, quantity, price, barcode) VALUES ('$name', '$description', '$quantity', '$price', '$barcode')");

    header('Location: index.php');
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM tbl_product WHERE id=$id");

    header('Location: index.php');
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM tbl_product WHERE id=$id");
    $row = $result->fetch_assoc();

    $name = $row['name'];
    $description = $row['description'];
    $quantity = $row['quantity'];
    $price = $row['price'];
    $barcode = $row['barcode'];
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $barcode = $_POST['barcode'];

    $conn->query("UPDATE tbl_product SET name='$name', description='$description', quantity='$quantity', price='$price', barcode='$barcode' WHERE id=$id");

    header('Location: index.php');
}

$result = $conn->query("SELECT * FROM tbl_product");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product CRUD</title>
</head>
<body>
    <h1>Product Management</h1>

    <form action="index.php" method="POST">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <div>
            <label>Name:</label>
            <input type="text" name="name" value="<?= $name; ?>" required>
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description" required><?= $description; ?></textarea>
        </div>
        <div>
            <label>Quantity:</label>
            <input type="number" name="quantity" value="<?= $quantity; ?>" required>
        </div>
        <div>
            <label>Price:</label>
            <input type="text" name="price" value="<?= $price; ?>" required>
        </div>
        <div>
            <label>Barcode:</label>
            <input type="text" name="barcode" value="<?= $barcode; ?>" required>
        </div>
        <div>
            <?php if ($id): ?>
                <button type="submit" name="update">Update</button>
            <?php else: ?>
                <button type="submit" name="save">Save</button>
            <?php endif; ?>
        </div>
    </form>

    <h2>Products List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Barcode</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['description']; ?></td>
                    <td><?= $row['quantity']; ?></td>
                    <td><?= $row['price']; ?></td>
                    <td><?= $row['barcode']; ?></td>
                    <td><?= $row['created_at']; ?></td>
                    <td><?= $row['updated_at']; ?></td>
                    <td>
                        <a href="index.php?edit=<?= $row['id']; ?>">Edit</a>
                        <a href="index.php?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>