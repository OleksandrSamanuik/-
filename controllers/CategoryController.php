<?php
require_once BASE_PATH . '/models/Category.php';

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    public function list() {
        $categories = $this->categoryModel->getAllCategories();
        return $categories;
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];

            if ($this->categoryModel->createCategory($name, $description)) {
                header('Location: /myshop/views/category/list.php');
                exit();
            } else {
                echo "Failed to create category";
            }
        } else {
            require_once BASE_PATH . '/views/category/form.php';
        }
    }

    public function edit($params) {
        $id = $params[0];
        $category = $this->categoryModel->getCategoryById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];

            if ($this->categoryModel->updateCategory($id, $name, $description)) {
                header('Location: /myshop/views/category/list.php');
                exit();
            } else {
                echo "Failed to update category";
            }
        } else {
            require_once BASE_PATH . '/views/category/form.php';
        }
    }

    public function delete($params) {
        $id = $params[0];

        if ($this->categoryModel->deleteCategory($id)) {
            header('Location: /myshop/views/category/list.php');
            exit();
        } else {
            echo "Failed to delete category";
        }
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
            $categoryId = $_POST['id'];
            $this->delete([$categoryId]);
        }
    }


}
?>
