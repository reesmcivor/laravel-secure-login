<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Unrecognized</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .error-message {
            color: red;
            font-size: 20px;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 20px;
        }
        .login-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="error-message">
    Your login attempt was unsuccessful.
</div>
<div class="info">
    Your request has been received and our management team will review it shortly.
</div>
<button class="login-button" onclick="location.href='/login'">Try Again</button>
</body>
</html>
