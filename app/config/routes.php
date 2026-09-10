<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/
/** @var object $router **/

$router->get('/', 'AuthController::loginForm');
$router->get('/login', 'AuthController::loginForm');
$router->post('/login', 'AuthController::login');
$router->get('/logout', 'AuthController::logout');

$router->group(['middleware' => 'auth'], function ($router) {
    $router->get('/products', 'ProductController::index');
    $router->get('/products/create', 'ProductController::createForm');
    $router->post('/products', 'ProductController::store');
    $router->get('/products/edit/{id}', 'ProductController::editForm')->where_number('id');
    $router->post('/products/edit/{id}', 'ProductController::update')->where_number('id');
    $router->post('/products/delete/{id}', 'ProductController::destroy')->where_number('id');
});

$router->get('/db-check', function () {
    try {
        $db = lava_instance()->call->database();
        $stmt = $db->raw('SHOW TABLES');
        $tables = $stmt ? $stmt->fetchAll(PDO::FETCH_COLUMN) : [];
        echo json_encode([
            'status' => 'ok',
            'driver' => getenv('DB_DRIVER') ?: 'mysql',
            'host' => getenv('DB_HOST') ?: 'unknown',
            'database' => getenv('DB_NAME') ?: 'unknown',
            'tables' => $tables,
        ], JSON_PRETTY_PRINT);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => explode("\n", $e->getTraceAsString()),
        ], JSON_PRETTY_PRINT);
    }
    exit;
});

$router->get('/users', 'UsersController::index');
$router->get('/users/{id}', 'UsersController::show');