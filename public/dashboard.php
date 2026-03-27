<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/middleware/AuthMiddleware.php';

checkAuth($pdo, ['admin', 'chairperson', 'treasurer']);

$pageTitle = "Dashboard";
$activePage = 'dashboard';

$totalMembers = $pdo->query("SELECT COUNT(*) FROM members")->fetchColumn();
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalSavings = $pdo->query("SELECT SUM(amount) FROM savings")->fetchColumn() ?: 0;
$totalLoans = $pdo->query("SELECT COUNT(*) FROM loans WHERE status = 'active'")->fetchColumn();
?>

<?php include __DIR__ . '/../includes/layout_start.php'; ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>

<div class="flex-1 flex flex-col min-h-screen bg-gray-100 font-sans">
    <?php include __DIR__ . '/../includes/topbar.php'; ?>

    <main class="p-8 flex-1 overflow-y-auto">

        <!-- HEADER -->
        <div class="flex flex-wrap justify-between items-center mb-8 gap-4">
            <div>
                <h2 class="text-4xl font-extrabold text-gray-800 tracking-tight mb-2">Dashboard Overview</h2>
                <p class="text-gray-500 text-sm">Real-time insights into your SACCO</p>
            </div>
            <div class="bg-white shadow-md rounded-lg px-6 py-3 flex items-center space-x-4 border border-gray-200">
                <div class="text-sm font-semibold text-gray-400 uppercase">Today</div>
                <div class="font-semibold text-gray-700"><?= date('D, d M Y') ?></div>
            </div>
        </div>

        <!-- ALERTS -->
        <?php if (isset($_GET['msg'])): ?>
            <div
                class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 font-medium shadow hover:shadow-lg transition">
                ✅ Action completed successfully
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div
                class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 font-medium shadow hover:shadow-lg transition">
                ❌ Transaction failed. Check member balance
            </div>
        <?php endif; ?>

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
            <!-- Members -->
            <div
                class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 p-6 border border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Members</p>
                        <h2 class="text-3xl font-bold text-gray-800"><?= number_format($totalMembers) ?></h2>
                    </div>
                    <div
                        class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-4xl transition-transform hover:scale-105">
                        👥
                    </div>
                </div>
            </div>
            <!-- Net Savings -->
            <div
                class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 p-6 border border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Net Savings</p>
                        <h2 class="text-3xl font-bold text-gray-800"><?= number_format($totalSavings) ?></h2>
                        <span class="text-xs text-gray-400 font-semibold">UGX</span>
                    </div>
                    <div
                        class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-4xl transition-transform hover:scale-105">
                        💰
                    </div>
                </div>
            </div>
            <!-- Active Loans -->
            <div
                class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 p-6 border border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Active Loans</p>
                        <h2 class="text-3xl font-bold text-gray-800"><?= number_format($totalLoans) ?></h2>
                    </div>
                    <div
                        class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-4xl transition-transform hover:scale-105">
                        💳
                    </div>
                </div>
            </div>
            <!-- Staff Users -->
            <div
                class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 p-6 border border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Staff Users</p>
                        <h2 class="text-3xl font-bold text-gray-800"><?= number_format($totalUsers) ?></h2>
                    </div>
                    <div
                        class="w-16 h-16 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-4xl transition-transform hover:scale-105">
                        🛡️
                    </div>
                </div>
            </div>
        </div>
        <!-- Quick Actions: Stylish Buttons -->
        <div class="max-w-7xl mx-auto px-4 mb-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <a href="/sacco-management-system/public/savings/deposit.php"
                class="bg-gradient-to-tr from-green-400 to-green-500 hover:from-green-500 hover:to-green-600 text-white font-semibold py-4 px-6 rounded-xl shadow-lg transform hover:scale-105 transition duration-200 text-center flex items-center justify-center space-x-2">
                <span class="text-xl">＋</span>
                <span class="text-lg">Deposit</span>
            </a>
            <a href="/sacco-management-system/public/savings/withdrawal.php"
                class="bg-gradient-to-tr from-pink-400 to-pink-500 hover:from-pink-500 hover:to-pink-600 text-white font-semibold py-4 px-6 rounded-xl shadow-lg transform hover:scale-105 transition duration-200 text-center flex items-center justify-center space-x-2">
                <span class="text-xl">−</span>
                <span class="text-lg">Withdraw</span>
            </a>
            <a href="/sacco-management-system/public/loans/issue_loan.php"
                class="bg-gradient-to-tr from-teal-400 to-teal-500 hover:from-teal-500 hover:to-teal-600 text-white font-semibold py-4 px-6 rounded-xl shadow-lg transform hover:scale-105 transition duration-200 text-center flex items-center justify-center space-x-2">
                <span class="text-xl">💳</span>
                <span class="text-lg">Issue Loan</span>
            </a>
            <a href="/sacco-management-system/public/loans/active_loans.php"
                class="bg-gradient-to-tr from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-white font-semibold py-4 px-6 rounded-xl shadow-lg transform hover:scale-105 transition duration-200 text-center flex items-center justify-center space-x-2">
                <span class="text-xl">📊</span>
                <span class="text-lg">Active Loans</span>
            </a>
        </div>

        <!-- Lower Section: Analytics + Quick Links -->
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">

            <!-- Analytics Chart -->
            <div
                class="lg:col-span-2 bg-white rounded-3xl p-8 border border-gray-200 shadow hover:shadow-xl transition duration-300">
                <h4 class="text-xl font-semibold text-gray-700 mb-4">Analytics & Reports</h4>
                <div
                    class="h-64 flex items-center justify-center border-4 border-dashed border-gray-300 rounded-xl text-gray-400 text-lg font-medium">
                    Charts & reports coming soon
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow hover:shadow-xl transition duration-300">
                <h4 class="text-xl font-semibold text-gray-700 mb-4">Quick Links</h4>
                <div class="flex flex-col gap-4">
                    <a href="/sacco-management-system/members/create_member.php"
                        class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                        <div
                            class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xl mr-4 shadow-sm">
                            👤
                        </div>
                        <span class="font-medium text-gray-700">Register Member</span>
                    </a>
                    <a href="/sacco-management-system/public/reports/financial_reports.php"
                        class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                        <div
                            class="w-10 h-10 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-xl mr-4 shadow-sm">
                            📄
                        </div>
                        <span class="font-medium text-gray-700">Generate Reports</span>
                    </a>
                </div>
            </div>
        </div>

        <?php include __DIR__ . '/../includes/layout_end.php'; ?>