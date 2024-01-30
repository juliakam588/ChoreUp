<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate schedule</title>
    <link rel="stylesheet" href="public/css/generate.css">
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

<div class="container1">
    <img src="public/media/generate.svg">
    <h2>Generate your schedule!</h2>
</div>
<div class="container2">
    <form id="chore-form" class="login-box" action="generate" method="POST">
        <h1>Choose chores to assign:</h1>
        <ul>
            <?php if (isset($chores) && is_array($chores)): ?>
                <?php foreach ($chores as $chore): ?>
                    <li>
                        <input type="checkbox" id="chore_<?php echo $chore['id']; ?>" name="chores[]" value="<?php echo $chore['id']; ?>">
                        <label for="chore_<?php echo $chore['id']; ?>"><?php echo htmlspecialchars($chore['name']); ?></label>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No chores found.</p>
            <?php endif; ?>
        </ul>

        <button type="submit" class="btn">Generate</button>
    </form>

</div>

</body>
</html>