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

DROP FUNCTION user_create(text, text, text, text, date);
CREATE OR REPLACE FUNCTION user_create( login text, passwd text, name text, email text, reg_date date )
  RETURNS int AS $$
    INSERT INTO users (login, passwd, name, email, reg_date) VALUES ($1, $2, $3, $4, $5);
    SELECT id FROM users WHERE login=$1 AND passwd=$2;
  $$ LANGUAGE SQL VOLATILE;

DROP FUNCTION user_update( id int, login text, passwd text, name text, email text );

/*
CREATE OR REPLACE FUNCTION user_update( id int, login text, passwd text, name text, email text )
  RETURNS void AS $$
IF $3='' THEN
UPDATE users SET (login, passwd, name, email) = ($2, $3, $4, $5) WHERE id=$1 RETURNING id;
ELSE
UPDATE users SET (login, name, email) = ($2, $4, $5) WHERE id=$1 RETURNING id;
END IF;
$$ LANGUAGE SQL VOLATILE;
 */

CREATE OR REPLACE FUNCTION user_update( id int, login text, passwd text, name text, email text )
  RETURNS int AS $$
    UPDATE users SET (login, passwd, name, email) = ($2, $3, $4, $5)
    WHERE id=$1 AND CASE $3=''
      WHEN TRUE THEN FALSE
      ELSE TRUE
    END;
    UPDATE users SET (login, name, email) = ($2, $4, $5)
    WHERE id=$1 AND CASE $3=''
      WHEN TRUE THEN TRUE
      ELSE FALSE
    END
    RETURNING id;
$$ LANGUAGE SQL VOLATILE;
