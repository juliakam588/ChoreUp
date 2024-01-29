<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Household members</title>
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
<form action="/saveChore" method="POST">
    <div class="title">
        <?php if (isset($choreDetails['name'])): ?>
            <h2><?= htmlspecialchars($choreDetails['name']); ?></h2>
        <?php endif; ?>
    </div>

    <label class="select" for="days">
        <h2>Choose the weekday:</h2>
        <select id="days" name="days">
            <option value="" disabled selected>Choose weekday</option>
            <?php foreach ($weekdays as $day): ?>
                <option value="<?= $day; ?>" <?= (isset($choreDetails['day_name']) && $day === $choreDetails['day_name']) ? 'selected' : ''; ?>>
                    <?= $day; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label class="select" for="members">
        <h2>Choose the member:</h2>
        <select id="members" name="members">
            <option value="" disabled selected>Choose member</option>
            <?php foreach ($members as $member): ?>
                <option value="<?= $member['id']; ?>" <?= (isset($choreDetails['user_id']) && $member['id'] === $choreDetails['user_id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($member['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <?php if (isset($choreDetails['id'])): ?>
        <input type="hidden" name="userChoreId" value="<?= $choreDetails['id']; ?>">
    <?php endif; ?>

    <input type="submit" value="Save">
</form>


<!-- SVG Sprites-->
<svg class="sprites">
    <symbol id="select-arrow-down" viewbox="0 0 10 6">
        <polyline points="1 1 5 5 9 1"></polyline>
    </symbol>
</svg>
</body>
</html>