<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/middleware/AuthMiddleware.php';

// Only Admin or Treasurer can issue loans
checkAuth($pdo, ['admin', 'treasurer']);

$pageTitle = "Issue Loan";
$activePage = 'loans';

// Fetch members for dropdown
$members = $pdo->query("SELECT id, full_name FROM members WHERE status = 'active' ORDER BY full_name ASC")->fetchAll();
?>

<?php include __DIR__ . '/../../includes/layout_start.php'; ?>
<?php include __DIR__ . '/../../includes/sidebar.php'; ?>

<div class="flex-1 flex flex-col min-h-screen bg-gray-50/50">
    <?php include __DIR__ . '/../../includes/topbar.php'; ?>

    <main class="p-8 flex-1 overflow-auto">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-10 flex items-end justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Issue a New Loan</h2>
                    <p class="text-slate-500 text-sm ml-0">Enter loan details for SACCO members</p>
                </div>
                <a href="../dashboard.php" class="text-sm font-bold text-slate-500 hover:text-slate-900 transition">
                    ← Back to Dashboard
                </a>
            </div>

            <!-- Loan Form -->
            <form action="store_loan.php" method="POST" class="bg-white shadow-2xl rounded-3xl p-8 md:p-10 space-y-8">

                <!-- Member -->
                <div class="space-y-2">
                    <label class="text-[13px] font-bold text-slate-700 uppercase tracking-wider">Select SACCO
                        Member</label>
                    <select name="member_id" required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-5 py-4 focus:ring-emerald-500 outline-none">
                        <option value="" disabled selected>-- Choose Member --</option>
                        <?php foreach ($members as $member): ?>
                            <option value="<?= $member['id'] ?>">
                                <?= htmlspecialchars($member["full_name"]) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Principal -->
                <div class="space-y-2">
                    <label class="text-[13px] font-bold text-slate-700 uppercase tracking-wider">Principal Amount
                        (UGX)</label>
                    <input type="number" name="principal" min="1" step="0.01" placeholder="e.g. 50000" required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-5 py-4 outline-none">
                </div>

                <!-- Interest Rate -->
                <div class="space-y-2">
                    <label class="text-[13px] font-bold text-slate-700 uppercase tracking-wider">Interest Rate
                        (%)</label>
                    <input type="number" name="interest_rate" min="0" max="100" step="0.01" placeholder="e.g. 10"
                        required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-5 py-4 outline-none">
                </div>

                <!-- Issue Date -->
                <div class="space-y-2">
                    <label class="text-[13px] font-bold text-slate-700 uppercase tracking-wider">Issue Date</label>
                    <input type="date" name="issued_date" value="<?= date('Y-m-d') ?>" required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-5 py-4 outline-none">
                </div>

                <!-- Submit -->
                <div class="pt-6 border-t border-slate-50 flex justify-end">
                    <button type="submit" name="submit_loan"
                        class="px-10 py-4 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-500 transition">
                        Issue Loan
                    </button>
                </div>

            </form>
        </div>
    </main>
</div>

<?php include __DIR__ . '/../../includes/layout_end.php'; ?>