<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="public/css/dashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
                <li><a href="#">Home</a></li>
                <li><a href="#">Chores</a></li>
                <li><a href="#">Household members</a></li>
            </ul>
         </nav>
    </header>
    <div class="container1">
        <div class="info">
            <h3>Today</h3>
            <script src="public/scripts/script.js"></script>
            <h1>Welcome, Charlie</h1>
            <h2>This week's chores</h2>
        </div>

        <div class="week-container">
            <div class="daily-container">
                <span class="day">Tuesday</span>
                <div class="task">
                    <img src="https://images.pexels.com/photos/2294923/pexels-photo-2294923.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="rounded-image">
                    <label for="checkbox-1" class="checkbox-label">Take out the rubbish</label>
                    <input type="checkbox" class="rounded-checkbox" id="checkbox-1">
                </div>
            </div>
            <div class="daily-container">
                <span class="day">Saturday</span>
                <div class="task">
                    <img src="https://i.imgur.com/bDLhJiP.jpg" class="rounded-image">
                    <label for="checkbox-2" class="checkbox-label">Vacuum cleaning</label>
                    <input type="checkbox" class="rounded-checkbox" id="checkbox-2">
                </div>
            </div>
            
            <div class="daily-container">
                <span class="day">Saturday</span>
                <div class="task">
                    <img src="https://images.unsplash.com/photo-1618481212122-7ddab34f8453?q=80&w=1949&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="rounded-image">
                    <label for="checkbox-3" class="checkbox-label">Mop the floor</label>
                    <input type="checkbox" class="rounded-checkbox" id="checkbox-3">
                </div>
            </div>
        </div>
        <button type="button" name="edit">EDIT</button>
    </div>

<div class="container2">
    <h2 id="progress">Your household’s current week progress:</h2>
    <canvas id="myChart" width="300" height="200"></canvas>
    <script>
        // Sample data
        let totalTasks = 3;
        let completedTasks = 2;


        let ctx = document.getElementById('myChart').getContext('2d');
        let myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Remaining'],
                datasets: [{
                    data: [completedTasks, totalTasks - completedTasks],
                    backgroundColor: ['#407BFF', '#F0F0F0'],
                }]
            },
            options: {
    cutoutPercentage: 90,
    plugins: {
        afterDraw: function (chart) {
            let width = chart.chart.width,
                height = chart.chart.height,
                ctx = chart.chart.ctx;


            ctx.font = '18px Poppins';
            ctx.fillStyle = '#000000';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';

            let percentage = ((completedTasks / totalTasks) * 100).toFixed(0) + '%';
            ctx.fillText(percentage, width / 2, height / 2);
        }
    }
}

        });


        function updateChart() {
            myChart.data.datasets[0].data = [completedTasks, totalTasks - completedTasks];
            myChart.update();
        }

        function completeChore() {
            completedTasks++;

            updateChart();
        }
    </script>
</div>

</body>
</html>