<aside class="w-60 bg-white border-r border-gray-200 flex flex-col">

    <!-- LOGO -->
    <div class="px-6 py-5 border-b border-gray-200">
        <h1 class="text-lg font-bold text-gray-800">
            SACCO SYSTEM
        </h1>
        <p class="text-xs text-gray-400 uppercase mt-1">
            <?= $_SESSION['user_role'] ?>
        </p>
    </div>

    <!-- NAV -->
    <nav class="flex-1 px-3 py-5 space-y-1">

        <!-- Dashboard -->
        <a href="/sacco-management-system/public/dashboard.php"
            class="nav-link <?= $activePage === 'dashboard' ? 'active' : '' ?>">
            Dashboard
        </a>

        <!-- Members -->
        <?php if (in_array($_SESSION['user_role'], ['admin', 'treasurer'])): ?>
            <div class="nav-section">Members</div>

            <a href="/sacco-management-system/members/create_member.php"
                class="nav-link <?= $activePage === 'add_member' ? 'active' : '' ?>">
                Add Member
            </a>

            <a href="/sacco-management-system/members/managemember.php"
                class="nav-link <?= $activePage === 'manage_members' ? 'active' : '' ?>">
                Manage Members
            </a>
        <?php endif; ?>

        <!-- Loans -->
        <?php if (in_array($_SESSION['user_role'], ['admin', 'treasurer'])): ?>
            <div class="nav-section">Loans</div>

            <a href="/sacco-management-system/public/loans/issue_loan.php"
                class="nav-link <?= $activePage === 'loans' ? 'active' : '' ?>">
                Issue Loan
            </a>

            <a href="/sacco-management-system/public/loans/active_loans.php"
                class="nav-link <?= $activePage === 'active_loans' ? 'active' : '' ?>">
                Active Loans
            </a>
        <?php endif; ?>

        <!-- System -->
        <?php if ($_SESSION['user_role'] === 'admin'): ?>
            <div class="nav-section">System</div>

            <a href="/sacco-management-system/public/addUser.php"
                class="nav-link <?= $activePage === 'add_user' ? 'active' : '' ?>">
                Add Staff
            </a>

            <a href="/sacco-management-system/public/manage_user.php"
                class="nav-link <?= $activePage === 'manage_users' ? 'active' : '' ?>">
                Manage Staff
            </a>
        <?php endif; ?>

        <!-- Reports -->
        <?php if (in_array($_SESSION['user_role'], ['admin', 'chairperson'])): ?>
            <div class="nav-section">Reports</div>

            <a href="#" class="nav-link">
                Financial Reports
            </a>
        <?php endif; ?>

    </nav>

    <!-- USER -->
    <div class="px-4 py-4 border-t border-gray-200">
        <p class="text-sm font-semibold text-gray-800">
            <?= $_SESSION['user_name'] ?>
        </p>
        <p class="text-xs text-gray-400 mb-3">
            <?= $_SESSION['user_role'] ?>
        </p>

        <a href="/sacco-management-system/public/logout.php" class="text-sm text-red-500 hover:text-red-600 transition">
            Logout
        </a>
    </div>
</aside>

<style>
    .nav-section {
        font-size: 11px;
        text-transform: uppercase;
        color: #9ca3af;
        font-weight: 600;
        padding: 10px 10px 4px;
    }

    .nav-link {
        display: block;
        padding: 10px 12px;
        border-radius: 8px;
        font-size: 14px;
        color: #374151;
        font-weight: 500;
        transition: background 0.15s ease;
    }

    .nav-link:hover {
        background: #f3f4f6;
    }

    .nav-link.active {
        background: #2563eb;
        color: white;
        font-weight: 600;
    }
</style>