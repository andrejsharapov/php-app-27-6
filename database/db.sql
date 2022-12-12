CREATE TABLE users
(
    id       SERIAL PRIMARY KEY,
    name     VARCHAR(256) NOT NULL,
    email    VARCHAR(256),
    password VARCHAR(30)  NOT NULL,
    date     DATE         NOT NULL
);

--
ALTER TABLE users
    MODIFY COLUMN password
    VARCHAR (256) NOT NULL
;

--
DELETE FROM users;
ALTER TABLE users AUTO_INCREMENT = 1;

--
SELECT * FROM users;

--
DROP TABLE users;
