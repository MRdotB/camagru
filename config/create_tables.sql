CREATE TABLE `Users` (
	`id` int NOT NULL AUTO_INCREMENT,
	`username` varchar(255) NOT NULL UNIQUE,
	`email` varchar(320) NOT NULL UNIQUE,
	`password` varchar(255) NOT NULL,
	`verify` boolean DEFAULT FALSE,
	`verif_link` int,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Images` (
	`id` int NOT NULL AUTO_INCREMENT,
	`path` varchar(255) NOT NULL,
	`user_id` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Comments` (
	`id` int NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NOT NULL,
	`text` longtext NOT NULL,
	`image_id` int NOT NULL,
	`user_id` int NOT NULL,
	`date` DATE NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Like` (
	`id` int NOT NULL AUTO_INCREMENT,
	`image_id` int NOT NULL,
	`user_id` int NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `Images` ADD CONSTRAINT `images_fk0` FOREIGN KEY (`user_id`) REFERENCES `Users`(`id`);

ALTER TABLE `Comments` ADD CONSTRAINT `comments_fk0` FOREIGN KEY (`image_id`) REFERENCES `Images`(`id`);

ALTER TABLE `Comments` ADD CONSTRAINT `comments_fk1` FOREIGN KEY (`user_id`) REFERENCES `Users`(`id`);

ALTER TABLE `Like` ADD CONSTRAINT `like_fk0` FOREIGN KEY (`image_id`) REFERENCES `Images`(`id`);

ALTER TABLE `Like` ADD CONSTRAINT `like_fk1` FOREIGN KEY (`user_id`) REFERENCES `Users`(`id`);
