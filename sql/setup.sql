DROP DATABASE IF EXISTS contacts_app;

CREATE DATABASE contacts_app;

USE contacts_app;

CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255),
    phone_number VARCHAR(255),

    FOREIGN KEY (user_id) REFERENCES users(id)
); 

CREATE TABLE addresses(
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT NOT NULL,
    country VARCHAR(255),
    city VARCHAR(255),
    street VARCHAR(255),
    zipcode VARCHAR(255),

    FOREIGN KEY (contact_id) REFERENCES contacts(id)
);

