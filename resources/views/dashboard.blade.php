<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* 基本样式 */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 28px;
            width: 100%;
            text-align: center;
        }

        /* 登出按钮容器 */
        .logout-container {
            width: 100%;
            display: flex;
            justify-content: flex-end; /* 将按钮移到右边 */
            margin-bottom: 10px;
        }

        .table-container {
            width: 100%; /* 改为 100%，覆盖整个屏幕宽度 */
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow-x: auto; /* 当表格宽度超出屏幕时，可以水平滚动 */
        }
        
        table {
            width: 100%; /* 使表格宽度为 100% */
            border-collapse: collapse;
        }

        thead {
            background-color: white;
            color: black;
        }

        th, td {
            padding: 15px;
            text-align: left;
            font-size: 14px;
            color: #555;
            word-wrap: break-word;
        }
        
        @media (max-width: 600px) {
            .table-container {
                padding: 0;
                border-radius: 0;
            }
        }

        th {
            font-size: 16px;
        }

        /* 增加Detail列的宽度 */
        th:nth-child(2), td:nth-child(2) {
            width: 50%;
        }

        td {
            font-size: 14px;
            color: #555;
            word-wrap: break-word; /* 处理长文本换行 */
        }

        tr {
            border-bottom: 1px solid #ddd;
        }

        tr:last-child {
            border-bottom: none;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* 操作按钮样式 */
        .action-btn {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            padding: 5px 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
            transition: all 0.2s;
        }

        .action-btn:hover {
            background-color: #007bff;
            color: #fff;
        }

        /* 登出按钮样式 */
        #logout-btn {
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        #logout-btn:hover {
            background-color: #c82333;
        }

        #add-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        #add-btn:hover {
            background-color: #fff;
            color: #007bff;
        }
    </style>
</head>
<body>
    <h1>Product List</h1>

    <!-- 登出按钮容器，放在右边 -->
    <div class="logout-container">
        <button onclick="window.location.href='/addProduct'" id="add-btn">Add Product</button>
        <button id="logout-btn">Logout</button>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product Detail</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="product-list"></tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');

            if (!token) {
                alert('You need to login first');
                window.location.href = '/';
                return;
            }

            // 获取产品列表
            fetch('{{ url('api/products') }}', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const productList = document.getElementById('product-list');
                if (data.success) {
                    const products = data.data;
                    products.forEach(product => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${product.name}</td>
                            <td>${product.detail}</td>
                            <td><a href="/viewProduct?id=${product.id}" class="action-btn">View</a></td>
                        `;
                        productList.appendChild(row);
                    });
                } else {
                    alert('Error fetching products: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));

            
            document.getElementById('logout-btn').addEventListener('click', function() {
                const token = localStorage.getItem('token');

                if (!token) {
                    alert('You are already logged out.');
                    window.location.href = '/';
                    return;
                }

                fetch('{{ url('api/logout') }}', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        localStorage.removeItem('token');
                        alert('Logout Successful');
                        window.location.href = '/';
                    } else {
                        alert('Error during logout: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred during logout.');
                });
            });
        });
    </script>
</body>
</html>
