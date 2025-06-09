<!DOCTYPE html>
<html>
<head>
    <title>Login - Student ChatRoom</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f1fdf1;
        }

        .header {
            background-color: #2d6a4f;
            padding: 20px;
            text-align: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }

        .login-box {
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .login-box input[type="text"] {
            padding: 10px;
            width: 250px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .login-box button {
            padding: 10px 20px;
            background-color: #2d6a4f;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-box button:hover {
            background-color: #1b4332;
        }
    </style>
</head>
<body>

<div class="header">
    Login to Student ChatRoom
</div>

<div class="login-container">
    <form class="login-box" onsubmit="event.preventDefault(); loginUser();">
        <input type="text" id="username" placeholder="Enter your username" required><br>
        <button type="submit">Enter ChatRoom</button>
    </form>
</div>

<script>
function loginUser() {
    const username = document.getElementById('username').value;
    localStorage.setItem("chatUsername", username);
    window.location.href = "chat.php";
}
</script>

</body>
</html>

