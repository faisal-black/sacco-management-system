<!-- Use "fixed" or "sticky" and "top-0 left-0" if you want it to ignore parent padding -->
<header class="w-full bg-white px-6 py-4 flex justify-between items-center border-b shadow-sm">
    <!-- Page Title -->
    <div>
        <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight"><?= htmlspecialchars($pageTitle) ?></h2>
        <p class="text-sm text-gray-500 mt-1">
            Welcome, <?= htmlspecialchars($_SESSION['full_name'] ?? 'User') ?>
            <span class="text-gray-400">| <?= ucfirst($_SESSION['role'] ?? '') ?></span>
        </p>
    </div>

    <!-- User Profile / Avatar -->
    <div class="flex items-center gap-4">
        <div class="text-right">
            <p class="text-sm text-gray-500">ID: <?= htmlspecialchars($_SESSION['user_id']) ?></p>
        </div>
        <div
            class="h-12 w-12 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg text-lg uppercase">
            <?= strtoupper(substr($_SESSION['full_name'] ?? 'U', 0, 1)) ?>
        </div>
    </div>
</header>