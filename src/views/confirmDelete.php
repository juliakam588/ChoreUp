<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm deletion</title>
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

<div class="confirm-delete">
    <h1>Are you sure you want to delete this task?</h1>
    <form action="/deleteChore" method="POST">
        <div class="buttons">
            <input type="hidden" name="userChoreId" value="<?= $userChoreId; ?>">
            <button type="submit" class="btn">Yes, delete it</button>
            <a href="/edit" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>