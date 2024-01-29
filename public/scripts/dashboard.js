document.addEventListener('DOMContentLoaded', () => {
    const taskDataDiv = document.getElementById('taskData');
    let totalTasks = parseInt(taskDataDiv.getAttribute('data-total-tasks'));
    let completedTasks = parseInt(taskDataDiv.getAttribute('data-completed-tasks'));


    let ctx = document.getElementById('myChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Remaining'],
            datasets: [{
                label: 'Tasks',
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

    function updateChart(completedTasks, totalTasks) {
        myChart.data.datasets[0].data = [completedTasks, totalTasks - completedTasks];
        myChart.update();
    }
    const checkboxes = document.querySelectorAll('.rounded-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', (event) => {
            const choreId = event.target.id.replace('checkbox-', '');
            const isCompleted = event.target.checked;
            const currCheckbox = document.querySelector(`#checkbox-${choreId}`)
            const taskLabel = currCheckbox.previousElementSibling;


            fetch('/updateChoreStatus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ choreId, isCompleted })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateChart(data.completedTasks, data.totalTasks);
                        if (isCompleted) {
                            taskLabel.classList.add('completed-task');
                        } else {
                            taskLabel.classList.remove('completed-task');
                        }
                    }

                    else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
});