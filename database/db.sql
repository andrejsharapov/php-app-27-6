CREATE TABLE users
(
    id       serial PRIMARY KEY,
    name     VARCHAR(256) NOT NULL,
    email    VARCHAR(256) NOT NULL,
    password VARCHAR(30)  NOT NULL,
    token    VARCHAR(256) NOT NULL,
    date     DATE         not null
);

--
ALTER TABLE users
    MODIFY COLUMN password
    VARCHAR (256) NOT NULL
;

--
DELETE
FROM users;
ALTER TABLE users AUTO_INCREMENT = 1;

--
select *
from users;
