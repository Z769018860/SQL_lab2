su - postgres

psql

CREATE DATABASE lab2 OWNER root;

GRANT ALL PRIVILEGES ON DATABASE lab2 to root;

CREATE TYPE se_type as enum 
(
    'YZ', 'RZ', 'YW1', 'YW2', 'YW3', 'RW1', 'RW2'
);

CREATE TYPE b_status as enum
(
    'cancelled','uncancelled'
);

CREATE TABLE Station
(
    St_Name          varchar(20) primary key,
    St_City          varchar(20) not null
);

CREATE TABLE Train
(
    T_Name          varchar(6) not null,
    T_Station       varchar(20) not null,
    T_StNum         integer not null,
    T_ArrivalTime   time,
    T_StartTime     time,
    T_YZMoney       float,
    T_RZMoney       float,
    T_YW1Money      float,
    T_YW2Money      float,
    T_YW3Money      float,
    T_RW1Money      float,
    T_RW2Money      float,
    primary key (T_Name,T_Station),
    foreign key (T_Station) references Station(St_Name)
);

CREATE TABLE MyUser
(
    U_ICNum         char(18) primary key,
    U_TelNum        char(11) not null,
    U_UName         varchar(20) not null,
    U_Name          varchar(20) not null,
    U_CCNum         char(16) not null
);

CREATE TABLE Book
(
    B_Id            serial primary key,
    B_User          varchar(18) not null,
    B_Money         float not null,
    B_Date          date not null,
    B_Train         varchar(6) not null,
    B_StartSt       varchar(20) not null,
    B_ArrivalSt     varchar(20) not null,
    B_Status        b_status not null,
    foreign key (B_User) references MyUser(U_ICNum),
    foreign key (B_Train,B_StartSt) references Train(T_Name,T_Station)
);

CREATE TABLE Seat
(
    Se_Train         varchar(6) not null,
    Se_Station       varchar(20) not null,
    Se_Date          date not null,
    Se_Type          se_type not null,
    Se_Num           integer not null,
    primary key (Se_Train,Se_Station,Se_Date,Se_Type),
    foreign key (Se_Train,Se_Station) references Train(T_Name,T_Station)
);

COPY Station

FROM '/var/www/html/data/station-data.csv'

WITH (FORMAT csv);

COPY Train

FROM '/var/www/html/data/train-data.csv'

WITH (FORMAT csv);
