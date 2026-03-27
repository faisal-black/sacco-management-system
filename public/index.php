<?php
// 1. Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Absolute path to your database file
// __DIR__ is C:\wamp64\www\sacco-management-system\public
// dirname(__DIR__) is C:\wamp64\www\sacco-management-system
require_once dirname(__DIR__) . '/config/database.php';

// 3. Verify that the $pdo variable exists
if (!isset($pdo)) {
    die("Error: The database connection variable \$pdo was not found in your config file.");
}

// 4. Fetch Live Stats (With Error Handling)
try {
    // Total active members
    $totalMembers = $pdo->query("SELECT COUNT(*) FROM members WHERE status = 'active'")->fetchColumn() ?: 0;

    // Net Savings: Deposits - Withdrawals
    $totalSavings = $pdo->query("
        SELECT SUM(CASE 
            WHEN transaction_type = 'deposit' THEN amount 
            WHEN transaction_type = 'withdrawal' THEN -amount 
            ELSE 0 
        END) 
        FROM savings
    ")->fetchColumn() ?: 0;
} catch (PDOException $e) {
    // If the database is missing columns (like transaction_type), this catches the error
    $totalMembers = 0;
    $totalSavings = 0;
    $db_error = $e->getMessage();
}

// 5. Progress Logic
$targetGoal = 10000000; // 10M UGX Target
$progressPercent = ($totalSavings > 0) ? min(round(($totalSavings / $targetGoal) * 100), 100) : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitebi Youth SACCO | Secure Growth</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .glass {
            backdrop-filter: blur(14px);
            background: rgba(255, 255, 255, 0.7);
        }

        .hero-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
            top: -150px;
            right: -150px;
            z-index: -1;
        }

        .smooth {
            transition: all 0.35s ease;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 overflow-x-hidden">

    <div class="hero-glow"></div>

    <!-- NAVIGATION -->
    <nav class="fixed w-full z-50 glass border-b border-white/40">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div
                    class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <span class="text-white font-bold">$</span>
                </div>
                <h1 class="text-xl font-bold tracking-tight">
                    KITEBI YOUTH <span
                        class="bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-500 bg-clip-text text-transparent">SACCO</span>
                </h1>
            </div>
            <div class="hidden md:flex space-x-10 font-medium text-slate-600">
                <a href="#features" class="hover:text-blue-600 smooth">Features</a>
                <a href="login.php" class="hover:text-blue-600 smooth">Staff Portal</a>
            </div>
            <a href="login.php"
                class="px-6 py-2.5 rounded-full bg-slate-900 text-white font-semibold shadow-lg hover:scale-105 smooth">
                Member Login
            </a>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="container mx-auto px-6 pt-40 pb-24 flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 space-y-8">
            <h2 class="text-5xl md:text-7xl font-black leading-tight">
                Secure. <span
                    class="bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-500 bg-clip-text text-transparent">Grow.</span><br>Prosper.
            </h2>
            <p class="text-lg text-slate-600 max-w-lg leading-relaxed">
                Empowering the youth of Kitebi with a secure digital platform for transparent financial management.
            </p>
            <div class="flex gap-4">
                <a href="login.php"
                    class="px-8 py-4 rounded-xl bg-blue-600 text-white font-bold shadow-xl hover:bg-blue-500 smooth">Get
                    Started</a>
                <a href="#features"
                    class="px-8 py-4 rounded-xl border border-slate-300 bg-white font-semibold hover:bg-slate-100 smooth">Learn
                    More</a>
            </div>
        </div>

        <!-- DYNAMIC DATA CARD -->
        <div class="md:w-1/2 mt-16 md:mt-0 flex justify-center">
            <div class="bg-white rounded-3xl shadow-2xl p-10 w-80 border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-600"></div>
                <h3 class="font-bold text-lg mb-6">SACCO Live Stats</h3>

                <?php if (isset($db_error)): ?>
                    <p class="text-xs text-red-500 bg-red-50 p-2 rounded">DB Error: Check if 'transaction_type' column
                        exists.</p>
                <?php endif; ?>

                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-400 mb-1">Total Savings (UGX)</p>
                        <p class="text-3xl font-black text-slate-900"><?= number_format($totalSavings) ?></p>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-2">
                            <span class="text-slate-500 uppercase">Growth Goal</span>
                            <span class="text-blue-600"><?= $progressPercent ?>%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full smooth" style="width: <?= $progressPercent ?>%">
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-slate-50 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Active Members</span>
                        <span class="font-bold text-slate-900"><?= $totalMembers ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-400 py-12 mt-20">
        <div class="container mx-auto px-6 text-center">
            <p class="text-sm">&copy; <?= date('Y') ?> Kitebi Youth SACCO. All Rights Reserved.</p>
        </div>
    </footer>
</body>

</html>