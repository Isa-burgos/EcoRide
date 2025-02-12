CREATE TABLE role(
    role_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50)
);

CREATE TABLE user(
    user_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    pseudo VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(50) NOT NULL,
    phone INT(10) NOT NULL,
    adress VARCHAR(255) NOT NULL,
    birth_date DATETIME NOT NULL,
    photo BLOB,
    gender VARCHAR(50) NOT NULL,
    possess INT(11) NOT NULL,
    FOREIGN KEY (possess) REFERENCES role(role_id)
);

CREATE TABLE vehicle(
    vehicle_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    registration VARCHAR(50),
    first_registration_date DATE NOT NULL,
    brand VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    color VARCHAR(50) NOT NULL,
    energy VARCHAR(50) NOT NULL,
    belong INT(11) NOT NULL,
    Foreign Key (belong) REFERENCES user(user_id)
);

CREATE TABLE carshare(
    carshare_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    price_person FLOAT NOT NULL,
    depart_adress VARCHAR(255) NOT NULL,
    arrival_adress VARCHAR(255) NOT NULL,
    depart_date DATE NOT NULL,
    arrival_date DATE NOT NULL,
    depart_time TIME NOT NULL,
    arrival_time TIME NOT NULL,
    statut VARCHAR(50) NOT NULL,
    nb_place TINYINT,
    used_vehicle INT(11) NOT NULL,
    Foreign Key (used_vehicle) REFERENCES vehicle(vehicle_id)
);

CREATE TABLE review(
    review_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    score INT(2) NOT NULL,
    user_comment TEXT(500)
);

CREATE TABLE statut(
    statut_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50)
);

CREATE TABLE user_carshare(
    user_id INT(11),
    carshare_id INT(11),
    Foreign Key (user_id) REFERENCES user(user_id),
    Foreign Key (carshare_id) REFERENCES carshare(carshare_id),
    PRIMARY KEY(user_id, carshare_id)
);

CREATE TABLE user_review(
    user_id INT(11),
    review_id INT(11),
    Foreign Key (user_id) REFERENCES user(user_id),
    Foreign Key (review_id) REFERENCES review(review_id),
    PRIMARY KEY (user_id, review_id)
);

CREATE TABLE user_statut(
    user_id INT(11),
    statut_id INT(11),
    Foreign Key (user_id) REFERENCES user(user_id),
    Foreign Key (statut_id) REFERENCES statut(statut_id),
    PRIMARY KEY (user_id, statut_id)
);

INSERT INTO role (name) VALUE ('utilisateur');

INSERT INTO user (name, firstname, email, password, possess) VALUES ('Doe', 'John', 'test@test.fr', '123', 1);

UPDATE user 
SET password = '$2y$10$BY3nfGURBXf/rFvd1jlBiuphmHoZ.Ea0lAdUTLkvYkUsoX09reZKG' 
WHERE email = 'test@test.fr';

ALTER TABLE user MODIFY COLUMN password VARCHAR(255) NOT NULL;

DESCRIBE user;

UPDATE user 
SET pseudo = 'JohnD',
    phone = '0606060606',
    adress = '20 rue de la ville, 07200 Aubenas',
    birth_date = '1980-01-01',
    photo = 'photo',
    gender = 'homme'
WHERE user_id = 3; 

SELECT * FROM vehicle;

INSERT INTO carshare (price_person, depart_adress, arrival_adress, depart_date, arrival_date, depart_time, arrival_time, statut, nb_place, used_vehicle) 
VALUES ('3', 'Aubenas', 'Montélimar', '2023-02-02', '2023-02-02', '08-00', '08-45', 'terminé', '2', 1);

INSERT INTO vehicle (registration, first_registration_date, brand, model, color, energy, belong)
VALUES ('XX-000-XX', '2020-01-01', 'Renault', 'Captur', 'gris', 'thermique', 3)
                                                    
ALTER TABLE vehicle ADD COLUMN energy_icon VARCHAR(255) NOT NULL;

UPDATE vehicle SET energy_icon = 'electric-icon.svg' WHERE energy = 'électrique';
UPDATE vehicle SET energy_icon = 'thermal-icon.svg' WHERE energy = 'thermique';

