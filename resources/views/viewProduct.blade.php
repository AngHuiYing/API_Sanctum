<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        /* 全局样式 */
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* 页面容器样式 */
        .container {
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border-radius: 8px;
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        /* 产品详情样式 */
        #product-details {
            margin-bottom: 20px;
            text-align: left;
        }

        #product-details p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }

        #product-details strong {
            color: #333;
        }

        /* 按钮样式 */
        button {
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        /* 编辑按钮 */
        #edit-product {
            background-color: #007bff;
            color: white;
        }

        #edit-product:hover {
            background-color: #0056b3;
        }

        /* 删除按钮 */
        #delete-product {
            background-color: #dc3545;
            color: white;
        }

        #delete-product:hover {
            background-color: #c82333;
        }

        /* 响应式布局 */
        @media (max-width: 600px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }

            button {
                width: 100%;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Product Details</h1>
        <br>
        <div id="product-details">
            <p><strong>Product Name:</strong> <span id="name"></span></p>
            <p><strong>Product Detail:</strong> <span id="detail"></span></p>
        </div>
        <button id="edit-product">Edit Product</button>
        <button id="delete-product">Delete Product</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');
            const urlParams = new URLSearchParams(window.location.search);
            const productId = urlParams.get('id'); // 假设通过URL传递产品ID，例如 viewProduct.html?id=123

            // 检查是否存在 Token
            if (!token) {
                alert('You need to login first');
                window.location.href = '/';
                return;
            }

            // 检查 productId 是否存在
            if (!productId) {
                alert('Product ID is missing.');
                window.location.href = '/dashboard';
                return;
            }

            // 获取产品详情
            fetch(`{{ url('api/products') }}/${productId}`, {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const product = data.data;
                    document.getElementById('name').textContent = product.name;
                    document.getElementById('detail').textContent = product.detail;
                } else {
                    alert('Error fetching product details: ' + data.message);
                    window.location.href = '/dashboard';
                }
            })
            .catch(error => console.error('Error:', error));

            // 编辑产品
            document.getElementById('edit-product').addEventListener('click', function() {
                const newName = prompt("Enter new product name:", document.getElementById('name').textContent);
                const newDetail = prompt("Enter new product detail:", document.getElementById('detail').textContent);

                if (newName && newDetail) {
                    fetch(`{{ url('api/products') }}/${productId}`, {
                        method: "PUT",
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            name: newName,
                            detail: newDetail
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Product updated successfully');
                            window.location.href = '/dashboard';
                        } else {
                            alert('Error updating product: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating the product.');
                    });
                }
            });

            // 删除产品
            document.getElementById('delete-product').addEventListener('click', function() {
                if (confirm("Are you sure you want to delete this product?")) {
                    fetch(`{{ url('api/products') }}/${productId}`, {
                        method: "DELETE",
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Product deleted successfully');
                            window.location.href = '/dashboard';
                        } else {
                            alert('Error deleting product: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the product.');
                    });
                }
            });
        });
    </script>
</body>
</html>
