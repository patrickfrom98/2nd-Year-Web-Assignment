SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `Book`;
DROP TABLE IF EXISTS `Author`;
DROP TABLE IF EXISTS `Contributor`;
DROP TABLE IF EXISTS `Review`;

CREATE TABLE `Book` (
	`bookid` INT NOT NULL AUTO_INCREMENT,
	`title` varchar(110) NOT NULL,
	`category` varchar(9) NOT NULL,
	`pages` INT NOT NULL,
	`isbn` varchar(13) NOT NULL,
	`publisher` varchar(40) NOT NULL,
	`width` FLOAT NOT NULL,
	`height` FLOAT NOT NULL,
	`style` varchar(9) NOT NULL,
	`image` varchar(60) NOT NULL,
	PRIMARY KEY (`bookid`)
);

CREATE TABLE `Author` (
	`authorid` INT NOT NULL AUTO_INCREMENT,
	`fname` varchar(20) NOT NULL,
	`lname` varchar(20) NOT NULL,
	`dob` DATE NOT NULL,
	`locality` varchar(40) NOT NULL,
	`description` varchar(800) NOT NULL,
	`image` varchar(60) NOT NULL,
	PRIMARY KEY (`authorid`)
);

CREATE TABLE `Contributor` (
	`bookid` INT NOT NULL,
	`authorid` INT NOT NULL,
	PRIMARY KEY (`bookid`,`authorid`)
);

CREATE TABLE `Review` (
	`bookid` INT NOT NULL,
	`reviewdate` DATE NOT NULL,
	`reviewer` varchar(20) NOT NULL,
	`review` varchar(400) NOT NULL,
	`rating` FLOAT NOT NULL,
	PRIMARY KEY (`bookid`,`reviewdate`)
);

ALTER TABLE `Contributor` ADD CONSTRAINT `Contributor_fk0` FOREIGN KEY (`bookid`) REFERENCES `Book`(`bookid`);

ALTER TABLE `Contributor` ADD CONSTRAINT `Contributor_fk1` FOREIGN KEY (`authorid`) REFERENCES `Author`(`authorid`);

ALTER TABLE `Review` ADD CONSTRAINT `Review_fk0` FOREIGN KEY (`bookid`) REFERENCES `Book`(`bookid`);

SET foreign_key_checks = 1;