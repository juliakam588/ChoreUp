<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find household</title>
    <link rel="stylesheet" href="public/css/after_register.css">
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
            <li><a href="/logout">Log out</a></li>
        </ul>
    </nav>
</header>
<div class="container1">
    <img src="public/media/House_searching.svg">
    <h2>Find your household<br> with ChoreUp!</h2>
</div>
<?php if (!empty($messages)): ?>
    <div class="messages">
        <?php foreach ($messages as $message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form class="container2" action="afterRegistration" method="POST">
    <div class="right-pane">
        <p class="create-house"><b>Create a new household</b><br>
            Start a new household and invite other members.</p>
        <input class="btn" type="submit" name="create" value="Create household">
    </div>
    <div class="right-pane">
        <p class="join-house"><b>Join an existing household with a code</b><br>
            Get an invitation code from another ChoreUp member. Fill in the code & join the household.</p>
        <div class="textbox">
            <input type="text" placeholder="" name="code" value="">
        </div>
        <input class="btn" type="submit" value="Join household">
    </div>
</form>

</body>
</html>