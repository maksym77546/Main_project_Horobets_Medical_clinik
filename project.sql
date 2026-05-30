-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Тра 30 2026 р., 15:00
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

-- --------------------------------------------------------

--
-- Структура таблиці `doctor_schedule` (графік роботи лікарів)
--

CREATE TABLE `doctor_schedule` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `day_of_week` tinyint(1) NOT NULL COMMENT '1=Пн, 2=Вт, 3=Ср, 4=Чт, 5=Пт, 6=Сб, 7=Нд',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `doctor_schedule`
--

INSERT INTO `doctor_schedule` (`id`, `doctor_id`, `day_of_week`, `start_time`, `end_time`) VALUES
-- Іван Іванов (терапевт): Пн-Пт 08:00-16:00
(1, 1, 1, '08:00:00', '16:00:00'),
(2, 1, 2, '08:00:00', '16:00:00'),
(3, 1, 3, '08:00:00', '16:00:00'),
(4, 1, 4, '08:00:00', '16:00:00'),
(5, 1, 5, '08:00:00', '16:00:00'),
-- Петро Петренко (хірург): Пн, Ср, Пт 09:00-17:00, Вт, Чт 10:00-18:00
(6, 2, 1, '09:00:00', '17:00:00'),
(7, 2, 2, '10:00:00', '18:00:00'),
(8, 2, 3, '09:00:00', '17:00:00'),
(9, 2, 4, '10:00:00', '18:00:00'),
(10, 2, 5, '09:00:00', '17:00:00'),
(11, 2, 6, '09:00:00', '13:00:00'),
-- Ганна Сидоренко (діагностика): Пн-Пт 08:30-15:30, Сб 09:00-13:00
(12, 3, 1, '08:30:00', '15:30:00'),
(13, 3, 2, '08:30:00', '15:30:00'),
(14, 3, 3, '08:30:00', '15:30:00'),
(15, 3, 4, '08:30:00', '15:30:00'),
(16, 3, 5, '08:30:00', '15:30:00'),
(17, 3, 6, '09:00:00', '13:00:00');

-- --------------------------------------------------------

--
-- Структура таблиці `doctor_certificates` (сертифікати лікарів)
--

CREATE TABLE `doctor_certificates` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `issued_date` date DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `doctor_certificates`
--

INSERT INTO `doctor_certificates` (`id`, `doctor_id`, `title`, `issued_date`, `description`) VALUES
(1, 1, 'Сертифікат спеціаліста з терапії', '2020-06-15', 'Національна медична академія ім. П.Л. Шупика. Вища кваліфікаційна категорія.'),
(2, 1, 'Сертифікат з кардіології', '2022-03-10', 'Курс підвищення кваліфікації з кардіології. Інститут серцево-судинної хірургії.'),
(3, 1, 'Сертифікат з ультразвукової діагностики', '2023-09-20', 'Курс УЗД для терапевтів. Київський медичний університет.'),
(4, 2, 'Сертифікат хірурга вищої категорії', '2019-11-05', 'Національний інститут хірургії та трансплантології ім. О.О. Шалімова.'),
(5, 2, 'Сертифікат з лапароскопічної хірургії', '2021-07-22', 'Міжнародний курс малоінвазивної хірургії. European Surgical Institute.'),
(6, 2, 'Сертифікат з невідкладної медичної допомоги', '2024-01-15', 'Курс ATLS (Advanced Trauma Life Support). Українська Академія Хірургії.'),
(7, 3, 'Сертифікат спеціаліста з УЗД', '2021-04-12', 'Національна медична академія ім. П.Л. Шупика. Спеціалізація з ультразвукової діагностики.'),
(8, 3, 'Сертифікат з ехокардіографії', '2022-08-30', 'Курс підвищення кваліфікації. Інститут серцево-судинної хірургії.'),
(9, 3, 'Сертифікат з пренатальної діагностики', '2023-05-18', 'Курс фетальної медицини. Інститут педіатрії, акушерства та гінекології НАМН.');

-- --------------------------------------------------------

--
-- Структура таблиці `users` (користувачі сайту)
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

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
-- Індекси таблиці `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Індекси таблиці `doctor_certificates`
--
ALTER TABLE `doctor_certificates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
-- AUTO_INCREMENT для таблиці `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблиці `doctor_certificates`
--
ALTER TABLE `doctor_certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  ADD CONSTRAINT `doctor_schedule_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `doctor_certificates`
--
ALTER TABLE `doctor_certificates`
  ADD CONSTRAINT `doctor_certificates_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
