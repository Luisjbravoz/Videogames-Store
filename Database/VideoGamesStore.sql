-- PROJECT: VIDEO GAMES STORE.
-- LUIS J. BRAVO ZÚÑIGA.
-- SCRIPT DATA BASE (MySQL).

-- [SYSTEM: DROP DATABASE]
drop database if exists videogames_store;

-- [SYSTEM: CREATING DATABASE]
 create database videogames_store;
 use videogames_store;

-- [SYSTEM: CREATING TABLES, PRIMARY KEY AND UNIQUE KEY] 

-- [SYSTEM: CREATING TABLE USERS]
 create table users(
 username			varchar(25)			not null,	
 password			varchar(16)			not null,
 state_data			varchar(1)			not null,
 primary key (username)
);

-- [SYSTEM: CREATING TABLE VIDEOGAME] 
create table Videogame(
id					int				not null	auto_increment,
title				varchar(50)		not null,
id_platform			int				not null,
id_genre			int				not null,
price				float	not null,			
quantity			int				not null,
state_data			varchar(1)		not null,
primary key(id),
unique key (title, id_platform)
);

-- [SYSTEM: CREATING TABLE PLATFORM]
create table Platform(
id					int				not null	auto_increment,
title				varchar(40)		not null,
state_data			varchar(1)		not null,
primary key (id)	
); 
    
-- [SYSTEM: CREATING TABLE GENRE] 
create table Genre(
id					int				not null	auto_increment,
title				varchar(40)		not null,
state_data			varchar(1)		not null,
primary key (id)
);

-- [SYSTEM: CREATING RESTRICCIONS]

-- [SYSTEM: CREATING FOREIGN KEY OF TABLE VIDEOGAME]
alter table Videogame add constraint FK_videogame_platform foreign key (id_platform) references Platform(id);
alter table Videogame add constraint FK_genre_platform foreign key (id_genre) references Genre(id);

-- [SYSTEM: CREATING CHECK CONSTRAINT FOR DATA STATE. THIS ATRIBUTTE ONLY CAN TAKE TWO VALUES: 'A' OR 'I'] 
alter table Users add constraint cdt_state_data_users check(state_data in ('A', 'I'));
alter table Videogame add constraint cdt_state_data_videogames check (state_data in ('A', 'I'));
alter table Platform add constraint cdt_state_data_platform check (state_data in ('A', 'I'));
alter table Genre add constraint cdt_state_data_genre check (state_data in ('A', 'I'));

-- [SYSTEM: CREATING CHECK CONSTRAINT FOR QUANTITY. THIS ATRIBUTTE MUST TO BE > -1] 
alter table Videogame add constraint cdt_quantity check (quantity > -1);

-- [SYSTEM: CREATING CHECK CONSTRAINT FOR PRICE. THIS ATRIBUTTE MUST TO BE > -1] 
alter table Videogame add constraint cdt_check_price check (price > -1);

-- [SYSTEM: INIT AUTOINCREMENT]
alter table Videogame auto_increment=1000;
alter table Platform auto_increment=1;
alter table Genre auto_increment=1;

DELIMITER $$

-- [SYSTEM: CREATING FUNCTIONS TO VALIDATE OPERATIONS]

-- [SYSTEM: CREATING FUNCTION TO KNOW IF THE VIDEOGAME EXISTS]
drop function if exists f_exist_videogame;$$
create function f_exist_videogame(arg_title varchar(50), arg_id_platform int) 
returns int deterministic
begin 
	declare var_result int;
	select count(id)
	into var_result
	from Videogame
	where title = arg_title and id_platform = arg_id_platform;
	return var_result;
end;
$$

-- [SYSTEM: CREATING PROCEDURE]
-- FORMAT: p_<OPERATION>_<TABLE>

-- NOTE: PROCEDURE FOR INSERT, UPDATE, DELETE AND CHECK USER
-- [SYSTEM: CREATING PROCEDURE FOR INSERT USERS]
drop procedure if exists p_insert_user;$$
create procedure p_insert_user(in arg_username varchar(25), in arg_password varchar(16))
begin
	insert into users(username, password, state_data) values (upper(arg_username), arg_password, 'A');
	commit;
end;$$

-- [SYSTEM: CREATING PROCEDURE FOR UPDATE USERS]
drop procedure if exists p_update_user;$$
create procedure p_update_user(in arg_username varchar(25), in arg_password varchar(16))
begin
	update Users set password = arg_password where username = upper(arg_username) and state_data = 'A';
	commit;
end;
$$

-- [SYSTEM: CREATING PROCEDURE FOR DELETE USERS]
drop procedure if exists p_delete_user;$$
create procedure p_delete_user(in arg_username varchar(25))
begin
	update Users set state_data = 'I' where username = upper(arg_username) and state_data = 'A';
	commit;
end;
$$

-- NOTE: FUNCTION FOR CHECK LOGIN.
-- [SYSTEM: CREATING FUNCTION FOR CHECK LOGIN]
drop procedure if exists p_check_login;$$
create procedure p_check_login(arg_username varchar(25), arg_password varchar(16))
begin 
	select count(username)
    from Users
    where username = upper(arg_username) and password = arg_password and state_data = 'A';
