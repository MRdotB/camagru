CREATE DATABASE IF NOT EXISTS `bc_camagru`;

CREATE TABLE `Users` (
	`id` int NOT NULL,
	`username` varchar NOT NULL UNIQUE,
	`email` varchar NOT NULL UNIQUE,
	`password` varchar NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `images` (
	`id` int NOT NULL,
	`path` varchar NOT NULL,
	`user_id` bigint NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `comments` (
	`id` int NOT NULL,
	`title` varchar NOT NULL,
	`text` longtext NOT NULL,
	`image_id` int NOT NULL,
	`user_id` int NOT NULL,
	`date` DATE NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `like` (
	`id` int NOT NULL,
	`image_id` int NOT NULL,
	`user_id` int NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `images` ADD CONSTRAINT `images_fk0` FOREIGN KEY (`user_id`) REFERENCES `Users`(`id`);

ALTER TABLE `comments` ADD CONSTRAINT `comments_fk0` FOREIGN KEY (`image_id`) REFERENCES `images`(`id`);

ALTER TABLE `comments` ADD CONSTRAINT `comments_fk1` FOREIGN KEY (`user_id`) REFERENCES `Users`(`id`);

ALTER TABLE `like` ADD CONSTRAINT `like_fk0` FOREIGN KEY (`image_id`) REFERENCES `images`(`id`);

ALTER TABLE `like` ADD CONSTRAINT `like_fk1` FOREIGN KEY (`user_id`) REFERENCES `Users`(`id`);
