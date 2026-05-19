-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Тра 19 2026 р., 14:57
-- Версія сервера: 10.4.27-MariaDB
-- Версія PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `project`
--

-- --------------------------------------------------------

--
-- Структура таблиці `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `menu`
--

INSERT INTO `menu` (`id`, `title`) VALUES
(1, 'Терапія'),
(2, 'Хірургія'),
(3, 'Діагностика');

-- --------------------------------------------------------

--
-- Структура таблиці `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `doctor_name` varchar(256) NOT NULL,
  `image` text NOT NULL,
  `specialization` text NOT NULL,
  `datetime` date NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `doctors`
--

INSERT INTO `doctors` (`id`, `doctor_name`, `image`, `specialization`, `datetime`, `menu_id`) VALUES
(1, 'Іван Іванов', 'https://upload.wikimedia.org/wikipedia/commons/4/48/Outdoors-man-portrait_%28cropped%29.jpg', 'Лікар-терапевт вищої категорії. Досвід роботи понад 15 років.', '2026-05-19', 1),
(2, 'Петро Петренко', 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b3/Doctor_wearing_scrubs_and_a_stethoscope.jpg/800px-Doctor_wearing_scrubs_and_a_stethoscope.jpg', 'Провідний хірург клініки. Спеціалізується на малоінвазивних операціях.', '2026-05-19', 2),
(3, 'Ганна Сидоренко', 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/74/Doctor_with_a_stethoscope_2.jpg/800px-Doctor_with_a_stethoscope_2.jpg', 'Спеціаліст з ультразвукової діагностики. Виконує всі види УЗД.', '2026-05-19', 3);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `menu_id_2` (`menu_id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблиці `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
