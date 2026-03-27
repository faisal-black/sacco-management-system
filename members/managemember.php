<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/middleware/AuthMiddleware.php';

// Only admin or treasurer can manage members
checkAuth($pdo, ['admin', 'treasurer']);

$pageTitle = "Manage Members";
$activePage = 'manage_members';

// Fetch all members
$stmt = $pdo->query("SELECT * FROM members ORDER BY id DESC");
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include __DIR__ . '/../includes/layout_start.php'; ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>

<div class="flex-1 flex flex-col min-h-screen bg-gray-50/50">
    <!-- Topbar stays outside main to remain full length -->
    <?php include __DIR__ . '/../includes/topbar.php'; ?>

    <main class="p-8 flex-1 overflow-auto">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-2xl font-extrabold text-gray-800 tracking-tight">Members List</h3>
            <a href="create_member.php"
                class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-bold shadow-lg hover:bg-blue-700 transition">
                + Add Member
            </a>
        </div>

        <!-- Table Container -->
        <div class="overflow-hidden bg-white shadow-xl shadow-gray-200/50 rounded-3xl border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Member
                            No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Full
                            Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Phone
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <?php foreach ($members as $index => $m): ?>
                        <tr class="hover:bg-blue-50/40 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-400 font-medium"><?= $index + 1 ?></td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm text-blue-600 font-bold bg-blue-50 px-2 py-1 rounded-lg">
                                    <?= htmlspecialchars($m['member_no']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-800">
                                <?= htmlspecialchars($m['full_name']) ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                <?= htmlspecialchars($m['phone']) ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                $status = strtolower($m['status'] ?? '');
                                $badge = match ($status) {
                                    'active' => 'bg-green-100 text-green-700',
                                    'suspended' => 'bg-red-100 text-red-700',
                                    'inactive' => 'bg-gray-100 text-gray-600',
                                    default => 'bg-yellow-100 text-yellow-700'
                                };
                                ?>
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-tighter <?= $badge ?>">
                                    <?= ucfirst($m['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 space-x-3">
                                <a href="edit_member.php?id=<?= $m['id'] ?>"
                                    class="text-blue-600 font-bold text-sm hover:underline">Edit</a>
                                <a href="/sacco-management-system/members/delete_member.php?id=<?= $m['id'] ?>"
                                    class="text-red-500 font-bold text-sm hover:underline"
                                    onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php include __DIR__ . '/../includes/layout_end.php'; ?>