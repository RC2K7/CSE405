DROP TABLE users;

CREATE TABLE users (
    username VARCHAR(36) PRIMARY KEY,
    password VARCHAR(36) NOT NULL,
    click_count INT NOT NULL DEFAULT 0
);

INSERT INTO users VALUES ('alice', '1234', DEFAULT);