<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller {
    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->call->database();
        $this->call->library('session');
        $this->session = $this->call->library('session');
        $this->call->model('ProductModel');
    }

    public function index()
    {
        $products = [];
        $error = '';

        try {
            $products = $this->ProductModel->order_by('id', 'DESC')->get_all() ?: [];
            $products = array_map(static function ($product) {
                return is_array($product) ? (object) $product : $product;
            }, $products);
        } catch (Throwable $e) {
            $error = 'Database error: ' . $e->getMessage();
        }

        $this->call->view('products/index', [
            'products' => $products,
            'error' => $error,
            'user' => $this->session->userdata('username') ?: 'Nursery Keeper',
            'role' => $this->session->userdata('role') ?: 'user',
            'success' => $this->session->flashdata('success') ?: '',
        ]);
    }

    public function createForm()
    {
        if (($this->session->userdata('role') ?? 'user') !== 'admin') {
            $this->session->set_flashdata('error', 'Only the nursery keeper can add product stories.');
            redirect('/products');
        }

        $this->call->view('products/create', [
            'error' => $this->session->flashdata('error') ?: '',
            'user' => $this->session->userdata('username') ?: 'Nursery Keeper',
            'role' => $this->session->userdata('role') ?: 'user',
        ]);
    }

    public function store()
    {
        if (($this->session->userdata('role') ?? 'user') !== 'admin') {
            $this->session->set_flashdata('error', 'Only the nursery keeper can add product stories.');
            redirect('/products');
        }

        $product_name = trim($_POST['product_name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $quantity = trim($_POST['quantity'] ?? '');

        if ($product_name === '' || $price === '' || $quantity === '') {
            $this->session->set_flashdata('error', 'Every little product needs a name, price, and quantity.');
            redirect('/products/create');
        }

        try {
            $this->ProductModel->insert([
                'product_name' => $product_name,
                'description' => $description,
                'price' => (float) $price,
                'quantity' => (int) $quantity,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $this->session->set_flashdata('success', 'A new rhyme-treat product has been added to the basket!');
            redirect('/products');
        } catch (Throwable $e) {
            $this->session->set_flashdata('error', 'The product basket could not be saved: ' . $e->getMessage());
            redirect('/products/create');
        }
    }

    public function editForm($id)
    {
        if (($this->session->userdata('role') ?? 'user') !== 'admin') {
            $this->session->set_flashdata('error', 'Only the nursery keeper can edit product stories.');
            redirect('/products');
        }

        $product = null;
        $error = '';

        try {
            $product = $this->ProductModel->find($id);
            if (is_array($product)) {
                $product = (object) $product;
            }
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }

        if (!$product) {
            $this->session->set_flashdata('error', 'That product could not be found in the rhyme shelf.');
            redirect('/products');
        }

        $this->call->view('products/edit', [
            'product' => $product,
            'error' => $error,
            'user' => $this->session->userdata('username') ?: 'Nursery Keeper',
            'role' => $this->session->userdata('role') ?: 'user',
        ]);
    }

    public function update($id)
    {
        if (($this->session->userdata('role') ?? 'user') !== 'admin') {
            $this->session->set_flashdata('error', 'Only the nursery keeper can edit product stories.');
            redirect('/products');
        }

        $product_name = trim($_POST['product_name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $quantity = trim($_POST['quantity'] ?? '');

        if ($product_name === '' || $price === '' || $quantity === '') {
            $this->session->set_flashdata('error', 'A name, price, and quantity are required for every nursery item.');
            redirect('/products/edit/' . $id);
        }

        try {
            $this->ProductModel->update($id, [
                'product_name' => $product_name,
                'description' => $description,
                'price' => (float) $price,
                'quantity' => (int) $quantity,
            ]);

            $this->session->set_flashdata('success', 'The product has been freshly polished and updated!');
            redirect('/products');
        } catch (Throwable $e) {
            $this->session->set_flashdata('error', 'Update failed: ' . $e->getMessage());
            redirect('/products/edit/' . $id);
        }
    }

    public function destroy($id)
    {
        if (($this->session->userdata('role') ?? 'user') !== 'admin') {
            $this->session->set_flashdata('error', 'Only the nursery keeper can remove product stories.');
            redirect('/products');
        }

        try {
            $this->ProductModel->delete($id);
            $this->session->set_flashdata('success', 'The product has been tucked away from the nursery shelf.');
        } catch (Throwable $e) {
            $this->session->set_flashdata('error', 'Delete failed: ' . $e->getMessage());
        }

        redirect('/products');
    }
}
