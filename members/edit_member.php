<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/middleware/AuthMiddleware.php';
checkAuth($pdo, 'admin');

$activePage = 'manage_members';
$pageTitle = "Edit Member";

// Utility
function safe($data)
{
    return htmlspecialchars($data ?? '', ENT_QUOTES, 'UTF-8');
}

// Fetch member by ID
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: managemember.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM members WHERE id = ?");
$stmt->execute([$id]);
$member = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$member) {
    die("Member not found.");
}

// Process form submission
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "UPDATE members SET 
                id_number = ?, full_name = ?, email = ?, dob = ?, 
                gender = ?, phone = ?, address = ?, status = ?, 
                next_of_kin_name = ?, next_of_kin_phone = ? 
                WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['id_number'],
            $_POST['full_name'],
            $_POST['email'],
            $_POST['dob'],
            $_POST['gender'],
            $_POST['phone'],
            $_POST['address'],
            $_POST['status'],
            $_POST['next_of_kin_name'],
            $_POST['next_of_kin_phone'],
            $id
        ]);
        $message = "Member details updated successfully!";
        $stmt = $pdo->prepare("SELECT * FROM members WHERE id = ?");
        $stmt->execute([$id]);
        $member = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<?php include __DIR__ . '/../includes/layout_start.php'; ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>

<div class="flex-1 flex flex-col min-w-0">
    <?php include __DIR__ . '/../includes/topbar.php'; ?>

    <main class="p-8 flex-1 overflow-auto">
        <?php if ($message): ?>
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                <?= safe($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="bg-white shadow-lg rounded-3xl border border-gray-200 p-10 space-y-10">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Edit Member: <?= safe($member['full_name']) ?></h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <input type="text" name="id_number" value="<?= safe($member['id_number']) ?>" placeholder="National ID"
                    class="rounded-xl border px-4 py-2.5">
                <input type="text" name="full_name" value="<?= safe($member['full_name']) ?>" placeholder="Full Name *"
                    required class="rounded-xl border px-4 py-2.5">
                <input type="email" name="email" value="<?= safe($member['email']) ?>" placeholder="Email Address"
                    class="rounded-xl border px-4 py-2.5">
                <input type="tel" name="phone" value="<?= safe($member['phone']) ?>" placeholder="Phone Number"
                    class="rounded-xl border px-4 py-2.5">
                <input type="date" name="dob" value="<?= safe($member['dob']) ?>" class="rounded-xl border px-4 py-2.5">
                <select name="status" class="rounded-xl border px-4 py-2.5">
                    <?php foreach (['active', 'inactive', 'dormant', 'suspended'] as $s): ?>
                        <option value="<?= $s ?>" <?= $member['status'] == $s ? 'selected' : '' ?>><?= ucfirst($s) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select name="gender" class="md:col-span-2 rounded-xl border px-4 py-2.5">
                    <option value="Male" <?= $member['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= $member['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                </select>
                <textarea name="address" rows="3" placeholder="Physical Address"
                    class="md:col-span-2 rounded-xl border px-4 py-2.5"><?= safe($member['address']) ?></textarea>
                <input type="text" name="next_of_kin_name" value="<?= safe($member['next_of_kin_name']) ?>"
                    placeholder="Next of Kin Name *" required class="rounded-xl border px-4 py-2.5">
                <input type="tel" name="next_of_kin_phone" value="<?= safe($member['next_of_kin_phone']) ?>"
                    placeholder="Next of Kin Phone *" required class="rounded-xl border px-4 py-2.5">
            </div>

            <div class="flex justify-end gap-4 mt-6">
                <a href="managemember.php"
                    class="px-6 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 transition">Cancel</a>
                <button type="submit"
                    class="px-8 py-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition">Save
                    Changes</button>
            </div>
        </form>
    </main>
</div>

<?php include __DIR__ . '/../includes/layout_end.php'; ?>