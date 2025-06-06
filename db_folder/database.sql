
-- Create the database

CREATE DATABASE binary_link;

-- Create clients table 

CREATE TABLE clients (
     id INT PRIMARY KEY AUTO_INCREMENT,
     name varchar(250),
     client_code varchar(6) UNIQUE,
     description varchar(250),
     type varchar(250),
);

-- Create contacts table

CREATE TABLE contacts (
      id INT PRIMARY KEY AUTO_INCREMENT,
      name VARCHAR(250),
      surname VARCHAR(250),
      email VARCHAR(250),
      type VARCHAR(250),
);

-- Create connections (link/unlink) table

CREATE TABLE connections (
      id INT PRIMARY KEY AUTO_INCREMENT,
      client_id INT,
      client_name varchar(250),
      client_code varchar(250),
      client_type varchar(250),
      contact_id INT.
      contact_name VARCHAR(250),
      contact_email VARCHAR(250),
      contact_type VARCHAR(250),
      );
