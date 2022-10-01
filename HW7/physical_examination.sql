-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2020-12-09 12:19:10
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
-- 資料庫： `student`
--

-- --------------------------------------------------------

--
-- 資料表結構 `physical examination`
--

CREATE TABLE `physical examination` (
  `student ID` varchar(10) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `birthdate` date NOT NULL,
  `height` float NOT NULL,
  `weight` float NOT NULL,
  `vision_of_left_eye` float NOT NULL,
  `vision_of_right_eye` float NOT NULL,
  `waistline` float NOT NULL,
  `scoliosis` tinyint(1) NOT NULL,
  `age` int(11) NOT NULL,
  `BMI` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `physical examination`
--

INSERT INTO `physical examination` (`student ID`, `gender`, `birthdate`, `height`, `weight`, `vision_of_left_eye`, `vision_of_right_eye`, `waistline`, `scoliosis`, `age`, `BMI`) VALUES
('109001', 'male', '2000-04-25', 1.782, 73.5, 0.5, 0.7, 84.5, 1, 20, 23.146),
('109002', 'male', '2001-08-14', 1.749, 68.4, 0.7, 0.3, 78.6, 0, 19, 22.36),
('109003', 'female', '2000-11-23', 1.624, 48.3, 0.7, 0.6, 63.5, 0, 20, 18.314),
('109004', 'male', '2001-06-08', 1.807, 84.5, 1, 0.9, 91.2, 1, 19, 25.879),
('109005', 'female', '2000-12-25', 1.673, 60.4, 0.4, 0.3, 70.4, 0, 19, 21.58),
('109006', 'male', '2001-03-11', 1.767, 79.4, 0.4, 0.6, 80.3, 0, 19, 25.43),
('109007', 'female', '2000-09-03', 1.593, 50.6, 0.7, 1, 81.3, 0, 20, 19.94),
('109008', 'male', '2000-12-04', 1.697, 67.3, 0.8, 0.9, 84.3, 1, 20, 23.37),
('109009', 'male', '2001-08-22', 1.793, 70.8, 0.4, 0.2, 79.5, 0, 19, 22.023),
('109010', 'female', '2001-06-27', 1.634, 52.7, 0.3, 0.2, 60.4, 0, 19, 19.738);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
