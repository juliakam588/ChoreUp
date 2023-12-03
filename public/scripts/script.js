function getFormattedDate() {

    var currentDate = new Date();


    var months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    var currentMonth = months[currentDate.getMonth()];
    var currentDay = currentDate.getDate();

    return currentMonth + " " + currentDay;
}

document.write(getFormattedDate());
