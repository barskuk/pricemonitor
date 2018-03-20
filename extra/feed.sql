-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Мар 20 2018 г., 15:59
-- Версия сервера: 10.1.25-MariaDB
-- Версия PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pricecheck`
--

-- --------------------------------------------------------

--
-- Структура таблицы `feed`
--

CREATE TABLE `feed` (
  `id` int(11) NOT NULL,
  `url` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `mode` varchar(45) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `auto` tinyint(4) DEFAULT NULL,
  `campaign_id` int(11) NOT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `feed`
--

INSERT INTO `feed` (`id`, `url`, `type`, `mode`, `is_active`, `auto`, `campaign_id`, `create_time`) VALUES
(3, 'http://wa.loc/yandexmarket/74396907-ae80-48be', 'yml', 'add', 1, 1, 19, '2018-03-20 14:33:39');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`id`,`campaign_id`),
  ADD KEY `fk_feed_campaign1_idx` (`campaign_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `feed`
--
ALTER TABLE `feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `feed`
--
ALTER TABLE `feed`
  ADD CONSTRAINT `fk_feed_campaign1` FOREIGN KEY (`campaign_id`) REFERENCES `campaign` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
