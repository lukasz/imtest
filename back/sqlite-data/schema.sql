create table ingredients
(
    id integer
        constraint ingredients_pk
            primary key autoincrement,
    recipe_id        int,
    name             varchar(128),
    unitName         varchar(16),
    unitAbbreviation varchar(8),
    unitSystem       varchar(16),
    quantity         float,
    text             varchar(64)
);

create table instructions
(
    id integer
        constraint instructions_pk
            primary key autoincrement,
    recipe_id    int,
    appliance    int,
    position     int,
    temperature  int,
    text         varchar(256)
);

create table recipes
(
    id integer
        constraint recipes_pk
            primary key autoincrement,
    name        int,
    servings    int,
    description varchar(512),
    thumb       varchar(256),
    time        int
);

