BEGIN;

CREATE TABLE sysvariables (
  var_name TEXT,
  var_val TEXT
);

INSERT INTO sysvariables VALUES ('version', '0.0.1');

COMMIT;