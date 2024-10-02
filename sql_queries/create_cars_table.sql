DROP TABLE IF EXISTS cars;

CREATE TABLE cars (
	id INT(11) NOT NULL AUTO_INCREMENT,
    make VARCHAR(30) NOT NULL,
    model VARCHAR(30) NOT NULL,
    vin VARCHAR(17) NOT NULL,
    plate_number VARCHAR(7) NOT NULL,
    itp_exp_date DATETIME,
    itp_notification_sent BOOLEAN DEFAULT FALSE,
    path_to_image VARCHAR(100),
    user_id INT(11) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);