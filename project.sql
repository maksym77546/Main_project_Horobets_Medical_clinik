-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Квт 15 2026 р., 14:57
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
(1, 'Програмування'),
(2, 'Архітектура ПК'),
(3, 'Вебдизайн'),
(4, 'AI'),
(5, 'Команда');

-- --------------------------------------------------------

--
-- Структура таблиці `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `image` text NOT NULL,
  `content` text NOT NULL,
  `datetime` date NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `news`
--

INSERT INTO `news` (`id`, `title`, `image`, `content`, `datetime`, `menu_id`) VALUES
(1, 'GPU на орбіті: канадський стартап побудував перший у світі комерційний дата-центр у космосі', 'https://itc.ua/wp-content/uploads/2026/04/Depositphotos_541095798_L-835x557.jpg', 'Найбільший на сьогодні обчислювальний дата-центр на орбіті від канадської компанії Kepler Communications вже має 18 клієнтів. Вчора вона оголосила про найновішого — Sophia Space, стартап, який тестуватиме програмне забезпечення для свого унікального орбітального комп’ютера на борту сузір’я Kepler.\r\n\r\nПопри весь галас навколо дата-центрів у космосі, там досі не так багато GPU. Але поки це починає змінюватися, короткострокова бізнес-модель орбітальних обчислень починає набувати конкретних обрисів. Кластер Kepler був запущений у січні й налічує близько 40 локальних процесорів NVIDIA Orin на борту 10 діючих супутників, усі з’єднаних між собою лазерними лініями зв’язку.\r\n\r\nЕксперти очікують, що великомасштабні дата-центри на кшталт тих, що задумані SpaceX чи Blue Origin, з’являться не раніше 2030-х років. Першим кроком стане обробка даних, зібраних на орбіті, для підвищення можливостей космічних сенсорів, якими користуються приватні компанії та державні відомства.\r\n\r\n“Kepler не вважає себе компанією з дата-центрів, а радше інфраструктурою для космічних застосунків”, — розповіла виданню TechCrunch генеральна директорка Міна Мітрі.\r\n\r\nКомпанія хоче стати прошарком, що надає мережеві послуги іншим супутникам у космосі або безпілотникам і літакам у небі нижче. Sophia, своєю чергою, розробляє космічні комп’ютери з пасивним охолодженням, які могли б вирішити одну з ключових проблем для великомасштабних дата-центрів на орбіті: запобігати перегріву потужних процесорів без необхідності будувати й виводити на орбіту важкі та дорогі системи активного охолодження.\r\n\r\nАрхітектура мережі Kepler розроблена з урахуванням відмовостійкості: якщо окремий вузол-супутник виходить з ладу, програмно визначена маршрутизація мережі може перенаправити обчислювальні задачі на інші вузли кільця для збереження безперервності послуги.\r\n\r\n“Ця архітектура усуває одне з найдавніших обмежень у космічних операціях. Використовуючи інфраструктуру NVIDIA AI у нашій оптичній мережі, дані можна обробляти, маршрутизувати й використовувати безпосередньо на орбіті — замість того, щоб чекати їх повернення на Землю”, — каже Мітрі.\r\n\r\nУ рамках нового партнерства Sophia завантажить свою власну операційну систему на один із супутників Kepler і спробує запустити та налаштувати її на шести GPU двох космічних апаратів. У наземному дата-центрі це буденна операція, і вперше вона здійснюватиметься на орбіті. Перевірка роботи програмного забезпечення в умовах орбіти стане ключовим заходом зі зниження ризиків для Sophia перед запланованим першим власним супутником наприкінці 2027 року.', '2026-04-14', 2),
(2, 'Китайський прорив: Huawei випереджає Apple та Samsung із запуском унікального складаного смартфона Pura X Max', 'https://itc.ua/wp-content/uploads/2026/04/Huawei-Pura-X-Max-render-2-835x513.jpg', 'Компанія Huawei офіційно підтвердила запуск свого нового флагмана Pura X Max у Китаї, який стане першим у світі горизонтально-широким складаним смартфоном. Новинка пропонує унікальний форм-фактор, що наближає пристрій за габаритами до компактних планшетів.\r\n\r\nЗгідно з офіційними даними, оприлюдненими 13 квітня 2026 року, пристрій отримає внутрішній дисплей діагоналлю 7.69 дюйма зі співвідношенням сторін 16:10. Зовнішній екран на 5.5 дюйма дозволяє комфортно виконувати щоденні завдання, не розгортаючи смартфон.\r\n\r\nТакий підхід суттєво відрізняється від звичних гнучких гаджетів, які у складеному стані мають витягнуту форму. Huawei Pura X Max більше нагадує оригінальний Google Pixel Fold або iPad mini, що робить перегляд відео та роботу з документами значно зручнішими.\r\nТехнічне серце новинки — новий дев’ятипіксельний чипсет Kirin 9030. Смартфон вийде у кількох конфігураціях пам’яті: від 12/256 ГБ до топової версії Collector’s Edition на 16 ГБ оперативної та 1 ТБ постійної пам’яті.\r\n\r\nОкрему увагу приділено камері. Пристрій оснащено системою XMAGE з трьома сенсорами, серед яких виділяється покращений телеоб’єктив із технологією Red Maple. Це дозволяє отримувати професійну якість знімків навіть при складному освітленні.', '2026-04-15', 3),
(3, 'Це тестова новина для перевірки', 'https://upload.wikimedia.org/wikipedia/commons/1/15/Cat_August_2010-4.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2026-04-15', 1);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `news`
--
ALTER TABLE `news`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблиці `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
