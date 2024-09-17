-- Drop all tables
DROP TABLE IF EXISTS insurances;
DROP TABLE IF EXISTS vignettes;
DROP TABLE IF EXISTS cars;
DROP TABLE IF EXISTS users;
-- ========================================



-- Create all tables
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    username VARCHAR(30) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE cars (
	id INT(11) NOT NULL AUTO_INCREMENT,
    make VARCHAR(30) NOT NULL,
    model VARCHAR(30) NOT NULL,
    vin VARCHAR(17) NOT NULL,
    plate_number VARCHAR(7) NOT NULL,
    itp_exp_date DATETIME,
    path_to_image VARCHAR(100),
    user_id INT(11) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

CREATE TABLE vignettes (
	id INT(11) NOT NULL AUTO_INCREMENT,
    car_id INT(11) NOT NULL,
    country VARCHAR(30) NOT NULL,
    details TEXT,
    expiration_date DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (car_id) REFERENCES cars (id) ON DELETE CASCADE
);

CREATE TABLE insurances (
	id INT(11) NOT NULL AUTO_INCREMENT,
    car_id INT(11) NOT NULL,
    insurance_type VARCHAR(30) NOT NULL,
    details TEXT,
    expiration_date DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (car_id) REFERENCES cars (id) ON DELETE CASCADE
);
-- ========================================



-- Insert admin and user
INSERT INTO `users`(`role`, `username`, `pwd`, `email`) 
VALUES ('user','user','$2y$12$IfAvcAQYyIrmms.mM0HITOXiMIsYDRzXca4OhDKyr8k5sW108HlUi','user@user.com');

INSERT INTO `users`(`role`, `username`, `pwd`, `email`) 
VALUES ('admin','admin','$2y$12$j50n9BLTNv0oCd2Wf0I8NuCOWtWPqgNiiUj3f1kmuTIcSgLxYlMrK','admin@admin.com');
-- ========================================