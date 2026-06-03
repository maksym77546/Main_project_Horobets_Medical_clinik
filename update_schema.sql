ALTER TABLE menu ADD COLUMN IF NOT EXISTS title_en VARCHAR(50) DEFAULT NULL;
UPDATE menu SET title_en = 'Therapy' WHERE id = 1;
UPDATE menu SET title_en = 'Surgery' WHERE id = 2;
UPDATE menu SET title_en = 'Diagnostics' WHERE id = 3;

ALTER TABLE doctors ADD COLUMN IF NOT EXISTS doctor_name_en VARCHAR(256) DEFAULT NULL;
ALTER TABLE doctors ADD COLUMN IF NOT EXISTS specialization_en TEXT DEFAULT NULL;

ALTER TABLE doctor_certificates ADD COLUMN IF NOT EXISTS title_en VARCHAR(256) DEFAULT NULL;
ALTER TABLE doctor_certificates ADD COLUMN IF NOT EXISTS description_en TEXT DEFAULT NULL;

CREATE TABLE IF NOT EXISTS appointments (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status VARCHAR(20) DEFAULT 'booked',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
