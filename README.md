# exam

## REGISTER - POST
```
URL:              /kumu_exam/register  
REQUEST BODY:
{
    "username": "sample",
    "password": "P@ssw0rd123"
}

RESPONSES:
200 - OK
{
    "response": "Registration Success"
}

422 - Unprocessable Entity
500 - Internal Server Error
```

## LOGIN - POST
```
URL:              /kumu_exam/login  
REQUEST BODY:
{
    "username": "sample",
    "password": "P@ssw0rd123"
}

RESPONSES:
200 - OK
{
    "response": "User Exists"
}

200 - OK
{
    "response": "Invalid Credentials"
}

422 - Unprocessable Entity
```


## GET USER LIST - POST
```
URL:              /kumu_test/getUsers  
REQUEST HEADER:   Basic base64(username:password)  
REQUEST BODY:  

[  
  {
   "username":"a"
  },
  {
    "username":"joshpena15"
  }
]  

RESPONSES:
200 - OK
[
    {
        "name": "Shuvalov Anton",
        "login": "A",
        "company": null,
        "followers": 463,
        "public_repos": 46,
        "avg_followers": 10
    },
    {
        "name": "Joshua Peña",
        "login": "joshpena15",
        "company": null,
        "followers": 0,
        "public_repos": 2,
        "avg_followers": 0
    }
]

401 - Unauthorized
422 - Unprocessable Entity
422 - Maximum Queries Reached
```

# MYSQL SCHEMA
```
** Run the followinf MySQL Script to create Database
-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 04, 2021 at 05:21 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kumu_test`
--
CREATE DATABASE IF NOT EXISTS `kumu_test` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `kumu_test`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `login`$$
CREATE PROCEDURE `login` (IN `user` VARCHAR(1000), IN `pass` VARCHAR(1000))  BEGIN
	IF NOT EXISTS (SELECT * FROM credentials WHERE username = user AND userpassword=pass) THEN
       SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid Credentials';
    END IF;
END$$

DROP PROCEDURE IF EXISTS `register`$$
CREATE PROCEDURE `register` (IN `user` VARCHAR(1000), IN `pass` VARCHAR(1000))  BEGIN
	IF EXISTS (SELECT * FROM credentials WHERE username = user ) THEN
       SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'User Already Exists';
    ELSE
        INSERT INTO credentials (username, userpassword) VALUES (user, pass);
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

DROP TABLE IF EXISTS `credentials`;
CREATE TABLE IF NOT EXISTS `credentials` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(1000) DEFAULT NULL,
  `userpassword` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

```

# HAMMING DISTANCE
```
go to /kumu_test/hamming.html and open browser console.

```
