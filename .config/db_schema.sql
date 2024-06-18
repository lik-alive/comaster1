-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Июн 16 2024 г., 18:04
-- Версия сервера: 8.0.37-0ubuntu0.20.04.3
-- Версия PHP: 7.4.3-4ubuntu2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `co1db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE `articles` (
  `ID_Article` smallint NOT NULL,
  `ID_Issue` tinyint NOT NULL,
  `ID_Section` tinyint NOT NULL,
  `SeqNumber` tinyint DEFAULT NULL,
  `Title` varchar(1023) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Authors` varchar(1023) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Affiliation` varchar(2047) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PageCount` tinyint DEFAULT NULL,
  `RecvDate` date NOT NULL,
  `CorName` varchar(127) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CorMail` varchar(127) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `RemDate` date DEFAULT NULL,
  `IsRevApproved` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `IsTechApproved` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `Language` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'R',
  `Comments` varchar(1023) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `experts`
--

CREATE TABLE `experts` (
  `ID_Expert` smallint NOT NULL,
  `Name` varchar(127) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mail` varchar(127) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `IsActive` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `Interests` varchar(2047) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Comments` varchar(1023) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Position` varchar(1023) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `issues`
--

CREATE TABLE `issues` (
  `ID_Issue` tinyint NOT NULL,
  `Title` varchar(31) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `IsActive` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `ID_Review` smallint NOT NULL,
  `ID_Article` smallint NOT NULL,
  `ID_Expert` smallint NOT NULL,
  `RevNo` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ToExpDate` date DEFAULT NULL,
  `FromExpDate` date DEFAULT NULL,
  `ID_Verdict` tinyint DEFAULT NULL,
  `ToAuthDate` date DEFAULT NULL,
  `FromAuthDate` date DEFAULT NULL,
  `RemDate` date DEFAULT NULL,
  `Comments` varchar(1023) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sections`
--

CREATE TABLE `sections` (
  `ID_Section` tinyint NOT NULL,
  `Title` varchar(127) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ShortTitle` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ID_Expert` smallint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `verdicts`
--

CREATE TABLE `verdicts` (
  `ID_Verdict` tinyint NOT NULL,
  `Title` varchar(31) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `verdicts`
--

INSERT INTO `verdicts` (`ID_Verdict`, `Title`) VALUES
(1, 'добро'),
(2, 'подправить'),
(3, 'переделать'),
(4, 'отклонить'),
(5, 'отказался'),
(6, 'снят');

-- --------------------------------------------------------

--
-- Структура таблицы `wp_aryo_activity_log`
--

CREATE TABLE `wp_aryo_activity_log` (
  `histid` int NOT NULL,
  `user_caps` varchar(70) NOT NULL DEFAULT 'guest',
  `action` varchar(255) NOT NULL,
  `object_type` varchar(255) NOT NULL,
  `object_subtype` varchar(255) NOT NULL DEFAULT '',
  `object_name` varchar(255) NOT NULL,
  `object_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL DEFAULT '0',
  `hist_ip` varchar(55) NOT NULL DEFAULT '127.0.0.1',
  `hist_time` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `wp_commentmeta`
--

CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint UNSIGNED NOT NULL,
  `comment_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `wp_comments`
--

CREATE TABLE `wp_comments` (
  `comment_ID` bigint UNSIGNED NOT NULL,
  `comment_post_ID` bigint UNSIGNED NOT NULL DEFAULT '0',
  `comment_author` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_author_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_karma` int NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'comment',
  `comment_parent` bigint UNSIGNED NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `wp_links`
--

CREATE TABLE `wp_links` (
  `link_id` bigint UNSIGNED NOT NULL,
  `link_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint UNSIGNED NOT NULL DEFAULT '1',
  `link_rating` int NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_rss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `wp_options`
--

CREATE TABLE `wp_options` (
  `option_id` bigint UNSIGNED NOT NULL,
  `option_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `wp_options`
--

INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(0, 'widget_block', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(1, 'siteurl', 'http://localhost', 'yes'),
(2, 'home', 'http://localhost', 'yes'),
(3, 'blogname', 'Журнал «Компьютерная оптика»', 'yes'),
(4, 'blogdescription', 'Добро пожаловать', 'yes'),
(5, 'users_can_register', '0', 'yes'),
(6, 'admin_email', 'admin@example.com', 'yes'),
(7, 'start_of_week', '1', 'yes'),
(8, 'use_balanceTags', '0', 'yes'),
(9, 'use_smilies', '1', 'yes'),
(10, 'require_name_email', '1', 'yes'),
(11, 'comments_notify', '1', 'yes'),
(12, 'posts_per_rss', '10', 'yes'),
(13, 'rss_use_excerpt', '0', 'yes'),
(14, 'mailserver_url', 'mail.example.com', 'yes'),
(15, 'mailserver_login', 'login@example.com', 'yes'),
(16, 'mailserver_pass', 'password', 'yes'),
(17, 'mailserver_port', '110', 'yes'),
(18, 'default_category', '1', 'yes'),
(19, 'default_comment_status', 'open', 'yes'),
(20, 'default_ping_status', 'open', 'yes'),
(21, 'default_pingback_flag', '0', 'yes'),
(22, 'posts_per_page', '10', 'yes'),
(23, 'date_format', 'd.m.Y', 'yes'),
(24, 'time_format', 'H:i', 'yes'),
(25, 'links_updated_date_format', 'd.m.Y H:i', 'yes'),
(26, 'comment_moderation', '0', 'yes'),
(27, 'moderation_notify', '1', 'yes'),
(28, 'permalink_structure', '/archives/%post_id%', 'yes'),
(29, 'rewrite_rules', 'a:92:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:17:\"^wp-sitemap\\.xml$\";s:23:\"index.php?sitemap=index\";s:17:\"^wp-sitemap\\.xsl$\";s:36:\"index.php?sitemap-stylesheet=sitemap\";s:23:\"^wp-sitemap-index\\.xsl$\";s:34:\"index.php?sitemap-stylesheet=index\";s:48:\"^wp-sitemap-([a-z]+?)-([a-z\\d_-]+?)-(\\d+?)\\.xml$\";s:75:\"index.php?sitemap=$matches[1]&sitemap-subtype=$matches[2]&paged=$matches[3]\";s:34:\"^wp-sitemap-([a-z]+?)-(\\d+?)\\.xml$\";s:47:\"index.php?sitemap=$matches[1]&paged=$matches[2]\";s:56:\"archives/category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:51:\"archives/category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:32:\"archives/category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:44:\"archives/category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:26:\"archives/category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:53:\"archives/tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:48:\"archives/tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:29:\"archives/tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:41:\"archives/tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:23:\"archives/tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:54:\"archives/type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:49:\"archives/type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:30:\"archives/type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:42:\"archives/type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:24:\"archives/type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:27:\"comment-page-([0-9]{1,})/?$\";s:38:\"index.php?&page_id=7&cpage=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:56:\"archives/author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:51:\"archives/author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:32:\"archives/author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:44:\"archives/author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:26:\"archives/author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:83:\"archives/date/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:78:\"archives/date/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:59:\"archives/date/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:71:\"archives/date/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:53:\"archives/date/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:70:\"archives/date/([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:65:\"archives/date/([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:46:\"archives/date/([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:58:\"archives/date/([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:40:\"archives/date/([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:57:\"archives/date/([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:52:\"archives/date/([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:33:\"archives/date/([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:45:\"archives/date/([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:27:\"archives/date/([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:37:\"archives/[0-9]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:47:\"archives/[0-9]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:67:\"archives/[0-9]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:62:\"archives/[0-9]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:62:\"archives/[0-9]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:43:\"archives/[0-9]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:26:\"archives/([0-9]+)/embed/?$\";s:34:\"index.php?p=$matches[1]&embed=true\";s:30:\"archives/([0-9]+)/trackback/?$\";s:28:\"index.php?p=$matches[1]&tb=1\";s:50:\"archives/([0-9]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?p=$matches[1]&feed=$matches[2]\";s:45:\"archives/([0-9]+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?p=$matches[1]&feed=$matches[2]\";s:38:\"archives/([0-9]+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?p=$matches[1]&paged=$matches[2]\";s:45:\"archives/([0-9]+)/comment-page-([0-9]{1,})/?$\";s:41:\"index.php?p=$matches[1]&cpage=$matches[2]\";s:34:\"archives/([0-9]+)(?:/([0-9]+))?/?$\";s:40:\"index.php?p=$matches[1]&page=$matches[2]\";s:26:\"archives/[0-9]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:36:\"archives/[0-9]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:56:\"archives/[0-9]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:51:\"archives/[0-9]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:51:\"archives/[0-9]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:32:\"archives/[0-9]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";}', 'yes'),
(30, 'hack_file', '0', 'yes'),
(31, 'blog_charset', 'UTF-8', 'yes'),
(32, 'moderation_keys', '', 'no'),
(33, 'active_plugins', 'a:6:{i:0;s:39:\"aryo-activity-log/aryo-activity-log.php\";i:1;s:32:\"baw-login-logout-menu/bawllm.php\";i:2;s:48:\"capability-manager-enhanced/capsman-enhanced.php\";i:3;s:33:\"nav-menu-roles/nav-menu-roles.php\";i:4;s:33:\"wp-force-login/wp-force-login.php\";i:5;s:43:\"wp-maintenance-mode/wp-maintenance-mode.php\";}', 'yes'),
(34, 'category_base', '', 'yes'),
(35, 'ping_sites', 'http://rpc.pingomatic.com/', 'yes'),
(36, 'comment_max_links', '2', 'yes'),
(37, 'gmt_offset', '3', 'yes'),
(38, 'default_email_category', '1', 'yes'),
(40, 'template', 'cactus-child', 'yes'),
(41, 'stylesheet', 'cactus-child', 'yes'),
(44, 'comment_registration', '0', 'yes'),
(45, 'html_type', 'text/html', 'yes'),
(46, 'use_trackback', '0', 'yes'),
(47, 'default_role', 'subscriber', 'yes'),
(48, 'db_version', '49752', 'yes'),
(49, 'uploads_use_yearmonth_folders', '1', 'yes'),
(50, 'upload_path', '', 'yes'),
(51, 'blog_public', '0', 'yes'),
(52, 'default_link_category', '2', 'yes'),
(53, 'show_on_front', 'page', 'yes'),
(54, 'tag_base', '', 'yes'),
(55, 'show_avatars', '1', 'yes'),
(56, 'avatar_rating', 'G', 'yes'),
(57, 'upload_url_path', '', 'yes'),
(58, 'thumbnail_size_w', '150', 'yes'),
(59, 'thumbnail_size_h', '150', 'yes'),
(60, 'thumbnail_crop', '1', 'yes'),
(61, 'medium_size_w', '300', 'yes'),
(62, 'medium_size_h', '300', 'yes'),
(63, 'avatar_default', 'mystery', 'yes'),
(64, 'large_size_w', '1024', 'yes'),
(65, 'large_size_h', '1024', 'yes'),
(66, 'image_default_link_type', '', 'yes'),
(67, 'image_default_size', '', 'yes'),
(68, 'image_default_align', '', 'yes'),
(69, 'close_comments_for_old_posts', '0', 'yes'),
(70, 'close_comments_days_old', '14', 'yes'),
(71, 'thread_comments', '1', 'yes'),
(72, 'thread_comments_depth', '5', 'yes'),
(73, 'page_comments', '0', 'yes'),
(74, 'comments_per_page', '50', 'yes'),
(75, 'default_comments_page', 'newest', 'yes'),
(76, 'comment_order', 'asc', 'yes'),
(77, 'sticky_posts', 'a:0:{}', 'yes'),
(78, 'widget_categories', 'a:3:{i:2;a:4:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:12:\"hierarchical\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;i:4;a:4:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:12:\"hierarchical\";i:0;s:8:\"dropdown\";i:0;}}', 'yes'),
(79, 'widget_text', 'a:5:{i:2;a:4:{s:5:\"title\";s:21:\"Найдите нас\";s:4:\"text\";s:226:\"<strong>Адрес</strong>\n123 Мейн стрит\nНью Йорк, NY 10001\n\n<strong>Часы</strong>\nПонедельник&mdash;пятница: 9:00&ndash;17:00\nСуббота и воскресенье: 11:00&ndash;15:00\";s:6:\"filter\";b:1;s:6:\"visual\";b:1;}i:3;a:4:{s:5:\"title\";s:13:\"О сайте\";s:4:\"text\";s:205:\"Здесь может быть отличное место для того, чтобы представить себя, свой сайт или выразить какие-то благодарности.\";s:6:\"filter\";b:1;s:6:\"visual\";b:1;}i:4;a:4:{s:5:\"title\";s:21:\"Найдите нас\";s:4:\"text\";s:226:\"<strong>Адрес</strong>\n123 Мейн стрит\nНью Йорк, NY 10001\n\n<strong>Часы</strong>\nПонедельник&mdash;пятница: 9:00&ndash;17:00\nСуббота и воскресенье: 11:00&ndash;15:00\";s:6:\"filter\";b:1;s:6:\"visual\";b:1;}i:5;a:4:{s:5:\"title\";s:13:\"О сайте\";s:4:\"text\";s:205:\"Здесь может быть отличное место для того, чтобы представить себя, свой сайт или выразить какие-то благодарности.\";s:6:\"filter\";b:1;s:6:\"visual\";b:1;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(80, 'widget_rss', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(82, 'timezone_string', '', 'yes'),
(84, 'page_on_front', '7', 'yes'),
(85, 'default_post_format', '0', 'yes'),
(86, 'link_manager_enabled', '0', 'yes'),
(87, 'finished_splitting_shared_terms', '1', 'yes'),
(88, 'site_icon', '351', 'yes'),
(89, 'medium_large_size_w', '768', 'yes'),
(90, 'medium_large_size_h', '0', 'yes'),
(91, 'initial_db_version', '38590', 'yes'),
(92, 'wp_user_roles', 'a:9:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:74:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;s:19:\"manage_capabilities\";b:1;s:22:\"tablepress_edit_tables\";b:1;s:24:\"tablepress_delete_tables\";b:1;s:22:\"tablepress_list_tables\";b:1;s:21:\"tablepress_add_tables\";b:1;s:22:\"tablepress_copy_tables\";b:1;s:24:\"tablepress_import_tables\";b:1;s:24:\"tablepress_export_tables\";b:1;s:32:\"tablepress_access_options_screen\";b:1;s:30:\"tablepress_access_about_screen\";b:1;s:29:\"tablepress_import_tables_wptr\";b:1;s:23:\"tablepress_edit_options\";b:1;s:26:\"view_all_aryo_activity_log\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:43:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:22:\"tablepress_edit_tables\";b:1;s:24:\"tablepress_delete_tables\";b:1;s:22:\"tablepress_list_tables\";b:1;s:21:\"tablepress_add_tables\";b:1;s:22:\"tablepress_copy_tables\";b:1;s:24:\"tablepress_import_tables\";b:1;s:24:\"tablepress_export_tables\";b:1;s:32:\"tablepress_access_options_screen\";b:1;s:30:\"tablepress_access_about_screen\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:19:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:22:\"tablepress_edit_tables\";b:1;s:24:\"tablepress_delete_tables\";b:1;s:22:\"tablepress_list_tables\";b:1;s:21:\"tablepress_add_tables\";b:1;s:22:\"tablepress_copy_tables\";b:1;s:24:\"tablepress_import_tables\";b:1;s:24:\"tablepress_export_tables\";b:1;s:32:\"tablepress_access_options_screen\";b:1;s:30:\"tablepress_access_about_screen\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}s:9:\"seceditor\";a:2:{s:4:\"name\";s:9:\"Seceditor\";s:12:\"capabilities\";a:0:{}}s:4:\"tech\";a:2:{s:4:\"name\";s:4:\"Tech\";s:12:\"capabilities\";a:0:{}}s:10:\"maineditor\";a:2:{s:4:\"name\";s:10:\"Maineditor\";s:12:\"capabilities\";a:0:{}}s:8:\"observer\";a:2:{s:4:\"name\";s:8:\"Observer\";s:12:\"capabilities\";a:0:{}}}', 'yes'),
(93, 'fresh_site', '0', 'yes'),
(94, 'WPLANG', 'ru_RU', 'yes'),
(95, 'widget_search', 'a:4:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;i:3;a:1:{s:5:\"title\";s:10:\"Поиск\";}i:4;a:1:{s:5:\"title\";s:10:\"Поиск\";}}', 'yes'),
(96, 'widget_recent-posts', 'a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(97, 'widget_recent-comments', 'a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(98, 'widget_archives', 'a:2:{i:2;a:3:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(99, 'widget_meta', 'a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'yes'),
(100, 'sidebars_widgets', 'a:7:{s:19:\"wp_inactive_widgets\";a:11:{i:0;s:6:\"text-2\";i:1;s:6:\"text-3\";i:2;s:7:\"pages-3\";i:3;s:12:\"categories-4\";i:4;s:10:\"archives-2\";i:5;s:6:\"meta-2\";i:6;s:8:\"search-2\";i:7;s:12:\"categories-2\";i:8;s:14:\"recent-posts-2\";i:9;s:17:\"recent-comments-2\";i:10;s:8:\"search-3\";}s:9:\"sidebar-1\";a:0:{}s:8:\"footer-1\";a:1:{i:0;s:6:\"text-4\";}s:8:\"footer-2\";a:2:{i:0;s:6:\"text-5\";i:1;s:8:\"search-4\";}s:8:\"footer-3\";N;s:8:\"footer-4\";N;s:13:\"array_version\";i:3;}', 'yes'),
(101, 'widget_pages', 'a:2:{s:12:\"_multiwidget\";i:1;i:3;a:0:{}}', 'yes'),
(102, 'widget_calendar', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(103, 'widget_media_audio', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(104, 'widget_media_image', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(105, 'widget_media_video', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(106, 'widget_tag_cloud', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(107, 'widget_nav_menu', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(108, 'widget_custom_html', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(109, 'cron', 'a:10:{i:1718054326;a:3:{s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1718058227;a:1:{s:18:\"wp_https_detection\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1718097549;a:1:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1718097914;a:1:{s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1718101427;a:1:{s:32:\"recovery_mode_clean_expired_keys\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1718104824;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1718139311;a:1:{s:28:\"wp_update_comment_type_batch\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:2:{s:8:\"schedule\";b:0;s:4:\"args\";a:0:{}}}}i:1718140083;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1718187827;a:1:{s:30:\"wp_site_health_scheduled_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}s:7:\"version\";i:2;}', 'yes'),
(144, 'nav_menu_options', 'a:1:{s:8:\"auto_add\";a:0:{}}', 'yes'),
(157, 'current_theme', 'Cactus-Child', 'yes'),
(158, 'theme_mods_cactus', 'a:6:{i:0;b:0;s:18:\"nav_menu_locations\";a:2:{s:3:\"top\";i:2;s:6:\"social\";i:3;}s:18:\"custom_css_post_id\";i:296;s:11:\"custom_logo\";i:370;s:16:\"header_textcolor\";s:6:\"0066bf\";s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1505803012;s:4:\"data\";a:3:{s:19:\"wp_inactive_widgets\";a:10:{i:0;s:8:\"search-4\";i:1;s:6:\"text-5\";i:2;s:7:\"pages-3\";i:3;s:12:\"categories-4\";i:4;s:10:\"archives-2\";i:5;s:6:\"meta-2\";i:6;s:8:\"search-2\";i:7;s:12:\"categories-2\";i:8;s:14:\"recent-posts-2\";i:9;s:17:\"recent-comments-2\";}s:18:\"orphaned_widgets_1\";a:3:{i:0;s:6:\"text-2\";i:1;s:8:\"search-3\";i:2;s:6:\"text-3\";}s:18:\"orphaned_widgets_2\";a:1:{i:0;s:6:\"text-4\";}}}}', 'yes'),
(159, 'theme_switched', '', 'yes'),
(168, 'recently_activated', 'a:0:{}', 'yes');
INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(187, 'do_activate', '0', 'yes'),
(192, 'sharing-options', 'a:1:{s:6:\"global\";a:5:{s:12:\"button_style\";s:9:\"icon-text\";s:13:\"sharing_label\";s:36:\"Поделиться ссылкой:\";s:10:\"open_links\";s:4:\"same\";s:4:\"show\";a:0:{}s:6:\"custom\";a:0:{}}}', 'yes'),
(193, 'stats_options', 'a:7:{s:9:\"admin_bar\";b:1;s:5:\"roles\";a:1:{i:0;s:13:\"administrator\";}s:11:\"count_roles\";a:0:{}s:7:\"blog_id\";b:0;s:12:\"do_not_track\";b:1;s:10:\"hide_smile\";b:1;s:7:\"version\";s:1:\"9\";}', 'yes'),
(289, 'capsman_version', '', 'yes'),
(290, 'capsman_backup', 'a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:62:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;s:19:\"manage_capabilities\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}', 'yes'),
(309, 'tablepress_plugin_options', '{\"plugin_options_db_version\":34,\"table_scheme_db_version\":3,\"prev_tablepress_version\":\"0\",\"tablepress_version\":\"1.8\",\"first_activation\":1505570201,\"message_plugin_update\":false,\"message_donation_nag\":true,\"use_custom_css\":true,\"use_custom_css_file\":true,\"custom_css\":\"\",\"custom_css_minified\":\"\",\"custom_css_version\":0}', 'yes'),
(310, 'tablepress_tables', '{\"last_id\":2,\"table_post\":{\"1\":35}}', 'yes'),
(316, 'wdtRenderFilter', 'footer', 'yes'),
(319, 'wdtTimeFormat', 'h:i A', 'yes'),
(321, 'wdtTablesPerPage', '10', 'yes'),
(322, 'wdtNumberFormat', '1', 'yes'),
(323, 'wdtDecimalPlaces', '2', 'yes'),
(324, 'wdtTimepickerRange', '5', 'yes'),
(325, 'wdtNumbersAlign', '1', 'yes'),
(326, 'wdtCustomJs', '', 'yes'),
(327, 'wdtCustomCss', '', 'yes'),
(328, 'wdtMinifiedJs', '1', 'yes'),
(329, 'wdtTabletWidth', '1024', 'yes'),
(330, 'wdtMobileWidth', '480', 'yes'),
(374, 'nav_menu_roles_db_version', '1.9.2', 'yes'),
(437, 'widget_shapely_recent_posts', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(438, 'widget_shapely-cats', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(439, 'widget_shapely_home_parallax', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(440, 'widget_shapely_home_features', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(441, 'widget_shapely_home_cfa', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(442, 'widget_shapely_home_clients', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(443, 'widget_shapely_video_widget', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(444, 'widget_shapely_home_contact', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(445, 'widget_shapely-social', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(463, 'widget_shapely_home_testimonial', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(464, 'widget_shapely_home_portfolio', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(466, 'shapely_show_required_actions', 'a:2:{s:37:\"shapely-req-ac-install-contact-form-7\";b:0;s:26:\"shapely-req-import-content\";b:0;}', 'yes');
INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(549, 'widget_software-socialize-widget', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(584, 'theme_switched_via_customizer', '', 'yes'),
(585, 'customize_stashed_theme_mods', 'a:0:{}', 'no'),
(609, 'cactus_options', 'a:1:{s:11:\"footer_logo\";s:0:\"\";}', 'yes'),
(650, 'theme_mods_cactus-child', 'a:4:{i:0;b:0;s:18:\"nav_menu_locations\";a:2:{s:3:\"top\";i:2;s:6:\"social\";i:3;}s:18:\"custom_css_post_id\";i:-1;s:11:\"custom_logo\";i:473;}', 'yes'),
(990, 'widget_wbr_feature_page_widget', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(991, 'widget_wbr_resent_news_widget', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(1336, 'seed_csp4_settings_content', 'a:9:{s:6:\"status\";s:1:\"1\";s:4:\"logo\";s:0:\"\";s:8:\"headline\";s:31:\"Сайт обновляется\";s:11:\"description\";s:76:\"Всё к лучшему - попробуйте зайти попозже...\";s:13:\"footer_credit\";s:1:\"1\";s:7:\"favicon\";s:0:\"\";s:9:\"seo_title\";s:0:\"\";s:15:\"seo_description\";s:0:\"\";s:12:\"ga_analytics\";s:0:\"\";}', 'yes'),
(1337, 'seed_csp4_settings_design', 'a:12:{s:8:\"bg_color\";s:7:\"#fafafa\";s:8:\"bg_image\";s:0:\"\";s:8:\"bg_cover\";a:1:{i:0;s:1:\"1\";}s:9:\"bg_repeat\";s:9:\"no-repeat\";s:11:\"bg_position\";s:8:\"left top\";s:13:\"bg_attahcment\";s:5:\"fixed\";s:9:\"max_width\";s:0:\"\";s:10:\"text_color\";s:7:\"#666666\";s:10:\"link_color\";s:7:\"#27AE60\";s:14:\"headline_color\";s:7:\"#444444\";s:9:\"text_font\";s:6:\"_arial\";s:10:\"custom_css\";s:0:\"\";}', 'yes'),
(1338, 'seed_csp4_settings_advanced', 'a:2:{s:14:\"header_scripts\";s:0:\"\";s:14:\"footer_scripts\";s:0:\"\";}', 'yes'),
(1341, 'seed_csp4_review', 'a:2:{s:4:\"time\";i:1509353383;s:9:\"dismissed\";b:0;}', 'yes'),
(1352, 'wpmm_settings', 'a:4:{s:7:\"general\";a:9:{s:6:\"status\";i:0;s:11:\"bypass_bots\";i:0;s:11:\"meta_robots\";i:0;s:11:\"redirection\";s:0:\"\";s:7:\"exclude\";a:3:{i:0;s:4:\"feed\";i:1;s:8:\"wp-login\";i:2;s:5:\"login\";}s:6:\"notice\";i:1;s:10:\"admin_link\";i:0;s:12:\"backend_role\";a:0:{}s:13:\"frontend_role\";a:0:{}}s:6:\"design\";a:10:{s:5:\"title\";s:8:\"Тест\";s:7:\"heading\";s:0:\"\";s:13:\"heading_color\";s:7:\"#ffffff\";s:4:\"text\";s:0:\"\";s:10:\"text_color\";s:7:\"#ffffff\";s:7:\"bg_type\";s:5:\"color\";s:8:\"bg_color\";s:7:\"#ffffff\";s:9:\"bg_custom\";s:0:\"\";s:13:\"bg_predefined\";s:7:\"bg1.jpg\";s:10:\"custom_css\";a:3:{s:13:\"heading_color\";s:28:\".wrap h1 { color: #ffffff; }\";s:10:\"text_color\";s:28:\".wrap h2 { color: #ffffff; }\";s:8:\"bg_color\";s:35:\"body { background-color: #ffffff; }\";}}s:7:\"modules\";a:22:{s:16:\"countdown_status\";i:0;s:15:\"countdown_start\";s:19:\"2017-10-30 12:54:37\";s:17:\"countdown_details\";a:3:{s:4:\"days\";i:0;s:5:\"hours\";i:1;s:7:\"minutes\";i:0;}s:15:\"countdown_color\";s:0:\"\";s:16:\"subscribe_status\";i:0;s:14:\"subscribe_text\";s:40:\"Сообщить о готовности\";s:20:\"subscribe_text_color\";s:0:\"\";s:13:\"social_status\";i:0;s:13:\"social_target\";i:1;s:13:\"social_github\";s:0:\"\";s:15:\"social_dribbble\";s:0:\"\";s:14:\"social_twitter\";s:0:\"\";s:15:\"social_facebook\";s:0:\"\";s:16:\"social_pinterest\";s:0:\"\";s:14:\"social_google+\";s:0:\"\";s:15:\"social_linkedin\";s:0:\"\";s:14:\"contact_status\";i:0;s:13:\"contact_email\";s:14:\"admin@example.com\";s:15:\"contact_effects\";s:20:\"move_top|move_bottom\";s:9:\"ga_status\";i:0;s:7:\"ga_code\";s:0:\"\";s:10:\"custom_css\";a:0:{}}s:3:\"bot\";a:6:{s:6:\"status\";i:0;s:4:\"name\";s:5:\"Admin\";s:6:\"avatar\";s:0:\"\";s:8:\"messages\";a:11:{s:2:\"01\";s:97:\"Hey! My name is {bot_name}, I am the owner of this website and I would like to be your assistant here.\";s:2:\"02\";s:28:\"I have just a few questions.\";s:2:\"03\";s:18:\"What is your name?\";s:2:\"04\";s:38:\"Nice to meet you here, {visitor_name}!\";s:2:\"05\";s:55:\"How you can see, our website will be lauched very soon.\";s:2:\"06\";s:76:\"I know, you are very excited to see it, but we need a few days to finish it.\";s:2:\"07\";s:37:\"Would you like to be first to see it?\";s:4:\"08_1\";s:81:\"Cool! Please leave your email here and I will send you a message when it is ready.\";s:4:\"08_2\";s:56:\"Sad to hear that, {visitor_name} :( See you next time…\";s:2:\"09\";s:40:\"Got it! Thank you and see you soon here!\";i:10;s:17:\"Have a great day!\";}s:9:\"responses\";a:4:{s:2:\"01\";s:22:\"Type your name here…\";s:4:\"02_1\";s:12:\"Tell me more\";s:4:\"02_2\";s:6:\"Boring\";s:2:\"03\";s:23:\"Type your email here…\";}s:10:\"custom_css\";a:0:{}}}', 'yes'),
(1353, 'wpmm_version', '2.1.2', 'yes');

-- --------------------------------------------------------

--
-- Структура таблицы `wp_postmeta`
--

CREATE TABLE `wp_postmeta` (
  `meta_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `wp_postmeta`
--

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(97, 7, '_edit_lock', '1627919618:1'),
(98, 30, '_menu_item_type', 'custom'),
(99, 30, '_menu_item_menu_item_parent', '0'),
(100, 30, '_menu_item_object_id', '30'),
(101, 30, '_menu_item_object', 'custom'),
(102, 30, '_menu_item_target', ''),
(103, 30, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(104, 30, '_menu_item_xfn', ''),
(105, 30, '_menu_item_url', '#bawloginout#'),
(113, 35, '_tablepress_table_options', '{\"last_editor\":1,\"table_head\":true,\"table_foot\":false,\"alternating_row_colors\":true,\"row_hover\":true,\"print_name\":false,\"print_name_position\":\"above\",\"print_description\":false,\"print_description_position\":\"below\",\"extra_css_classes\":\"\",\"use_datatables\":true,\"datatables_sort\":true,\"datatables_filter\":true,\"datatables_paginate\":true,\"datatables_lengthchange\":true,\"datatables_paginate_entries\":10,\"datatables_info\":true,\"datatables_scrollx\":false,\"datatables_custom_commands\":\"\"}'),
(114, 35, '_tablepress_table_visibility', '{\"rows\":[1,1],\"columns\":[1,1]}'),
(203, 7, '_edit_last', '1'),
(204, 7, '_wp_page_template', 'page-templates/mainpage.php'),
(218, 78, '_edit_last', '1'),
(219, 78, '_edit_lock', '1507462419:1'),
(220, 78, '_wp_page_template', 'page-templates/tables_section_list.php'),
(221, 80, '_menu_item_type', 'post_type'),
(222, 80, '_menu_item_menu_item_parent', '571'),
(223, 80, '_menu_item_object_id', '78'),
(224, 80, '_menu_item_object', 'page'),
(225, 80, '_menu_item_target', ''),
(226, 80, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(227, 80, '_menu_item_xfn', ''),
(228, 80, '_menu_item_url', ''),
(230, 86, '_edit_last', '1'),
(231, 86, '_edit_lock', '1507462426:1'),
(232, 86, '_wp_page_template', 'page-templates/tables_issue_list.php'),
(239, 108, '_menu_item_type', 'post_type'),
(240, 108, '_menu_item_menu_item_parent', '571'),
(241, 108, '_menu_item_object_id', '86'),
(242, 108, '_menu_item_object', 'page'),
(243, 108, '_menu_item_target', ''),
(244, 108, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(245, 108, '_menu_item_xfn', ''),
(246, 108, '_menu_item_url', ''),
(268, 144, '_edit_last', '1'),
(269, 144, '_edit_lock', '1507471067:1'),
(270, 149, '_edit_last', '1'),
(271, 149, '_edit_lock', '1507464350:1'),
(272, 154, '_menu_item_type', 'post_type'),
(273, 154, '_menu_item_menu_item_parent', '571'),
(274, 154, '_menu_item_object_id', '149'),
(275, 154, '_menu_item_object', 'page'),
(276, 154, '_menu_item_target', ''),
(277, 154, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(278, 154, '_menu_item_xfn', ''),
(279, 154, '_menu_item_url', ''),
(281, 156, '_edit_last', '1'),
(282, 156, '_edit_lock', '1507466066:1'),
(283, 169, '_menu_item_type', 'post_type'),
(284, 169, '_menu_item_menu_item_parent', '571'),
(285, 169, '_menu_item_object_id', '156'),
(286, 169, '_menu_item_object', 'page'),
(287, 169, '_menu_item_target', ''),
(288, 169, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(289, 169, '_menu_item_xfn', ''),
(290, 169, '_menu_item_url', ''),
(292, 170, '_menu_item_type', 'post_type'),
(293, 170, '_menu_item_menu_item_parent', '571'),
(294, 170, '_menu_item_object_id', '144'),
(295, 170, '_menu_item_object', 'page'),
(296, 170, '_menu_item_target', ''),
(297, 170, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(298, 170, '_menu_item_xfn', ''),
(299, 170, '_menu_item_url', ''),
(303, 173, '_edit_last', '1'),
(304, 173, '_edit_lock', '1510592084:1'),
(384, 144, '_wp_page_template', 'page-templates/tables_verdict_list.php'),
(385, 156, '_wp_page_template', 'page-templates/tables_review_list.php'),
(386, 149, '_wp_page_template', 'page-templates/tables_expert_list.php'),
(435, 351, '_wp_attached_file', '2017/09/cropped-COIcon.png'),
(436, 351, '_wp_attachment_context', 'site-icon'),
(437, 351, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:512;s:6:\"height\";i:512;s:4:\"file\";s:26:\"2017/09/cropped-COIcon.png\";s:5:\"sizes\";a:6:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:26:\"cropped-COIcon-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:6:\"medium\";a:4:{s:4:\"file\";s:26:\"cropped-COIcon-300x300.png\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";}s:13:\"site_icon-270\";a:4:{s:4:\"file\";s:26:\"cropped-COIcon-270x270.png\";s:5:\"width\";i:270;s:6:\"height\";i:270;s:9:\"mime-type\";s:9:\"image/png\";}s:13:\"site_icon-192\";a:4:{s:4:\"file\";s:26:\"cropped-COIcon-192x192.png\";s:5:\"width\";i:192;s:6:\"height\";i:192;s:9:\"mime-type\";s:9:\"image/png\";}s:13:\"site_icon-180\";a:4:{s:4:\"file\";s:26:\"cropped-COIcon-180x180.png\";s:5:\"width\";i:180;s:6:\"height\";i:180;s:9:\"mime-type\";s:9:\"image/png\";}s:12:\"site_icon-32\";a:4:{s:4:\"file\";s:24:\"cropped-COIcon-32x32.png\";s:5:\"width\";i:32;s:6:\"height\";i:32;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(501, 376, '_edit_last', '1'),
(502, 376, '_wp_page_template', 'page-templates/info_main.php'),
(503, 376, '_edit_lock', '1627919624:1'),
(643, 473, '_wp_attached_file', '2017/09/COLogo.png'),
(644, 473, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:165;s:6:\"height\";i:50;s:4:\"file\";s:18:\"2017/09/COLogo.png\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:17:\"COLogo-150x50.png\";s:5:\"width\";i:150;s:6:\"height\";i:50;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(679, 494, '_edit_lock', '1508174513:1'),
(680, 494, '_edit_last', '1'),
(681, 494, '_wp_page_template', 'page-templates/info_late_reviews.php'),
(740, 519, '_edit_lock', '1507464196:1'),
(741, 519, '_edit_last', '1'),
(742, 519, '_wp_page_template', 'page-templates/tables_expert_create.php'),
(743, 521, '_edit_lock', '1507466079:1'),
(744, 521, '_edit_last', '1'),
(745, 521, '_wp_page_template', 'page-templates/tables_expert_create.php'),
(746, 523, '_edit_lock', '1507465254:1'),
(747, 523, '_edit_last', '1'),
(748, 523, '_wp_page_template', 'page-templates/tables_issue_create.php'),
(749, 527, '_edit_lock', '1507464330:1'),
(750, 527, '_edit_last', '1'),
(751, 527, '_wp_page_template', 'page-templates/tables_issue_create.php'),
(752, 529, '_edit_lock', '1507464353:1'),
(753, 529, '_edit_last', '1'),
(754, 529, '_wp_page_template', 'page-templates/tables_section_create.php'),
(755, 531, '_edit_lock', '1507464376:1'),
(756, 531, '_edit_last', '1'),
(757, 531, '_wp_page_template', 'page-templates/tables_section_create.php'),
(758, 533, '_edit_lock', '1507464401:1'),
(759, 533, '_edit_last', '1'),
(760, 533, '_wp_page_template', 'page-templates/tables_review_create.php'),
(761, 535, '_edit_lock', '1507467910:1'),
(762, 535, '_edit_last', '1'),
(763, 535, '_wp_page_template', 'page-templates/tables_review_create.php'),
(764, 537, '_edit_lock', '1507467945:1'),
(765, 537, '_edit_last', '1'),
(766, 537, '_wp_page_template', 'page-templates/tables_verdict_create.php'),
(767, 539, '_edit_lock', '1507465206:1'),
(768, 539, '_edit_last', '1'),
(769, 539, '_wp_page_template', 'page-templates/tables_verdict_create.php'),
(770, 542, '_edit_lock', '1507499980:1'),
(771, 542, '_edit_last', '1'),
(772, 542, '_wp_page_template', 'page-templates/info_late_articles.php'),
(813, 552, '_menu_item_type', 'post_type'),
(814, 552, '_menu_item_menu_item_parent', '0'),
(815, 552, '_menu_item_object_id', '7'),
(816, 552, '_menu_item_object', 'page'),
(817, 552, '_menu_item_target', ''),
(818, 552, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(819, 552, '_menu_item_xfn', ''),
(820, 552, '_menu_item_url', ''),
(822, 552, '_nav_menu_role', 'in'),
(858, 169, '_nav_menu_role', 'a:2:{i:0;s:13:\"administrator\";i:1;s:8:\"observer\";}'),
(859, 154, '_nav_menu_role', 'a:2:{i:0;s:13:\"administrator\";i:1;s:8:\"observer\";}'),
(860, 108, '_nav_menu_role', 'a:2:{i:0;s:13:\"administrator\";i:1;s:8:\"observer\";}'),
(861, 80, '_nav_menu_role', 'a:2:{i:0;s:13:\"administrator\";i:1;s:8:\"observer\";}'),
(862, 170, '_nav_menu_role', 'a:2:{i:0;s:13:\"administrator\";i:1;s:8:\"observer\";}'),
(880, 173, '_wp_page_template', 'page-templates/tables_main.php'),
(891, 571, '_menu_item_type', 'post_type'),
(892, 571, '_menu_item_menu_item_parent', '0'),
(893, 571, '_menu_item_object_id', '173'),
(894, 571, '_menu_item_object', 'page'),
(895, 571, '_menu_item_target', ''),
(896, 571, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(897, 571, '_menu_item_xfn', ''),
(898, 571, '_menu_item_url', ''),
(909, 571, '_nav_menu_role', 'a:2:{i:0;s:13:\"administrator\";i:1;s:8:\"observer\";}'),
(911, 576, '_edit_lock', '1510592099:1'),
(912, 576, '_edit_last', '1'),
(913, 576, '_wp_page_template', 'page-templates/download.php'),
(914, 578, '_edit_lock', '1717974812:1'),
(915, 578, '_edit_last', '1'),
(916, 578, '_wp_page_template', 'page-templates/articles_main.php'),
(917, 580, '_edit_lock', '1509122357:1'),
(918, 580, '_edit_last', '1'),
(919, 580, '_wp_page_template', 'page-templates/articles_nst.php'),
(920, 582, '_edit_lock', '1509051065:1'),
(921, 582, '_edit_last', '1'),
(922, 582, '_wp_page_template', 'page-templates/articles_create.php'),
(923, 584, '_edit_lock', '1509050764:1'),
(924, 584, '_edit_last', '1'),
(925, 584, '_wp_page_template', 'page-templates/articles_view.php'),
(926, 586, '_edit_lock', '1627919621:1'),
(927, 586, '_edit_last', '1'),
(928, 586, '_wp_page_template', 'page-templates/articles_late.php'),
(929, 588, '_edit_lock', '1509050869:1'),
(930, 588, '_edit_last', '1'),
(931, 588, '_wp_page_template', 'page-templates/articles_archive.php'),
(932, 591, '_menu_item_type', 'post_type'),
(933, 591, '_menu_item_menu_item_parent', '0'),
(934, 591, '_menu_item_object_id', '578'),
(935, 591, '_menu_item_object', 'page'),
(936, 591, '_menu_item_target', ''),
(937, 591, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(938, 591, '_menu_item_xfn', ''),
(939, 591, '_menu_item_url', ''),
(941, 592, '_menu_item_type', 'post_type'),
(942, 592, '_menu_item_menu_item_parent', '591'),
(943, 592, '_menu_item_object_id', '588'),
(944, 592, '_menu_item_object', 'page'),
(945, 592, '_menu_item_target', ''),
(946, 592, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(947, 592, '_menu_item_xfn', ''),
(948, 592, '_menu_item_url', ''),
(950, 593, '_menu_item_type', 'post_type'),
(951, 593, '_menu_item_menu_item_parent', '591'),
(952, 593, '_menu_item_object_id', '586'),
(953, 593, '_menu_item_object', 'page'),
(954, 593, '_menu_item_target', ''),
(955, 593, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(956, 593, '_menu_item_xfn', ''),
(957, 593, '_menu_item_url', ''),
(977, 596, '_menu_item_type', 'post_type'),
(978, 596, '_menu_item_menu_item_parent', '591'),
(979, 596, '_menu_item_object_id', '580'),
(980, 596, '_menu_item_object', 'page'),
(981, 596, '_menu_item_target', ''),
(982, 596, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(983, 596, '_menu_item_xfn', ''),
(984, 596, '_menu_item_url', ''),
(986, 591, '_nav_menu_role', 'a:5:{i:0;s:13:\"administrator\";i:1;s:9:\"seceditor\";i:2;s:4:\"tech\";i:3;s:10:\"maineditor\";i:4;s:8:\"observer\";}'),
(987, 597, '_edit_lock', '1510592074:1'),
(988, 597, '_edit_last', '1'),
(989, 597, '_wp_page_template', 'page-templates/experts_main.php'),
(990, 599, '_edit_lock', '1509355280:1'),
(991, 599, '_edit_last', '1'),
(992, 599, '_wp_page_template', 'page-templates/experts_list.php'),
(993, 601, '_edit_lock', '1509323931:1'),
(994, 601, '_edit_last', '1'),
(995, 601, '_wp_page_template', 'page-templates/experts_rate.php'),
(996, 603, '_edit_lock', '1509323935:1'),
(997, 603, '_edit_last', '1'),
(998, 603, '_wp_page_template', 'page-templates/experts_late.php'),
(999, 605, '_edit_lock', '1509323938:1'),
(1000, 605, '_edit_last', '1'),
(1001, 605, '_wp_page_template', 'page-templates/experts_payment.php'),
(1002, 607, '_menu_item_type', 'post_type'),
(1003, 607, '_menu_item_menu_item_parent', '0'),
(1004, 607, '_menu_item_object_id', '597'),
(1005, 607, '_menu_item_object', 'page'),
(1006, 607, '_menu_item_target', ''),
(1007, 607, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(1008, 607, '_menu_item_xfn', ''),
(1009, 607, '_menu_item_url', ''),
(1011, 608, '_menu_item_type', 'post_type'),
(1012, 608, '_menu_item_menu_item_parent', '607'),
(1013, 608, '_menu_item_object_id', '605'),
(1014, 608, '_menu_item_object', 'page'),
(1015, 608, '_menu_item_target', ''),
(1016, 608, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(1017, 608, '_menu_item_xfn', ''),
(1018, 608, '_menu_item_url', ''),
(1020, 609, '_menu_item_type', 'post_type'),
(1021, 609, '_menu_item_menu_item_parent', '607'),
(1022, 609, '_menu_item_object_id', '603'),
(1023, 609, '_menu_item_object', 'page'),
(1024, 609, '_menu_item_target', ''),
(1025, 609, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(1026, 609, '_menu_item_xfn', ''),
(1027, 609, '_menu_item_url', ''),
(1029, 610, '_menu_item_type', 'post_type'),
(1030, 610, '_menu_item_menu_item_parent', '607'),
(1031, 610, '_menu_item_object_id', '601'),
(1032, 610, '_menu_item_object', 'page'),
(1033, 610, '_menu_item_target', ''),
(1034, 610, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(1035, 610, '_menu_item_xfn', ''),
(1036, 610, '_menu_item_url', ''),
(1038, 611, '_menu_item_type', 'post_type'),
(1039, 611, '_menu_item_menu_item_parent', '607'),
(1040, 611, '_menu_item_object_id', '599'),
(1041, 611, '_menu_item_object', 'page'),
(1042, 611, '_menu_item_target', ''),
(1043, 611, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(1044, 611, '_menu_item_xfn', ''),
(1045, 611, '_menu_item_url', ''),
(1047, 607, '_nav_menu_role', 'a:4:{i:0;s:13:\"administrator\";i:1;s:9:\"seceditor\";i:2;s:10:\"maineditor\";i:3;s:8:\"observer\";}'),
(1048, 617, '_edit_lock', '1509324579:1'),
(1049, 617, '_edit_last', '1'),
(1050, 617, '_wp_page_template', 'page-templates/experts_view.php'),
(1051, 596, '_nav_menu_role', 'a:5:{i:0;s:13:\"administrator\";i:1;s:9:\"seceditor\";i:2;s:4:\"tech\";i:3;s:10:\"maineditor\";i:4;s:8:\"observer\";}'),
(1052, 593, '_nav_menu_role', 'a:4:{i:0;s:13:\"administrator\";i:1;s:9:\"seceditor\";i:2;s:10:\"maineditor\";i:3;s:8:\"observer\";}'),
(1053, 592, '_nav_menu_role', 'a:5:{i:0;s:13:\"administrator\";i:1;s:9:\"seceditor\";i:2;s:4:\"tech\";i:3;s:10:\"maineditor\";i:4;s:8:\"observer\";}'),
(1054, 611, '_nav_menu_role', 'a:4:{i:0;s:13:\"administrator\";i:1;s:9:\"seceditor\";i:2;s:10:\"maineditor\";i:3;s:8:\"observer\";}'),
(1055, 610, '_nav_menu_role', 'a:4:{i:0;s:13:\"administrator\";i:1;s:9:\"seceditor\";i:2;s:10:\"maineditor\";i:3;s:8:\"observer\";}'),
(1056, 609, '_nav_menu_role', 'a:4:{i:0;s:13:\"administrator\";i:1;s:9:\"seceditor\";i:2;s:10:\"maineditor\";i:3;s:8:\"observer\";}'),
(1057, 608, '_nav_menu_role', 'a:2:{i:0;s:13:\"administrator\";i:1;s:8:\"observer\";}'),
(1095, 622, '_edit_lock', '1627919627:1'),
(1096, 622, '_edit_last', '1'),
(1097, 622, '_wp_page_template', 'page-templates/tables_article_list.php'),
(1098, 624, '_edit_lock', '1510657950:1'),
(1099, 624, '_edit_last', '1'),
(1100, 624, '_wp_page_template', 'page-templates/tables_article_create.php'),
(1101, 626, '_edit_lock', '1510658024:1'),
(1102, 626, '_edit_last', '1'),
(1103, 626, '_wp_page_template', 'page-templates/tables_article_create.php'),
(1104, 628, '_menu_item_type', 'post_type'),
(1105, 628, '_menu_item_menu_item_parent', '571'),
(1106, 628, '_menu_item_object_id', '622'),
(1107, 628, '_menu_item_object', 'page'),
(1108, 628, '_menu_item_target', ''),
(1109, 628, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(1110, 628, '_menu_item_xfn', ''),
(1111, 628, '_menu_item_url', ''),
(1135, 640, '_edit_lock', '1627919613:1'),
(1136, 640, '_edit_last', '1'),
(1137, 640, '_wp_page_template', 'default'),
(1138, 645, '_edit_lock', '1627919630:1'),
(1139, 645, '_edit_last', '1'),
(1140, 645, '_wp_page_template', 'page-templates/articles_mtng.php'),
(1141, 647, '_menu_item_type', 'post_type'),
(1142, 647, '_menu_item_menu_item_parent', '591'),
(1143, 647, '_menu_item_object_id', '645'),
(1144, 647, '_menu_item_object', 'page'),
(1145, 647, '_menu_item_target', ''),
(1146, 647, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(1147, 647, '_menu_item_xfn', ''),
(1148, 647, '_menu_item_url', ''),
(1150, 647, '_nav_menu_role', 'a:2:{i:0;s:13:\"administrator\";i:1;s:8:\"observer\";}'),
(1161, 552, '_wp_old_date', '2017-10-12'),
(1162, 591, '_wp_old_date', '2017-10-26'),
(1163, 596, '_wp_old_date', '2017-10-26'),
(1164, 593, '_wp_old_date', '2017-10-26'),
(1165, 592, '_wp_old_date', '2017-10-26'),
(1166, 647, '_wp_old_date', '2018-04-06'),
(1167, 607, '_wp_old_date', '2017-10-27'),
(1168, 611, '_wp_old_date', '2017-10-27'),
(1169, 610, '_wp_old_date', '2017-10-27'),
(1170, 609, '_wp_old_date', '2017-10-27'),
(1171, 608, '_wp_old_date', '2017-10-27'),
(1172, 571, '_wp_old_date', '2017-10-16'),
(1173, 628, '_wp_old_date', '2017-11-14'),
(1174, 169, '_wp_old_date', '2017-09-16'),
(1175, 154, '_wp_old_date', '2017-09-16'),
(1176, 108, '_wp_old_date', '2017-09-16'),
(1177, 80, '_wp_old_date', '2017-09-16'),
(1178, 170, '_wp_old_date', '2017-09-16'),
(1179, 30, '_wp_old_date', '2017-09-16');

-- --------------------------------------------------------

--
-- Структура таблицы `wp_posts`
--

CREATE TABLE `wp_posts` (
  `ID` bigint UNSIGNED NOT NULL,
  `post_author` bigint UNSIGNED NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `to_ping` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinged` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_parent` bigint UNSIGNED NOT NULL DEFAULT '0',
  `guid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int NOT NULL DEFAULT '0',
  `post_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_count` bigint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `wp_posts`
--

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(7, 1, '2017-09-16 12:19:58', '2017-09-16 09:19:58', 'Добро пожаловать на сайт!', 'Главная', '', 'publish', 'closed', 'closed', '', '%d0%b3%d0%bb%d0%b0%d0%b2%d0%bd%d0%b0%d1%8f-%d1%81%d1%82%d1%80%d0%b0%d0%bd%d0%b8%d1%86%d0%b0', '', '', '2017-11-13 19:54:19', '2017-11-13 16:54:19', '', 0, '', 1, 'page', '', 0),
(30, 1, '2021-08-20 17:10:09', '2017-09-16 10:19:23', '', 'Войти|Выйти', '', 'publish', 'closed', 'closed', '', '%d0%b2%d0%be%d0%b9%d1%82%d0%b8%d0%b2%d1%8b%d0%b9%d1%82%d0%b8', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 0, '', 19, 'nav_menu_item', '', 0),
(35, 1, '2017-09-16 14:18:25', '2017-09-16 11:18:25', '[[\"1\",\"asd\"],[\"2\",\"qwe\"]]', 'parts', '', 'publish', 'closed', 'closed', '', 'parts', '', '', '2017-09-16 14:18:52', '2017-09-16 11:18:52', '', 0, '', 0, 'tablepress_table', 'application/json', 0),
(78, 1, '2017-09-16 19:40:40', '2017-09-16 16:40:40', '', 'Разделы', '', 'publish', 'closed', 'closed', '', 'sections', '', '', '2017-10-08 14:33:39', '2017-10-08 11:33:39', '', 173, '', 4, 'page', '', 0),
(80, 1, '2021-08-20 17:10:09', '2017-09-16 16:41:29', ' ', '', '', 'publish', 'closed', 'closed', '', '80', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 173, '', 17, 'nav_menu_item', '', 0),
(86, 1, '2017-09-16 19:54:44', '2017-09-16 16:54:44', '', 'Выпуски', '', 'publish', 'closed', 'closed', '', 'issues', '', '', '2017-10-08 14:33:46', '2017-10-08 11:33:46', '', 173, '', 5, 'page', '', 0),
(108, 1, '2021-08-20 17:10:09', '2017-09-16 17:47:36', ' ', '', '', 'publish', 'closed', 'closed', '', '108', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 173, '', 16, 'nav_menu_item', '', 0),
(144, 1, '2017-09-16 23:27:17', '2017-09-16 20:27:17', '', 'Вердикты', '', 'publish', 'closed', 'closed', '', 'verdicts', '', '', '2017-10-08 16:08:49', '2017-10-08 13:08:49', '', 173, '', 6, 'page', '', 0),
(149, 1, '2017-09-16 23:46:00', '2017-09-16 20:46:00', '', 'Рецензенты', '', 'publish', 'closed', 'closed', '', 'experts', '', '', '2017-10-08 15:05:50', '2017-10-08 12:05:50', '', 173, '', 3, 'page', '', 0),
(154, 1, '2021-08-20 17:10:09', '2017-09-16 20:48:02', ' ', '', '', 'publish', 'closed', 'closed', '', '154', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 173, '', 15, 'nav_menu_item', '', 0),
(156, 1, '2017-09-16 23:57:15', '2017-09-16 20:57:15', '', 'Рецензии', '', 'publish', 'closed', 'closed', '', 'reviews', '', '', '2017-10-08 14:33:28', '2017-10-08 11:33:28', '', 173, '', 2, 'page', '', 0),
(169, 1, '2021-08-20 17:10:09', '2017-09-16 21:05:51', ' ', '', '', 'publish', 'closed', 'closed', '', '169', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 173, '', 14, 'nav_menu_item', '', 0),
(170, 1, '2021-08-20 17:10:09', '2017-09-16 21:05:51', ' ', '', '', 'publish', 'closed', 'closed', '', '170', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 173, '', 18, 'nav_menu_item', '', 0),
(173, 1, '2017-09-17 00:08:45', '2017-09-16 21:08:45', '', 'Таблицы', '', 'publish', 'closed', 'closed', '', 'tables', '', '', '2017-11-13 19:54:44', '2017-11-13 16:54:44', '', 0, '', 4, 'page', '', 0);
INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(351, 1, '2017-09-18 00:52:07', '2017-09-17 21:52:07', '', 'cropped-COIcon.png', '', 'inherit', 'open', 'closed', '', 'cropped-coicon-png', '', '', '2017-09-18 00:52:07', '2017-09-17 21:52:07', '', 0, '', 0, 'attachment', 'image/png', 0),
(376, 1, '2017-09-18 01:06:15', '2017-09-17 22:06:15', '', 'Оповещения', '', 'publish', 'closed', 'closed', '', 'info', '', '', '2017-10-16 20:19:07', '2017-10-16 17:19:07', '', 0, '', 4, 'page', '', 0),
(473, 1, '2017-09-19 11:03:06', '2017-09-19 08:03:06', '', 'COLogo', '', 'inherit', 'open', 'closed', '', 'cologo', '', '', '2017-09-19 11:03:06', '2017-09-19 08:03:06', '', 0, '', 0, 'attachment', 'image/png', 0),
(494, 1, '2017-10-03 12:06:15', '2017-10-03 09:06:15', '', 'Рецензии', '', 'publish', 'closed', 'closed', '', 'latereviews', '', '', '2017-10-16 20:21:37', '2017-10-16 17:21:37', '', 376, '', 0, 'page', '', 0);
INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(519, 1, '2017-10-08 15:04:27', '2017-10-08 12:04:27', '', 'Создать рецензента', '', 'publish', 'closed', 'closed', '', 'create', '', '', '2017-10-08 15:04:27', '2017-10-08 12:04:27', '', 149, '', 1, 'page', '', 0),
(521, 1, '2017-10-08 15:06:38', '2017-10-08 12:06:38', '', 'Редактировать рецензента', '', 'publish', 'closed', 'closed', '', 'edit', '', '', '2017-10-08 15:06:38', '2017-10-08 12:06:38', '', 149, '', 2, 'page', '', 0),
(523, 1, '2017-10-08 15:07:04', '2017-10-08 12:07:04', '', 'Создать выпуск', '', 'publish', 'closed', 'closed', '', 'create', '', '', '2017-10-08 15:23:15', '2017-10-08 12:23:15', '', 86, '', 1, 'page', '', 0),
(527, 1, '2017-10-08 15:07:53', '2017-10-08 12:07:53', '', 'Редактировать выпуск', '', 'publish', 'closed', 'closed', '', 'edit', '', '', '2017-10-08 15:07:53', '2017-10-08 12:07:53', '', 86, '', 2, 'page', '', 0),
(529, 1, '2017-10-08 15:08:14', '2017-10-08 12:08:14', '', 'Создать раздел', '', 'publish', 'closed', 'closed', '', 'create', '', '', '2017-10-08 15:08:14', '2017-10-08 12:08:14', '', 78, '', 1, 'page', '', 0),
(531, 1, '2017-10-08 15:08:39', '2017-10-08 12:08:39', '', 'Редактировать раздел', '', 'publish', 'closed', 'closed', '', 'edit', '', '', '2017-10-08 15:08:39', '2017-10-08 12:08:39', '', 78, '', 2, 'page', '', 0),
(533, 1, '2017-10-08 15:09:03', '2017-10-08 12:09:03', '', 'Создать рецензию', '', 'publish', 'closed', 'closed', '', 'create', '', '', '2017-10-08 15:09:03', '2017-10-08 12:09:03', '', 156, '', 1, 'page', '', 0),
(535, 1, '2017-10-08 15:09:28', '2017-10-08 12:09:28', '', 'Редактировать рецензию', '', 'publish', 'closed', 'closed', '', 'edit', '', '', '2017-10-08 15:09:28', '2017-10-08 12:09:28', '', 156, '', 2, 'page', '', 0),
(537, 1, '2017-10-08 15:09:52', '2017-10-08 12:09:52', '', 'Создать вердикт', '', 'publish', 'closed', 'closed', '', 'create', '', '', '2017-10-08 16:08:07', '2017-10-08 13:08:07', '', 144, '', 1, 'page', '', 0),
(539, 1, '2017-10-08 15:10:12', '2017-10-08 12:10:12', '', 'Редактировать вердикт', '', 'publish', 'closed', 'closed', '', 'edit', '', '', '2017-10-08 15:10:12', '2017-10-08 12:10:12', '', 144, '', 2, 'page', '', 0),
(542, 1, '2017-10-09 01:01:53', '2017-10-08 22:01:53', '', 'Статьи', '', 'publish', 'closed', 'closed', '', 'latearticles', '', '', '2017-10-09 01:01:53', '2017-10-08 22:01:53', '', 376, '', 2, 'page', '', 0),
(552, 1, '2021-08-20 17:10:09', '2017-10-12 23:24:52', ' ', '', '', 'publish', 'closed', 'closed', '', '552', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 0, '', 1, 'nav_menu_item', '', 0),
(571, 1, '2021-08-20 17:10:09', '2017-10-16 17:20:34', ' ', '', '', 'publish', 'closed', 'closed', '', '571', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 0, '', 12, 'nav_menu_item', '', 0),
(576, 1, '2017-10-20 21:35:43', '2017-10-20 18:35:43', '', 'Download', '', 'publish', 'closed', 'closed', '', 'download', '', '', '2017-11-13 19:54:59', '2017-11-13 16:54:59', '', 0, '', 6, 'page', '', 0),
(578, 1, '2017-10-26 23:44:45', '2017-10-26 20:44:45', '', 'Статьи', '', 'publish', 'closed', 'closed', '', 'articles', '', '', '2017-11-13 19:54:26', '2017-11-13 16:54:26', '', 0, '', 2, 'page', '', 0),
(580, 1, '2017-10-26 23:45:13', '2017-10-26 20:45:13', '', 'Портфель', '', 'publish', 'closed', 'closed', '', 'nst', '', '', '2017-10-27 19:39:17', '2017-10-27 16:39:17', '', 578, '', 3, 'page', '', 0),
(582, 1, '2017-10-26 23:46:04', '2017-10-26 20:46:04', '', 'Создать статью', '', 'publish', 'closed', 'closed', '', 'create', '', '', '2017-10-26 23:51:05', '2017-10-26 20:51:05', '', 578, '', 1, 'page', '', 0),
(584, 1, '2017-10-26 23:47:11', '2017-10-26 20:47:11', '', 'Детальная информация', '', 'publish', 'closed', 'closed', '', 'view', '', '', '2017-10-26 23:48:26', '2017-10-26 20:48:26', '', 578, '', 2, 'page', '', 0),
(586, 1, '2017-10-26 23:49:17', '2017-10-26 20:49:17', '', 'Опаздывающие', '', 'publish', 'closed', 'closed', '', 'late', '', '', '2017-10-26 23:50:37', '2017-10-26 20:50:37', '', 578, '', 4, 'page', '', 0),
(588, 1, '2017-10-26 23:49:58', '2017-10-26 20:49:58', '', 'Архив', '', 'publish', 'closed', 'closed', '', 'archive', '', '', '2017-10-26 23:50:08', '2017-10-26 20:50:08', '', 578, '', 5, 'page', '', 0),
(591, 1, '2021-08-20 17:10:09', '2017-10-26 20:52:05', ' ', '', '', 'publish', 'closed', 'closed', '', '591', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 0, '', 2, 'nav_menu_item', '', 0),
(592, 1, '2021-08-20 17:10:09', '2017-10-26 20:52:05', ' ', '', '', 'publish', 'closed', 'closed', '', '592', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 578, '', 5, 'nav_menu_item', '', 0),
(593, 1, '2021-08-20 17:10:09', '2017-10-26 20:52:05', ' ', '', '', 'publish', 'closed', 'closed', '', '593', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 578, '', 4, 'nav_menu_item', '', 0),
(596, 1, '2021-08-20 17:10:09', '2017-10-26 20:52:05', ' ', '', '', 'publish', 'closed', 'closed', '', '596', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 578, '', 3, 'nav_menu_item', '', 0),
(597, 1, '2017-10-27 19:37:37', '2017-10-27 16:37:37', '', 'Рецензенты', '', 'publish', 'closed', 'closed', '', 'experts', '', '', '2017-11-13 19:54:34', '2017-11-13 16:54:34', '', 0, '', 3, 'page', '', 0),
(599, 1, '2017-10-27 19:39:57', '2017-10-27 16:39:57', '', 'Перечень', '', 'publish', 'closed', 'closed', '', 'list', '', '', '2017-10-30 12:21:20', '2017-10-30 09:21:20', '', 597, '', 2, 'page', '', 0),
(601, 1, '2017-10-27 19:41:17', '2017-10-27 16:41:17', '', 'Рейтинг', '', 'publish', 'closed', 'closed', '', 'rate', '', '', '2017-10-30 03:38:51', '2017-10-30 00:38:51', '', 597, '', 3, 'page', '', 0),
(603, 1, '2017-10-27 19:41:59', '2017-10-27 16:41:59', '', 'Опаздывающие', '', 'publish', 'closed', 'closed', '', 'late', '', '', '2017-10-30 03:38:55', '2017-10-30 00:38:55', '', 597, '', 4, 'page', '', 0),
(605, 1, '2017-10-27 19:42:29', '2017-10-27 16:42:29', '', 'Выплаты', '', 'publish', 'closed', 'closed', '', 'payment', '', '', '2017-10-30 03:38:58', '2017-10-30 00:38:58', '', 597, '', 5, 'page', '', 0),
(607, 1, '2021-08-20 17:10:09', '2017-10-27 16:43:08', ' ', '', '', 'publish', 'closed', 'closed', '', '607', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 0, '', 7, 'nav_menu_item', '', 0),
(608, 1, '2021-08-20 17:10:09', '2017-10-27 16:43:08', ' ', '', '', 'publish', 'closed', 'closed', '', '608', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 597, '', 11, 'nav_menu_item', '', 0),
(609, 1, '2021-08-20 17:10:09', '2017-10-27 16:43:08', ' ', '', '', 'publish', 'closed', 'closed', '', '609', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 597, '', 10, 'nav_menu_item', '', 0),
(610, 1, '2021-08-20 17:10:09', '2017-10-27 16:43:08', ' ', '', '', 'publish', 'closed', 'closed', '', '610', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 597, '', 9, 'nav_menu_item', '', 0),
(611, 1, '2021-08-20 17:10:09', '2017-10-27 16:43:08', ' ', '', '', 'publish', 'closed', 'closed', '', '611', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 597, '', 8, 'nav_menu_item', '', 0),
(617, 1, '2017-10-30 03:39:21', '2017-10-30 00:39:21', '', 'Детальная информация', '', 'publish', 'closed', 'closed', '', 'view', '', '', '2017-10-30 03:39:35', '2017-10-30 00:39:35', '', 597, '', 0, 'page', '', 0),
(622, 1, '2017-11-14 14:13:47', '2017-11-14 11:13:47', '', 'Статьи', '', 'publish', 'closed', 'closed', '', 'articles', '', '', '2017-11-14 14:14:08', '2017-11-14 11:14:08', '', 173, '', 1, 'page', '', 0),
(624, 1, '2017-11-14 14:14:35', '2017-11-14 11:14:35', '', 'Создать статью', '', 'publish', 'closed', 'closed', '', 'create', '', '', '2017-11-14 14:14:35', '2017-11-14 11:14:35', '', 622, '', 1, 'page', '', 0),
(626, 1, '2017-11-14 14:16:03', '2017-11-14 11:16:03', '', 'Редактировать статью', '', 'publish', 'closed', 'closed', '', 'edit', '', '', '2017-11-14 14:16:03', '2017-11-14 11:16:03', '', 622, '', 2, 'page', '', 0),
(628, 1, '2021-08-20 17:10:09', '2017-11-14 11:16:55', ' ', '', '', 'publish', 'closed', 'closed', '', '628', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 173, '', 13, 'nav_menu_item', '', 0),
(640, 1, '2018-01-18 22:38:26', '2018-01-18 19:38:26', 'Подключи шаблон', 'Test', '', 'private', 'closed', 'closed', '', 'test', '', '', '2018-01-19 01:13:10', '2018-01-18 22:13:10', '', 0, '', 0, 'page', '', 0),
(645, 1, '2018-04-06 11:40:11', '2018-04-06 08:40:11', '', 'Заседание', '', 'publish', 'closed', 'closed', '', 'meeting', '', '', '2018-04-06 11:40:11', '2018-04-06 08:40:11', '', 578, '', 6, 'page', '', 0),
(647, 1, '2021-08-20 17:10:09', '2018-04-06 08:42:20', ' ', '', '', 'publish', 'closed', 'closed', '', '647', '', '', '2021-08-20 17:10:09', '2021-08-20 14:10:09', '', 578, '', 6, 'nav_menu_item', '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `wp_termmeta`
--

CREATE TABLE `wp_termmeta` (
  `meta_id` bigint UNSIGNED NOT NULL,
  `term_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `wp_terms`
--

CREATE TABLE `wp_terms` (
  `term_id` bigint UNSIGNED NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `wp_terms`
--

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Без рубрики', '%d0%b1%d0%b5%d0%b7-%d1%80%d1%83%d0%b1%d1%80%d0%b8%d0%ba%d0%b8', 0),
(2, 'Верхнее меню', '%d0%b2%d0%b5%d1%80%d1%85%d0%bd%d0%b5%d0%b5-%d0%bc%d0%b5%d0%bd%d1%8e', 0),
(3, 'Меню социальных ссылок', '%d0%bc%d0%b5%d0%bd%d1%8e-%d1%81%d0%be%d1%86%d0%b8%d0%b0%d0%bb%d1%8c%d0%bd%d1%8b%d1%85-%d1%81%d1%81%d1%8b%d0%bb%d0%be%d0%ba', 0),
(4, 'Боковое меню', '%d0%b1%d0%be%d0%ba%d0%be%d0%b2%d0%be%d0%b5-%d0%bc%d0%b5%d0%bd%d1%8e', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `wp_term_relationships`
--

CREATE TABLE `wp_term_relationships` (
  `object_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `term_order` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `wp_term_relationships`
--

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(22, 3, 0),
(23, 3, 0),
(24, 3, 0),
(25, 3, 0),
(26, 3, 0),
(30, 2, 0),
(80, 2, 0),
(108, 2, 0),
(154, 2, 0),
(169, 2, 0),
(170, 2, 0),
(552, 2, 0),
(571, 2, 0),
(591, 2, 0),
(592, 2, 0),
(593, 2, 0),
(596, 2, 0),
(607, 2, 0),
(608, 2, 0),
(609, 2, 0),
(610, 2, 0),
(611, 2, 0),
(628, 2, 0),
(647, 2, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `wp_term_taxonomy`
--

CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint UNSIGNED NOT NULL,
  `term_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint UNSIGNED NOT NULL DEFAULT '0',
  `count` bigint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `wp_term_taxonomy`
--

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 0),
(2, 2, 'nav_menu', '', 0, 19),
(3, 3, 'nav_menu', '', 0, 0),
(4, 4, 'nav_menu', '', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `wp_usermeta`
--

CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `wp_users`
--

CREATE TABLE `wp_users` (
  `ID` bigint UNSIGNED NOT NULL,
  `user_login` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` int NOT NULL DEFAULT '0',
  `display_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `wp_wpmm_subscribers`
--

CREATE TABLE `wp_wpmm_subscribers` (
  `id_subscriber` bigint NOT NULL,
  `email` varchar(50) NOT NULL,
  `insert_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `xvals`
--

CREATE TABLE `xvals` (
  `ID_XVAL` int NOT NULL,
  `Title` varchar(31) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Value` varchar(2047) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`ID_Article`),
  ADD KEY `Relation_2` (`ID_Issue`),
  ADD KEY `Relation_3` (`ID_Section`);

--
-- Индексы таблицы `experts`
--
ALTER TABLE `experts`
  ADD PRIMARY KEY (`ID_Expert`);

--
-- Индексы таблицы `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`ID_Issue`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ID_Review`),
  ADD KEY `Relation_4` (`ID_Article`),
  ADD KEY `Relation_5` (`ID_Expert`),
  ADD KEY `Relation_6` (`ID_Verdict`);

--
-- Индексы таблицы `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`ID_Section`),
  ADD KEY `Relation_1` (`ID_Expert`);

--
-- Индексы таблицы `verdicts`
--
ALTER TABLE `verdicts`
  ADD PRIMARY KEY (`ID_Verdict`);

--
-- Индексы таблицы `wp_aryo_activity_log`
--
ALTER TABLE `wp_aryo_activity_log`
  ADD PRIMARY KEY (`histid`);

--
-- Индексы таблицы `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Индексы таблицы `wp_comments`
--
ALTER TABLE `wp_comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_post_ID` (`comment_post_ID`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
  ADD KEY `comment_parent` (`comment_parent`),
  ADD KEY `comment_author_email` (`comment_author_email`(10));

--
-- Индексы таблицы `wp_links`
--
ALTER TABLE `wp_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_visible` (`link_visible`);

--
-- Индексы таблицы `wp_options`
--
ALTER TABLE `wp_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_name` (`option_name`),
  ADD KEY `autoload` (`autoload`);

--
-- Индексы таблицы `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Индексы таблицы `wp_posts`
--
ALTER TABLE `wp_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_name` (`post_name`(191)),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  ADD KEY `post_parent` (`post_parent`),
  ADD KEY `post_author` (`post_author`);

--
-- Индексы таблицы `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Индексы таблицы `wp_terms`
--
ALTER TABLE `wp_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `slug` (`slug`(191)),
  ADD KEY `name` (`name`(191));

--
-- Индексы таблицы `wp_term_relationships`
--
ALTER TABLE `wp_term_relationships`
  ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Индексы таблицы `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- Индексы таблицы `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  ADD PRIMARY KEY (`umeta_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Индексы таблицы `wp_users`
--
ALTER TABLE `wp_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nicename`),
  ADD KEY `user_email` (`user_email`);

--
-- Индексы таблицы `wp_wpmm_subscribers`
--
ALTER TABLE `wp_wpmm_subscribers`
  ADD PRIMARY KEY (`id_subscriber`);

--
-- Индексы таблицы `xvals`
--
ALTER TABLE `xvals`
  ADD PRIMARY KEY (`ID_XVAL`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `articles`
--
ALTER TABLE `articles`
  MODIFY `ID_Article` smallint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `experts`
--
ALTER TABLE `experts`
  MODIFY `ID_Expert` smallint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `issues`
--
ALTER TABLE `issues`
  MODIFY `ID_Issue` tinyint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ID_Review` smallint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `sections`
--
ALTER TABLE `sections`
  MODIFY `ID_Section` tinyint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `verdicts`
--
ALTER TABLE `verdicts`
  MODIFY `ID_Verdict` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `wp_aryo_activity_log`
--
ALTER TABLE `wp_aryo_activity_log`
  MODIFY `histid` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  MODIFY `meta_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `wp_comments`
--
ALTER TABLE `wp_comments`
  MODIFY `comment_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `wp_links`
--
ALTER TABLE `wp_links`
  MODIFY `link_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  MODIFY `meta_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1180;

--
-- AUTO_INCREMENT для таблицы `wp_posts`
--
ALTER TABLE `wp_posts`
  MODIFY `ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=659;

--
-- AUTO_INCREMENT для таблицы `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  MODIFY `meta_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `wp_terms`
--
ALTER TABLE `wp_terms`
  MODIFY `term_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  MODIFY `term_taxonomy_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  MODIFY `umeta_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `wp_users`
--
ALTER TABLE `wp_users`
  MODIFY `ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `wp_wpmm_subscribers`
--
ALTER TABLE `wp_wpmm_subscribers`
  MODIFY `id_subscriber` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `xvals`
--
ALTER TABLE `xvals`
  MODIFY `ID_XVAL` int NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `Relation_2` FOREIGN KEY (`ID_Issue`) REFERENCES `issues` (`ID_Issue`),
  ADD CONSTRAINT `Relation_3` FOREIGN KEY (`ID_Section`) REFERENCES `sections` (`ID_Section`);

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `Relation_4` FOREIGN KEY (`ID_Article`) REFERENCES `articles` (`ID_Article`),
  ADD CONSTRAINT `Relation_5` FOREIGN KEY (`ID_Expert`) REFERENCES `experts` (`ID_Expert`),
  ADD CONSTRAINT `Relation_6` FOREIGN KEY (`ID_Verdict`) REFERENCES `verdicts` (`ID_Verdict`);

--
-- Ограничения внешнего ключа таблицы `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `Relation_1` FOREIGN KEY (`ID_Expert`) REFERENCES `experts` (`ID_Expert`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
