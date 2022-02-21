
function populateCalendar(teacher){
    var calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "timeGridWeek",
        nowIndicator: true,
        weekends: true,
        hiddenDays: [0], // hide Sunday
        headerToolbar: {
            start: "prev,next today",
            center: "title",
            end: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        locale: "fr",
        slotMinTime: "08:00:00",
        slotMaxTime: "22:00:00",
        businessHours: {
            //daysOfWeek: [ 1, 2, 3, 4, 5 ], // Monday - Thursday, sunday = 0
            startTime: '08:15',
            endTime: '18:00',
        },
        fixedWeekCount: false,
        showNonCurrentDates: false,

    });
    url = "/getCalendar/"+teacher;
    axios.get(url).then(response =>{
        informations = response.data;
        seances = informations.seances;
        teachers = informations.teachers;
        for(var i=0;i<seances.length;i++){
            var title = seances[i][0];
            var start= seances[i][1]+"T"+seances[i][2];
            var end= seances[i][1]+"T"+seances[i][3];
            var url = seances[i][4];
            calendar.addEvent({title:title,start:start,end:end,url:url});
        }
        var select = document.getElementById('selectTeacher');
        console.log(teachers);
        for(var i=0;i<teachers.length;i++){
            var opt = document.createElement('option');
            opt.value = teachers[i].last_name;
            opt.innerHTML = teachers[i].last_name;
            select.appendChild(opt);
        }
    });
    calendar.render();
};

function initCalendar(teacher){
    document.addEventListener('DOMContentLoaded', populateCalendar(teacher));
}

function getSeanceByTeacher(){
    var select = document.getElementById('selectTeacher');
    var teacher = select.value;
    window.location.href = "/seances/"+teacher;
}

