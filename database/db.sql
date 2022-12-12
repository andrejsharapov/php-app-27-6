CREATE TABLE users
(
    id       serial PRIMARY KEY,
    name     VARCHAR(256) NOT NULL,
    email    VARCHAR(256),
    password VARCHAR(30)  NOT NULL,
    date     DATE         not null
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
DROP TABLE users;

--
ALTER TABLE users
    ADD COLUMN role VARCHAR(30)
--     DROP COLUMN role
;

--
ALTER TABLE users
    ALTER role
        SET DEFAULT 'user'
;

--
UPDATE users
SET role = 'user'
WHERE id = 1;

--
SELECT * FROM users;
