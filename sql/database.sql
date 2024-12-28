-- To run type the following commands on the terminal
-- ./sqlite3.exe
-- .read database.sql
-- ===================================================

.headers ON
.mode columns
PRAGMA FOREIGN_KEYS = ON;

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

CREATE TABLE Department (
    name TEXT PRIMARY KEY
);

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
    employee_id INTEGER REFERENCES Person PRIMARY KEY,
p
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

CREATE TABLE Disease (
    name TEXT PRIMARY KEY
);

CREATE TABLE PatientDisease (
    patient_id INTEGER REFERENCES Patient,
    disease TEXT REFERENCES Disease,
    PRIMARY KEY (patient_id, disease)
);

CREATE TABLE Doctor (
    employee_id INTEGER PRIMARY KEY REFERENCES Employee,
    department TEXT REFERENCES Department NOT NULL, 
    specialty TEXT NOT NULL CHECK (specialty IN ('cardiology', 'orthopedy', 'pediatrics'))
);

CREATE TABLE Supervision (
    supervisee INTEGER PRIMARY KEY REFERENCES Doctor,
    supervisor REFERENCES Doctor
);

CREATE TABLE Nurse (
    employee_id INTEGER PRIMARY KEY REFERENCES Employee,
    department TEXT REFERENCES Department NOT NULL, 
    specialty TEXT NOT NULL CHECK (specialty IN ('cardiology', 'orthopedy', 'pediatrics'))
);

CREATE TABLE Secretary (
    employee_id INTEGER PRIMARY KEY REFERENCES Employee
);

CREATE TABLE Admin (
    employee_id INTEGER PRIMARY KEY REFERENCES Employee
);

CREATE TABLE LabTech (
    employee_id INTEGER PRIMARY KEY REFERENCES Employee,
    specialty TEXT NOT NULL CHECK (specialty IN ('cardiology', 'orthopedy', 'pediatrics'))
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

CREATE TABLE Exam (
    appointment INTEGER PRIMARY KEY REFERENCES Appointment,
    schedule TEXT NOT NULL,
    report TEXT NOT NULL
);

CREATE TABLE ExamTech (
    exam_id INTEGER REFERENCES Exam,
    tech_id INTEGER REFERENCES LabTech,
    lab TEXT NOT NULL,
    PRIMARY KEY (exam_id, tech_id),
    UNIQUE(exam_id, lab)
);

CREATE TABLE Drug (
    name TEXT PRIMARY KEY
);

CREATE TABLE AppointmentDrug(
    appointment INTEGER REFERENCES Appointment,
    drug TEXT REFERENCES Drug,
    dose INTEGER CHECK (dose > 0),
    uses_per_day INTEGER CHECK (uses_per_day > 0),
    days INTEGER CHECK (days > 0),
    PRIMARY KEY (appointment, drug)
);

