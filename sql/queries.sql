INSERT INTO Department (name) 
VALUES ('A2');

-- Turno 1: Das 9h às 17h
INSERT INTO Schedule (date, start_time, leaving_time)
VALUES (NULL, '09:00', '17:00');

-- Turno 2: Das 17h às 01h
INSERT INTO Schedule (date, start_time, leaving_time)
VALUES (NULL, '17:00', '01:00');

-- Turno 3: Das 01h às 09h
INSERT INTO Schedule (date, start_time, leaving_time)
VALUES (NULL, '01:00', '09:00');


-- Inserção de possíveis horários de consulta

-- Para o dia 2024-12-18
INSERT INTO Schedule (date, start_time)
VALUES ('2024-12-18', '09:00');

INSERT INTO Schedule (date, start_time)
VALUES ('2024-12-18', '10:30');

INSERT INTO Schedule (date, start_time)
VALUES ('2024-12-18', '12:00');

INSERT INTO Schedule (date, start_time)
VALUES ('2024-12-18', '13:30');

INSERT INTO Schedule (date, start_time)
VALUES ('2024-12-18', '15:00');

INSERT INTO Schedule (date, start_time)
VALUES ('2024-12-18', '16:30');

-- Para o dia 2024-12-19
INSERT INTO Schedule (date, start_time)
VALUES ('2024-12-19', '09:00');

INSERT INTO Schedule (date, start_time)
VALUES ('2024-12-19', '11:00');

INSERT INTO Schedule (date, start_time)
VALUES ('2024-12-19', '13:00');

INSERT INTO Schedule (date, start_time)
VALUES ('2024-12-19', '14:30');

INSERT INTO Schedule (date, start_time)
VALUES ('2024-12-19', '16:00');

INSERT INTO Schedule (date, start_time)
VALUES ('2024-12-19', '17:30');



INSERT INTO Person (password, name, age, email_address, address, phone_number) 
VALUES ('f4b30235d3c8d28ff4c925f1e441d32efb8f83b0d4ef50fc7ccdb497e4040d1d', 'Ana Silva', 28, 'ana.silva@gmail.com', 'Rua A, 123', '123456789');

INSERT INTO Person (password, name, age, email_address, address, phone_number) 
VALUES ('3cb705a9e7467563bfe1a51cc63cd0b07f7b5a03e7cc79a06d0ebd9d2256346d', 'Carlos Pereira', 35, 'carlos.pereira@hotmail.com', 'Rua B, 456', '987654321');

INSERT INTO Person (password, name, age, email_address, address, phone_number) 
VALUES ('4f3f7e4102df6b2cfe26fbbd5e02a63d1f7c2bfcf0042ef8cfa8483f04268a5f', 'Beatriz Costa', 42, 'beatriz.costa@yahoo.com', 'Rua C, 789', '555123456');

INSERT INTO Person (password, name, age, email_address, address, phone_number) 
VALUES ('7a7bfa86cbd3f1985791e5b6b30626f5f129bb3909e6f8c5c8035e560fd8b7fb', 'João Oliveira', 51, 'joao.oliveira@gmail.com', 'Rua D, 101', '666123987');

INSERT INTO Person (password, name, age, email_address, address, phone_number) 
VALUES ('1a99e59bff3c76a89b90a6d8635092fe7d0e1f606b748cfe3cb2e6c49a4d16a1', 'Maria Santos', 29, 'maria.santos@outlook.com', 'Rua E, 202', '111223344');


INSERT INTO Employee (employee_id, work_schedule, start_contract, end_contract) 
VALUES (2, 1, '2024-01-01', '2025-01-01');

INSERT INTO Employee (employee_id, work_schedule, start_contract, end_contract) 
VALUES (3, 2, '2024-01-01', '2025-01-01');

INSERT INTO Employee (employee_id, work_schedule, start_contract, end_contract) 
VALUES (4, 3, '2024-01-01', '2025-01-01');

INSERT INTO Employee (employee_id, work_schedule, start_contract, end_contract) 
VALUES (5, 1, '2024-01-01', '2025-01-01');

INSERT INTO Employee (employee_id, work_schedule, start_contract, end_contract) 
VALUES (6, 1, '2024-01-01', '2025-01-01');


INSERT INTO Patient (patient_id) 
VALUES (1);

INSERT INTO Doctor (employee_id, department, specialty) 
VALUES (2, 'A2', 'cardiology');

INSERT INTO Doctor (employee_id, department, specialty) 
VALUES (3, 'A2', 'cardiology');

INSERT INTO Doctor (employee_id, department, specialty) 
VALUES (4, 'A2', 'cardiology');

INSERT INTO Nurse (employee_id, department, specialty) 
VALUES (5, 'A2', 'cardiology');

INSERT INTO Admin (employee_id) 
VALUES (6);

INSERT INTO Appointment (patient_id, doctor_id, nurse_id, schedule, report) 
VALUES (1, 2, 5, 5, 'Consulta detalhada sobre o acompanhamento do paciente. Durante a consulta, discutimos os sintomas persistentes, realizamos exames físicos e decidimos por uma série de exames laboratoriais para aprofundar o diagnóstico. O paciente foi orientado sobre a importância do acompanhamento e retorno após os exames.');

INSERT INTO Appointment (patient_id, doctor_id, nurse_id, schedule, report) 
VALUES (1, 3, 5, 10, 'Consulta para revisão da medicação. O paciente relatou melhora geral, mas com queixas de leves efeitos colaterais. Foi ajustada a dosagem de alguns medicamentos e orientado a manter o regime atual de tratamento. A enfermeira forneceu instruções detalhadas sobre o uso correto dos medicamentos e alertou sobre possíveis efeitos adversos.');

INSERT INTO Appointment (patient_id, doctor_id, nurse_id, schedule, report) 
VALUES (1, 4, 5, 12, 'Consulta de acompanhamento pós-cirúrgico. A cirurgia realizada há duas semanas foi bem-sucedida, e o paciente está se recuperando adequadamente. O paciente foi orientado sobre os cuidados com a ferida e a necessidade de repouso. O médico discutiu os resultados dos exames pós-operatórios, que indicam boa recuperação, mas sugeriu acompanhamento contínuo para evitar complicações.');




INSERT INTO Disease (name) 
VALUES ('Diabetes');

