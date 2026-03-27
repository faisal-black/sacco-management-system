<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/middleware/AuthMiddleware.php';

// Only Admin or Treasurer can record deposits
checkAuth($pdo, ['admin', 'treasurer']);

$pageTitle = "Record Saving";
$activePage = 'savings';

// In a full MVC, $members is passed from the controller. 
// If calling this file directly, fetch them here:
$members = $pdo->query("SELECT id, full_name FROM members WHERE status = 'active' ORDER BY full_name ASC")->fetchAll();
?>

<?php include __DIR__ . '/../../includes/layout_start.php'; ?>
<?php include __DIR__ . '/../../includes/sidebar.php'; ?>

<div class="flex-1 flex flex-col min-h-screen bg-gray-50/50">
    <?php include __DIR__ . '/../../includes/topbar.php'; ?>

    <main class="p-8 flex-1 overflow-auto bg-slate-50/50">
        <!-- Form Container -->
        <div class="max-w-3xl mx-auto">
            <div class="mb-10 flex items-end justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <div class="h-8 w-1.5 bg-emerald-600 rounded-full"></div>
                        <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Record New Saving</h2>
                    </div>
                    <p class="text-slate-500 text-sm ml-4">Enter deposit details for SACCO members</p>
                </div>
                <a href="../dashboard.php"
                    class="group text-sm font-bold text-slate-500 hover:text-slate-900 transition-all flex items-center gap-2 pb-1">
                    <i class="hgi-stroke hgi-arrow-left-01 text-lg group-hover:-translate-x-1 transition-transform"></i>
                    Back to Dashboard
                </a>
            </div>

            <!-- Form starts here -->
            <form action="/sacco-management-system/public/savings/store_deposit.php" method="POST"
                class="bg-white shadow-2xl shadow-slate-200/60 rounded-3xl border border-slate-100 p-8 md:p-10 space-y-8 relative overflow-hidden">

                <!-- Subtle accent gradient -->
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-emerald-500 to-teal-400"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                    <!-- Member Selection -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[13px] font-bold text-slate-700 ml-1 uppercase tracking-wider">Select SACCO
                            Member</label>
                        <div class="relative">
                            <select name="member_id" required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-5 py-4 focus:bg-white focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 outline-none transition-all appearance-none cursor-pointer text-slate-900 font-medium">
                                <option value="" disabled selected>-- Choose Member --</option>
                                <?php foreach ($members as $member): ?>
                                    <option value="<?= $member['id']; ?>">
                                        <?= $member['id'] . " - " . htmlspecialchars($member["full_name"]); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <i class="hgi-stroke hgi-arrow-down-01"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Amount Input -->
                    <div class="space-y-2">
                        <label class="text-[13px] font-bold text-slate-700 ml-1 uppercase tracking-wider">Amount to
                            Deposit (UGX)</label>
                        <div class="relative group">
                            <div
                                class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                                <i class="hgi-stroke hgi-money-receive-01 text-xl"></i>
                            </div>
                            <input type="number" name="amount" step="0.01" min="1" required placeholder="e.g. 50,000"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-12 pr-5 py-4 focus:bg-white focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 outline-none transition-all font-bold text-slate-900 placeholder:font-normal placeholder:text-slate-300">
                        </div>
                    </div>

                    <!-- Date Input -->
                    <div class="space-y-2">
                        <label class="text-[13px] font-bold text-slate-700 ml-1 uppercase tracking-wider">Transaction
                            Date</label>
                        <div class="relative group">
                            <div
                                class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                                <i class="hgi-stroke hgi-calendar-01 text-xl"></i>
                            </div>
                            <input type="date" name="saved_at" value="<?= date('Y-m-d'); ?>" required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-12 pr-5 py-4 focus:bg-white focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 outline-none transition-all font-medium text-slate-900">
                        </div>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="pt-6 border-t border-slate-50 flex justify-end">
                    <button type="submit" name="submit_deposit"
                        class="group w-full md:w-auto px-10 py-4 bg-emerald-600 text-white rounded-xl hover:bg-emerald-500 font-bold shadow-xl shadow-emerald-900/10 transition-all transform active:scale-[0.98] flex items-center justify-center gap-3">
                        <i
                            class="hgi-stroke hgi-checkmark-circle-01 text-xl group-hover:scale-110 transition-transform"></i>
                        Confirm & Save Deposit
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<?php include __DIR__ . '/../../includes/layout_end.php'; ?>