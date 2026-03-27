<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SACCO Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-200 flex items-center justify-center min-h-screen p-4">

    <div class="login-container bg-white p-10 rounded-2xl shadow-2xl w-full max-w-sm border border-gray-100">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">SACCO Login</h2>
            <p class="text-gray-500 text-sm mt-2">Please enter your credentials</p>
        </div>

        <form id="loginForm" method="POST" class="space-y-5">
            <div>
                <label for="user-email" class="block font-semibold mb-1.5 text-gray-700 text-sm">Email Address</label>
                <input type="email" name="useremail" id="user-email" placeholder="Enter your email" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-400 bg-gray-50" />
            </div>

            <div>
                <label for="user-password" class="block font-semibold mb-1.5 text-gray-700 text-sm">Password</label>
                <input type="password" name="userpassword" id="user-password" placeholder="Enter your password" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-400 bg-gray-50" />
            </div>

            <div id="errorMessage"
                class="text-red-500 text-sm hidden font-medium bg-red-50 p-2 rounded-lg border border-red-100"></div>

            <div class="pt-2">
                <input type="submit" value="Sign In"
                    class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 cursor-pointer transition-all shadow-lg shadow-blue-200 active:scale-[0.98]" />
            </div>
        </form>

        <div class="mt-8 text-center">
            <p class="text-xs text-gray-400 uppercase tracking-widest">&copy; 2026 KITEBI YOUTH SACCO SYSTEM</p>
        </div>
    </div>

    <script src="assets/js/login.js"></script>
</body>

</html>