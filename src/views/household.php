<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Household members</title>
    <link rel="stylesheet" href="public/css/household.css">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
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

    <h2 class="household">Household members</h2>
    <div class="members">
        <?php foreach ($members as $member): ?>
        <?php if ($member['is_admin']): ?>
        <div class="host">
            <img src="public/media/roof.png" alt="Roof Image" class="roof">
            <div class="user">
                <img src="public/uploads/<?php echo $member['photo']; ?>" width="100" class="rounded-image" alt="">
                <h2><?php echo htmlspecialchars($member['name']); ?></h2></div>
        </div>
        <?php endif; ?>
        <?php if (!$member['is_admin']): ?>
        <div class="users">
            <div class="user">
                <img src="public/uploads/<?php echo $member['photo']; ?>" width="100" class="rounded-image" alt="">
                <h2><?php echo htmlspecialchars($member['name']); ?></h2></div>
        </div>
            <?php endif; ?>

        <?php endforeach; ?>

    </div>
    <div class = 'buttons'>
        <?php if ($isAdmin): ?>
            <button onclick="showHouseholdCode()" class="btn">Show Household Code</button>
            <script>
                function showHouseholdCode() {
                    alert('Your household code is: <?php echo $household->getHouseholdCode(); ?>');
                }
            </script>
            <a href="/chooseUserToDelete" class="btn">Delete user from household</a>
            <a href="/editChoreSettings" class="btn">Edit chore settings</a>
        <?php endif; ?>
    </div>

</body>
</html>
