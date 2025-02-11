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

