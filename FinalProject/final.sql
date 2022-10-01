-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-01-08 11:29:12
-- 伺服器版本： 10.4.16-MariaDB
-- PHP 版本： 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `final`
--

-- --------------------------------------------------------

--
-- 資料表結構 `class`
--

CREATE TABLE `class` (
  `class` text NOT NULL,
  `password` text NOT NULL,
  `TeacherID` text NOT NULL,
  `time` time NOT NULL,
  `bool` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `class`
--

INSERT INTO `class` (`class`, `password`, `TeacherID`, `time`, `bool`) VALUES
('123', '0000', '', '17:49:00', 0),
('666', '456', '', '06:56:00', 0),
('99', '0000', 'undefined', '18:58:00', 0),
('6666', '456', '', '18:04:00', 0),
('655', '0000', '', '20:08:00', 0),
('8888', '0000', '', '18:12:00', 0),
('999', '0000', 'ID', '18:12:00', 0),
('789789', '0000', 'undefined', '18:15:00', 0),
('6545', '0000', '1230', '18:30:00', 1),
('33666', '456', '1230', '07:33:00', 0),
('6996', '456', '1230', '11:34:00', 1),
('123456', '456', 'undefined', '18:40:00', 0),
('12366', '0000', '1230', '18:43:00', 1),
('6669999', '456', '1230', '08:39:00', 0),
('69658', '123456', '1230', '21:21:00', 0),
('475', '456', '1230', '09:31:00', 1),
('test', '0000', '1230', '15:48:00', 0),
('7777', '123', '1230', '08:00:00', 1),
('9685', '1234', '123568743', '16:26:00', 0),
('9966', '456', '1230', '15:38:00', 0),
('12389', '789', '1230', '18:12:00', 0),
('09999', '789', '1230', '19:13:00', 0),
('456', '9999', '1230', '19:14:00', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `roll`
--

CREATE TABLE `roll` (
  `class` text NOT NULL,
  `ID` text NOT NULL,
  `Longitude` text NOT NULL,
  `Latitude` text NOT NULL,
  `time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `roll`
--

INSERT INTO `roll` (`class`, `ID`, `Longitude`, `Latitude`, `time`) VALUES
('6996', '1230', '121.56542680000001', '25.0329636', '00:00:00'),
('6996', '1230', '121.56542680000001', '25.0329636', '00:00:00'),
('6669999', '1230', '121.56542680000001', '25.0329636', 'Thu Jan 07 2021 02:58:45 GMT+0800 (台北標準時間)'),
('69658', '1230', '121.56542680000001', '25.0329636', 'Thu Jan 07 2021 03:13:13 GMT+0800 (台北標準時間)'),
('6996', '1230', '121.56542680000001', '25.0329636', 'Thu Jan 07 2021 03:19:00 GMT+0800 (台北標準時間)'),
('6545', '1230', '121.56542680000001', '25.0329636', 'Thu Jan 07 2021 07:11:09 GMT+0800 (台北標準時間)'),
('6545', '1230', '120.67364819999999', '24.1477358', 'Thu Jan 07 2021 08:31:27 GMT+0800 (台北標準時間)'),
('475', '1230', '120.67364819999999', '24.1477358', 'Thu Jan 07 2021 13:50:11 GMT+0800 (台北標準時間)'),
('7777', '1230', '120.67364819999999', '24.1477358', 'Thu Jan 07 2021 14:13:09 GMT+0800 (台北標準時間)'),
('12366', '1230', '120.67364819999999', '24.1477358', 'Fri Jan 08 2021 18:22:30 GMT+0800 (台北標準時間)');

-- --------------------------------------------------------

--
-- 資料表結構 `rolls`
--

CREATE TABLE `rolls` (
  `class` text NOT NULL,
  `ID` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `rolls`
--

INSERT INTO `rolls` (`class`, `ID`, `latitude`, `longitude`, `time`) VALUES
('999', '', '25.0329636', '121.56542680000001', 'Thu Jan 07 2021 06:31:06 GMT+0800 (台北標準時間)'),
('123', '', '24.1477358', '120.67364819999999', 'Thu Jan 07 2021 06:33:37 GMT+0800 (台北標準時間)'),
('666', '123456', '25.0329636', '121.56542680000001', 'Thu Jan 07 2021 06:36:18 GMT+0800 (台北標準時間)'),
('6996', '123456', '25.0329636', '121.56542680000001', 'Thu Jan 07 2021 06:44:08 GMT+0800 (台北標準時間)'),
('6545', '41083369523', '24.1215855', '120.6726903', 'Thu Jan 07 2021 08:32:54 GMT+0800 (台北標準時間)'),
('6996', '4560', '24.1477358', '120.67364819999999', 'Thu Jan 07 2021 13:42:47 GMT+0800 (台北標準時間)'),
('6996', '4560', '24.1477358', '120.67364819999999', 'Thu Jan 07 2021 13:48:22 GMT+0800 (台北標準時間)'),
('6996', '2147483647', '24.1477358', '120.67364819999999', 'Thu Jan 07 2021 14:10:08 GMT+0800 (台北標準時間)'),
('6996', '999', '24.1477358', '120.67364819999999', 'Thu Jan 07 2021 14:12:05 GMT+0800 (台北標準時間)'),
('6545', '1237776', '24.1477358', '120.67364819999999', 'Fri Jan 08 2021 18:17:10 GMT+0800 (台北標準時間)'),
('7777', '4560', '24.1477358', '120.67364819999999', 'Fri Jan 08 2021 18:26:46 GMT+0800 (台北標準時間)');

-- --------------------------------------------------------

--
-- 資料表結構 `student`
--

CREATE TABLE `student` (
  `name` text NOT NULL,
  `ID` text NOT NULL,
  `password` text NOT NULL,
  `cellphone` text NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `student`
--

INSERT INTO `student` (`name`, `ID`, `password`, `cellphone`, `address`, `email`) VALUES
('student1', '41086332', '', '9568327', '台中市南區興大路', 'student@gmail.com'),
('student2', '41083695', '', '95863246', '台中市南區興大路123號', 'student2@gmail.com'),
('student3', '2147483647', '45832Solkuh', '96325874', '台中市南區興大路125號', 'student3@gmail.com'),
('student4', '41083369523', '2536FOhiyj', '2147483647', '台中市南區興大路125號', 'student4@gmail.com'),
('', '', '', '', '', ''),
('', '8822', '', '', '', ''),
('student1', '3333', '', '', '', ''),
('teacher1', '123456', '333333', '09568327', '台中市南區興大路125號', 'teacher@gmail.com'),
('student10', '4560', '0000', '095683247', '台中市南區興大路125號', 'student10@gmail.com'),
('student11', '999', '0000', '09583264', '台中市南區興大路127號', 'studen11t@gmail.com'),
('student13', '96555', '789456', '0985325666', '台中市南區興大路185號', 'stude6nt@gmail.com'),
('student1999', '123456789', '78456123', '09869656556', '台中市南區興大路789', 'student999@gmail.com'),
('student1999', '12345679', '9999', '09869656556', '台中市南區興大路789', 'student999@gmail.com'),
('student1', '1234787', '96', '0985326556', '台中市南區興大路', 'student@gmail.com'),
('student198', '1237776', '7777777', 'eds123', '台中市南區興大路', 'studen69t@gmail.com'),
('student198', '123776', '999', 'eds123', '台中市南區興大路', 'studen69t@gmail.com'),
('student19966', '78945633', '456445', '09523223', '台中市南區興大路125號', '456@gmail.com');

-- --------------------------------------------------------

--
-- 資料表結構 `teacher`
--

CREATE TABLE `teacher` (
  `name` text NOT NULL,
  `ID` text NOT NULL,
  `password` text NOT NULL,
  `cellphone` text NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `teacher`
--

INSERT INTO `teacher` (`name`, `ID`, `password`, `cellphone`, `address`, `email`) VALUES
('teacher1', '123456', '', '9568327', '台中市南區興大路', 'teacher@gmail.com'),
('teacher2', '1234525', '', '9865324', '台中市南區興大路123號', 'teacher2@gmail.com'),
('teacher3', '85632147', '', '9653287', '台中市南區興大路456號', 'teacher3@gmail.com'),
('teacher4', '123568743', '123695Sjiyg', '2147483647', '台中市南區興大路125號', 'teacher4@gmail.com'),
('teacher5', '1230', '0000', '09563284', '台中市南區興大路', 'teacher5@gmail.com'),
('studentf', '1235555', '999999', '09456123', '台中市南區興大路89454', 'student789@gmail.com'),
('student199', '7894546', '789456', '02121223', '台中市南區興大路', 'student999@gmail.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

# `student`@`%` 的權限

GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO `student`@`%` IDENTIFIED BY PASSWORD '*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19' WITH GRANT OPTION;

GRANT ALL PRIVILEGES ON `final`.* TO `student`@`%`;


# `teacher`@`%` 的權限

GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO `teacher`@`%` IDENTIFIED BY PASSWORD '*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19' WITH GRANT OPTION;
