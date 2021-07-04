create database online_grocery_store_database;

-- drop database online_grocery_store_database;

use online_grocery_store_database;

--  user table
create table `user`(
	email_id varchar(255) character set utf8mb4,
	`password` varchar(50) not null check (length(`password`)>=8),
	phone_number varchar(10) check (length(phone_number)=10 or phone_number is null),
	name varchar(50) not null,
	primary key(email_id) );
	
-- drop table user;

-- user_address table
create table user_address(
	email_id varchar(255) character set utf8mb4,
    location varchar(200),
    city varchar(50),
    state varchar(50),
    pincode varchar(6) check (length(pincode)=6),
    primary key(email_id, location, city, state, pincode),
    foreign key (email_id) references user(email_id));
    
--  drop table user_address; 
	
-- product table
create table product(
	product_id varchar(10)  check (length(product_id)=10),
    name varchar(50) not null,
    price numeric(8,2) not null  check (price>0),
    image blob,
    brand varchar(30),
    inventory int not null check (inventory >= 0),
    max_quantity int not null check (max_quantity > 0),
    primary key(product_id));
    
-- drop table product;

-- product_category table
create table product_category(
	product_id varchar(10),
    category varchar(30),
    primary key(product_id, category),
    foreign key (product_id) references product(product_id));
    
-- offer table
create table offer(
	offer_id varchar(5)  check (length(offer_id)=5),
    offer_name varchar(50) not null,
    percentage decimal(5,2)  check ( (percentage >= 0 and percentage <= 100) or percentage is null),
    primary key(offer_id));
    
-- offer_product table
create table offer_product(
	offer_id varchar(5),
    product_id varchar(10) ,
    primary key(offer_id, product_id),
    foreign key (offer_id) references offer(offer_id),
    foreign key (product_id) references product(product_id));
    
-- user_cart table
create table user_cart(
	email_id varchar(255) character set utf8mb4,
    product_id varchar(10),
    quantity int not null,
    primary key (email_id, product_id),
    foreign key (product_id) references product(product_id),
    foreign key (email_id) references user(email_id));
  
-- order_product
create table order_product(
	order_id varchar(20)  check (length(order_id)=20),
    product_id varchar(10) ,
    quantity int not null,
    primary key(order_id, product_id),
    foreign key (product_id) references product(product_id));
    
-- user_order
  create table user_order(
	order_id varchar(20),
    order_status enum('CONFIRMED', 'CANCELLED', 'DELIVERING','DELIVERED') not null,
    price numeric(8,2) not null,
    email_id varchar(255) character set utf8mb4,
    ordered_on timestamp default current_timestamp on update current_timestamp not null,
    delivered_on datetime,
    primary key(order_id),
    foreign key (email_id) references user(email_id),
    foreign key (order_id) references order_product(order_id));  
    
-- delivery_man table
create table delivery_man(
	email_id varchar(255) character set utf8mb4,
    password varchar(50) not null check (length(password)>=8),
    phone_number varchar(10) check (length(phone_number)=10 or phone_number is null),
	name varchar(50) not null,
    location varchar(200),
    city varchar(50),
    state varchar(50),
    pincode varchar(6) check (length(pincode)=6),
	primary key(email_id));
    
-- order_delivery_man table  
create table order_delivery_man(
	email_id varchar(255) character set utf8mb4,
	order_id varchar(20) not null,
	order_salary numeric(8,2) not null check (order_salary>0),
	primary key(order_id, email_id),
	foreign key (order_id) references user_order(order_id),
	foreign key (email_id) references delivery_man(email_id));
    