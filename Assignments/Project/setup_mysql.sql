DROP TABLE users;

CREATE TABLE users (
    username VARCHAR(36) PRIMARY KEY NOT NULL,
    password VARCHAR(36) NOT NULL,
    blogtext TEXT
);

INSERT INTO users VALUES ("alice", "1234", DEFAULT);
INSERT INTO users VALUES ("arusik", "password", DEFAULT);
INSERT INTO users VALUES ("ruben", "password", DEFAULT);