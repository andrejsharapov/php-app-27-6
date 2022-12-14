SHOW DATABASES;

-- create database
CREATE DATABASE php_app_27_6;
USE php_app_27_6;

SHOW TABLES;

-- create users table (with error in password)
CREATE TABLE users
(
    id       serial PRIMARY KEY,
    name     VARCHAR(256) NOT NULL,
    email    VARCHAR(256),
    password VARCHAR(30)  NOT NULL,
    date     DATE         not null
);

-- fix password error (use hash)
ALTER TABLE users
    MODIFY COLUMN password
    VARCHAR (256) NOT NULL
;

-- tests
-- DELETE FROM users;
-- ALTER TABLE users AUTO_INCREMENT = 1;
-- DROP TABLE users;

-- add new column for users roles
ALTER TABLE users
    ADD COLUMN role VARCHAR(30)
--     DROP COLUMN role
;

-- set default role
ALTER TABLE users
    ALTER role
        SET DEFAULT 'user'
;

-- add a role if there is a previously created user
UPDATE users
SET role = 'user'
WHERE id = 1;

-- show table
SELECT * FROM users;
