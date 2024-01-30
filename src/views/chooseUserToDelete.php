<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete members</title>
    <link rel="stylesheet" href="public/css/editChore.css">
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
<form action="/deleteUser" method="POST">
    <label for="members">
        <h2>Choose the member:</h2>
        <select id="members" name="members">
            <option value="" disabled selected>Choose member</option>
            <?php foreach ($members as $member): ?>
                <?php if (!$member['is_admin']): ?>
                    <option value="<?= $member['id']; ?>">
                        <?= htmlspecialchars($member['name']); ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </label>
    <input type="submit" value="Delete">
</form>

<svg class="sprites">
    <symbol id="select-arrow-down" viewbox="0 0 10 6">
        <polyline points="1 1 5 5 9 1"></polyline>
    </symbol>
</svg>
</body>
</html>