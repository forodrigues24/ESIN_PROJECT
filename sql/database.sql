    -- To run type the following commands on the terminal
    -- ./sqlite3.exe
    -- .read database.sql
    -- ===================================================

   
    DROP TABLE IF EXISTS TimeStamps;
    DROP TABLE IF EXISTS EmployeeSchedule;
    DROP TABLE IF EXISTS AppointmentDrug;
    DROP TABLE IF EXISTS Drug;
    DROP TABLE IF EXISTS ExamTech;
    DROP TABLE IF EXISTS Exam;
    DROP TABLE IF EXISTS Appointment;
    DROP TABLE IF EXISTS LabTech;
    DROP TABLE IF EXISTS Admin;
    DROP TABLE IF EXISTS Secretary;
    DROP TABLE IF EXISTS Nurse;
    DROP TABLE IF EXISTS Supervision;
    DROP TABLE IF EXISTS Doctor;
    DROP TABLE IF EXISTS Employee;
    DROP TABLE IF EXISTS PatientDisease;
    DROP TABLE IF EXISTS Patient;
    DROP TABLE IF EXISTS Disease;
    DROP TABLE IF EXISTS Department;
    DROP TABLE IF EXISTS Person;


    CREATE TABLE Person (
        person_id INTEGER PRIMARY KEY AUTOINCREMENT,
        password TEXT NOT NULL,
        name TEXT NOT NULL,
        age INTEGER, 
        email_address TEXT NOT NULL UNIQUE, 
        address TEXT, 
        phone_number TEXT NOT NULL UNIQUE
    );

    CREATE TABLE Employee (
        employee_id INTEGER PRIMARY KEY REFERENCES Person,
        start_contract DATE,
        end_contract DATE CHECK(end_contract IS NULL OR end_contract > start_contract)
    );


    CREATE TABLE TimeStamps (
        time_block TIME PRIMARY KEY
    );

    CREATE TABLE EmployeeSchedule(
        employee_id INTEGER REFERENCES Employee,
        date DATE,
        start_time TIME REFERENCES TimeStamps,
        end_time TIME REFERENCES TimeStamps,
        PRIMARY KEY (employee_id ,date)
    );


    CREATE TABLE Patient (
        patient_id INTEGER PRIMARY KEY REFERENCES Person
    );


    CREATE TABLE Doctor (
        employee_id INTEGER PRIMARY KEY REFERENCES Employee,
        specialty TEXT CHECK (specialty IN ('cardiology', 'orthopedy', 'pediatrics'))
    );


    CREATE TABLE Nurse (
        employee_id INTEGER PRIMARY KEY REFERENCES Employee,
        specialty TEXT CHECK (specialty IN ('cardiology', 'orthopedy', 'pediatrics'))
    );

    CREATE TABLE Secretary (
        employee_id INTEGER PRIMARY KEY REFERENCES Employee
    );

    CREATE TABLE Admin (
        employee_id INTEGER PRIMARY KEY REFERENCES Employee
    );

    
    CREATE TABLE Appointment (
        appointment_id INTEGER PRIMARY KEY AUTOINCREMENT,
        patient_id INTEGER REFERENCES Patient,
        doctor_id INTEGER REFERENCES Doctor NOT NULL,
        nurse_id INTEGER REFERENCES Nurse,
        time_block TIME NOT NULL REFERENCES TimeStamps,
        appointment_date DATE NOT NULL ,
        report TEXT NOT NULL
    );

    

    INSERT INTO Employee (employee_id, start_contract, end_contract) 
    VALUES (1, '2024-01-01', '2025-01-01');

    INSERT INTO Admin (employee_id) 
    VALUES (1);

    INSERT INTO TimeStamps (time_block) VALUES ('08:00');
    INSERT INTO TimeStamps (time_block) VALUES ('08:30');
    INSERT INTO TimeStamps (time_block) VALUES ('09:00');
    INSERT INTO TimeStamps (time_block) VALUES ('09:30');
    INSERT INTO TimeStamps (time_block) VALUES ('10:00');
    INSERT INTO TimeStamps (time_block) VALUES ('10:30');
    INSERT INTO TimeStamps (time_block) VALUES ('11:00');
    INSERT INTO TimeStamps (time_block) VALUES ('11:30');
    INSERT INTO TimeStamps (time_block) VALUES ('12:00');
    INSERT INTO TimeStamps (time_block) VALUES ('12:30');
    INSERT INTO TimeStamps (time_block) VALUES ('13:00');
    INSERT INTO TimeStamps (time_block) VALUES ('13:30');
    INSERT INTO TimeStamps (time_block) VALUES ('14:00');
    INSERT INTO TimeStamps (time_block) VALUES ('14:30');
    INSERT INTO TimeStamps (time_block) VALUES ('15:00');
    INSERT INTO TimeStamps (time_block) VALUES ('15:30');
    INSERT INTO TimeStamps (time_block) VALUES ('16:00');
    INSERT INTO TimeStamps (time_block) VALUES ('16:30');
    INSERT INTO TimeStamps (time_block) VALUES ('17:00');
    INSERT INTO TimeStamps (time_block) VALUES ('17:30');
    INSERT INTO TimeStamps (time_block) VALUES ('18:00');
    INSERT INTO TimeStamps (time_block) VALUES ('18:30');
    INSERT INTO TimeStamps (time_block) VALUES ('19:00');
    INSERT INTO TimeStamps (time_block) VALUES ('19:30');
    INSERT INTO TimeStamps (time_block) VALUES ('20:00');
