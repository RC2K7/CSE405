use store;

/**
* Create Tables
**/

CREATE TABLE employees
(
    name varchar(255),
    salary int
);


CREATE TABLE inventory
(
    id int NOT NULL,
    name varchar(255),
    quantity int,
    PRIMARY KEY(id)
);

/**
* Insert Records
**/

INSERT INTO employees (name, salary) VALUES ('Mick Jagg', 32000);
INSERT INTO employees (name, salary) VALUES ('Seth Mitts', 2400);
INSERT INTO employees (name, salary) VALUES ('Unpaid Intern', NULL);

INSERT INTO inventory (id, name, quantity) VALUES (1, 'Beds', 3);
INSERT INTO inventory (id, name, quantity) VALUES (2, 'Chairs', 0);
INSERT INTO inventory (id, name, quantity) VALUES (3, 'Tables', 12);