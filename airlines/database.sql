DROP DATABASE IF EXISTS airlines;
CREATE DATABASE IF NOT EXISTS airlines;
USE airlines;


-- Create table for Aircraft type with index on Capacity
CREATE TABLE Aircraft_type (
    A_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Capacity INT,
    A_model VARCHAR(50),
    A_weight INT,
    Company VARCHAR(50),
    INDEX idx_Capacity (Capacity)
);

-- Create table for Route with indexes on Departure and Destination
CREATE TABLE Route (
    Route_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Departure VARCHAR(50),
    Destination VARCHAR(50),
    R_type VARCHAR(20),
    INDEX idx_Departure (Departure),
    INDEX idx_Destination (Destination)
);

-- Create table for Flight with indexes on Departure, Arrival, and Flight_date
CREATE TABLE Flight (
    Flight_ID VARCHAR(50) PRIMARY KEY,
    Departure VARCHAR(50),
    Arrival VARCHAR(50),
    Flight_date DATE,
    Route_ID INT,
    FOREIGN KEY (Route_ID) REFERENCES Route(Route_ID),
    INDEX idx_Departure (Departure),
    INDEX idx_Arrival (Arrival),
    INDEX idx_Flight_date (Flight_date)
);

-- Create table for Airfare with indexes on Class and Charged_amount
CREATE TABLE Airfare (
    Fare_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Class VARCHAR(50),
    Charged_amount DECIMAL(8,2),
    Description VARCHAR(50),
    Flight_ID VARCHAR(50),
    FOREIGN KEY (Flight_ID) REFERENCES Flight (Flight_ID) ON UPDATE CASCADE,
    INDEX idx_Class (Class),
    INDEX idx_Charged_amount (Charged_amount)
);

-- Create table for Passengers with index on Flight_ID
CREATE TABLE Passengers (
    P_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    P_fname VARCHAR(50),
    P_lname VARCHAR(50),
    Age INT,
    Street VARCHAR(50),
    House_no INT,
    City VARCHAR(50),
    Sex ENUM('Male','Female'),
    Flight_ID VARCHAR (50),
    FOREIGN KEY (Flight_ID) REFERENCES Flight (Flight_ID),
    INDEX idx_Flight_ID (Flight_ID)
);

-- Create table for Transaction with index on Flight_ID
CREATE TABLE Transaction (
    Ts_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Ts_type ENUM('GooglePay', 'PhonePe', 'Credit Card', 'Debit Card', 'Paytm'),
    Departure_date DATE,
    Booking_date DATE,
    Charged_amount DECIMAL(8,2),
    Flight_ID VARCHAR (50),
    FOREIGN KEY (Flight_ID) REFERENCES Flight (Flight_ID),
    INDEX idx_Flight_ID (Flight_ID)
);

-- Create table for Countries with a primary key constraint
CREATE TABLE Countries (
    Country_code INT PRIMARY KEY,
    Country_name VARCHAR(50)
);

-- Create table for Airport with primary key constraint and index on Country_code
CREATE TABLE Airport (
    Air_code VARCHAR(50) PRIMARY KEY,
    Name VARCHAR(50),
    State VARCHAR(50),
    City VARCHAR(50),
    Country_code INT,
    FOREIGN KEY (Country_code) REFERENCES Countries(Country_code),
    INDEX idx_Country_code (Country_code)
);

-- Create table for can_land with primary key constraint

-- Create table for travels_on with primary key constraint

-- Create table for Passenger_contact with primary key constraint
CREATE TABLE Passenger_contact (
    P_ID INT,
    Contact varchar(30),
    PRIMARY KEY(P_ID, Contact),
    FOREIGN KEY (P_ID) REFERENCES Passengers(P_ID)
);

-- Create table for users with a primary key constraint
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO Route
VALUES
    (101,'New York', 'Tokyo', 'Direct'),
    (102,'Beijing', 'Sydney', '1Hr Layover'),
    (103,'Dubai', 'Paris', '2Hr Break'),
    (104,'India','Sri lanka','Direct');

