DROP TABLE if EXISTS `users`;
CREATE TABLE `users`(
	`id` int(11) NOT NULL AUTO_INCREMENT, 
	`username` varchar(250) default NULL,
	`email` varchar(250) default NULL,
	`password` varchar(250) default NULL,
	`fullname` varchar(250) default NULL,
	`dob` date,
	PRIMARY KEY(id) 
);


DROP TABLE if EXISTS `posts`;
CREATE TABLE `posts`(
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(250) default NULL,
	`body` text default NULL,
	`publishDate` date,
	`userId` int(11),
	PRIMARY KEY(id),
	FOREIGN KEY(userId) REFERENCES users(id)
);