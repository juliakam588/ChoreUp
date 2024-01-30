<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chores</title>
    <link rel="stylesheet" href="public/css/edit.css">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">

</head>
<body>
<header>
    <div class="logo">
        <img src="public/media/logo.png" alt="ChoreUp Logo">
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

<h2 class="title">Edit your schedule</h2>
<div class="schedule-wrapper">
    <table class="schedule-table">
        <thead>
        <tr>
            <th>Chore</th>
            <th>Member</th>
            <th>Weekday</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= ($task->getChore()->getChoreName()); ?></td>
                <td><img src="<?= 'public/uploads/' . $task->getUser()->getPhoto(); ?>" alt="Member" class="member-avatar"></td>
                <td><?= htmlspecialchars($task->getDayName()); ?></td>
                <td class="edit-icon">
                    <a href="/editChore?userChoreId=<?= $task->getId(); ?>&householdId=<?= $householdId; ?>">
                        <img src="public/media/edit_icon.png" alt="Edit">
                    </a>
                    <a href="/confirmDelete?userChoreId=<?= $task->getId(); ?>" class="delete-icon">
                        <img src="public/media/trash_icon.png" alt="Delete">
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <form action="/finishEditing" method="post">
        <button type="submit" class="save-btn">Finish Editing</button>
    </form>
</div>

</body>
</html>
