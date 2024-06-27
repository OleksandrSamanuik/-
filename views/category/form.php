<!DOCTYPE html>
<html lang="en">

<body>

    <div class="container">
        <h2 class="mt-4"><?php echo isset($category) ? 'Edit Category' : 'Create Category'; ?></h2>
        <form action="<?php echo isset($category) ? '/myshop/views/category/edit.php?id=' . $category['id'] : '/myshop/views/category/create.php'; ?>" method="post" class="mt-4">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($category) ? $category['name'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required><?php echo isset($category) ? $category['description'] : ''; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><?php echo isset($category) ? 'Update' : 'Create'; ?></button>
        </form>
    </div>

</body>
</html>
