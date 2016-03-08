CREATE DATABASE LoginDB;

CREATE TABLE Users (
  fName VARCHAR(30) NOT NULL,
  lName VARCHAR(30) NOT NULL,
  userMail VARCHAR(30) NOT NULL,
  userName VARCHAR(50) NOT NULL PRIMARY KEY,
  passwrd VARCHAR(50) NOT NULL

);

CREATE TABLE Posts (
	postId INT AUTO_INCREMENT PRIMARY KEY,
	userName VARCHAR(30) NOT NULL,
	publishDate DATE,
	commentText TEXT,
	FOREIGN KEY(userName) REFERENCES Users(userName)
);

INSERT INTO Users(fName, lName, userMail, userName, passwrd)
VALUES  ('Alfredo', 'Salazar', 'alfred@gmail.com','alfredo08', 'alfred90'),
		('David', 'Quilla', 'dquilla@gmail.com','dquilla', '123dquilla');
