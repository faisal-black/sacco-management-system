<header class="bg-white px-8 py-4 flex justify-between items-center border-b shadow-sm">
    <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight"><?= $pageTitle ?></h2>
    <div class="flex items-center gap-4">
        <span class="text-sm text-gray-500">
            Admin ID: <?= htmlspecialchars($_SESSION['user_id'] ?? 'Admin') ?>
        </span>
        <div class="h-10 w-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg">
            A
        </div>
    </div>
</header>