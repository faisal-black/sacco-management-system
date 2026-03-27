<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../app/middleware/AuthMiddleware.php";

// Only admin can access this page
checkAuth($pdo, ['admin']);

$pageTitle = "Edit User";
$activePage = 'manage_users';
$message = "";

// Utility function for escaping output
function safe($data)
{
    return htmlspecialchars($data ?? '', ENT_QUOTES, 'UTF-8');
}

// Fetch User by ID
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: manage_user.php");
    exit;
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Base SQL (Never update the Primary Key ID)
        $sql = "UPDATE users SET full_name = ?, username = ?, email = ?, role = ?";
        $params = [
            $_POST['full_name'],
            $_POST['username'],
            $_POST['email'],
            $_POST['role']
        ];

        // Only update password if provided
        if (!empty($_POST['password'])) {
            $sql .= ", password = ?";
            $params[] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $message = "User updated successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// Fetch current user data to populate the form
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}
?>

<?php include __DIR__ . '/../includes/layout_start.php'; ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>

<div class="flex-1 flex flex-col min-h-screen">
    <?php include __DIR__ . '/../includes/topbar.php'; ?>

    <main class="p-8 flex-1 overflow-auto bg-gray-50">
        <?php if ($message): ?>
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                <?= safe($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="max-w-4xl bg-white shadow-xl rounded-3xl border border-gray-200 p-10 space-y-8">
            <div class="border-b pb-4">
                <h3 class="text-2xl font-bold text-gray-800">Edit User Profile</h3>
                <p class="text-sm text-gray-500">Update account details for <?= safe($user['full_name']) ?></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-gray-700">Full Name *</label>
                    <input type="text" name="full_name" value="<?= safe($user['full_name']) ?>" required
                        class="rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                <!-- Username -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-gray-700">Username *</label>
                    <input type="text" name="username" value="<?= safe($user['username']) ?>" required
                        class="rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                <!-- Email -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-gray-700">Email Address *</label>
                    <input type="email" name="email" value="<?= safe($user['email']) ?>" required
                        class="rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>

                <!-- Role Selection -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-gray-700">System Role</label>
                    <select name="role"
                        class="rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none transition bg-white">
                        <?php foreach (['admin', 'treasurer', 'chairperson'] as $r): ?>
                            <option value="<?= $r ?>" <?= $user['role'] == $r ? 'selected' : '' ?>><?= ucfirst($r) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Password -->
                <div class="md:col-span-2 flex flex-col gap-2">
                    <label class="text-sm font-semibold text-gray-700">New Password</label>
                    <input type="password" name="password" placeholder="Leave blank to keep current password"
                        class="rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
            </div>

            <div class="flex justify-end items-center gap-4 pt-6 border-t">
                <a href="manage_user.php" class="text-gray-600 hover:text-gray-800 font-medium px-4">Cancel</a>
                <button type="submit"
                    class="px-10 py-3 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all active:scale-95">
                    Update User Account
                </button>
            </div>
        </form>
    </main>
</div>

<?php include __DIR__ . '/../includes/layout_end.php'; ?>