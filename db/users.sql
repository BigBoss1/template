CREATE OR REPLACE FUNCTION get_users( id int )
  RETURNS TABLE (
    id int,
    login text,
    name text,
    email text,
    reg_date date,
    last_login timestamp,
    disabled bool
  ) AS $$
    SELECT id, login, name, email, reg_date, last_login, disabled FROM users
    WHERE CASE $1 IS NULL
      WHEN TRUE THEN TRUE
      ELSE id=$1
    END
    ORDER BY reg_date, id;
  $$ LANGUAGE SQL STABLE;

CREATE OR REPLACE FUNCTION user_create( login text, passwd text, name text, email text, reg_date date )
  RETURNS int AS $$
    DECLARE
      i int;
    BEGIN
      INSERT INTO users (login, passwd, name, email, reg_date, last_login) VALUES ($1, $2, $3, $4, $5, NOW())
      RETURNING id INTO i;
      RETURN i;
    EXCEPTION
      WHEN UNIQUE_VIOLATION THEN
        RETURN -1;
      WHEN NOT_NULL_VIOLATION THEN
        RETURN -2;
    END;
  $$ LANGUAGE plpgsql VOLATILE;

CREATE OR REPLACE FUNCTION user_update( id int, login text, passwd text, name text, email text, disabled bool )
  RETURNS int AS $$
    DECLARE
      i int;
    BEGIN
      UPDATE users SET (login, passwd, name, email, disabled) = ($2,
        CASE $3 IS NULL
          WHEN TRUE THEN (SELECT users.passwd FROM users WHERE users.id=$1)
        ELSE $3
        END, $4, $5,
        CASE $6 IS NULL
          WHEN TRUE THEN FALSE
          ELSE $6
        END
      )
      WHERE users.id=$1
      RETURNING $1 INTO i;
      RETURN i;
    EXCEPTION
      WHEN UNIQUE_VIOLATION THEN
        RETURN -1;
      WHEN NOT_NULL_VIOLATION THEN
        RETURN -2;
    END;
$$ LANGUAGE plpgsql VOLATILE;

CREATE OR REPLACE FUNCTION auth( l_login text, l_passwd text )
  RETURNS TABLE (
    id int,
    login text,
    name text,
    email text,
    reg_date date,
    last_login timestamp
  ) AS $$
    DECLARE
      l_last_login TIMESTAMP;
    BEGIN
      SELECT users.last_login INTO l_last_login FROM users
      WHERE users.login=$1 AND users.passwd=$2 AND NOT users.disabled;
      UPDATE users SET last_login=NOW() WHERE users.login=$1 AND users.passwd=$2AND NOT users.disabled;
      RETURN QUERY
        SELECT users.id, users.login, users.name, users.email, users.reg_date, l_last_login
        FROM users WHERE users.login=$1 AND users.passwd=$2 AND NOT users.disabled;
    END;
  $$ LANGUAGE plpgsql VOLATILE;

CREATE OR REPLACE FUNCTION get_rights( id int )
  RETURNS TABLE (
    profile_upd bool,
    users_upd bool
  ) AS $$
    SELECT profile_upd, users_upd FROM roles
    WHERE id=(SELECT role_id FROM users WHERE id=$1);
$$ LANGUAGE SQL STABLE;