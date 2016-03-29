-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 29 2016 г., 19:02
-- Версия сервера: 5.6.26
-- Версия PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `lawyer`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('administrator', '11', 1450805099),
('chief', '9', 1450805097),
('lawyer', '10', 1450805098);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('administrator', 1, NULL, NULL, NULL, 1450803658, 1450803658),
('BasicAdmin', 2, 'Can manage roles', NULL, NULL, 1450804807, 1450804807),
('BasicInsuranceCreate', 2, 'Can create Work', NULL, NULL, 1459267424, 1459267424),
('BasicInsuranceDelete', 2, 'Can delete Work', NULL, NULL, 1459267424, 1459267424),
('BasicInsuranceIndex', 2, 'Can view Work list', NULL, NULL, 1459267424, 1459267424),
('BasicInsuranceUpdate', 2, 'Can update Work', NULL, NULL, 1459267424, 1459267424),
('BasicInsuranceView', 2, 'Can view Work', NULL, NULL, 1459267424, 1459267424),
('BasicLawCreate', 2, 'Can create Law', NULL, NULL, 1450804807, 1450804807),
('BasicLawDelete', 2, 'Can delete Law', NULL, NULL, 1450804808, 1450804808),
('BasicLawIndex', 2, 'Can view Law list', NULL, NULL, 1450804807, 1450804807),
('BasicLawUpdate', 2, 'Can update Law', NULL, NULL, 1450804808, 1450804808),
('BasicLawView', 2, 'Can view Law', NULL, NULL, 1450804807, 1450804807),
('BasicUsersCreate', 2, 'Can create/registration user', NULL, NULL, 1450804807, 1450804807),
('BasicUsersDelete', 2, 'Can delete user', NULL, NULL, 1450804807, 1450804807),
('BasicUsersIndex', 2, 'Can view users list', NULL, NULL, 1450804807, 1450804807),
('BasicUsersUpdate', 2, 'Can update user+password', NULL, NULL, 1450804807, 1450804807),
('BasicUsersView', 2, 'Can view user', NULL, NULL, 1450804807, 1450804807),
('BasicWorkCreate', 2, 'Can create Work', NULL, NULL, 1450804808, 1450804808),
('BasicWorkDelete', 2, 'Can delete Work', NULL, NULL, 1450804808, 1450804808),
('BasicWorkIndex', 2, 'Can view Work list', NULL, NULL, 1450804808, 1450804808),
('BasicWorkUpdate', 2, 'Can update Work', NULL, NULL, 1450804808, 1450804808),
('BasicWorkView', 2, 'Can view Work', NULL, NULL, 1450804808, 1450804808),
('chief', 1, NULL, NULL, NULL, 1450803658, 1450803658),
('guest', 1, NULL, NULL, NULL, 1450803658, 1450803658),
('lawyer', 1, NULL, NULL, NULL, 1450803658, 1450803658);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('administrator', 'BasicAdmin'),
('chief', 'BasicInsuranceCreate'),
('chief', 'BasicInsuranceDelete'),
('chief', 'BasicInsuranceIndex'),
('chief', 'BasicInsuranceUpdate'),
('chief', 'BasicInsuranceView'),
('chief', 'BasicLawCreate'),
('lawyer', 'BasicLawCreate'),
('chief', 'BasicLawDelete'),
('lawyer', 'BasicLawDelete'),
('chief', 'BasicLawIndex'),
('lawyer', 'BasicLawIndex'),
('chief', 'BasicLawUpdate'),
('lawyer', 'BasicLawUpdate'),
('chief', 'BasicLawView'),
('lawyer', 'BasicLawView'),
('administrator', 'BasicUsersCreate'),
('guest', 'BasicUsersCreate'),
('administrator', 'BasicUsersDelete'),
('administrator', 'BasicUsersIndex'),
('chief', 'BasicUsersIndex'),
('administrator', 'BasicUsersUpdate'),
('administrator', 'BasicUsersView'),
('chief', 'BasicUsersView'),
('lawyer', 'BasicWorkCreate'),
('lawyer', 'BasicWorkDelete'),
('lawyer', 'BasicWorkIndex'),
('lawyer', 'BasicWorkUpdate'),
('lawyer', 'BasicWorkView');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `data_attachments`
--

