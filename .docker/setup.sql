-- create the databases
CREATE DATABASE IF NOT EXISTS finnico;

-- create the users for each database
CREATE USER 'finnico'@'%' IDENTIFIED BY 'finnico';
GRANT CREATE, ALTER, INDEX, LOCK TABLES, REFERENCES, UPDATE, DELETE, DROP, SELECT, INSERT ON `finnico`.* TO 'finnico'@'%';

FLUSH PRIVILEGES;