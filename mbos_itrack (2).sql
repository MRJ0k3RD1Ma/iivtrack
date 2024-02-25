-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2024 at 07:20 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mbos_itrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address` varchar(500) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `long` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `soato_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address`, `lat`, `long`, `created`, `updated`, `user_id`, `soato_id`) VALUES
('Ozero', '41.55257828249837', '60.61355614571813', NULL, NULL, 4, NULL),
('Sevinch klinikasi', '41.549473530377426', '60.636231482390826', NULL, NULL, 4, NULL),
('Urganch shahar xalqaro airaporti', '41.58531116985703', '60.632868011900094', NULL, NULL, 4, NULL),
('Xorazm viloyati hokimligi', '41.54912838152944', '60.63035863957408', NULL, NULL, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `call`
--

CREATE TABLE `call` (
  `id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `code_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `call`
--

INSERT INTO `call` (`id`, `code`, `code_id`, `name`, `phone`, `gender`, `type_id`, `detail`, `address`, `user_id`, `created`, `updated`, `status`) VALUES
(1, NULL, NULL, 'Dilmurod', '+998999670395', 1, 1, 'Ikki kishi janjallashmoqda sevinch klinikani orqa tomonida', 'Sevinch klinikasi', 4, '2024-02-25 03:02:02', '2024-02-25 03:02:02', 1),
(2, NULL, NULL, 'asdasd', 'asdasd', 1, 1, 'asdasd', 'Ozero', 4, '2024-02-25 15:34:32', '2024-02-25 15:34:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `call_type`
--

CREATE TABLE `call_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `call_type`
--

INSERT INTO `call_type` (`id`, `name`) VALUES
(1, 'Janjal'),
(2, 'O\'g\'irlik');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL DEFAULT '',
  `logo` varchar(255) DEFAULT NULL,
  `location` text DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `wifi` varchar(255) DEFAULT NULL,
  `work_begin` varchar(255) DEFAULT NULL,
  `work_end` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `work_status` int(11) DEFAULT 0,
  `theme_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `address` varchar(500) NOT NULL DEFAULT '',
  `target` varchar(500) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL COMMENT 'url uchun qisqa nom',
  `soato_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `logo`, `location`, `lat`, `long`, `phone`, `phone2`, `wifi`, `work_begin`, `work_end`, `status`, `work_status`, `theme_id`, `created`, `updated`, `address`, `target`, `alias`, `soato_id`) VALUES
