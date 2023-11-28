-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Ноя 28 2023 г., 16:46
-- Версия сервера: 10.5.12-MariaDB-0+deb11u1
-- Версия PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ServiceDesk`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

CREATE TABLE `comment` (
  `id_comment` int(11) NOT NULL,
  `id_tack` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `message` text NOT NULL,
  `dt_message` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `comment`
--

INSERT INTO `comment` (`id_comment`, `id_tack`, `id_user`, `message`, `dt_message`) VALUES
(1, 5, 1, 'asd', '2023-04-24 16:44:27'),
(2, 4, 1, 'где?', '2023-04-24 16:46:04'),
(3, 4, 1, 'тут?', '2023-04-24 16:51:43'),
(4, 5, 1, 'Привет', '2023-04-28 10:10:58'),
(5, 5, 1, '123', '2023-04-28 10:11:32'),
(6, 5, 1, '123', '2023-04-28 10:12:22'),
(7, 5, 1, '123', '2023-04-28 10:12:55'),
(8, 5, 1, '123', '2023-04-28 10:12:57'),
(9, 5, 1, '123', '2023-05-02 12:20:20'),
(10, 5, 1, 'd', '2023-05-02 12:21:04'),
(11, 5, 1, '3', '2023-05-02 12:22:23'),
(12, 1, 1, '213', '2023-09-28 16:53:14'),
(13, 1, 1, '123', '2023-09-28 16:53:15');

-- --------------------------------------------------------

--
-- Структура таблицы `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `id_tack` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `dt_status` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `log`
--

INSERT INTO `log` (`id_log`, `id_tack`, `status`, `dt_status`) VALUES
(1, 1, 0, '2023-04-24 10:58:38'),
(2, 2, 0, '2023-04-24 10:58:38'),
(3, 3, 0, '2023-04-24 11:01:30'),
(4, 3, 1, '2023-04-24 13:09:12'),
(5, 1, 2, '2023-04-24 13:09:19'),
(6, 4, 0, '2023-04-24 13:58:49'),
(7, 5, 0, '2023-04-24 14:00:40'),
(8, 5, 1, '2023-04-24 14:59:35'),
(9, 2, 1, '2023-04-28 09:42:02'),
(10, 5, 1, '2023-04-28 09:58:05'),
(11, 4, 2, '2023-04-28 10:41:37');

-- --------------------------------------------------------

--
-- Структура таблицы `pc`
--

CREATE TABLE `pc` (
  `id_pc` int(11) NOT NULL,
  `inv` int(11) NOT NULL,
  `place` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `pc`
--

INSERT INTO `pc` (`id_pc`, `inv`, `place`) VALUES
(1, 456890, '35к'),
(2, 456234, '36к'),
(3, 456113, '35к'),
(4, 451233, '38к'),
(5, 455341, '35к'),
(6, 455123, '36к'),
(7, 451234, '45к'),
(8, 452236, '34к'),
(9, 454567, '43к');

-- --------------------------------------------------------

--
-- Структура таблицы `tack`
--

CREATE TABLE `tack` (
  `id_tack` int(11) NOT NULL,
  `id_owner` int(11) NOT NULL,
  `id_pc` int(11) NOT NULL,
  `id_executor` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `DT_create` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `tack`
--

INSERT INTO `tack` (`id_tack`, `id_owner`, `id_pc`, `id_executor`, `message`, `DT_create`) VALUES
(1, 1, 5, 5, 'Не показывает монитор', '2023-04-24 10:58:37'),
(2, 8, 1, 4, 'Не включается', '2023-04-24 10:58:38'),
(3, 5, 2, 3, 'Пропылесосить системник!', '2023-04-24 11:01:30'),
(4, 1, 3, 3, 'Горит!', '2023-04-24 13:58:49'),
(5, 2, 2, 4, 'Установить Office', '2023-04-24 14:00:40');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `pass` varchar(300) NOT NULL,
  `fio` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `role` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `fio`, `address`, `telephone`, `role`) VALUES
(1, 'admin', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Кошелев Даниил Николаевич', '167000, Респ. Коми, г. Сыктывкар, ул. Коммунистическая, д. 28', '23-48-32', 1),
(2, 'user', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Назаров Савелий Владимирович', NULL, '123', 0),
(3, 'admin2', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Назаров Савелий Владимирович', NULL, '123-123-123', 1),
(4, 'admin3', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Грачев Леонид Сергеевич', NULL, NULL, 1),
(5, 'admin4', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Петрова Александра Константиновна', NULL, NULL, 1),
(6, 'user1', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Кириллова Милана Марсельевна', NULL, NULL, 0),
(7, 'user2', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Широков Яков Михайлович', NULL, NULL, 0),
(8, 'user3', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Алексеева Амина Алексеевна', NULL, NULL, 0),
(9, 'user4', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Новиков Матвей Евгеньевич', NULL, NULL, 0),
(10, 'user5', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Борисова Таисия Артёмовна', NULL, NULL, 0),
(11, 'user6', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Левина Ксения Захаровна', NULL, NULL, 0),
(12, 'user7', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Лазарев Игорь Матвеевич', NULL, NULL, 0),
(13, 'user8', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Александрова Анна Глебовна', NULL, NULL, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `id_tack` (`id_tack`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_tack` (`id_tack`);

--
-- Индексы таблицы `pc`
--
ALTER TABLE `pc`
  ADD PRIMARY KEY (`id_pc`);

--
-- Индексы таблицы `tack`
--
ALTER TABLE `tack`
  ADD PRIMARY KEY (`id_tack`),
  ADD KEY `id_owner` (`id_owner`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comment`
--
ALTER TABLE `comment`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `pc`
--
ALTER TABLE `pc`
  MODIFY `id_pc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `tack`
--
ALTER TABLE `tack`
  MODIFY `id_tack` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id_tack`) REFERENCES `tack` (`id_tack`);

--
-- Ограничения внешнего ключа таблицы `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`id_tack`) REFERENCES `tack` (`id_tack`);

--
-- Ограничения внешнего ключа таблицы `tack`
--
ALTER TABLE `tack`
  ADD CONSTRAINT `tack_ibfk_1` FOREIGN KEY (`id_owner`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
