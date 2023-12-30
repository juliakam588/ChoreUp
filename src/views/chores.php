<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chores</title>
    <link rel="stylesheet" href="public/css/chores.css">
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

    <h2 class="chores">Chores</h2>


    <section class="filter-buttons">
        <button class="filter-btn" data-filter="all">All</button>
        <button class="filter-btn" data-filter="indoors">Indoors</button>
        <button class="filter-btn" data-filter="outdoors">Outdoors</button>
        <button class="filter-btn" data-filter="kitchen">Kitchen</button>
        <button class="filter-btn" data-filter="bathroom">Bathroom</button>
        <button class="filter-btn" data-filter="living-room">Living room</button>
        <button class="filter-btn" data-filter="bedroom">Bedroom</button>
    </section>
<div class="container">
    <div class="chores-container">
        <div class="chore" data-category="indoors kitchen bathroom living-room bedroom">
            <img src="public/media/vacuum.png" alt="Vacuum cleaning">
            <p>Vacuum cleaning</p>
        </div>
        <div class="chore" data-category="outdoors kitchen bathroom">
            <img src="public/media/rubbish.png" alt="Taking out the rubbish">
            <p>Taking out the rubbish</p>
        </div>
        <div class="chore" data-category="indoors kitchen bathroom living-room bedroom">
            <img src="public/media/mop.png" alt="Mopping the floor">
            <p>Mopping the floor</p>
        </div>
    </div>
</div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const chores = document.querySelectorAll('.chore');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.getAttribute('data-filter');
                    chores.forEach(chore => {
                        if (filter === 'all' || chore.getAttribute('data-category').includes(filter)) {
                            chore.style.display = 'flex';
                        } else {
                            chore.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>

    
</body>
</html>