(1, 'Olimp kafe', 'logo/1696675400.9748.jpg', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2985.7262332944465!2d60.59011017650768!3d41.55352448567294!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x41dfc91a77cd15c7%3A0x413c70e098355c40!2sOlimp%20Kafe!5e0!3m2!1sru!2s!4v1696675334448!5m2!1sru!2s\" height=\"450\" style=\"border:0; width:100%\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '41.5535245', '60.5901102', '1177', '+998 99 740 00 38', '', '09:00', '23:00', 1, 1, NULL, '2023-10-07 15:43:20', '2023-10-10 17:39:37', 'Urganch tumani (Raysentr) / Uzbekistan -', 'Yetkazib berish xizmati mavjud: ', NULL, 1733401);

-- --------------------------------------------------------

--
-- Stand-in structure for view `district_view`
-- (See below for the actual view)
--
CREATE TABLE `district_view` (
`id` bigint(20)
,`region_id` int(11)
,`district_id` int(11)
,`name_lot` varchar(100)
,`center_lot` varchar(50)
,`name_cyr` varchar(100)
,`center_cyr` varchar(50)
,`name_ru` varchar(100)
,`center_ru` varchar(50)
,`sector` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `region_view`
-- (See below for the actual view)
--
CREATE TABLE `region_view` (
`id` bigint(20)
,`region_id` int(11)
,`district_id` int(11)
,`name_lot` varchar(100)
,`center_lot` varchar(50)
,`name_cyr` varchar(100)
,`center_cyr` varchar(50)
,`name_ru` varchar(100)
,`center_ru` varchar(50)
,`sector` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `soato`
--

CREATE TABLE `soato` (
  `id` bigint(20) NOT NULL,
  `res_id` int(11) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `qfi_id` int(11) DEFAULT NULL,
  `mahalla_id` int(11) DEFAULT NULL,
  `name_lot` varchar(100) DEFAULT NULL,
  `center_lot` varchar(50) DEFAULT NULL,
  `name_cyr` varchar(100) DEFAULT NULL,
  `center_cyr` varchar(50) DEFAULT NULL,
  `name_ru` varchar(100) DEFAULT NULL,
  `center_ru` varchar(50) DEFAULT NULL,
  `sector` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `soato`
--

INSERT INTO `soato` (`id`, `res_id`, `region_id`, `district_id`, `qfi_id`, `mahalla_id`, `name_lot`, `center_lot`, `name_cyr`, `center_cyr`, `name_ru`, `center_ru`, `sector`) VALUES
(17, 17, NULL, NULL, NULL, NULL, 'O\'zbekiston Respublikasi', NULL, 'Ўзбекистон Республикаси', NULL, 'Республика Узбекистан', NULL, 0),
(1703, 17, 3, NULL, NULL, NULL, 'Andijon viloyati', 'Andijon sh.', 'Андижон вилояти', 'Андижон ш.', 'Андижанская область', 'г. Андижан', 0),
(1706, 17, 6, NULL, NULL, NULL, 'Buxoro viloyati', 'Buxoro sh.', 'Бухоро вилояти', 'Бухоро ш.', 'Бухарская область', 'г. Бухара', 0),
(1708, 17, 8, NULL, NULL, NULL, 'Jizzax viloyati', 'Jizzax sh.', 'Жиззах вилояти', 'Жиззах ш.', 'Джизакская область', 'г. Джизак', 0),
(1710, 17, 10, NULL, NULL, NULL, 'Qashqadaryo viloyati', 'Qarshi sh.', 'Қашқадарё вилояти', 'Қарши ш.', 'Кашкадарьинская область', 'г. Карши', 0),
(1712, 17, 12, NULL, NULL, NULL, 'Navoiy viloyati', 'Navoiy sh.', 'Навоий вилояти', 'Навоий ш.', 'Навоийская область', 'г. Навои', 0),
(1714, 17, 14, NULL, NULL, NULL, 'Namangan viloyati', 'Namangan sh.', 'Наманган вилояти', 'Наманган ш.', 'Наманганская область', 'г. Наманган', 0),
(1718, 17, 18, NULL, NULL, NULL, 'Samarqand viloyati', 'Samarqand sh.', 'Самарқанд вилояти', 'Самарқанд ш.', 'Самаркандская область', 'г. Самарканд', 0),
(1722, 17, 22, NULL, NULL, NULL, 'Surxondaryo viloyati', 'Termiz sh.', 'Сурхондарё вилояти', 'Термиз ш.', 'Сурхандарьинская область', 'г. Термез', 0),
(1724, 17, 24, NULL, NULL, NULL, 'Sirdaryo viloyati', 'Guliston sh.', 'Сирдарё вилояти', 'Гулистон ш.', 'Сырдарьинская область', 'г. Гулистан', 0),
(1726, 17, 26, NULL, NULL, NULL, 'Toshkent shahri', NULL, 'Тошкент шаҳри', NULL, 'город Ташкент', NULL, 0),
(1727, 17, 27, NULL, NULL, NULL, 'Toshkent viloyati', 'Nurafshon sh.', 'Тошкент вилояти', 'Нурафшон ш.', 'Ташкентская область', 'г. Нурафшон', 0),
(1730, 17, 30, NULL, NULL, NULL, 'Farg\'ona viloyati', 'Farg\'ona sh.', 'Фарғона вилояти', 'Фарғона ш.', 'Ферганская область', 'г. Фергана', 0),
(1733, 17, 33, NULL, NULL, NULL, 'Xorazm viloyati', 'Urganch sh.', 'Хоразм вилояти', 'Урганч ш.', 'Хорезмская область', 'г. Ургенч', 0),
(1735, 17, 35, NULL, NULL, NULL, 'Qoraqalpog\'iston Respublikasi', 'Nukus sh.', 'Қорақалпоғистон Республикаси', 'Нукус ш.', 'Республика Каракалпакстан', 'г. Hукус', 0),
(1703202, 17, 3, 202, NULL, NULL, 'Oltinko\'l tumani', 'Oltinko\'l a.p.', 'Олтинкўл тумани', 'Олтинкўл а.п.', 'Алтынкульский район', 'нп Алтынкуль', 0),
(1703203, 17, 3, 203, NULL, NULL, 'Andijon tumani', 'Kuyganyor shaharchasi', 'Андижон тумани', 'Куйганёр шаҳарчаси', 'Андижанский район', 'гп Куйганяр', 0),
(1703206, 17, 3, 206, NULL, NULL, 'Baliqchi tumani', 'Baliqchi shaharchasi', 'Балиқчи тумани', 'Балиқчи шаҳарчаси', 'Балыкчинский район', 'гп Баликчи', 0),
(1703209, 17, 3, 209, NULL, NULL, 'Bo\'ston tumani', 'Bo\'z shaharchasi', 'Бўстон тумани', 'Бўз шаҳарчаси', 'Бустонский район', 'гп Боз', 0),
(1703210, 17, 3, 210, NULL, NULL, 'Buloqboshi tumani', 'Buloqboshi shaharchasi', 'Булоқбоши тумани', 'Булоқбоши шаҳарчаси', 'Булакбашинский район', 'гп Булокбоши', 0),
(1703211, 17, 3, 211, NULL, NULL, 'Jalaquduq tumani', 'Jalaquduq sh.', 'Жалақудуқ тумани', 'Жалақудуқ ш.', 'Жалакудукский район', 'г.Жалакудук', 0),
(1703214, 17, 3, 214, NULL, NULL, 'Izboskan tumani', 'Paytug sh.', 'Избоскан тумани', 'Пайтуг ш.', 'Избасканский район', 'г.Пайтуг', 0),
(1703217, 17, 3, 217, NULL, NULL, 'Ulug\'nor tumani', 'Oq oltin shaharchasi', 'Улуғнор тумани', 'Оқ олтин шаҳарчаси', 'Улугноpский район', 'гп Ок-олтин', 0),
(1703220, 17, 3, 220, NULL, NULL, 'Qo\'rg\'ontepa tumani', 'Qo\'rg\'ontepa sh.', 'Қўрғонтепа тумани', 'Қўрғонтепа ш.', 'Кургантепинский район', 'г.Кургантепа', 0),
(1703224, 17, 3, 224, NULL, NULL, 'Asaka tumani', 'Asaka sh.', 'Асака тумани', 'Асака ш.', 'Асакинский район', 'г.Асака', 0),
(1703227, 17, 3, 227, NULL, NULL, 'Marxamat tumani', 'Marxamat sh.', 'Мархамат тумани', 'Мархамат ш.', 'Мархаматский район', 'г.Мархамат', 0),
(1703230, 17, 3, 230, NULL, NULL, 'Shaxrixon tumani', 'Shaxrixon sh.', 'Шахрихон тумани', 'Шахрихон ш.', 'Шахриханский район', 'г.Шахрихан', 0),
(1703232, 17, 3, 232, NULL, NULL, 'Paxtaobod tumani', 'Paxtaobod sh.', 'Пахтаобод тумани', 'Пахтаобод ш.', 'Пахтаабадский район', 'г.Пахтаабад', 0),
(1703236, 17, 3, 236, NULL, NULL, 'Xo\'jaobod tumani', 'Xo\'jaobod sh.', 'Хўжаобод тумани', 'Хўжаобод ш.', 'Ходжаабадский район', 'г.Ходжаабад', 0),
(1703401, 17, 3, 401, NULL, NULL, 'Andijon shahar', NULL, 'Андижон', NULL, 'Андижан', NULL, 0),
(1703408, 17, 3, 408, NULL, NULL, 'Xonobod shahar', NULL, 'Хонобод', NULL, 'Ханабад', NULL, 0),
(1706204, 17, 6, 204, NULL, NULL, 'Olot tumani', 'Olot sh.', 'Олот тумани', 'Олот ш.', 'Алатский район', 'г.Алат', 0),
(1706207, 17, 6, 207, NULL, NULL, 'Buxoro tumani', 'Gala Osiyo shaharchasi', 'Бухоро тумани', 'Гала Осиё шаҳарчаси', 'Бухарский район', 'г. Галлаасия', 0),
(1706212, 17, 6, 212, NULL, NULL, 'Vobkent tumani', 'Vobkent sh.', 'Вобкент тумани', 'Вобкент ш.', 'Вабкентский район', 'г. Вабкент', 0),
(1706215, 17, 6, 215, NULL, NULL, 'G\'ijduvon tumani', 'G\'ijduvon sh.', 'Ғиждувон тумани', 'Ғиждувон ш.', 'Гиждуванский район', 'г. Гиждуван', 0),
(1706219, 17, 6, 219, NULL, NULL, 'Kogon tumani', 'Kogon sh.', 'Когон тумани', 'Когон ш.', 'Каганский район', 'г. Каган', 0),
(1706230, 17, 6, 230, NULL, NULL, 'Qorako\'l tumani', 'Qorako\'l sh.', 'Қоракўл тумани', 'Қоракўл ш.', 'Каракульский район', 'г. Каракуль', 0),
(1706232, 17, 6, 232, NULL, NULL, 'Qorovulbozor tumani', 'Qorovulbozor sh.', 'Қоровулбозор тумани', 'Қоровулбозор ш.', 'Караулбазарский район', 'г. Каpаулбазаp', 0),
(1706240, 17, 6, 240, NULL, NULL, 'Peshku tumani', 'Yangibozor shaharchasi', 'Пешку тумани', 'Янгибозор шаҳарчаси', 'Пешкунский район', 'гп Янгибозор', 0),
(1706242, 17, 6, 242, NULL, NULL, 'Romitan tumani', 'Romitan sh.', 'Ромитан тумани', 'Ромитан ш.', 'Ромитанский район', 'г. Ромитан', 0),
(1706246, 17, 6, 246, NULL, NULL, 'Jondor tumani', 'Jondor shaharchasi', 'Жондор тумани', 'Жондор шаҳарчаси', 'Жондоpский район', 'гп Жондор', 0),
(1706258, 17, 6, 258, NULL, NULL, 'Shofirkon tumani', 'Shofirkon sh.', 'Шофиркон тумани', 'Шофиркон ш.', 'Шафирканский район', 'г. Шафиркан', 0),
(1706401, 17, 6, 401, NULL, NULL, 'Buxoro shahar', NULL, 'Бухоро', NULL, 'Бухара', NULL, 0),
(1706403, 17, 6, 403, NULL, NULL, 'Kogon shahar', NULL, 'Когон', NULL, 'Каган', NULL, 0),
(1708201, 17, 8, 201, NULL, NULL, 'Arnasoy tumani', 'G\'oliblar shaharchasi', 'Арнасой тумани', 'Ғолиблар шаҳарчаси', 'Арнасайский район', 'гп Голиблаp', 0),
(1708204, 17, 8, 204, NULL, NULL, 'Baxmal tumani', 'O\'smat shaharchasi', 'Бахмал тумани', 'Ўсмат шаҳарчаси', 'Бахмальский район', 'гп Усмат', 0),
(1708209, 17, 8, 209, NULL, NULL, 'G\'allaorol tumani', 'G\'allaorol sh.', 'Ғаллаорол тумани', 'Ғаллаорол ш.', 'Галляаральский район', 'г. Галляарал', 0),
(1708212, 17, 8, 212, NULL, NULL, 'Sharof Rashidov tumani', 'Uchtepa shaharchasi', 'Шароф Рашидов тумани', 'Учтепа шаҳарчаси', 'Шароф Рашидовский район', 'гп Уч-тепа', 0),
(1708215, 17, 8, 215, NULL, NULL, 'Do\'stlik tumani', 'Do\'stlik sh.', 'Дўстлик тумани', 'Дўстлик ш.', 'Дустликский район', 'г. Дустлик', 0),
(1708218, 17, 8, 218, NULL, NULL, 'Zomin tumani', 'Zomin shaharchasi', 'Зомин тумани', 'Зомин шаҳарчаси', 'Зааминский район', 'гп Заамин', 0),
(1708220, 17, 8, 220, NULL, NULL, 'Zarbdor tumani', 'Zarbdor shaharchasi', 'Зарбдор тумани', 'Зарбдор шаҳарчаси', 'Зарбдарский район', 'гп Зарбдар', 0),
(1708223, 17, 8, 223, NULL, NULL, 'Mirzacho\'l tumani', 'Gagarin sh.', 'Мирзачўл тумани', 'Гагарин ш.', 'Мирзачульский район', 'г. Гагарин', 0),
(1708225, 17, 8, 225, NULL, NULL, 'Zafarobod tumani', 'Zafarobod shaharchasi', 'Зафаробод тумани', 'Зафаробод шаҳарчаси', 'Зафарабадский район', 'гп Зафарабад', 0),
(1708228, 17, 8, 228, NULL, NULL, 'Paxtakor tumani', 'Paxtakor sh.', 'Пахтакор тумани', 'Пахтакор ш.', 'Пахтакорский район', 'г. Пахтакор', 0),
(1708235, 17, 8, 235, NULL, NULL, 'Forish tumani', 'Bog\'don shaharchasi', 'Фориш тумани', 'Боғдон шаҳарчаси', 'Фаришский район', 'гп Богдон', 0),
(1708237, 17, 8, 237, NULL, NULL, 'Yangiobod tumani', 'Balandchaqir a.p.', 'Янгиобод тумани', 'Баландчақир а.п.', 'Янгиободский район', 'нп Баландчакир', 0),
(1708401, 17, 8, 401, NULL, NULL, 'Jizzax shahar', NULL, 'Жиззах', NULL, 'Джизак', NULL, 0),
(1710207, 17, 10, 207, NULL, NULL, 'G\'uzor tumani', 'G\'uzor sh.', 'Ғузор тумани', 'Ғузор ш.', 'Гузарский район', 'г. Гузар', 0),
(1710212, 17, 10, 212, NULL, NULL, 'Dehqonobod tumani', 'Karashina shaharchasi', 'Деҳқонобод тумани', 'Карашина шаҳарчаси', 'Дехканабадский район', 'гп Корашина', 0),
(1710220, 17, 10, 220, NULL, NULL, 'Qamashi tumani', 'Qamashi sh.', 'Қамаши тумани', 'Қамаши ш.', 'Камашинский район', 'г. Камаши', 0),
(1710224, 17, 10, 224, NULL, NULL, 'Qarshi tumani', 'Beshkent sh.', 'Қарши тумани', 'Бешкент ш.', 'Каршинский район', 'г. Бешкент', 0),
(1710229, 17, 10, 229, NULL, NULL, 'Koson tumani', 'Koson sh.', 'Косон тумани', 'Косон ш.', 'Касанский район', 'г. Касан', 0),
(1710232, 17, 10, 232, NULL, NULL, 'Kitob tumani', 'Kitob sh.', 'Китоб тумани', 'Китоб ш.', 'Китабский район', 'г. Китаб', 0),
(1710233, 17, 10, 233, NULL, NULL, 'Mirishkor tumani', 'Yangi Mirishkor shaharchasi', 'Миришкор тумани', 'Янги Миришкор шаҳарчаси', 'Миришкорский район', 'гп Янги Миришкор', 0),
(1710234, 17, 10, 234, NULL, NULL, 'Muborak tumani', 'Muborak sh.', 'Муборак тумани', 'Муборак ш.', 'Мубарекский район', 'г. Мубарек', 0),
(1710235, 17, 10, 235, NULL, NULL, 'Nishon tumani', 'Yangi Nishon sh.', 'Нишон тумани', 'Янги Нишон ш.', 'Нишанский район', 'г. Янги-Нишан', 0),
(1710237, 17, 10, 237, NULL, NULL, 'Kasbi tumani', 'Mug\'lon shaharchasi', 'Касби тумани', 'Муғлон шаҳарчаси', 'Касбинский район', 'гп Муглон', 0),
(1710242, 17, 10, 242, NULL, NULL, 'Chiroqchi tumani', 'Chiroqchi sh.', 'Чироқчи тумани', 'Чироқчи ш.', 'Чиракчинский район', 'г. Чиракчи', 0),
(1710245, 17, 10, 245, NULL, NULL, 'Shahrisabz tumani', 'Shahrisabz sh.', 'Шаҳрисабз тумани', 'Шаҳрисабз ш.', 'Шахрисабзский район', 'г. Шахрисабз', 0),
(1710250, 17, 10, 250, NULL, NULL, 'Yakkabog\' tumani', 'Yakkabog\' sh.', 'Яккабоғ тумани', 'Яккабоғ ш.', 'Яккабагский район', 'г. Яккабаг', 0),
(1710401, 17, 10, 401, NULL, NULL, 'Qarshi shahar', NULL, 'Қарши', NULL, 'Карши', NULL, 0),
(1710405, 17, 10, 405, NULL, NULL, 'Shahrisabz shahar', NULL, 'Шаҳрисабз', NULL, 'Шахрисабз', NULL, 0),
(1712211, 17, 12, 211, NULL, NULL, 'Konimex tumani', 'Konimex shaharchasi', 'Конимех тумани', 'Конимех шаҳарчаси', 'Канимехский район', 'гп Канимех', 0),
(1712216, 17, 12, 216, NULL, NULL, 'Qiziltepa tumani', 'Qiziltepa sh.', 'Қизилтепа тумани', 'Қизилтепа ш.', 'Кызылтепинский район', 'г. Кызылтепа', 0),
(1712230, 17, 12, 230, NULL, NULL, 'Navbahor tumani', 'Beshrabot a.p.', 'Навбаҳор тумани', 'Бешработ а.п.', 'Навбахорский район', 'нп Бешрабад', 0),
(1712234, 17, 12, 234, NULL, NULL, 'Karmana tumani', 'Karmana shaharchasi', 'Кармана тумани', 'Кармана шаҳарчаси', 'Карманинский район', 'гп Кармана', 0),
(1712238, 17, 12, 238, NULL, NULL, 'Nurota tumani', 'Nurota sh.', 'Нурота тумани', 'Нурота ш.', 'Нуратинский район', 'г. Нурата', 0),
(1712244, 17, 12, 244, NULL, NULL, 'Tomdi tumani', 'Tomdibuloq shaharchasi', 'Томди тумани', 'Томдибулоқ шаҳарчаси', 'Тамдынский район', 'гп Томдибулок', 0),
(1712248, 17, 12, 248, NULL, NULL, 'Uchquduq tumani', 'Uchquduq sh.', 'Учқудуқ тумани', 'Учқудуқ ш.', 'Учкудукский район', 'г. Учкудук', 0),
(1712251, 17, 12, 251, NULL, NULL, 'Xatirchi tumani', 'Yangirabod sh.', 'Хатирчи тумани', 'Янгирабод ш.', 'Хатырчинский район', 'г. Янгирабод', 0),
(1712401, 17, 12, 401, NULL, NULL, 'Navoiy shahar', NULL, 'Навоий', NULL, 'Навои', NULL, 0),
(1712408, 17, 12, 408, NULL, NULL, 'Zarafshon shahar', NULL, 'Зарафшон', NULL, 'Заpафшан', NULL, 0),
(1712412, 17, 12, 412, NULL, NULL, 'G\'ozg\'on shahar', NULL, 'Ғозғон', NULL, 'Газган', NULL, 0),
(1714204, 17, 14, 204, NULL, NULL, 'Mingbuloq tumani', 'Jo\'masho\'y shaharchasi', 'Мингбулоқ тумани', 'Жўмашўй шаҳарчаси', 'Мингбулакский pайон', 'гп Джумашуй', 0),
(1714207, 17, 14, 207, NULL, NULL, 'Kosonsoy tumani', 'Kosonsoy sh.', 'Косонсой тумани', 'Косонсой ш.', 'Касансайский район', 'г. Касансай', 0),
(1714212, 17, 14, 212, NULL, NULL, 'Namangan tumani', 'Toshbuloq shaharchasi', 'Наманган тумани', 'Тошбулоқ шаҳарчаси', 'Наманганский район', 'гп Ташбулак', 0),
(1714216, 17, 14, 216, NULL, NULL, 'Norin tumani', 'Xaqqulobod sh.', 'Норин тумани', 'Хаққулобод ш.', 'Нарынский район', 'г. Хаккулабад', 0),
(1714219, 17, 14, 219, NULL, NULL, 'Pop tumani', 'Pop sh.', 'Поп тумани', 'Поп ш.', 'Папский район', 'г. Пап', 0),
(1714224, 17, 14, 224, NULL, NULL, 'To\'raqo\'rg\'on tumani', 'To\'raqo\'rg\'on sh.', 'Тўрақўрғон тумани', 'Тўрақўрғон ш.', 'Туракурганский район', 'г. Туракурган', 0),
(1714229, 17, 14, 229, NULL, NULL, 'Uychi tumani', 'Uychi shaharchasi', 'Уйчи тумани', 'Уйчи шаҳарчаси', 'Уйчинский район', 'гп Уйчи', 0),
(1714234, 17, 14, 234, NULL, NULL, 'Uchqo\'rg\'on tumani', 'Uchqo\'rg\'on sh.', 'Учқўрғон тумани', 'Учқўрғон ш.', 'Учкурганский район', 'г. Учкурган', 0),
(1714236, 17, 14, 236, NULL, NULL, 'Chortoq tumani', 'Chortoq sh.', 'Чортоқ тумани', 'Чортоқ ш.', 'Чартакский район', 'г. Чартак', 0),
(1714237, 17, 14, 237, NULL, NULL, 'Chust tumani', 'Chust sh.', 'Чуст тумани', 'Чуст ш.', 'Чустский район', 'г. Чуст', 0),
(1714242, 17, 14, 242, NULL, NULL, 'Yangiqo\'rg\'on tumani', 'Yangiqo\'rg\'on shaharchasi', 'Янгиқўрғон тумани', 'Янгиқўрғон шаҳарчаси', 'Янгикурганский район', 'гп Янгикурган', 0),
(1714401, 17, 14, 401, NULL, NULL, 'Namangan shahar', NULL, 'Наманган', NULL, 'Наманган', NULL, 0),
(1718203, 17, 18, 203, NULL, NULL, 'Oqdaryo tumani', 'Loyish shaharchasi', 'Оқдарё тумани', 'Лойиш шаҳарчаси', 'Акдарьинский район', 'гп Лаиш', 0),
(1718206, 17, 18, 206, NULL, NULL, 'Bulung\'ur tumani', 'Bulung\'ur sh.', 'Булунғур тумани', 'Булунғур ш.', 'Булунгурский район', 'г. Булунгур', 0),
(1718209, 17, 18, 209, NULL, NULL, 'Jomboy tumani', 'Jomboy sh.', 'Жомбой тумани', 'Жомбой ш.', 'Джамбайский район', 'г. Джамбай', 0),
(1718212, 17, 18, 212, NULL, NULL, 'Ishtixon tumani', 'Ishtixon sh.', 'Иштихон тумани', 'Иштихон ш.', 'Иштыханский район', 'г. Иштыхан', 0),
(1718215, 17, 18, 215, NULL, NULL, 'Kattaqo\'rg\'on tumani', 'Payshanba shaharchasi', 'Каттақўрғон тумани', 'Пайшанба шаҳарчаси', 'Каттакурганский район', 'гп Пайшанба', 0),
(1718216, 17, 18, 216, NULL, NULL, 'Qo\'shrabot tumani', 'Qo\'shrabot shaharchasi', 'Қўшработ тумани', 'Қўшработ шаҳарчаси', 'Кошрабадский район', 'гп Кушрабад', 0),
(1718218, 17, 18, 218, NULL, NULL, 'Narpay tumani', 'Oqtosh sh.', 'Нарпай тумани', 'Оқтош ш.', 'Нарпайский район', 'г. Акташ', 0),
(1718224, 17, 18, 224, NULL, NULL, 'Payariq tumani', 'Payariq sh.', 'Паяриқ тумани', 'Паяриқ ш.', 'Пайарыкский район', 'г.Пайаpык', 0),
(1718227, 17, 18, 227, NULL, NULL, 'Pastdarg\'om tumani', 'Juma sh.', 'Пастдарғом тумани', 'Жума ш.', 'Пастдаргомский район', 'г. Джума', 0),
(1718230, 17, 18, 230, NULL, NULL, 'Paxtachi tumani', 'Ziyovuddin shaharchasi', 'Пахтачи тумани', 'Зиёвуддин шаҳарчаси', 'Пахтачийский район', 'гп Зиатдин', 0),
(1718233, 17, 18, 233, NULL, NULL, 'Samarqand tumani', 'Gulobod shaharchasi', 'Самарқанд тумани', 'Гулобод шаҳарчаси', 'Самаркандский район', 'гп Гулабад', 0),
(1718235, 17, 18, 235, NULL, NULL, 'Nurobod tumani', 'Nurobod sh.', 'Нуробод тумани', 'Нуробод ш.', 'Нурабадский район', 'г. Нурабад', 0),
(1718236, 17, 18, 236, NULL, NULL, 'Urgut tumani', 'Urgut sh.', 'Ургут тумани', 'Ургут ш.', 'Ургутский район', 'г. Ургут', 0),
(1718238, 17, 18, 238, NULL, NULL, 'Tayloq tumani', 'Toyloq shaharchasi', 'Тайлоқ тумани', 'Тойлоқ шаҳарчаси', 'Тайлякский район', 'гп Тайлок', 0),
(1718401, 17, 18, 401, NULL, NULL, 'Samarqand shahar', NULL, 'Самарқанд', NULL, 'Самарканд', NULL, 0),
(1718406, 17, 18, 406, NULL, NULL, 'Kattaqo\'rg\'on', NULL, 'Каттақўрғон', NULL, 'Каттакурган', NULL, 0),
(1722201, 17, 22, 201, NULL, NULL, 'Oltinsoy tumani', 'Qorliq shaharchasi', 'Олтинсой тумани', 'Қорлиқ шаҳарчаси', 'Алтынсайский район', 'гп Корлик', 0),
(1722202, 17, 22, 202, NULL, NULL, 'Angor tumani', 'Angor shaharchasi', 'Ангор тумани', 'Ангор шаҳарчаси', 'Ангорский район', 'гп Ангор', 0),
(1722203, 17, 22, 203, NULL, NULL, 'Bandixon tumani', 'Bandixon shaharchasi', 'Бандихон тумани', 'Бандихон шаҳарчаси', 'Бандихонский район', 'гп Бандихон', 0),
(1722204, 17, 22, 204, NULL, NULL, 'Boysun tumani', 'Boysun sh.', 'Бойсун тумани', 'Бойсун ш.', 'Байсунский район', 'г. Байсун', 0),
(1722207, 17, 22, 207, NULL, NULL, 'Muzrabot tumani', 'Xalqobod shaharchasi', 'Музработ тумани', 'Халқобод шаҳарчаси', 'Музрабадский район', 'гп Халкабад', 0),
(1722210, 17, 22, 210, NULL, NULL, 'Denov tumani', 'Denov sh.', 'Денов тумани', 'Денов ш.', 'Денауский район', 'г. Денау', 0),
(1722212, 17, 22, 212, NULL, NULL, 'Jarqo\'rg\'on tumani', 'Jarqo\'rg\'on sh.', 'Жарқўрғон тумани', 'Жарқўрғон ш.', 'Джаркурганский район', 'г. Джаркурган', 0),
(1722214, 17, 22, 214, NULL, NULL, 'Qumqo\'rg\'on tumani', 'Qumqo\'rg\'on sh.', 'Қумқўрғон тумани', 'Қумқўрғон ш.', 'Кумкурганский район', 'г. Кумкурган', 0),
(1722215, 17, 22, 215, NULL, NULL, 'Qiziriq tumani', 'Sariq shaharchasi', 'Қизириқ тумани', 'Сариқ шаҳарчаси', 'Кизирикский район', 'гп Сарик', 0),
(1722217, 17, 22, 217, NULL, NULL, 'Sariosiyo tumani', 'Sariosiyo shaharchasi', 'Сариосиё тумани', 'Сариосиё шаҳарчаси', 'Сариасийский район', 'гп Сариасия', 0),
(1722220, 17, 22, 220, NULL, NULL, 'Termiz tumani', 'Uchqizil shaharchasi', 'Термиз тумани', 'Учқизил шаҳарчаси', 'Термезский район', 'гп Учкизил', 0),
(1722221, 17, 22, 221, NULL, NULL, 'Uzun tumani', 'Uzun shaharchasi', 'Узун тумани', 'Узун шаҳарчаси', 'Узунский район', 'гп Узун', 0),
(1722223, 17, 22, 223, NULL, NULL, 'Sherobod tumani', 'Sherobod sh.', 'Шеробод тумани', 'Шеробод ш.', 'Шерабадский район', 'г. Шерабад', 0),
(1722226, 17, 22, 226, NULL, NULL, 'Sho\'rchi tumani', 'Sho\'rchi sh.', 'Шўрчи тумани', 'Шўрчи ш.', 'Шурчинский район', 'г. Шурчи', 0),
(1722401, 17, 22, 401, NULL, NULL, 'Termiz shahar', NULL, 'Термиз', NULL, 'Термез', NULL, 0),
(1724206, 17, 24, 206, NULL, NULL, 'Oqoltin tumani', 'Sardoba shaharchasi', 'Оқолтин тумани', 'Сардоба шаҳарчаси', 'Акалтынский район', 'гп Сардоба', 0),
(1724212, 17, 24, 212, NULL, NULL, 'Boyovut tumani', 'Boyovut shaharchasi', 'Боёвут тумани', 'Боёвут шаҳарчаси', 'Баяутский район', 'гп Баяут', 0),
(1724216, 17, 24, 216, NULL, NULL, 'Sayxunobod tumani', 'Sayxun shaharcha', 'Сайхунобод тумани', 'Сайхун шаҳарча', 'Сайхунабадский район', 'гп Сайхун', 0),
(1724220, 17, 24, 220, NULL, NULL, 'Guliston tumani', 'Dehqonobod shaharchasi', 'Гулистон тумани', 'Деҳқонобод шаҳарчаси', 'Гулистанский район', 'гп Дехканабад', 0),
(1724226, 17, 24, 226, NULL, NULL, 'Sardoba tumani', 'Paxtaobod shaharchasi', 'Сардоба тумани', 'Пахтаобод шаҳарчаси', 'Сардобский район', 'гп Пахтаабад', 0),
(1724228, 17, 24, 228, NULL, NULL, 'Mirzaobod tumani', 'Navro\'z shaharchasi', 'Мирзаобод тумани', 'Наврўз шаҳарчаси', 'Мирзаабадский район', 'гп Навруз', 0),
(1724231, 17, 24, 231, NULL, NULL, 'Sirdaryo tumani', 'Sirdaryo sh.', 'Сирдарё тумани', 'Сирдарё ш.', 'Сырдарьинский район', 'г. Сырдарья', 0),
(1724235, 17, 24, 235, NULL, NULL, 'Xovos tumani', 'Xovos shaharchasi', 'Ховос тумани', 'Ховос шаҳарчаси', 'Хавасский район', 'гп Хавас', 0),
(1724401, 17, 24, 401, NULL, NULL, 'Guliston shahar', NULL, 'Гулистон', NULL, 'Гулистан', NULL, 0),
(1724410, 17, 24, 410, NULL, NULL, 'Shirin shahar', NULL, 'Ширин', NULL, 'Шиpин', NULL, 0),
(1724413, 17, 24, 413, NULL, NULL, 'Yangiyer shahar', NULL, 'Янгиер', NULL, 'Янгиеp', NULL, 0),
(1726260, 17, 26, 260, NULL, NULL, 'Toshkent shahrining tumanlari', NULL, 'Тошкент шаҳрининг туманлари', NULL, 'Районы города Ташкента', NULL, 0),
(1726262, 17, 26, 262, NULL, NULL, 'Uchtepa tumani', NULL, 'Учтепа тумани', NULL, 'Учтепинский район', NULL, 0),
(1726264, 17, 26, 264, NULL, NULL, 'Bektemir tumani', NULL, 'Бектемир тумани', NULL, 'Бектемирский район', NULL, 0),
(1726266, 17, 26, 266, NULL, NULL, 'Yunusobod tumani', NULL, 'Юнусобод тумани', NULL, 'Юнусабадский район', NULL, 0),
(1726269, 17, 26, 269, NULL, NULL, 'Mirzo Ulug\'bek tumani', NULL, 'Мирзо Улуғбек тумани', NULL, 'Мирзо-Улугбекский район', NULL, 0),
(1726273, 17, 26, 273, NULL, NULL, 'Mirobod tumani', NULL, 'Миробод тумани', NULL, 'Мирабадский район', NULL, 0),
(1726277, 17, 26, 277, NULL, NULL, 'Shayxontoxur tumani', NULL, 'Шайхонтохур тумани', NULL, 'Шайхантахурский район', NULL, 0),
(1726280, 17, 26, 280, NULL, NULL, 'Olmazor tumani', NULL, 'Олмазор тумани', NULL, 'Алмазарский район', NULL, 0),
(1726283, 17, 26, 283, NULL, NULL, 'Sirg\'ali tumani', NULL, 'Сирғали тумани', NULL, 'Сергелийский район', NULL, 0),
(1726287, 17, 26, 287, NULL, NULL, 'Yakkasaroy tumani', NULL, 'Яккасарой тумани', NULL, 'Яккасарайский район', NULL, 0),
(1726290, 17, 26, 290, NULL, NULL, 'Yashnobod tumani', NULL, 'Яшнобод тумани', NULL, 'Яшнободский район', NULL, 0),
(1726292, 17, 26, 292, NULL, NULL, 'Yangihayot tumani', NULL, 'Янгиҳаёт тумани', NULL, 'Янгихаётский район', NULL, 0),
(1726294, 17, 26, 294, NULL, NULL, 'Chilonzor tumani', NULL, 'Чилонзор тумани', NULL, 'Чиланзарский район', NULL, 0),
(1727206, 17, 27, 206, NULL, NULL, 'Oqqo\'rg\'on tumani', 'Oqqo\'rg\'on sh.', 'Оққўрғон тумани', 'Оққўрғон ш.', 'Аккурганский район', 'г. Аккурган', 0),
(1727212, 17, 27, 212, NULL, NULL, 'Ohangaron tumani', 'Ohangaron sh.', 'Оҳангарон тумани', 'Оҳангарон ш.', 'Ахангаранский район', 'г. Ахангаран', 0),
(1727220, 17, 27, 220, NULL, NULL, 'Bekobod tumani', 'Zafar shaharchasi', 'Бекобод тумани', 'Зафар шаҳарчаси', 'Бекабадский район', 'гп Зафар', 0),
(1727224, 17, 27, 224, NULL, NULL, 'Bo\'stonliq tumani', 'G\'azalkent sh.', 'Бўстонлиқ тумани', 'Ғазалкент ш.', 'Бостанлыкский район', 'г. Газалкент', 0),
(1727228, 17, 27, 228, NULL, NULL, 'Bo\'ka tumani', 'Bo\'ka sh.', 'Бўка тумани', 'Бўка ш.', 'Букинский район', 'г. Бука', 0),
(1727233, 17, 27, 233, NULL, NULL, 'Quyichirchiq tumani', 'Do\'stobod sh.', 'Қуйичирчиқ тумани', 'Дўстобод ш.', 'Куйичирчикский район', 'г. Дустобод', 0),
(1727237, 17, 27, 237, NULL, NULL, 'Zangiota tumani', 'Eshonguzar shaharchasi', 'Зангиота тумани', 'Эшонгузар шаҳарчаси ', 'Зангиатинский район', 'гп Эшангузар', 0),
(1727239, 17, 27, 239, NULL, NULL, 'Yuqorichirchiq tumani', 'Yangibozor shaharchasi', 'Юқоричирчиқ тумани', 'Янгибозор шаҳарчаси', 'Юкоричирчикский район', 'гп Янгибазар', 0),
(1727248, 17, 27, 248, NULL, NULL, 'Qibray tumani', 'Qibray shaharchasi', 'Қибрай тумани', 'Қибрай шаҳарчаси', 'Кибрайский район', 'гп Кибрай', 0),
(1727249, 17, 27, 249, NULL, NULL, 'Parkent tumani', 'Parkent sh.', 'Паркент тумани', 'Паркент ш.', 'Паркентский район', 'г. Паркент', 0),
(1727250, 17, 27, 250, NULL, NULL, 'Pskent tumani', 'Pskent sh.', 'Пскент тумани', 'Пскент ш.', 'Пскентский район', 'г. Пскент', 0),
(1727253, 17, 27, 253, NULL, NULL, 'O\'rtachirchiq tumani', 'Nurafshon sh.', 'Ўртачирчиқ тумани', 'Нурафшон ш.', 'Уртачирчикский район', 'г. Нурафшон', 0),
(1727256, 17, 27, 256, NULL, NULL, 'Chinoz tumani', 'Chinoz sh.', 'Чиноз тумани', 'Чиноз ш.', 'Чиназский район', 'г. Чиназ', 0),
(1727259, 17, 27, 259, NULL, NULL, 'Yangiyo\'l tumani', 'Yangiyo\'l sh.', 'Янгийўл тумани', 'Янгийўл ш.', 'Янгиюльский район', 'г.Янгиюль', 0),
(1727265, 17, 27, 265, NULL, NULL, 'Toshkent tumani', 'Keles sh.', 'Тошкент тумани', 'Келес ш.', 'Ташкентский район', 'г.Келес', 0),
(1727401, 17, 27, 401, NULL, NULL, 'Nurafshon shahar', NULL, 'Нурафшон', NULL, 'Нурафшон', NULL, 0),
(1727404, 17, 27, 404, NULL, NULL, 'Olmaliq shahar', NULL, 'Олмалиқ', NULL, 'Алмалык', NULL, 0),
(1727407, 17, 27, 407, NULL, NULL, 'Angren shahar', NULL, 'Ангрен', NULL, 'Ангрен', NULL, 0),
(1727413, 17, 27, 413, NULL, NULL, 'Bekobod shahar', NULL, 'Бекобод', NULL, 'Бекабад', NULL, 0),
(1727415, 17, 27, 415, NULL, NULL, 'Ohangaron shahar', NULL, 'Оҳангарон', NULL, 'Ахангаран', NULL, 0),
(1727419, 17, 27, 419, NULL, NULL, 'Chirchiq shahar', NULL, 'Чирчиқ', NULL, 'Чиpчик', NULL, 0),
(1727424, 17, 27, 424, NULL, NULL, 'Yangiyo\'l shahar', NULL, 'Янгийўл', NULL, 'Янгиюль', NULL, 0),
(1730203, 17, 30, 203, NULL, NULL, 'Oltiariq tumani', 'Oltiariq shaharchasi', 'Олтиариқ тумани', 'Олтиариқ шаҳарчаси', 'Алтыарыкский район', 'гп Алтыарык', 0),
(1730206, 17, 30, 206, NULL, NULL, 'Qo\'shtepa tumani', 'Langar a.p.', 'Қўштепа тумани', 'Лангар а.п.', 'Куштепинский район', 'нп Лангар', 0),
(1730209, 17, 30, 209, NULL, NULL, 'Bog\'dod tumani', 'Bog\'dod shaharchasi', 'Боғдод тумани', 'Боғдод шаҳарчаси', 'Багдадский район', 'гп Багдад', 0),
(1730212, 17, 30, 212, NULL, NULL, 'Buvayda tumani', 'Ibrat shaharchasi', 'Бувайда тумани', 'Ибрат шаҳарчаси', 'Бувайдинский район', 'гп Ибрат', 0),
(1730215, 17, 30, 215, NULL, NULL, 'Beshariq tumani', 'Beshariq sh.', 'Бешариқ тумани', 'Бешариқ ш.', 'Бешарыкский район', 'г. Бешарык', 0),
(1730218, 17, 30, 218, NULL, NULL, 'Quva tumani', 'Quva sh.', 'Қува тумани', 'Қува ш.', 'Кувинский район', 'г. Кува', 0),
(1730221, 17, 30, 221, NULL, NULL, 'Uchko\'prik tumani', 'Uchko\'prik shaharchasi', 'Учкўприк тумани', 'Учкўприк шаҳарчаси', 'Учкуприкский район', 'гп Учкуприк', 0),
(1730224, 17, 30, 224, NULL, NULL, 'Rishton tumani', 'Rishton sh.', 'Риштон тумани', 'Риштон ш.', 'Риштанский район', 'г. Риштан', 0),
(1730226, 17, 30, 226, NULL, NULL, 'So\'x tumani', 'Ravon shaharchasi', 'Сўх тумани', 'Равон шаҳарчаси', 'Сохский район', 'гп Равон', 0),
(1730227, 17, 30, 227, NULL, NULL, 'Toshloq tumani', 'Toshloq shaharchasi', 'Тошлоқ тумани', 'Тошлоқ шаҳарчаси', 'Ташлакский район', 'гп Ташлак', 0),
(1730230, 17, 30, 230, NULL, NULL, 'O\'zbekiston tumani', 'Yaypan sh.', 'Ўзбекистон тумани', 'Яйпан ш.', 'Узбекистанский район', 'г. Яйпан', 0),
(1730233, 17, 30, 233, NULL, NULL, 'Farg\'ona tumani', 'Chimyon shaharchasi', 'Фарғона тумани', 'Чимён шаҳарчаси', 'Ферганский район', 'гп Чимен', 0),
(1730236, 17, 30, 236, NULL, NULL, 'Dang\'ara tumani', 'Dang\'ara shaharchasi', 'Данғара тумани', 'Данғара шаҳарчаси', 'Дангаринский район', 'гп Дангара', 0),
(1730238, 17, 30, 238, NULL, NULL, 'Furqat tumani', 'Navbahor shaharchasi', 'Фурқат тумани', 'Навбаҳор шаҳарчаси', 'Фуркатский район', 'гп Навбахор', 0),
(1730242, 17, 30, 242, NULL, NULL, 'Yozyovon tumani', 'Yozyovon shaharchasi', 'Ёзёвон тумани', 'Ёзёвон шаҳарчаси', 'Язъяванский район', 'гп Язъяван', 0),
(1730401, 17, 30, 401, NULL, NULL, 'Farg\'ona shahar', NULL, 'Фарғона', NULL, 'Фергана', NULL, 0),
(1730405, 17, 30, 405, NULL, NULL, 'Qo\'qon shahar', NULL, 'Қўқон', NULL, 'Коканд', NULL, 0),
(1730408, 17, 30, 408, NULL, NULL, 'Quvasoy shahar', NULL, 'Қувасой', NULL, 'Кувасай', NULL, 0),
(1730412, 17, 30, 412, NULL, NULL, 'Marg\'ilon shahar', NULL, 'Марғилон', NULL, 'Маpгилан', NULL, 0),
(1733204, 17, 33, 204, NULL, NULL, 'Bog\'ot tumani', 'Bog\'ot shaharchasi', 'Боғот тумани', 'Боғот шаҳарчаси', 'Багатский район', 'гп Багат', 1),
(1733208, 17, 33, 208, NULL, NULL, 'Gurlan tumani', 'Gurlan shaharchasi', 'Гурлан тумани', 'Гурлан шаҳарчаси', 'Гурленский район', 'гп Гурлен', 2),
(1733212, 17, 33, 212, NULL, NULL, 'Qo\'shko\'pir tumani', 'Qo\'shko\'pir shaharchasi', 'Қўшкўпир тумани', 'Қўшкўпир шаҳарчаси', 'Кошкупырский район', 'гп Кошкупыр', 4),
(1733217, 17, 33, 217, NULL, NULL, 'Urganch tumani', 'Qoroul a.p.', 'Урганч тумани', 'Қороул а.п.', 'Ургенчский район', 'нп Караул', 3),
(1733220, 17, 33, 220, NULL, NULL, 'Xazorasp tumani', 'Xazorasp shaharchasi', 'Хазорасп тумани', 'Хазорасп шаҳарчаси', 'Хазараспский район', 'гп Хазарасп', 1),
(1733221, 17, 33, 221, NULL, NULL, 'Tuproqqal\'a tumani', 'Pitnak shahri', 'Тупроққалъа тумани', 'Питнак шаҳри', 'Тупроккалинский район', 'г. Питнак', 1),
(1733223, 17, 33, 223, NULL, NULL, 'Xonqa tumani', 'Xonqa shaharchasi', 'Хонқа тумани', 'Хонқа шаҳарчаси', 'Ханкинский район', 'гп Ханка', 3),
(1733226, 17, 33, 226, NULL, NULL, 'Xiva tumani', 'Xiva sh.', 'Хива тумани', 'Хива ш.', 'Хивинский район', 'г. Хива', 4),
(1733230, 17, 33, 230, NULL, NULL, 'Shovot tumani', 'Shovot shaharchasi', 'Шовот тумани', 'Шовот шаҳарчаси', 'Шаватский район', 'гп Шават', 2),
(1733233, 17, 33, 233, NULL, NULL, 'Yangiariq tumani', 'Yangiariq shaharchasi', 'Янгиариқ тумани', 'Янгиариқ шаҳарчаси', 'Янгиарыкский район', 'гп Янгиарык', 3),
(1733236, 17, 33, 236, NULL, NULL, 'Yangibozor tumani', 'Yangibozor shaharchasi', 'Янгибозор тумани', 'Янгибозор шаҳарчаси', 'Янгибазарский район', 'гп Янгибазар', 2),
(1733401, 17, 33, 401, NULL, NULL, 'Urganch shahar', NULL, 'Урганч', NULL, 'Ургенч', NULL, 1),
(1733406, 17, 33, 406, NULL, NULL, 'Xiva shahar', NULL, 'Хива', NULL, 'Хива', NULL, 4),
(1735204, 17, 35, 204, NULL, NULL, 'Amudaryo tumani', 'Mang\'it sh.', 'Амударё тумани', 'Манғит ш.', 'Амударьинский район', 'г. Мангит', 0),
(1735207, 17, 35, 207, NULL, NULL, 'Beruniy tumani', 'Beruniy sh.', 'Беруний тумани', 'Беруний ш.', 'Берунийский район', 'г. Беруни', 0),
(1735209, 17, 35, 209, NULL, NULL, 'Bo\'zatov tumani', 'Bo\'zatov shaharchasi', 'Бўзатов тумани', 'Бўзатов шаҳарчаси', 'Бозатауский район', 'гп Бозатау', 0),
(1735211, 17, 35, 211, NULL, NULL, 'Qorao\'zak tumani', 'Qorao\'zak shaharchasi', 'Қораўзак тумани', 'Қораўзак шаҳарчаси', 'Караузякский район', 'гп Караузяк', 0),
(1735212, 17, 35, 212, NULL, NULL, 'Kegeyli tumani', 'Kegeyli shaharchasi', 'Кегейли тумани', 'Кегейли шаҳарчаси', 'Кегейлийский район', 'гп Кегейли', 0),
(1735215, 17, 35, 215, NULL, NULL, 'Qo\'ng\'irot tumani', 'Qo\'ng\'irot sh.', 'Қўнғирот тумани', 'Қўнғирот ш.', 'Кунградский район', 'г. Кунград', 0),
(1735218, 17, 35, 218, NULL, NULL, 'Qanliko\'l tumani', 'Qanliko\'l shaharchasi', 'Қанликўл тумани', 'Қанликўл шаҳарчаси', 'Канлыкульский район', 'гп Канлыкуль', 0),
(1735222, 17, 35, 222, NULL, NULL, 'Mo\'ynoq tumani', 'Mo\'ynoq sh.', 'Мўйноқ тумани', 'Мўйноқ ш.', 'Муйнакский район', 'г. Муйнак', 0),
(1735225, 17, 35, 225, NULL, NULL, 'Nukus tumani', 'Oqmang\'it shaharchasi', 'Нукус тумани', 'Оқманғит шаҳарчаси', 'Нукусский район', 'гп Акмангит', 0),
(1735228, 17, 35, 228, NULL, NULL, 'Taxiatosh tumani', 'Taxiatosh sh.', 'Тахиатош тумани', 'Тахиатош ш.', 'Тахиаташский район', 'г.Тахиаташ', 0),
(1735230, 17, 35, 230, NULL, NULL, 'Taxtako\'pir tumani', 'Taxtako\'pir shaharchasi', 'Тахтакўпир тумани', 'Тахтакўпир шаҳарчаси', 'Тахтакупырский район', 'гп Тахтакупыр', 0),
(1735233, 17, 35, 233, NULL, NULL, 'To\'rtko\'l tumani', 'To\'rtko\'l sh.', 'Тўрткўл тумани', 'Тўрткўл ш.', 'Турткульский район', 'г. Турткуль', 0),
(1735236, 17, 35, 236, NULL, NULL, 'Xo\'jayli tumani', 'Xo\'jayli sh.', 'Хўжайли тумани', 'Хўжайли ш.', 'Ходжейлийский район', 'г. Ходжейли', 0),
(1735240, 17, 35, 240, NULL, NULL, 'Chimboy tumani', 'Chimboy sh.', 'Чимбой тумани', 'Чимбой ш.', 'Чимбайский район', 'г. Чимбай', 0),
(1735243, 17, 35, 243, NULL, NULL, 'Shumanay tumani', 'Shumanay sh.', 'Шуманай тумани', 'Шуманай ш.', 'Шуманайский район', 'г. Шуманай', 0),
(1735250, 17, 35, 250, NULL, NULL, 'Ellikkala tumani', 'Bo\'ston sh.', 'Элликкала тумани', 'Бўстон ш.', 'Элликкалинский район', 'г. Бустан', 0),
(1735401, 17, 35, 401, NULL, NULL, 'Nukus shahar', NULL, 'Нукус', NULL, 'Нукус', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(500) DEFAULT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `access_token` varchar(500) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) DEFAULT 1,
  `role_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default/avatar.png',
  `lat` varchar(255) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL,
  `active_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `active` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `auth_key`, `token`, `code`, `access_token`, `created`, `updated`, `status`, `role_id`, `image`, `lat`, `long`, `active_date`, `active`) VALUES
(1, 'Dilmurod Allabergenov', '(99)967-0395', '$2y$13$VPNOwR3oHhP6FP4vneeUW.dLx6WRtLH4hx3hqV2kC9FeClMAvg2Ii', NULL, NULL, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwiaWF0IjoxNzA4ODc4NzQ0LCJuYmYiOjE3MDg5NjUxNDQsIm5hbWUiOiJEaWxtdXJvZCBBbGxhYmVyZ2Vub3YifQ.JVExrYaNt3mNy4iRZS98uRP3r5bywHd_r2miCDT_Z70', '2023-10-07 13:52:47', '2024-02-25 21:41:55', 1, 100, 'default/avatar.png', '41.552269', '60.631571', '2024-02-25 05:41:55', 1),
(4, 'Mansur', '(91)912-1101', '$2y$13$9aVxQzZBzidOoT5Yj8PjP.iKfq9SLmK6zqfEDNaS8bJYLIuXRX1US', NULL, NULL, NULL, NULL, '2024-02-23 11:41:31', '2024-02-23 11:41:31', 1, 30, 'default/avatar.png', NULL, NULL, '2024-02-25 14:22:18', 0),
(5, 'Inspektor', '(99)967-1234', '$2y$13$X/AIQaGRj.BuO7gI.75aleElkgb/28/aGNc6VyT9Wmy5AF1g9Yoty', NULL, NULL, NULL, NULL, '2024-02-25 03:00:08', '2024-02-25 03:00:08', 1, 20, 'default/avatar.png', NULL, NULL, '2024-02-25 14:22:18', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `name`, `url`, `status`) VALUES
(20, 'Profilaktika', '/profi/', 1),
(30, 'Call center', '/cc/', 1),
(60, 'Rahbar', '/manager/', 1),
(100, 'Superadmin', '/cp/', 1);

-- --------------------------------------------------------

--
-- Structure for view `district_view`
--
DROP TABLE IF EXISTS `district_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `district_view`  AS SELECT `s`.`id` AS `id`, `s`.`region_id` AS `region_id`, `s`.`district_id` AS `district_id`, `s`.`name_lot` AS `name_lot`, `s`.`center_lot` AS `center_lot`, `s`.`name_cyr` AS `name_cyr`, `s`.`center_cyr` AS `center_cyr`, `s`.`name_ru` AS `name_ru`, `s`.`center_ru` AS `center_ru`, `s`.`sector` AS `sector` FROM `soato` AS `s` WHERE `s`.`qfi_id` is null AND `s`.`district_id` is not nullnot null  ;

-- --------------------------------------------------------

--
-- Structure for view `region_view`
--
DROP TABLE IF EXISTS `region_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `region_view`  AS SELECT `s`.`id` AS `id`, `s`.`region_id` AS `region_id`, `s`.`district_id` AS `district_id`, `s`.`name_lot` AS `name_lot`, `s`.`center_lot` AS `center_lot`, `s`.`name_cyr` AS `name_cyr`, `s`.`center_cyr` AS `center_cyr`, `s`.`name_ru` AS `name_ru`, `s`.`center_ru` AS `center_ru`, `s`.`sector` AS `sector` FROM `soato` AS `s` WHERE `s`.`district_id` is null AND `s`.`region_id` is not nullnot null  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address`),
  ADD KEY `FK_address_user_id` (`user_id`);

--
-- Indexes for table `call`
--
ALTER TABLE `call`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_call_address` (`address`);

--
-- Indexes for table `call_type`
--
ALTER TABLE `call_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_company_soato_id` (`soato_id`);

--
-- Indexes for table `soato`
--
ALTER TABLE `soato`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `FK_user_role_id` (`role_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `call`
--
ALTER TABLE `call`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `call_type`
--
ALTER TABLE `call_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_address_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `call`
--
ALTER TABLE `call`
  ADD CONSTRAINT `FK_call_address` FOREIGN KEY (`address`) REFERENCES `address` (`address`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `FK_company_soato_id` FOREIGN KEY (`soato_id`) REFERENCES `soato` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_user_role_id` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
