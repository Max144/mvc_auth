echo "** Creating users table"

mysql -u "$MYSQL_USER" -p"$MYSQL_PASSWORD" -e \
"use $MYSQL_DATABASE
    create table IF NOT EXISTS users (
      id int(11) NOT NULL AUTO_INCREMENT,
      first_name varchar(191) NOT NULL,
      last_name varchar(191) NOT NULL,
      password varchar(255) NOT NULL,
      email varchar(191) NOT NULL,
      phone_number varchar(191) NOT NULL,
      PRIMARY KEY (id),
      UNIQUE (email)
  );
"

echo "** Finished creating users table"