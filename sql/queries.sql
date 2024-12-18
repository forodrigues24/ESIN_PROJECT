INSERT INTO Department (name) 
VALUES ('A2');

INSERT INTO Employee (employee_id, work_schedule, start_contract, end_contract) 
VALUES (2, 1, '2024-01-01', '2025-01-01');

INSERT INTO Employee (employee_id, work_schedule, start_contract, end_contract) 
VALUES (3, 1, '2024-01-01', '2025-01-01');

INSERT INTO Employee (employee_id, work_schedule, start_contract, end_contract) 
VALUES (4, 1, '2024-01-01', '2025-01-01');

INSERT INTO Employee (employee_id, work_schedule, start_contract, end_contract) 
VALUES (5, 1, '2024-01-01', '2025-01-01');

INSERT INTO Schedule (schedule_id, day, start_time, leaving_time) 
VALUES (1, 1, '08:00', '17:00');

INSERT INTO Patient (patient_id) 
VALUES (1);

INSERT INTO Doctor (employee_id, department, specialty) 
VALUES (2, 'Cardiology', 'cardiology');

INSERT INTO Nurse (employee_id, department, specialty) 
VALUES (2, 'Cardiology', 'cardiology');

INSERT INTO Admin (employee_id) 
VALUES (3);

INSERT INTO Appointment (patient_id, doctor_id, nurse_id, schedule, report) 
VALUES (1, 2, 2, 1, 'Consulta importante');



INSERT INTO Disease (name) 
VALUES ('Diabetes');

SELECT 
    Schedule.day AS consultation_day, 
    Schedule.start_time AS consultation_start_time,
    Appointment.report AS consultation_report,
    DoctorPerson.name AS doctor_name,
    NursePerson.name AS nurse_name
FROM 
    Appointment
JOIN 
    Schedule ON Appointment.schedule = Schedule.schedule_id
JOIN 
    Doctor ON Appointment.doctor_id = Doctor.employee_id
JOIN 
    Person AS DoctorPerson ON Doctor.employee_id = DoctorPerson.person_id
LEFT JOIN 
    Nurse ON Appointment.nurse_id = Nurse.employee_id
LEFT JOIN 
    Person AS NursePerson ON Nurse.employee_id = NursePerson.person_id;


SELECT 
            a.appointment_id,
            dp.name AS doctor_name,
            np.name AS nurse_name,
            s.day AS consultation_day,
            s.start_time AS consultation_start_time,
            a.report AS consultation_report
        FROM 
            Appointment a
        JOIN 
            Schedule s ON a.schedule = s.schedule_id
        JOIN 
            Doctor d ON a.doctor_id = d.employee_id
        JOIN 
            Person dp ON d.employee_id = dp.person_id
        LEFT JOIN 
            Nurse n ON a.nurse_id = n.employee_id
        LEFT JOIN 
            Person np ON n.employee_id = np.person_id
        WHERE 
            a.patient_id = 1
        ORDER BY 
            s.day, s.start_time;