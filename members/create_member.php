<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/middleware/AuthMiddleware.php';

checkAuth($pdo, ['admin', 'treasurer']);

$pageTitle = "Add New Member";
$activePage = 'add_member';
?>

<?php include __DIR__ . '/../includes/layout_start.php'; ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>

<div class="flex-1 flex flex-col min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    <?php include __DIR__ . '/../includes/topbar.php'; ?>

    <main class="p-8 flex-1 overflow-auto">
        <div class="max-w-6xl mx-auto">

            <!-- Header -->
            <div class="mb-10 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Member Registration</h2>
                    <p class="text-slate-500 mt-1">Add a new member to the SACCO system</p>
                </div>

                <a href="managemember.php"
                    class="group flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-xl font-semibold text-slate-600 shadow-sm hover:shadow-md hover:text-blue-600 transition">
                    View Members
                    <span class="group-hover:translate-x-1 transition">→</span>
                </a>
            </div>

            <!-- Card -->
            <div class="bg-white/90 backdrop-blur rounded-3xl shadow-xl border border-slate-200 overflow-hidden">

                <!-- Accent -->
                <div class="h-1.5 bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-500"></div>

                <form id="registerForm" method="POST"
                    action="/sacco-management-system/app/controllers/RegMemberController.php"
                    class="p-8 md:p-12 space-y-14">

                    <!-- PERSONAL INFO -->
                    <section>
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                1</div>
                            <h3 class="text-xl font-bold text-slate-800">Personal Information</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                            <div class="input-group">
                                <label>Member No *</label>
                                <input type="text" name="member_no" required placeholder="MBR-001">
                            </div>

                            <div class="input-group lg:col-span-2">
                                <label>Full Name *</label>
                                <input type="text" name="full_name" required placeholder="Enter full name">
                            </div>

                            <div class="input-group">
                                <label>National ID</label>
                                <input type="text" name="id_number">
                            </div>

                            <div class="input-group">
                                <label>Email</label>
                                <input type="email" name="email">
                            </div>

                            <div class="input-group">
                                <label>Phone</label>
                                <input type="tel" name="phone" placeholder="+256...">
                            </div>

                            <div class="input-group">
                                <label>Date of Birth</label>
                                <input type="date" name="dob">
                            </div>

                            <div class="input-group">
                                <label>Gender</label>
                                <select name="gender">
                                    <option value="">Select</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>

                            <div class="input-group">
                                <label>Joined Date</label>
                                <input type="date" name="joined_date" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>

                        <div class="mt-6 input-group">
                            <label>Address</label>
                            <textarea name="address" rows="3"></textarea>
                        </div>
                    </section>

                    <!-- NEXT OF KIN -->
                    <section class="bg-slate-50 border border-slate-200 rounded-2xl p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                2</div>
                            <h3 class="text-xl font-bold text-slate-800">Next of Kin</h3>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="input-group">
                                <label>Full Name *</label>
                                <input type="text" name="next_of_kin_name" required>
                            </div>

                            <div class="input-group">
                                <label>Phone *</label>
                                <input type="tel" name="next_of_kin_phone" required>
                            </div>
                        </div>
                    </section>

                    <!-- ACTIONS -->
                    <div class="flex justify-between items-center pt-6 border-t">
                        <a href="managemember.php" class="text-slate-400 hover:text-slate-600 font-medium transition">
                            Cancel
                        </a>

                        <button type="submit"
                            class="px-10 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-bold shadow-lg hover:scale-[1.02] active:scale-[0.98] transition">
                            Register Member
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>
</div>

<!-- Styles -->
<style>
    .input-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 6px;
    }

    .input-group input,
    .input-group select,
    .input-group textarea {
        width: 100%;
        padding: 12px 14px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .input-group input:focus,
    .input-group select:focus,
    .input-group textarea:focus {
        background: #fff;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08);
        outline: none;
    }
</style>

<script src="/sacco-management-system/public/assets/js/regmembers.js"></script>

<?php include __DIR__ . '/../includes/layout_end.php'; ?>