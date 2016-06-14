CREATE LANGUAGE plpgsql;

DROP TABLE IF EXISTS users;

CREATE TABLE users(
  id serial,
  login text,
  passwd text,
  name text,
  email text,
  is_admin bool DEFAULT FALSE,
  reg_date date,
  last_login timestamp DEFAULT NULL,
  disabled bool DEFAULT FALSE,
  UNIQUE ( login ),
  UNIQUE ( email )
);