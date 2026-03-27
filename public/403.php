<?php
session_start();
// If someone tries to access this page directly without being logged in
if (!isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Restricted | SACCO System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">

    <div
        class="max-w-md w-full bg-white p-10 rounded-3xl shadow-2xl border border-gray-100 text-center transform transition-all hover:scale-[1.01]">

        <!-- Professional Shield Icon (Blue instead of Red) -->
        <div
            class="mb-6 inline-flex items-center justify-center w-20 h-20 bg-blue-50 text-blue-600 rounded-2xl ring-4 ring-blue-50/50">
            <svg xmlns="http://www.w3.org" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
        </div>

        <h1 class="text-2xl font-extrabold text-slate-900 mb-2 tracking-tight">Access Restricted</h1>

        <p class="text-slate-500 mb-6 text-sm">
            Hello, <span
                class="font-semibold text-slate-800"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Staff Member') ?></span>.
            This area is restricted based on your current system role.
        </p>

        <!-- Role Badge -->
        <div class="inline-block bg-slate-100 border border-slate-200 rounded-full px-4 py-1.5 mb-8">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mr-2">Your Role:</span>
            <span class="text-xs font-extrabold text-blue-700 uppercase tracking-wider">
                <?= htmlspecialchars($_SESSION['user_role']) ?>
            </span>
        </div>

        <div class="space-y-4">
            <a href="/sacco-management-system/public/dashboard.php"
                class="block w-full bg-slate-900 text-white font-bold py-4 rounded-xl hover:bg-slate-800 transition-all shadow-lg active:scale-95">
                Go to Dashboard
            </a>

            <p class="text-xs text-slate-400 mt-6">
                Please contact the <b>System Administrator</b> if you need access to this module.
            </p>
        </div>

        <div class="mt-10 pt-6 border-t border-slate-100">
            <p class="text-[10px] text-slate-400 uppercase tracking-[0.2em] font-bold">Kitebi Youth Sacco Management</p>
        </div>
    </div>

</body>

</html>