DROP TABLE IF EXISTS users;

CREATE TABLE users(
  id serial,
  login text,
  passwd text,
  name text,
  email text,
  reg_date date,
  last_login timestamp DEFAULT NULL,
  disabled bool DEFAULT FALSE,
  UNIQUE ( login ),
  UNIQUE ( email )
);