<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* 全局样式 */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        /* 表单容器样式 */
        .form-container {
            background: #fff;
            padding: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* 注册按钮样式 */
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

        /* 登录链接样式 */
        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
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
        <h1>Register</h1>
        <form id="register-form">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <label for="c_password">Confirm Password</label>
            <input type="password" name="c_password" id="c_password" required>

            <button type="submit">Register</button>
        </form>
        <a href="{{ route('LoginForm') }}">Login Page</a>
    </div>

    <script>
        document.getElementById('register-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('{{ url('api/register') }}', {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: formData.get('name'),
                    email: formData.get('email'),
                    password: formData.get('password'),
                    c_password: formData.get('c_password'),
                }),
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    alert('Registration successful');
                    window.location.href = '/';
                } else {
                    alert('Registration failed: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
