<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Apotek</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('<?php echo BASE_URL; ?>/path/to/your/background.gif');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .login-container {
            width: 400px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #343a40;
        }

        .login-container p {
            color: red;
            margin-bottom: 15px;
        }

        .login-container label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-bottom: 10px;
            color: #343a40;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: calc(100% - 24px);
            padding: 12px 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #343a40;
            color: #ffc107;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .login-container button:hover {
            background-color: #ffc107;
            color: #343a40;
        }

        .login-footer {
            margin-top: 15px;
            font-size: 14px;
            color: #555;
        }

        .login-footer a {
            color: #007bff;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        #background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
    </style>
</head>
<body>
    <video autoplay muted loop id="background-video">
        <source src="<?php echo BASE_URL; ?>/images/1215.mp4" type="video/mp4">
        <source src="<?php echo BASE_URL; ?>/images/your-video.webm" type="video/webm">
        Your browser does not support the video tag.
    </video>
    <div class="login-container">
        <h2>Login Apotek</h2>
        <?php if(isset($data['error'])): ?>
            <p><?php echo htmlspecialchars($data['error']); ?></p>
        <?php endif; ?>
        <form method="POST" action="<?php echo BASE_URL; ?>/auth/login">
            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Masukkan username Anda" required>

            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Masukkan password Anda" required>

            <button type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
        </form>
        <div class="login-footer">
        </div>
    </div>
</body>
</html>
