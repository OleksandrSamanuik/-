<!DOCTYPE html>
<html lang="en">

<body>

    <div class="container">
        <h2 class="mt-4"><?php echo isset($product) ? 'Edit Product' : 'Create Product'; ?></h2>
        <form action="<?php echo isset($product) ? '/myshop/views/product/edit.php?id=' . $product['id'] : '/myshop/views/product/create.php'; ?>" method="post" enctype="multipart/form-data" class="mt-4">
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php if (isset($product) && $product['category_id'] == $category['id']) echo 'selected'; ?>>
                            <?php echo $category['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($product) ? $product['name'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required><?php echo isset($product) ? $product['description'] : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo isset($product) ? $product['price'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            </div>
            <?php if (isset($product['image_path']) && !empty($product['image_path'])): ?>
                <div class="form-group">
                    <label>Current Image:</label><br>
                    <img src="<?php echo $product['image_path']; ?>" alt="Product Image" style="max-width: 200px;">
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary"><?php echo isset($product) ? 'Update Product' : 'Create Product'; ?></button>
        </form>
    </div>

</body>
</html>
