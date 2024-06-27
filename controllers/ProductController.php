<?php
require_once BASE_PATH . '/models/Product.php';
require_once BASE_PATH . '/models/Category.php';

class ProductController {
    protected $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    public function getProductModel() {
        return $this->productModel;
    }

    public function setProductModel($productModel) {
        $this->productModel = $productModel;
    }

    public function getCategoryModel() {
        return $this->categoryModel;
    }

    public function setCategoryModel($categoryModel) {
        $this->categoryModel = $categoryModel;
    }

    public function list() {
        $products = $this->productModel->getAllProducts();

        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $categoryId = $_GET['category'];
            $products = $this->productModel->getByCategory($categoryId);
        } elseif (isset($_GET['search']) && !empty($_GET['search'])) {
            $keyword = $_GET['search'];
            $products = $this->productModel->search($keyword);
        }

        return $products;
    }

    public function getByCategory($categoryId) {
        return $this->productModel->getProductsByCategory($categoryId);
    }

    public function search($keyword) {
        return $this->productModel->search($keyword);
    }

    public function create() {
        $categories = $this->categoryModel->getAllCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryId = $_POST['category_id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $imagePath = $_POST['image_path'];

            if ($this->productModel->createProduct($categoryId, $name, $description, $price, $imagePath)) {
                header('Location: /myshop/views/product/list.php');
                exit();
            } else {
                echo "Failed to create product";
            }
        } else {
            require_once BASE_PATH . '/views/product/form.php';
        }
    }

    public function edit($params) {
        $id = $params[0];
        $product = $this->productModel->getProductById($id);
        $categories = $this->categoryModel->getAllCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryId = $_POST['category_id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $imagePath = $_POST['image_path'];

            if ($this->productModel->updateProduct($id, $categoryId, $name, $description, $price, $imagePath)) {
                header('Location: /myshop/views/product/list.php');
                exit();
            } else {
                echo "Failed to update product";
            }
        } else {
            require_once BASE_PATH . '/views/product/form.php';
        }
    }

    public function delete($params) {
        $id = $params[0];

        if ($this->productModel->deleteProduct($id)) {
            header('Location: /myshop/views/product/list.php');
            exit();
        } else {
            echo "Failed to delete product";
        }
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
            $productId = $_POST['id'];
            $this->delete([$productId]);
        }
    }
}

?>
