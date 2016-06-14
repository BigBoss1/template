CREATE OR REPLACE FUNCTION get_users( id int )
  RETURNS TABLE (
    id int,
    login text,
    name text,
    email text,
    reg_date date,
    last_login timestamp
  ) AS $$
    SELECT id, login, name, email, reg_date, last_login FROM users
    WHERE CASE $1 IS NULL
      WHEN TRUE THEN TRUE
      ELSE id=$1
    END;
  $$ LANGUAGE SQL STABLE;

CREATE OR REPLACE FUNCTION user_create( login text, passwd text, name text, email text, reg_date date )
  RETURNS TABLE (
    id int,
    login text,
    name text,
    email text,
    role text,
    reg_date date,
    last_login timestamp
  ) AS $$
    INSERT INTO users (login, passwd, name, email, reg_date, last_login) VALUES ($1, $2, $3, $4, $5, NOW());
    SELECT auth($1, $2);
  $$ LANGUAGE SQL VOLATILE;

CREATE OR REPLACE FUNCTION user_update( id int, login text, passwd text, name text, email text )
  RETURNS int AS $$
    UPDATE users SET (login, passwd, name, email) = ($2,
      CASE $3 IS NULL
        WHEN TRUE THEN (SELECT passwd FROM users WHERE  id=$1)
      ELSE $3
      END, $4, $5)
    WHERE id=$1
    RETURNING id;
$$ LANGUAGE SQL VOLATILE;

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
      UPDATE users SET last_login=NOW() WHERE users.login=$1 AND users.passwd=$2;
      RETURN QUERY
        SELECT users.id, users.login, users.name, users.email, users.reg_date, l_last_login
        FROM users WHERE users.login=$1 AND users.passwd=$2;
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