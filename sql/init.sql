create table sections
(
    id   int primary key auto_increment,
    name varchar(30) not null unique
);

create table products
(
    id         int primary key auto_increment,
    name       varchar(60)  not null,
    s_num      varchar(60)  not null unique,
    price      float        not null,
    year       year         not null,
    country    varchar(60)  not null,
    img        varchar(100) not null,
    id_section int          not null,
    foreign key (id_section) references sections (id)
);

create table param
(
    id         int primary key auto_increment,
    name       varchar(100) not null,
    value      varchar(200) not null,
    id_product varchar(60)  not null
);

create table reviews
(
    id         int primary key auto_increment,
    name       varchar(100) not null,
    email      varchar(50)  not null,
    comment    varchar(200) not null,
    id_product int          not null
);