-- Inserir dados na tabela Department
INSERT INTO Department (name) VALUES ('Cardiologia');

-- Inserir dados na tabela Person
INSERT INTO Person (password, name, age, email_address, address, phone_number)
VALUES ('password123', 'Fábio Silva', 35, 'fabioescola23@gmail.com', 'Rua Principal, 123', '123-456-789');

-- Inserir dados na tabela Schedule
INSERT INTO Schedule (start_time, leaving_time)
VALUES ('08:00', '17:00');

-- Inserir dados na tabela Employee
INSERT INTO Employee (employee_id, work_schedule, start_contract, end_contract)
VALUES (1, '08:00-17:00', '2024-01-01', '2024-12-31');

-- Inserir dados na tabela Patient
INSERT INTO Patient (patient_id)
VALUES (1);

-- Inserir dados na tabela Disease
INSERT INTO Disease (name) VALUES ('Hipertensão');

-- Associar uma doença ao paciente na tabela PatientDisease
INSERT INTO PatientDisease (patient_id, disease)
VALUES (1, 'Hipertensão');

-- Inserir dados na tabela Doctor
INSERT INTO Doctor (employee_id, department, specialty)
VALUES (1, 'Cardiologia', 'cardiology');

-- Inserir dados na tabela Supervision
INSERT INTO Supervision (supervisee, supervisor)
VALUES (1, 1);

-- Inserir dados na tabela Nurse
INSERT INTO Nurse (employee_id, department, specialty)
VALUES (2, 'Cardiologia', 'cardiology');

-- Inserir dados na tabela Secretary
INSERT INTO Secretary (employee_id)
VALUES (3);

-- Inserir dados na tabela Admin
INSERT INTO Admin (employee_id)
VALUES (4);

-- Inserir dados na tabela LabTech
INSERT INTO LabTech (employee_id, specialty)
VALUES (5, 'cardiology');

-- Inserir dados na tabela Appointment
INSERT INTO Appointment (doctor_id, patient_id, secretary_id, nurse_id, schedule, report)
VALUES (1, 1, 3, 2, '2024-12-08 14:30:00', 'Consulta de rotina. Paciente está bem.');

-- Inserir dados na tabela Exam
INSERT INTO Exam (appointment, schedule, report)
VALUES (1, '2024-12-08 14:30:00', 'Exame de rotina: todos os parâmetros normais.');

-- Inserir dados na tabela ExamTech
INSERT INTO ExamTech (exam_id, tech_id, lab)
VALUES (1, 5, 'Cardiologia');

-- Inserir dados na tabela Drug
INSERT INTO Drug (name) VALUES ('Aspirina');

-- Associar um medicamento à consulta na tabela AppointmentDrug
INSERT INTO AppointmentDrug (appointment, drug, dose, uses_per_day, days)
VALUES (1, 'Aspirina', 100, 1, 10);
