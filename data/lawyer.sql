-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Май 31 2016 г., 12:43
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
('administrator', '30', 1464012815),
('chief', '26', 1464012812),
('lawyer', '27', 1464012813),
('lawyer', '28', 1464012814),
('lawyer', '29', 1464012814),
('lawyer', '32', 1464013727),
('lawyer', '33', 1464331690),
('lawyer', '34', 1464331947),
('lawyer', '35', 1464331996),
('lawyer', '36', 1464332171);

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
('BasicAdmin', 2, 'Can manage roles', NULL, NULL, 1464010455, 1464010455),
('BasicInsuranceCreate', 2, 'Can create Insurance', NULL, NULL, 1464010457, 1464010457),
('BasicInsuranceDelete', 2, 'Can delete Insurance', NULL, NULL, 1464010457, 1464010457),
('BasicInsuranceIndex', 2, 'Can view Insurance list', NULL, NULL, 1464010457, 1464010457),
('BasicInsuranceUpdate', 2, 'Can update Insurance', NULL, NULL, 1464010457, 1464010457),
('BasicInsuranceUpdateAll', 2, 'Can update Insurance', NULL, NULL, 1464010457, 1464010457),
('BasicInsuranceView', 2, 'Can view Insurance', NULL, NULL, 1464010457, 1464010457),
('BasicLawCreate', 2, 'Can create Law', NULL, NULL, 1464010456, 1464010456),
('BasicLawDelete', 2, 'Can delete Law', NULL, NULL, 1464010456, 1464010456),
('BasicLawIndex', 2, 'Can view Law list', NULL, NULL, 1464010456, 1464010456),
('BasicLawUpdate', 2, 'Can update Law', NULL, NULL, 1464010456, 1464010456),
('BasicLawView', 2, 'Can view Law', NULL, NULL, 1464010456, 1464010456),
('BasicNotificationsCreate', 2, 'Can create Notifications', NULL, NULL, 1464279599, 1464279599),
('BasicNotificationsIndex', 2, 'Can view Notifications list', NULL, NULL, 1464279598, 1464279598),
('BasicNotificationsIndexAll', 2, 'Can view Notifications all list', NULL, NULL, 1464279598, 1464279598),
('BasicNotificationsView', 2, 'Can view Notifications', NULL, NULL, 1464279598, 1464279598),
('BasicUsersCabinet', 2, 'Can update profile', NULL, NULL, 1464516196, 1464516196),
('BasicUsersCreate', 2, 'Can create/registration user', NULL, NULL, 1464010456, 1464010456),
('BasicUsersDelete', 2, 'Can delete user', NULL, NULL, 1464010456, 1464010456),
('BasicUsersIndex', 2, 'Can view users list', NULL, NULL, 1464010455, 1464010455),
('BasicUsersUpdate', 2, 'Can update user+password', NULL, NULL, 1464010456, 1464010456),
('BasicUsersView', 2, 'Can view user', NULL, NULL, 1464010456, 1464010456),
('BasicWorkCreate', 2, 'Can create Work', NULL, NULL, 1464010456, 1464010456),
('BasicWorkDelete', 2, 'Can delete Work', NULL, NULL, 1464010456, 1464010456),
('BasicWorkIndex', 2, 'Can view Work list', NULL, NULL, 1464010456, 1464010456),
('BasicWorkUpdate', 2, 'Can update Work', NULL, NULL, 1464010456, 1464010456),
('BasicWorkView', 2, 'Can view Work', NULL, NULL, 1464010456, 1464010456),
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
('lawyer', 'BasicInsuranceIndex'),
('chief', 'BasicInsuranceUpdate'),
('lawyer', 'BasicInsuranceUpdate'),
('chief', 'BasicInsuranceUpdateAll'),
('chief', 'BasicInsuranceView'),
('lawyer', 'BasicInsuranceView'),
('chief', 'BasicLawCreate'),
('chief', 'BasicLawDelete'),
('chief', 'BasicLawIndex'),
('lawyer', 'BasicLawIndex'),
('chief', 'BasicLawUpdate'),
('chief', 'BasicLawView'),
('lawyer', 'BasicLawView'),
('administrator', 'BasicNotificationsCreate'),
('administrator', 'BasicNotificationsIndex'),
('chief', 'BasicNotificationsIndex'),
('lawyer', 'BasicNotificationsIndex'),
('administrator', 'BasicNotificationsIndexAll'),
('administrator', 'BasicNotificationsView'),
('chief', 'BasicNotificationsView'),
('lawyer', 'BasicNotificationsView'),
('administrator', 'BasicUsersCabinet'),
('chief', 'BasicUsersCabinet'),
('lawyer', 'BasicUsersCabinet'),
('administrator', 'BasicUsersCreate'),
('chief', 'BasicUsersCreate'),
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='Attachments';

--
-- Дамп данных таблицы `data_attachments`
--

