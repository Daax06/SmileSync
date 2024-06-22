document.addEventListener('DOMContentLoaded', () => {
    fetch('data.php')
        .then(response => response.json())
        .then(data => {
            const overviewContent = document.getElementById('overview-content');
            const analyticsContent = document.getElementById('analytics-content');
            const appointmentsContent = document.getElementById('appointments-content');
            const patientsContent = document.getElementById('patients-content');
            
            overviewContent.innerHTML = `<p>Total Patients: ${data.totalPatients}</p>
                                         <p>Upcoming Appointments: ${data.upcomingAppointments}</p>`;

            analyticsContent.innerHTML = `<p>Current Users: ${data.currentUsers}</p>
                                          <p>Average Response Time: ${data.responseTime} ms</p>
                                          <p>Daily Active Users: ${data.dailyActiveUsers}</p>
                                          <p>Monthly Active Users: ${data.monthlyActiveUsers}</p>`;

            appointmentsContent.innerHTML = data.appointments.map(appointment => 
                `<p>${appointment.date} - ${appointment.patientName} (${appointment.status})</p>`
            ).join('');

            patientsContent.innerHTML = data.patients.map(patient => 
                `<p>${patient.name} - ${patient.age} years old</p>`
            ).join('');
        })
        .catch(error => console.error('Error fetching data:', error));

    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.section');

    navLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            navLinks.forEach(link => link.classList.remove('active'));
            link.classList.add('active');

            const target = link.getAttribute('href').substring(1);
            sections.forEach(section => {
                section.classList.remove('active');
                if (section.id === target) {
                    section.classList.add('active');
                }
            });
        });
    });
});
