CREATE LANGUAGE plpgsql;

DROP TABLE IF EXISTS users;

CREATE TABLE users(
  id serial,
  login text,
  passwd text,
  name text,
  email text,
  role_id int DEFAULT 3 REFERENCES roles(id),
  reg_date date,
  last_login timestamp DEFAULT NULL,
  disabled bool DEFAULT FALSE,
  UNIQUE ( login ),
  UNIQUE ( email )
);

CREATE TABLE roles (
  id serial,
  name TEXT,
  profile_upd BOOL DEFAULT FALSE,
  users_upd BOOL DEFAULT FALSE,
  PRIMARY KEY (id)
);