INSERT INTO `data_attachments` (`id`, `model_class`, `model_id`, `type`, `default`, `attachment`, `created`) VALUES
(1, 'Users', NULL, '', 0, '{"name":"xiVFtlaoInw.jpg","size":53024,"type":"image\\/jpeg","url":"\\/uploads\\/Users\\/xiVFtlaoInw.jpg","deleteUrl":"http:\\/\\/lawyer:8181\\/?file=xiVFtlaoInw.jpg","deleteType":"DELETE"}', '2016-05-29 10:21:41'),
(2, 'Users', NULL, '', 0, '{"name":"_ZYimeOO1M0.jpg","size":39997,"type":"image\\/jpeg","url":"\\/uploads\\/Users\\/_ZYimeOO1M0.jpg","deleteUrl":"http:\\/\\/lawyer:8181\\/?file=_ZYimeOO1M0.jpg","deleteType":"DELETE"}', '2016-05-29 10:23:08'),
(3, 'Users', NULL, '', 0, '{"name":"80N0gFRIHco.jpg","size":96552,"type":"image\\/jpeg","url":"\\/uploads\\/Users\\/80N0gFRIHco.jpg","deleteUrl":"http:\\/\\/lawyer:8181\\/?file=80N0gFRIHco.jpg","deleteType":"DELETE"}', '2016-05-29 10:37:14'),
(22, 'Law', 2, 'document', 0, '{"name":"1 (10).txt","size":3,"type":"text\\/plain","url":"\\/uploads\\/Law\\/1%20%2810%29.txt","deleteUrl":"http:\\/\\/lawyer:8181\\/?file=1%20%2810%29.txt","deleteType":"DELETE"}', '2016-05-29 13:49:17'),
(23, 'Users', NULL, 'image', 0, '{"name":"avril-lavigne-365-04.jpg","size":433955,"type":"image\\/jpeg","url":"\\/uploads\\/Users\\/avril-lavigne-365-04.jpg","deleteUrl":"http:\\/\\/lawyer:8181\\/?file=avril-lavigne-365-04.jpg","deleteType":"DELETE"}', '2016-05-30 13:02:59');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
('m151215_173814_init_permission', 1464010457),
('m151216_060100_add_users', 1464012816),
('m160526_173814_notify_permission', 1464279599),
('m160527_071029_new_permission', 1464516196);

-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `create_at`) VALUES
(15, 30, 'Новый пользователь прошел регистрацию, login:<a href="/users/view?id=36">new</a>', 0, '2016-05-27 06:56:12'),
(16, 26, 'Новый пользователь прошел регистрацию, login:<a href="/users/view?id=36">new</a>', 1, '2016-05-27 06:56:12'),
(17, 30, 'Пользователь выполнил вход в систему: chief', 0, '2016-05-27 06:56:33'),
(18, 30, 'Пользователь выполнил вход в систему: administrator', 0, '2016-05-27 07:08:37'),
(19, 30, 'Пользователь выполнил вход в систему: chief', 0, '2016-05-27 07:23:13'),
(20, 30, 'Пользователь выполнил вход в систему: administrator', 0, '2016-05-27 07:24:26'),
(21, 30, 'Пользователь выполнил вход в систему: chief', 0, '2016-05-29 12:09:13'),
(22, 30, 'Пользователь выполнил вход в систему: chief', 0, '2016-05-30 10:34:14'),
(23, 30, 'Пользователь выполнил вход в систему: lawyer', 0, '2016-05-30 10:34:34'),
(24, 30, 'Пользователь выполнил вход в систему: administrator', 0, '2016-05-31 06:40:34'),
(25, 30, 'Пользователь выполнил вход в систему: chief', 0, '2016-05-31 06:46:20');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `status` enum('new','active','disabled') NOT NULL DEFAULT 'new',
  `avatar_id` int(11) DEFAULT NULL,
  `username` varchar(64) NOT NULL,
  `password_hash` varchar(128) NOT NULL,
  `email` varchar(64) NOT NULL,
  `phone` varchar(64) NOT NULL,
  `fio` tinytext NOT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `online_at` timestamp NULL DEFAULT NULL,
  `auth_key` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `status`, `avatar_id`, `username`, `password_hash`, `email`, `phone`, `fio`, `create_at`, `online_at`, `auth_key`) VALUES
(26, 'active', NULL, 'chief', '$2y$13$hasw6tIMs5HrmRECqkLU/.Hb1DrxQ2/CEyND724ItdGpLFEHcTD86', 'chief@test.ru', '+79001112233', 'chief', '2016-05-23 14:13:32', '2016-05-31 06:46:20', ''),
(27, 'active', 23, 'lawyer', '$2y$13$.VP1oC1Zl88Jmoo1p6m5TuMuvBcG7ANqpxFzN.WSiA6GhumM731sG', 'lawyer@test.ru', '+79001112233', 'lawyer', '2016-05-23 14:13:33', '2016-05-30 13:23:34', ''),
(28, 'active', NULL, 'lawyer2', '$2y$13$8viOkcqEB7a/Dg5lHMOscO7b2DX9TUTSMxQ7wVsYldT5K5sETPgde', 'lawyer2@test.ru', '+79001112233', 'lawyer2', '2016-05-23 14:13:34', NULL, ''),
(29, 'active', NULL, 'lawyer3', '$2y$13$hUUDzUeTJ1XaVToPZnFuAOOBmqsTfiUA00P61ce42/qnIvX2xf1hG', 'lawyer3@test.ru', '+79001112233', 'lawyer3', '2016-05-23 14:13:34', NULL, ''),
(30, 'active', 3, 'administrator', '$2y$13$bRuoY0hFIB8DjKV7pMLr4.hqOA/pfr5soRqaZWP1/SSw.AFNyDLXi', 'administrator@test.ru', '+79601112233', 'Администратор системы', '2016-05-23 14:13:35', '2016-05-31 06:46:14', ''),
(36, 'new', NULL, 'new', '$2y$13$U7oI3fr0pl/3.EyeBIfZJeWpEVWWUS0q83JEXgXj6uSBs094nz9u.', '123@mail.com', '123', '123', '2016-05-27 06:56:11', NULL, '');

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
-- Индексы таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_notifications_users` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
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
  ADD CONSTRAINT `FK_insurance_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `FK_notifications_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

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
