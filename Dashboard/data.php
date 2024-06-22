<?php
header('Content-Type: application/json');

$data = [
    'totalPatients' => 100,
    'upcomingAppointments' => 17,
    'currentUsers' => rand(10, 50),
    'responseTime' => rand(100, 300),
    'dailyActiveUsers' => rand(50, 100),
    'monthlyActiveUsers' => rand(200, 400),
    'appointments' => [
        ['date' => '2024-06-22', 'patientName' => 'Felix Miguel Lapuz', 'status' => 'Scheduled'],
        ['date' => '2024-06-23', 'patientName' => 'John Allain Constantino', 'status' => 'Confirmed'],
        ['date' => '2024-06-24', 'patientName' => 'Jessa Joy Caboteja', 'status' => 'Completed'],
        ['date' => '2024-06-25', 'patientName' => 'James Calindas', 'status' => 'Scheduled'],
        ['date' => '2024-06-26', 'patientName' => 'Eleno Carlo Buenaflor', 'status' => 'Cancelled'],
        ['date' => '2024-06-26', 'patientName' => 'Jospeh Ryann Manongsong', 'status' => 'Confirmed'],
    ],
    'patients' => [
        ['name' => 'Felix Miguel Lapuz', 'age' => 21],
        ['name' => 'John Allain Constantino', 'age' => 20],
        ['name' => 'Jessa Joy Caboteja', 'age' => 20],
        ['name' => 'James Calindas', 'age' => 20],
        ['name' => 'Eleno Carlo Buenaflor', 'age' => 22],
        ['name' => 'Jospeh Ryann Manongsong', 'age' => 20],
    ]
];

echo json_encode($data);