end; 
$$
 
 -- NOTE: PROCEDURE FOR INSERT, UPDATE, DELETE, CONSULT AND LIST VIDEOGAME
 -- [SYSTEM: CREATING PROCEDURE FOR INSERT VIDEOGAME]
drop procedure if exists p_insert_videogame;$$
create procedure p_insert_videogame(in arg_title varchar(50), in arg_id_platform int, 
									in arg_id_genre int, in arg_price float, 
									in arg_quantity int)
begin
	if f_exist_videogame(arg_title, arg_id_platform) = 0 then
		insert into Videogame(title, id_platform, id_genre, price, quantity, state_data) values (initcap(arg_title), arg_id_platform, arg_id_genre, arg_price, arg_quantity,'A');
	else
		update Videogame set title = initcap(arg_title), id_platform = arg_id_platform, id_genre = arg_id_genre, price = arg_price, quantity = arg_quantity, state_data = 'A'
		where id = arg_id;
	end if;
	commit;
end;
$$

 -- [SYSTEM: CREATING PROCEDURE FOR UPDATE VIDEOGAME]
drop procedure if exists p_update_videogame;$$
create procedure p_update_videogame(in arg_id int, in arg_title varchar(50),
									in arg_id_platform int, in arg_id_genre int, 
									in arg_price float, in arg_quantity int)
begin
	update Videogame set title = initcap(arg_title), id_platform = arg_id_platform, id_genre = arg_id_genre, price = arg_price, quantity = arg_quantity
	where id = arg_id;
	commit;
end;
$$

 -- [SYSTEM: CREATING PROCEDURE FOR DELETE VIDEOGAME]
drop procedure if exists p_delete_videogame;$$
create procedure p_delete_videogame(in arg_id int)
begin
	update Videogame set state_data = 'I' where id = arg_id;
	commit;
end;
$$

-- [SYSTEM: CREATING PROCEDURE FOR CONSULT VIDEOGAME]
drop procedure if exists p_consult_videogame;$$
create procedure p_consult_videogame(in arg_id int)
begin
	select id, title, id_platform, id_genre, price, quantity
    from Videogame
    where id = arg_id;
end;
$$

-- [SYSTEM: CREATING PROCEDURE FOR LIST VIDEOGAME]
drop procedure if exists p_list_videogame;$$
create procedure p_list_videogame()
begin
	select id, title, id_platform, id_genre, price, quantity
    from Videogame
	where state_data = 'A';
end;
$$

-- NOTE: PROCEDURE FOR INSERT AND LIST PLATFORM
-- [SYSTEM: CREATING PROCEDURE FOR INSERT PLATFORM]
drop procedure if exists p_insert_platform;$$
create procedure p_insert_platform(in arg_title varchar(40))
begin
	insert into platform(title, state_data) values (initcap(arg_title), 'A');
	commit;
end;
$$

-- [SYSTEM: CREATING PROCEDURE FOR LIST PLATFORM]
drop procedure if exists p_list_platform;$$
create procedure p_list_platform()
begin
	select title
    from Platform
	where state_data = 'A';
end;
$$

-- NOTE: PROCEDURE FOR INSERT AND LIST GENRE
-- [SYSTEM: CREATING PROCEDURE FOR INSERT GENRE]
drop procedure if exists p_insert_genre;$$
create procedure p_insert_genre(in arg_title varchar(40))
begin
	insert into genre(title, state_data) values (arg_title, 'A');
	commit;
end;
$$

-- [SYSTEM: CREATING PROCEDURE FOR LIST GENRE]
drop procedure if exists p_list_genre;$$
create procedure p_list_genre()
begin
	select title
    from genre
	where state_data = 'A';
end;
$$

-- [SYSTEM: CREATING FUNCTION INITCAP] 
drop function if exists initcap;$$
create function initcap(input varchar(255))
returns varchar(255) deterministic	
begin
	declare len int;
	declare i int;
	set len   = char_length(input);
	set input = lower(input);
	set i = 0;
	while (i < len) do
		if (mid(input,i,1) = ' ' or i = 0) then
			if (i < len) then
				set input = concat(
					left(input,i),
					upper(mid(input,i + 1,1)),
					right(input,len - i - 1)
				);
			end if;
		end if;
		set i = i + 1;
	end while;
return input;
end;
$$

 DELIMITER ;
 
-- [SYSTEM: INSERTING DATA] 

-- [SYSTEM: INSERTING USERS] 
call p_insert_user('admin@rex.com', 'Admin1234');

