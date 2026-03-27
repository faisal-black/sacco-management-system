<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add savings</title>
</head>

<body>

    <div class="savings-container">
        <h2>Record New Saving</h2>
        <hr>

        <form action="" method="">
            <!---Member selection --->

            <div>
                <label for="member_id"> Select Member </label>
                <select name="member_id" id="member_id" required>
                    <option value="">--Choose Member --</option>
                    <?php foreach ($members as $member): ?>
                        <option value="<?php echo $member['id']; ?>">
                            <?php echo $member['id'] . " - " . $member["full_name"]; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!--- Amount Input --->
            <div>
                <label for="amount">Amount to Deposit: </label>
                <input type="number" name="amount" id="amount" step="0.01" min="1" required placeholder="Enter Amount">
            </div>

        </form>
    </div>

</body>

</html>