-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Сен 03 2018 г., 15:20
-- Версия сервера: 10.1.35-MariaDB
-- Версия PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ptodo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

CREATE TABLE `projects` (
  `IDProject` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Color` varchar(10) NOT NULL,
  `Archive` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `projects`
--

INSERT INTO `projects` (`IDProject`, `Name`, `Color`, `Archive`) VALUES
(2, 'Project1', '#0000ff', 0),
(3, 'Project12', '#00ff00', 1),
(6, 'Project11', '#00ff00', 1),
(7, 'Project10', '#ff0080', 1),
(8, 'Project3', '#008000', 0),
(9, 'Project4', '#ff0000', 0),
(11, 'Project14', '#ff0000', 1),
(13, 'Project2', '#ffff00', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `IDTask` int(11) NOT NULL,
  `IDProject` int(11) NOT NULL,
  `DeadLine` date NOT NULL,
  `IDTasksStatus` int(11) NOT NULL,
  `IDTasksPriority` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`IDTask`, `IDProject`, `DeadLine`, `IDTasksStatus`, `IDTasksPriority`, `Name`) VALUES
(1, 3, '2018-08-16', 10, 1, '12312'),
(4, 8, '2018-08-26', 1, 1, 'Task3'),
(5, 8, '2018-09-05', 1, 2, 'Task6'),
(6, 2, '2018-09-13', 1, 3, 'Task4'),
(7, 6, '2018-09-04', 10, 3, 'Task16'),
(8, 11, '2018-09-03', 10, 2, 'Task15'),
(9, 9, '2018-09-01', 1, 3, 'Task2'),
(10, 7, '2018-09-04', 10, 1, 'dasdas'),
(11, 13, '2018-08-01', 1, 3, 'Task1'),
(12, 6, '2018-09-18', 10, 1, 'tryutyuy'),
(14, 11, '2018-09-06', 10, 1, 'Task17'),
(15, 13, '2018-09-03', 1, 2, 'Task5'),
(16, 2, '2018-09-04', 1, 3, 'Task'),
(17, 8, '2018-09-04', 1, 2, 'Task7'),
(18, 8, '2018-09-06', 1, 1, 'Task8'),
(19, 13, '2018-09-04', 1, 1, 'Task9');

-- --------------------------------------------------------

--
-- Структура таблицы `taskspriority`
--

CREATE TABLE `taskspriority` (
  `IDTasksPriority` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Color` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `taskspriority`
--

INSERT INTO `taskspriority` (`IDTasksPriority`, `Name`, `Color`) VALUES
(1, 'low', '#DDDDDD'),
(2, 'mid', '#ffc125'),
(3, 'hi', '#ff3232');

-- --------------------------------------------------------

--
-- Структура таблицы `tasksstatus`
--

CREATE TABLE `tasksstatus` (
  `IDTasksStatus` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasksstatus`
--

INSERT INTO `tasksstatus` (`IDTasksStatus`, `Name`) VALUES
(1, 'Run'),
(10, 'Done');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `Hash` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`idUser`, `Name`, `email`, `pass`, `Hash`) VALUES
(9, '1', '2@2', '202cb962ac59075b964b07152d234b70', '62e62c0b38f30c8c36e26e342356b215'),
(10, '12312', 'bvb@vsesvit.pro', '202cb962ac59075b964b07152d234b70', '29b9fd841ba1997bdd28c6d0510ebda0'),
(11, 'test', 'test@test.com', '202cb962ac59075b964b07152d234b70', 'afeff225132a12a564a9d43c7ec250ec');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`IDProject`),
  ADD KEY `I_Projects1` (`Archive`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`IDTask`),
  ADD KEY `FK_tasks_Projects` (`IDProject`),
  ADD KEY `FK_tasks_TasksPriority` (`IDTasksPriority`),
  ADD KEY `I_Tasks_1` (`DeadLine`,`IDTasksStatus`),
  ADD KEY `I_Tasks_2` (`IDTasksStatus`,`DeadLine`);

--
-- Индексы таблицы `taskspriority`
--
ALTER TABLE `taskspriority`
  ADD PRIMARY KEY (`IDTasksPriority`);

--
-- Индексы таблицы `tasksstatus`
--
ALTER TABLE `tasksstatus`
  ADD PRIMARY KEY (`IDTasksStatus`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`),
  ADD KEY `I_useres` (`email`,`pass`),
  ADD KEY `I_Useres_Hash` (`Hash`) USING BTREE;

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `projects`
--
ALTER TABLE `projects`
  MODIFY `IDProject` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `IDTask` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `FK_tasks_Projects` FOREIGN KEY (`IDProject`) REFERENCES `projects` (`IDProject`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tasks_TasksPriority` FOREIGN KEY (`IDTasksPriority`) REFERENCES `taskspriority` (`IDTasksPriority`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tasks_TasksStatus` FOREIGN KEY (`IDTasksStatus`) REFERENCES `tasksstatus` (`IDTasksStatus`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
