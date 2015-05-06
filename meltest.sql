-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 06 2015 г., 20:12
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.4.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `meltest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Car_type`
--

CREATE TABLE IF NOT EXISTS `Car_type` (
  `ID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `Title` char(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `Car_type`
--

INSERT INTO `Car_type` (`ID`, `Title`) VALUES
(1, 'СНГ'),
(2, 'Иномарки Европа'),
(3, 'Иномарки Азия'),
(4, 'Иномарки США'),
(5, 'Все');

-- --------------------------------------------------------

--
-- Структура таблицы `Cities`
--

CREATE TABLE IF NOT EXISTS `Cities` (
  `ID` smallint(6) NOT NULL AUTO_INCREMENT,
  `Title` char(80) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `Cities`
--

INSERT INTO `Cities` (`ID`, `Title`) VALUES
(1, 'Москва'),
(2, 'Санкт-Петербург');

-- --------------------------------------------------------

--
-- Структура таблицы `Objects`
--

CREATE TABLE IF NOT EXISTS `Objects` (
  `ID` smallint(6) NOT NULL AUTO_INCREMENT,
  `User_id` tinyint(4) NOT NULL,
  `Title` char(255) NOT NULL,
  `City_id` tinyint(4) NOT NULL,
  `Address` char(255) NOT NULL,
  `Phone` char(20) NOT NULL,
  `Email` char(25) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Text` text NOT NULL,
  `Object_id` tinyint(4) NOT NULL,
  `Car_id` tinyint(4) NOT NULL,
  `Lat_map` varchar(255) NOT NULL COMMENT 'Долгота',
  `Lng_map` varchar(255) NOT NULL COMMENT 'Широта',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `Objects`
--

INSERT INTO `Objects` (`ID`, `User_id`, `Title`, `City_id`, `Address`, `Phone`, `Email`, `Description`, `Text`, `Object_id`, `Car_id`, `Lat_map`, `Lng_map`) VALUES
(1, 9, 'РегионМАЗ ООО', 1, 'Проспект Вернадского, 78', '(495)123-45-78', 'mail@mail.ru', 'Краткое описание оказываемых услуг', '0', 2, 3, '37.480391', '55.670026'),
(2, 9, 'Камаз', 1, 'Чистопрудный бульвар 4', '(499)456-78-96', 'mail@mail.com', 'Краткое описание', '0', 1, 2, '37.639437', '55.763888'),
(3, 9, 'СпбАвто', 2, 'Лиговский проспект, 18', '(812)513-16-17', 'hhhh@mail.ru', 'Краткое описание наших услуг находится в разработке', '0', 2, 4, '30.361062', '59.929556');

-- --------------------------------------------------------

--
-- Структура таблицы `Object_type`
--

CREATE TABLE IF NOT EXISTS `Object_type` (
  `ID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `Title` char(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `Object_type`
--

INSERT INTO `Object_type` (`ID`, `Title`) VALUES
(1, 'Автосервис'),
(2, 'Магазин'),
(3, 'Все');

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `ID` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Login` char(15) NOT NULL COMMENT 'Login',
  `Password` char(32) NOT NULL COMMENT 'Password',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`ID`, `Login`, `Password`) VALUES
(9, 'pembrock', '202cb962ac59075b964b07152d234b70');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
