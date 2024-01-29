<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="public/css/dashboard.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="../../public/scripts/dashboard.js" defer></script>


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
            <li><a href="/generate">Generate</a></li>
            <li><a href="/household">Household members</a></li>
            <li><a href="/logout">Log out</a></li>
        </ul>
    </nav>
</header>
<div class="container1">
    <div class="info">
        <h3>Today</h3>
        <script src="public/scripts/script.js"></script>
        <h1>Welcome, <?= htmlspecialchars($userName); ?></h1>
    </div>
        <?php if (isset($scheduleExists) && !$scheduleExists): ?>
            <div class="no-schedule">
                <p>No schedule generated for this week.</p>
                <a href="/generate" class="btn">Generate Schedule</a>
            </div>
        <?php endif; ?>
    <?php if (isset($groupedTasks) && isset($scheduleExists)): ?>
        <div class="week-container">
            <?php foreach ($groupedTasks as $dayName => $tasksForDay): ?>
                <div class="daily-container">
                    <span class="day"><?= htmlspecialchars($dayName); ?></span>
                    <?php foreach ($tasksForDay as $taskObject): ?>
                        <div class="task">
                            <img src="public/uploads/<?= htmlspecialchars($taskObject->getUser()->getPhoto()); ?>" width="100" class="rounded-image" alt="">
                            <label for="checkbox-<?= $taskObject->getId(); ?>"
                                   class="checkbox-label <?= $taskObject->getStatus() == 'Done' ? 'completed-task' : ''; ?>">
                                <?= htmlspecialchars($taskObject->getChore()->getChoreName()); ?>
                            </label>
                            <input type="checkbox" class="rounded-checkbox"
                                   id="checkbox-<?= $taskObject->getId(); ?>"
                                <?= $taskObject->getStatus() == 'Done' ? 'checked' : ''; ?>>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

        </div>
    <?php endif; ?>

    <button type="button" name="edit" onclick="window.location.href='/edit'">EDIT</button>


</div>

<div class="container2">
    <h2 id="progress">Your household’s current week progress:</h2>
    <canvas id="myChart" width="300" height="200"></canvas>
    <div id="taskData" data-total-tasks="<?= $totalTasksCount['totalTasks'] ?? '0' ?>"
         data-completed-tasks="<?= $completedTasksCount ?? '0' ?>" style="display:none;"></div>



</div>

</body>
</html>