CREATE DATABASE doctor_appointments;

USE doctor_appointments;

CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT NOT NULL,
    patient_name VARCHAR(100) NOT NULL,
    patient_email VARCHAR(100) NOT NULL,
    appointment_date DATE NOT NULL,
    reason TEXT NOT NULL,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id)
);



INSERT INTO doctors_data (name, specialty, rating, availability) VALUES
('Dr. John Doe', 'Cardiology', 4.5, '12pm - 5pm'),
('Dr. Jane Smith', 'Ophthalmology', 4.8, '10am - 4pm'),
('Dr. Mike Johnson', 'Orthopedics', 4.7, '9am - 3pm');