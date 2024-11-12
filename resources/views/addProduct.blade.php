<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        /* 全局样式 */
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* 表单容器样式 */
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* 提交按钮样式 */
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* 错误提示样式 */
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Add New Product</h1>
        <form id="add-product-form">
            <label for="name">Product Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="detail">Detail:</label>
            <textarea name="detail" id="detail" rows="4" required></textarea>

            <button type="submit">Add Product</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');

            // 检查是否存在 Token
            if (!token) {
                alert('You need to login first');
                window.location.href = '/';
                return;
            }

            // 监听表单提交事件
            document.getElementById('add-product-form').addEventListener('submit', function(event) {
                event.preventDefault();

                const name = document.getElementById('name').value;
                const detail = document.getElementById('detail').value;
                
                // 使用 Fetch API 发送 POST 请求
                fetch('{{ url('api/products') }}', {
                    method: "POST",
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        name: name,
                        detail: detail
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product added successfully');
                        window.location.href = '/dashboard';
                    } else {
                        alert('Error adding product: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while adding the product.');
                });
            });
        });
    </script>
</body>
</html>
