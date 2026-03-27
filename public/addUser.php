<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/middleware/AuthMiddleware.php';

// Only admin can add users
checkAuth($pdo, ['admin']);

$pageTitle = "Add User";
$activePage = 'add_user';

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];

        $stmt = $pdo->prepare("INSERT INTO users (full_name, username, email, password, role) VALUES (?,?,?,?,?)");
        $stmt->execute([$full_name, $username, $email, $password, $role]);
        $message = "User added successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<?php include __DIR__ . '/../includes/layout_start.php'; ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>

<div class="flex-1 flex flex-col min-h-screen bg-gray-50/50">
    <?php include __DIR__ . '/../includes/topbar.php'; ?>

    <main class="p-8 flex-1 overflow-auto bg-slate-50/50">
        <!-- Success Message -->
        <?php if ($message): ?>
        <div
            class="max-w-3xl mx-auto mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl shadow-sm flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white shadow-sm">
                <i class="hgi-stroke hgi-checkmark-circle-02 text-lg"></i>
            </div>
            <p class="font-bold text-sm"><?= $message ?></p>
        </div>
        <?php endif; ?>

        <!-- Form Container -->
        <div class="max-w-3xl mx-auto">
            <div class="mb-10 flex items-end justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <div class="h-8 w-1.5 bg-blue-600 rounded-full"></div>
                        <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Create New User</h2>
                    </div>
                    <p class="text-slate-500 text-sm ml-4">Register a new administrator or staff member</p>
                </div>
                <a href="manage_user.php"
                    class="group text-sm font-bold text-slate-500 hover:text-slate-900 transition-all flex items-center gap-2 pb-1">
                    <i class="hgi-stroke hgi-arrow-left-01 text-lg group-hover:-translate-x-1 transition-transform"></i>
                    Back to Users
                </a>
            </div>

            <form method="POST"
                class="bg-white shadow-2xl shadow-slate-200/60 rounded-3xl border border-slate-100 p-8 md:p-10 space-y-8 relative overflow-hidden">

                <!-- Subtle accent gradient -->
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-600 to-indigo-500"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <!-- Full Name -->
                    <div class="space-y-2">
                        <label class="text-[13px] font-bold text-slate-700 ml-1 uppercase tracking-wider">Full
                            Name</label>
                        <div class="relative group">
                            <div
                                class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="hgi-stroke hgi-user text-xl"></i>
                            </div>
                            <input type="text" name="full_name" placeholder="John Doe" required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-12 pr-5 py-4 focus:bg-white focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all font-medium text-slate-900 placeholder:text-slate-300">
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="space-y-2">
                        <label
                            class="text-[13px] font-bold text-slate-700 ml-1 uppercase tracking-wider">Username</label>
                        <div class="relative group">
                            <div
                                class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="hgi-stroke hgi-at-sign text-xl"></i>
                            </div>
                            <input type="text" name="username" placeholder="johndoe123" required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-12 pr-5 py-4 focus:bg-white focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all font-medium text-slate-900 placeholder:text-slate-300">
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label class="text-[13px] font-bold text-slate-700 ml-1 uppercase tracking-wider">Email
                            Address</label>
                        <div class="relative group">
                            <div
                                class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="hgi-stroke hgi-mail-01 text-xl"></i>
                            </div>
                            <input type="email" name="email" placeholder="name@example.com" required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-12 pr-5 py-4 focus:bg-white focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all font-medium text-slate-900 placeholder:text-slate-300">
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="space-y-2">
                        <label class="text-[13px] font-bold text-slate-700 ml-1 uppercase tracking-wider">Assign
                            Role</label>
                        <div class="relative group">
                            <div
                                class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="hgi-stroke hgi-user-shield-01 text-xl"></i>
                            </div>
                            <select name="role" required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-12 pr-10 py-4 focus:bg-white focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all appearance-none cursor-pointer text-slate-900 font-medium">
                                <option value="" disabled selected>Choose a role...</option>
                                <option value="admin">Admin</option>
                                <option value="treasurer">Treasurer</option>
                                <option value="chairperson">Chairperson</option>
                            </select>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <i class="hgi-stroke hgi-arrow-down-01"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[13px] font-bold text-slate-700 ml-1 uppercase tracking-wider">Secure
                            Password</label>
                        <div class="relative group">
                            <div
                                class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="hgi-stroke hgi-lock-password text-xl"></i>
                            </div>
                            <input type="password" name="password" placeholder="••••••••••••" required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-12 pr-5 py-4 focus:bg-white focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all font-medium text-slate-900 placeholder:text-slate-300">
                        </div>
                        <p class="text-[11px] text-slate-400 ml-1 flex items-center gap-1">
                            <i class="hgi-stroke hgi-information-circle text-sm"></i>
                            Must be at least 8 characters long.
                        </p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 border-t border-slate-50 flex justify-end">
                    <button type="submit"
                        class="group w-full md:w-auto px-10 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-500 font-bold shadow-xl shadow-blue-900/10 transition-all transform active:scale-[0.98] flex items-center justify-center gap-3">
                        <i class="hgi-stroke hgi-user-add-01 text-xl group-hover:scale-110 transition-transform"></i>
                        Create User Account
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<?php include __DIR__ . '/../includes/layout_end.php'; ?>