INSERT INTO Flight (Flight_ID, Departure, Arrival, Flight_date, Route_ID)
VALUES 
    ('14', 'New York', 'Tokyo', '2024-02-09', 101),
    ('15', 'Beijing', 'Sydney', '2024-02-10', 102),
    ('16', 'India', 'Sri lanka', '2024-02-11', 103),
    ('17', 'Dubai', 'Paris', '2024-02-12', 104);

INSERT INTO Aircraft_type (A_ID, Capacity, A_model, A_weight, Company)
VALUES
    (504, 150, 'Airbus A320', 780, 'British Airways'),
    (505, 300, 'Boeing 777', 384, 'Emirates'),
    (506, 180, 'Airbus A321', 790, 'Lufthansa');
    -- Add more data as needed

-- Insert more data into Route table


-- Inserting data into Airfare table for Flight 14 (Dubai to Chandigarh, Direct)
INSERT INTO Airfare (Fare_ID, Class, Charged_amount, Description, Flight_ID)
VALUES (85, 'Economy', 400, 'Economy class for Dubai to Chandigarh', 14);
       

-- Inserting data into Airfare table for Flight 15 (Seoul to Amritsar, 2Hr Break)
INSERT INTO Airfare (Fare_ID, Class, Charged_amount, Description, Flight_ID)
VALUES  (90, 'First class', 1400, 'First class for Seoul to Amritsar', 15);

-- Inserting data into Airfare table for Flight 16 (Singapore to Lucknow, Direct)
INSERT INTO Airfare (Fare_ID, Class, Charged_amount, Description, Flight_ID)
VALUES   (93, 'First class', 120000, 'First class for Singapore to Lucknow', 16);

-- Inserting data into Airfare table for Flight 17 (Singapore to Lucknow, 1Hr Layover)
INSERT INTO Airfare (Fare_ID, Class, Charged_amount, Description, Flight_ID)
VALUES (96, 'First class', 125000, 'First class', 17);

-- Inserting data into Passengers table
INSERT INTO Passengers (P_ID, P_fname, P_lname, Age, Street, House_no, City, Sex, Flight_ID)
VALUES
    (3, 'John', 'Doe', 35, '4567 Downtown', 23, 'Washington', 'Male', 14),
    (4, 'Jane', 'Doe', 28, '7890 Uptown', 45, 'Chennai', 'Female', 15),
    (16, 'Ethan', 'Sanchez', 26, '6789 Ocean View', 289, 'Singapore', 'Male', 16),
    (17, 'Camila', 'Torres', 29, '7890 Lake Shore', 301, 'Singapore', 'Female', 17);

-- Inserting data into Passenger_contact table
INSERT INTO Passenger_contact (P_ID, Contact)
VALUES
    (3, 9876543210),
    (4, 1234567890),
    (16, 1234567896),
    (17, 9876543217);

-- Create procedure to update Flight dates
DELIMITER $$

CREATE PROCEDURE UpdateFlightDates(IN newDate DATE)
BEGIN
    UPDATE Flight
    SET Flight_date = DATE_ADD(newDate, INTERVAL 1 DAY);
END $$

DELIMITER ;


DELIMITER $$

CREATE TRIGGER UpdateAirfareDescription
BEFORE INSERT ON Airfare
FOR EACH ROW
BEGIN
    DECLARE dep_city VARCHAR(50);
    DECLARE arr_city VARCHAR(50);
    
    -- Retrieve departure and arrival cities for the corresponding Flight_ID
    SELECT Departure, Arrival INTO dep_city, arr_city
    FROM Flight
    WHERE Flight_ID = NEW.Flight_ID;

    -- Set the Description field for the new row in Airfare
    SET NEW.Description = CONCAT(NEW.Class, ' class for ', dep_city, ' to ', arr_city);
END $$

DELIMITER ;

-- Create a view to display Flight information with corresponding Aircraft details
CREATE VIEW FlightDetails AS
SELECT 
    f.Flight_ID,
    f.Departure,
    f.Arrival,
    f.Flight_date,
    f.Route_ID,
    at.Capacity,
    at.A_model,
    at.A_weight,
    at.Company
FROM Flight f
JOIN Aircraft_type at ON f.Route_ID = at.A_ID;