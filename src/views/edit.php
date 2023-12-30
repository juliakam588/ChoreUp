<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chores</title>
    <link rel="stylesheet" href="public/css/edit.css">
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
               <li><a href="#">Home</a></li>
               <li><a href="#">Chores</a></li>
               <li><a href="#">Household members</a></li>
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
                <tr>
                    <td>Vacuum cleaning</td>
                    <td><img src="https://i.imgur.com/bDLhJiP.jpg" alt="Member" class="member-avatar"></td>
                    <td>Saturday</td>
                    <td class="edit-icon"><img src="public/media/edit_icon.png" alt="Edit"></td>
                </tr>
                <tr>
                    <td>Mopping the floor</td>
                    <td><img src="https://i.imgur.com/bDLhJiP.jpg" alt="Member" class="member-avatar"></td>
                    <td>Saturday</td>
                    <td class="edit-icon"><img src="public/media/edit_icon.png" alt="Edit"></td>
                </tr>
                <tr>
                    <td>Taking out the rubbish</td>
                    <td><img src="https://i.imgur.com/bDLhJiP.jpg" alt="Member" class="member-avatar"></td>
                    <td>Tuesday</td>
                    <td class="edit-icon"><img src="public/media/edit_icon.png" alt="Edit"></td>
                </tr>
            </tbody>
        </table>
        <button class="save-btn">SAVE</button>
    </div>
</body>
</html>