CREATE TABLE IF NOT EXISTS `data_attachments` (
  `id` int(11) NOT NULL,
  `model_class` varchar(32) NOT NULL,
  `model_id` int(11) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `default` int(11) DEFAULT '0' COMMENT 'Для определения логотипа у News и Infosys',
  `attachment` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Attachments';

-- --------------------------------------------------------

--
-- Структура таблицы `data_comments`
--

CREATE TABLE IF NOT EXISTS `data_comments` (
  `id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `model_class` varchar(32) NOT NULL,
  `model_id` int(11) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `state` int(11) DEFAULT NULL,
  `title` text,
  `txt` text NOT NULL,
  `attachment` varchar(256) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `insurance`
--

CREATE TABLE IF NOT EXISTS `insurance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `law`
--

CREATE TABLE IF NOT EXISTS `law` (
  `id` int(11) NOT NULL,
  `number` text NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `publicate_at` date NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `law`
--

INSERT INTO `law` (`id`, `number`, `name`, `description`, `publicate_at`, `create_at`) VALUES
(2, 'Статья 272.', 'Неправомерный доступ к компьютерной информации', '1. Неправомерный доступ к охраняемой законом компьютерной информации, если это деяние повлекло уничтожение, блокирование, модификацию либо копирование компьютерной информации, -\r\nнаказывается штрафом в размере до двухсот тысяч рублей или в размере заработной платы или иного дохода осужденного за период до восемнадцати месяцев, либо исправительными работами на срок до одного года, либо ограничением свободы на срок до двух лет, либо принудительными работами на срок до двух лет, либо лишением свободы на тот же срок.\r\n2. То же деяние, причинившее крупный ущерб или совершенное из корыстной заинтересованности, -\r\nнаказывается штрафом в размере от ста тысяч до трехсот тысяч рублей или в размере заработной платы или иного дохода осужденного за период от одного года до двух лет, либо исправительными работами на срок от одного года до двух лет, либо ограничением свободы на срок до четырех лет, либо принудительными работами на срок до четырех лет, либо лишением свободы на тот же срок.\r\n(в ред. Федерального закона от 28.06.2014 N 195-ФЗ)\r\n(см. текст в предыдущей редакции)\r\n3. Деяния, предусмотренные частями первой или второй настоящей статьи, совершенные группой лиц по предварительному сговору или организованной группой либо лицом с использованием своего служебного положения, -\r\nнаказываются штрафом в размере до пятисот тысяч рублей или в размере заработной платы или иного дохода осужденного за период до трех лет с лишением права занимать определенные должности или заниматься определенной деятельностью на срок до трех лет, либо ограничением свободы на срок до четырех лет, либо принудительными работами на срок до пяти лет, либо лишением свободы на тот же срок.\r\n4. Деяния, предусмотренные частями первой, второй или третьей настоящей статьи, если они повлекли тяжкие последствия или создали угрозу их наступления, -\r\nнаказываются лишением свободы на срок до семи лет.\r\nПримечания. 1. Под компьютерной информацией понимаются сведения (сообщения, данные), представленные в форме электрических сигналов, независимо от средств их хранения, обработки и передачи.\r\n2. Крупным ущербом в статьях настоящей главы признается ущерб, сумма которого превышает один миллион рублей.', '2015-12-30', '2016-03-29 15:17:25');

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1450801286),
('m140506_102106_rbac_init', 1450801293),
('m151215_173740_create_roles', 1450803658),
('m151215_173814_init_permission', 1450804808),
('m151216_060100_add_users', 1450805099),
('m160329_123814_update_permission', 1459267424);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `status` enum('new','active','disabled') NOT NULL,
  `avatar_id` int(11) DEFAULT NULL,
  `username` varchar(64) NOT NULL,
  `password_hash` varchar(128) NOT NULL,
  `email` varchar(64) NOT NULL,
  `phone` varchar(64) NOT NULL,
  `fio` tinytext NOT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `online_at` timestamp NULL DEFAULT NULL,
  `auth_key` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `status`, `avatar_id`, `username`, `password_hash`, `email`, `phone`, `fio`, `create_at`, `online_at`, `auth_key`) VALUES
(9, 'new', NULL, 'chief', '$2y$13$eYP75ze7hFl.tbyXZ2Rf7.wIDU.8IevXW9sQuM5kamO0LYDpUsjue', 'chief@test.ru', '+79001112233', 'chief', '2015-12-22 17:24:57', NULL, ''),
(10, 'new', NULL, 'lawyer', '$2y$13$Xki19TTGYgPOjr9ZWOQGj.2ij7A.IgTmXbG8hHYJHQ2XyR/UaGC.q', 'lawyer@test.ru', '+79001112233', 'lawyer', '2015-12-22 17:24:58', NULL, ''),
(11, 'new', NULL, 'administrator', '$2y$13$yrYw91qaIVnPrXlRA4dVhuPzR3cZaLADwj7o9EcWdQ0J3X8wsEUN6', 'administrator@test.ru', '+79001112233', 'administrator', '2015-12-22 17:24:59', NULL, '');

-- --------------------------------------------------------

--
-- Структура таблицы `work`
--

CREATE TABLE IF NOT EXISTS `work` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text,
  `insurance_id` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `done_at` timestamp NULL DEFAULT NULL,
  `max_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `data_attachments`
--
ALTER TABLE `data_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `belongs_index` (`model_id`);

--
-- Индексы таблицы `data_comments`
--
ALTER TABLE `data_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_data_comments_users` (`user_id`);

--
-- Индексы таблицы `insurance`
--
ALTER TABLE `insurance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_insurance_users` (`user_id`);

--
-- Индексы таблицы `law`
--
ALTER TABLE `law`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_users_data_attachments` (`avatar_id`);

--
-- Индексы таблицы `work`
--
ALTER TABLE `work`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_work_insurance` (`insurance_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `data_attachments`
--
ALTER TABLE `data_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `data_comments`
--
ALTER TABLE `data_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `insurance`
--
ALTER TABLE `insurance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `law`
--
ALTER TABLE `law`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `work`
--
ALTER TABLE `work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `data_comments`
--
ALTER TABLE `data_comments`
  ADD CONSTRAINT `FK_data_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `insurance`
--
ALTER TABLE `insurance`
  ADD CONSTRAINT `FK_insurance_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `insurance_ibfk_1` FOREIGN KEY (`id`) REFERENCES `data_attachments` (`model_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_data_attachments` FOREIGN KEY (`avatar_id`) REFERENCES `data_attachments` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `work`
--
ALTER TABLE `work`
  ADD CONSTRAINT `FK_work_insurance` FOREIGN KEY (`insurance_id`) REFERENCES `insurance` (`id`),
  ADD CONSTRAINT `work_ibfk_1` FOREIGN KEY (`id`) REFERENCES `data_attachments` (`model_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
