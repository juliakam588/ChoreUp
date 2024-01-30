<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit chore settings</title>
    <link rel="stylesheet" href="public/css/editChore.css">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
</head>
<body>
<header>
    <div class="logo">
        <img src="public/media/logo.png">
        <a href="#" class="logo-text">ChoreUp!</a>
    </div>
    <input type="checkbox" id="menu-bar">
    <label for="menu-bar" id="menu-label">&#9776;</label>
    <nav class="navbar">
        <ul>
            <li><a href="/dashboard">Home</a></li>
            <li><a href="/household">Household members</a></li>
            <li><a href="/logout">Log out</a></li>
        </ul>
    </nav>
</header>
<?php
if (isset($_SESSION['messages'])) {
    foreach ($_SESSION['messages'] as $message) {
        echo '<div class="message">' . htmlspecialchars($message) . '</div>';
    }
    unset($_SESSION['messages']);
}
?>
<form action="/saveChoreSettings" method="POST">
    <?php foreach ($choreSettings as $choreId => $settings): ?>
        <div class="chore-setting">
            <h3><?= $choreSettings[$choreId]['name']; ?></h3>

            <label class="select">Times in a Week:
                <select name="settings[<?= $choreId; ?>][times_in_a_week]">
                    <?php for ($i = 1; $i <= 7; $i++): ?>
                        <option value="<?= $i; ?>" <?= $i == $settings['times_in_a_week'] ? 'selected' : ''; ?>>
                            <?= $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </label>

            <label class="select">Duration (minutes):
                <select name="settings[<?= $choreId; ?>][duration]">
                    <?php for ($i = 5; $i <= 120; $i+=5): ?>
                        <option value="<?= $i; ?>" <?= $i == $settings['duration'] ? 'selected' : ''; ?>>
                            <?= $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </label>
        </div>
    <?php endforeach; ?>
    <input type="submit" value="Save">
</form>


</body>
</html>