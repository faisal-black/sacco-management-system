<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/middleware/AuthMiddleware.php';

// Only admin can manage users
checkAuth($pdo, ['admin']);

$pageTitle = "Manage Users";
$activePage = 'manage_users';

$users = $pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include __DIR__ . '/../includes/layout_start.php'; ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>

<div class="flex-1 flex flex-col min-h-screen bg-gray-50/50">
    <!-- Topbar stays outside main to remain full length -->
    <?php include __DIR__ . '/../includes/topbar.php'; ?>

    <main class="p-8 flex-1 overflow-auto bg-slate-50/50">
        <!-- Header Section -->
        <div class="flex justify-between items-end mb-10">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <div class="h-8 w-1.5 bg-blue-600 rounded-full"></div>
                    <h3 class="text-3xl font-bold text-slate-900 tracking-tight">Users List</h3>
                </div>
                <p class="text-slate-500 text-sm ml-4">Manage system administrators and staff members</p>
            </div>
            <a href="addUser.php"
                class="group flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-900/20 hover:bg-blue-500 transition-all transform active:scale-[0.98]">
                <i class="hgi-stroke hgi-user-add-01 text-lg group-hover:scale-110 transition-transform"></i>
                Add New User
            </a>
        </div>

        <!-- Table Container -->
        <div class="overflow-hidden bg-white shadow-2xl shadow-slate-200/60 rounded-3xl border border-slate-100">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th
                            class="px-6 py-5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em]">
                            #</th>
                        <th
                            class="px-6 py-5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em]">
                            User Details</th>
                        <th
                            class="px-6 py-5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em]">
                            Username</th>
                        <th
                            class="px-6 py-5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em]">
                            Role</th>
                        <th
                            class="px-6 py-5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em]">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach ($users as $index => $u): ?>
                        <tr class="group hover:bg-blue-50/30 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-400 font-medium"><?= $index + 1 ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs shadow-sm border border-white">
                                        <?= strtoupper(substr($u['full_name'], 0, 2)) ?>
                                    </div>
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-bold text-slate-900"><?= htmlspecialchars($u['full_name']) ?></span>
                                        <span
                                            class="text-[11px] text-slate-400 font-medium"><?= htmlspecialchars($u['email']) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-md bg-slate-100 text-slate-600 font-mono text-[10px] font-bold border border-slate-200/50">
                                    @<?= htmlspecialchars($u['username']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                $roleColor = match (strtolower($u['role'])) {
                                    'admin' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                    'treasurer' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    default => 'bg-blue-50 text-blue-700 border-blue-100'
                                };
                                ?>
                                <span
                                    class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full border <?= $roleColor ?>">
                                    <?= ucfirst($u['role']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="edit_user.php?id=<?= $u['id'] ?>"
                                        class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                        title="Edit User">
                                        <i class="hgi-stroke hgi-pencil-edit-01 text-lg"></i>
                                    </a>
                                    <a href="/sacco-management-system/public/delete_user.php?id=<?= $u['id'] ?>"
                                        class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                        onclick="return confirm('Are you sure you want to delete this user?')"
                                        title="Delete User">
                                        <i class="hgi-stroke hgi-delete-02 text-lg"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php include __DIR__ . '/../includes/layout_end.php'; ?>