-- [SYSTEM: INSERTING PLATFORM]
call p_insert_platform('Play Station');
call p_insert_platform('Play Station 2');
call p_insert_platform('Play Station 3');
call p_insert_platform('Play Station 4');
call p_insert_platform('Play Station 4 pro');
call p_insert_platform('Play Station 5');
call p_insert_platform('Play Station');
call p_insert_platform('Xbox');
call p_insert_platform('Xbox 360');
call p_insert_platform('Xbox 360 Elite');
call p_insert_platform('Xbox 360 One');
call p_insert_platform('Xbox 360 OneS');
call p_insert_platform('Xbox 360 One X');
call p_insert_platform('PC');
call p_insert_platform('Wii');
call p_insert_platform('Wii U');
call p_insert_platform('Nintendo Switch');
call p_insert_platform('Nintendo Switch Lite');
call p_insert_platform('Nintendo DSi XL');
call p_insert_platform('Nintendo DSi');
call p_insert_platform('Nintendo DS Lite');
call p_insert_platform('Nintendo DS');
call p_insert_platform('Nintendo 2DS');
call p_insert_platform('Nintendo 3DS');
call p_insert_platform('Nintendo 3DS/XL');
call p_insert_platform('Nintendo GameCube');
call p_insert_platform('Nintendo 64');
call p_insert_platform('Game boy Advance');

-- [SYSTEM: INSERTING GENRE]
call p_insert_genre('Platform');
call p_insert_genre('Shooter');
call p_insert_genre('Fighting');
call p_insert_genre('Beat em up');
call p_insert_genre('Survival');
call p_insert_genre('Battle Royale');
call p_insert_genre('Rhythm');
call p_insert_genre('Survival horror');
call p_insert_genre('Metroidvania');
call p_insert_genre('Text adventures');
call p_insert_genre('Graphic Adventures');
call p_insert_genre('Visual novels');
call p_insert_genre('Interactive movie');
call p_insert_genre('Real-time 3D adventures');
call p_insert_genre('RPG');
call p_insert_genre('Roguelikes');
call p_insert_genre('Sandbox RPG');
call p_insert_genre('JRPG');
call p_insert_genre('Monster Collection');
call p_insert_genre('First-person party-based RPG');
call p_insert_genre('Construction and management simulation');
call p_insert_genre('Life simulation');
call p_insert_genre('Vehicle simulation');
call p_insert_genre('4X game');
call p_insert_genre('Artillery game');
call p_insert_genre('Auto battler (Auto chess)');
call p_insert_genre('Multiplayer online battle arena (MOBA)');
call p_insert_genre('Real-time strategy (RTS)');
call p_insert_genre('Real-time tactics (RTT)');
call p_insert_genre('Tower defense');
call p_insert_genre('Turn-based strategy (TBS)');
call p_insert_genre('Turn-based tactics (TBT)');
call p_insert_genre('Wargame');
call p_insert_genre('Grand strategy wargame');
call p_insert_genre('Racing');
call p_insert_genre('Sports game');
call p_insert_genre('Competitive');
call p_insert_genre('Sports-based fighting');
call p_insert_genre('Board game or card game');
call p_insert_genre('Casual games');
call p_insert_genre('Digital collectible card game');
call p_insert_genre('Horror game');
call p_insert_genre('Logic game');
call p_insert_genre('MMO');
call p_insert_genre('Mobile game');
call p_insert_genre('Party game');
call p_insert_genre('Programming game');
call p_insert_genre('Trivia game');
call p_insert_genre('Adventure');
call p_insert_genre('Hack and slash');


-- [SYSTEM: INSERTING VIDEOGAME] 
call p_insert_videogame('Resident Evil 1', 1, 8, 30.25, 10);
call p_insert_videogame('Resident Evil 3: Nemesis', 1, 8, 25.75, 5);
call p_insert_videogame('Resident Evil 2', 1, 8, 20.75, 3);
call p_insert_videogame('Bioshock', 4, 2, 15.75, 10);
call p_insert_videogame('Bioshock', 5, 2, 25.75, 5);
call p_insert_videogame('Bioshock', 9, 2, 20.75, 4);
call p_insert_videogame('Bioshock', 17, 2, 35.90, 12);
call p_insert_videogame('Bioshock 2', 4, 2, 23.75, 9);
call p_insert_videogame('Bioshock 2', 17, 2, 23.75, 8);
call p_insert_videogame('Resident Evil 3: Nemesis Remake', 4, 8, 40.75, 8);
call p_insert_videogame('Resident Evil 3: Nemesis Remake', 5, 8, 43.75, 7);
call p_insert_videogame('Resident Evil 2 Remake', 4, 8, 35.75, 7);
call p_insert_videogame('Resident Evil 2 Remake', 5, 8, 38.75, 2);
call p_insert_videogame('Dino Crisis', 14, 8, 50.10, 2);
call p_insert_videogame('Age of Empire', 14, 31, 25.75, 5);
call p_insert_videogame('Age of Empire 2', 14, 31, 25.75, 9);
call p_insert_videogame('Age of Mythology', 14, 31, 30.50, 14);
call p_insert_videogame('Pokemon Sun & Moon', 23, 15, 10.75, 21);
call p_insert_videogame('Pokemon Sun & Moon', 24, 15, 15.75, 5);
call p_insert_videogame('Pokemon Monsters Omega Ruby & Alpha Sapphire', 23, 15, 30.75, 3);
call p_insert_videogame('Yu-Gi-Oh! Duel Links', 14, 39, 10.20, 2);

-- NOTE: FINAL COMMIT;
commit;

-- [SYSTEM: END OF SCRIPT]