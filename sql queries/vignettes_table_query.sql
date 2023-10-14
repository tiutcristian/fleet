CREATE TABLE vignettes (
	id INT(11) NOT NULL AUTO_INCREMENT,
    car_id INT(11) NOT NULL,
    country VARCHAR(30) NOT NULL,
    details TEXT,
    expiration_date DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (car_id) REFERENCES cars (id) ON DELETE CASCADE
);