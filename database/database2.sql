CREATE DATABASE IF NOT EXISTS meals_on_wheels;
USE meals_on_wheels;

CREATE TABLE users(
id       int(255) auto_increment not null,
role     varchar(20),
email    varchar(255),
name     varchar(255),
surname  varchar(255),
password varchar(255),
nick     varchar(50),
bio      varchar(255),
image    varchar(255),
CONSTRAINT users_uniques_fields UNIQUE (email, nick),
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE = InnoDb;


CREATE TABLE restaurants(
id       int(255) auto_increment not null,
user int(255),
name varchar(50),
description     mediumtext,
min_order decimal(10,2),
delivery_cost decimal(10,2),
image   varchar(255),
category   varchar(255),
street varchar(255),
num varchar(50),
post_code varchar(20),
days varchar(7),
start_time time,
end_time time,
CONSTRAINT pk_restaurants PRIMARY KEY(id),
CONSTRAINT fk_restaurants_users FOREIGN KEY(user) references users(id)
)ENGINE = InnoDb;


CREATE TABLE orders(
id       int(255) auto_increment not null,
user     int(255),
created_at datetime,
restaurant int (255),
CONSTRAINT pk_orders PRIMARY KEY(id),
CONSTRAINT fk_orders_users FOREIGN KEY(user) references users(id),
CONSTRAINT fk_orders_restautants FOREIGN KEY(restaurant) references restaurants(id)
)ENGINE = InnoDb;

CREATE TABLE products(
id       int(255) auto_increment not null,
restaurant int (255),
name     varchar(255),
description varchar(255),
price decimal(10,2),
type varchar(25),
CONSTRAINT pk_product PRIMARY KEY(id),
CONSTRAINT fk_products_restaurants FOREIGN KEY(restaurant) references restaurants(id)
)ENGINE = InnoDb;


CREATE TABLE order_details(
id int (255) auto_increment not null,
order_id int(255),
product int(255),
CONSTRAINT order_uniques_fields UNIQUE (order_id, product),
CONSTRAINT pk_details PRIMARY KEY(id),
CONSTRAINT fk_details_orders FOREIGN KEY(order_id) references orders(id),
CONSTRAINT fk_details_products FOREIGN KEY(product) references products(id)

)ENGINE = InnoDb;









CREATE TABLE ratings(
id       int(255) auto_increment not null,
user        int(255),
restaurant int(255),
created_at datetime,
text mediumtext,
points int(255),
CONSTRAINT pk_ratings PRIMARY KEY(id),
CONSTRAINT fk_ratings_users FOREIGN KEY(user) references users(id),
CONSTRAINT fk_ratings_restaurants FOREIGN KEY(restaurant) references restaurants(id)
)ENGINE = InnoDb;



