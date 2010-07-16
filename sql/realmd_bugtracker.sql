SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE `bt_screen` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`entry` int(11) NOT NULL,
`address` varchar(25) NOT NULL,
`mini` varchar(25) NOT NULL,
PRIMARY KEY (`id`));

CREATE TABLE `bt_comment` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`entry` int(11) NOT NULL,
`account` int(11) NOT NULL,
`player` int(11) NOT NULL,
`text` varchar(255) NOT NULL,
`date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
`admin_reply` int(1) NOT NULL DEFAULT 0,
PRIMARY KEY (`id`));

DROP TABLE IF EXISTS `bt_map_id`;
CREATE TABLE `bt_map_id` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

INSERT INTO `bt_map_id` VALUES ('1', 'Восточные Королевства');
INSERT INTO `bt_map_id` VALUES ('2', 'Калимдор');
INSERT INTO `bt_map_id` VALUES ('3', 'Подземелья');
INSERT INTO `bt_map_id` VALUES ('4', 'Рейды');
INSERT INTO `bt_map_id` VALUES ('5', 'Поля боя');
INSERT INTO `bt_map_id` VALUES ('6', 'Запределье');
INSERT INTO `bt_map_id` VALUES ('7', 'Арены');
INSERT INTO `bt_map_id` VALUES ('8', 'Нордскол');

DROP TABLE IF EXISTS `bt_message`;
CREATE TABLE `bt_message` (
  `id` int(11) NOT NULL,
  `account` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `status` int(11) NOT NULL default '0',
  `percentage` int(3) NOT NULL default '0',
  `priority` int(1) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0,
  `text_1` longtext NOT NULL,
  `text_2` longtext NOT NULL,
  `text_3` longtext NOT NULL,
  `subtype` int(11) NOT NULL DEFAULT 0,
  `map` int(11) NOT NULL DEFAULT 0,
  `zone` int(11) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

DROP TABLE IF EXISTS `bt_options`;
CREATE TABLE `bt_options` (
  `id` int(11) NOT NULL,
  `link` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

DROP TABLE IF EXISTS `bt_priority`;
CREATE TABLE `bt_priority` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(25) NOT NULL,
  `color` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `bt_priority` VALUES ('1', 'Обычный', 'white');
INSERT INTO `bt_priority` VALUES ('3', 'Важный', 'gold');
INSERT INTO `bt_priority` VALUES ('4', 'Критичный', 'navy');
INSERT INTO `bt_priority` VALUES ('5', 'Фатальный', 'red');
INSERT INTO `bt_priority` VALUES ('2', 'Средний', 'pink');

DROP TABLE IF EXISTS `bt_section`;
CREATE TABLE `bt_section` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=cp1251;

INSERT INTO `bt_section` VALUES ('1', 'Заклинание');
INSERT INTO `bt_section` VALUES ('2', 'Задание');
INSERT INTO `bt_section` VALUES ('3', 'Предмет');
INSERT INTO `bt_section` VALUES ('4', 'НИП');
INSERT INTO `bt_section` VALUES ('5', 'Объект');
INSERT INTO `bt_section` VALUES ('6', 'Достижение');
INSERT INTO `bt_section` VALUES ('7', 'Звание');

CREATE TABLE `bt_subtype` (
`id`  int(11) NOT NULL ,
`name`  varchar(15) NOT NULL ,
PRIMARY KEY (`id`));

INSERT INTO `bt_subtype` VALUES ('1','Воин');
INSERT INTO `bt_subtype` VALUES ('2','Друид');
INSERT INTO `bt_subtype` VALUES ('3','Жрец');
INSERT INTO `bt_subtype` VALUES ('4','Маг');
INSERT INTO `bt_subtype` VALUES ('5','Охотник');
INSERT INTO `bt_subtype` VALUES ('6','Паладин');
INSERT INTO `bt_subtype` VALUES ('7','Разбойник');
INSERT INTO `bt_subtype` VALUES ('8','Рыцарь смерти');
INSERT INTO `bt_subtype` VALUES ('9','Чернокнижник');
INSERT INTO `bt_subtype` VALUES ('10','Шаман');

DROP TABLE IF EXISTS `bt_status`;
CREATE TABLE `bt_status` (
  `id` int(3) NOT NULL,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `bt_status` VALUES ('0', 'Обработка');
INSERT INTO `bt_status` VALUES ('2', 'Реализация');
INSERT INTO `bt_status` VALUES ('1', 'Решение');
INSERT INTO `bt_status` VALUES ('3', 'Отбракован');
INSERT INTO `bt_status` VALUES ('4', 'Готово');
INSERT INTO `bt_status` VALUES ('5', 'Дубль');

DROP TABLE IF EXISTS `bt_zone_id`;
CREATE TABLE `bt_zone_id` (
  `map` int(11) NOT NULL,
  `zone` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`zone`)
) ENGINE=MyISAM AUTO_INCREMENT=4990 DEFAULT CHARSET=cp1251;

INSERT INTO `bt_zone_id` VALUES ('1', '10', 'Сумеречный лес');
INSERT INTO `bt_zone_id` VALUES ('1', '1537', 'Стальгорн');
INSERT INTO `bt_zone_id` VALUES ('1', '130', 'Серебряный бор');
INSERT INTO `bt_zone_id` VALUES ('1', '12', 'Элвиннский лес');
INSERT INTO `bt_zone_id` VALUES ('1', '1519', 'Штормград');
INSERT INTO `bt_zone_id` VALUES ('1', '85', 'Тирисфальские леса');
INSERT INTO `bt_zone_id` VALUES ('1', '51', 'Тлеющее ущелье');
INSERT INTO `bt_zone_id` VALUES ('1', '33', 'Тернистая долина');
INSERT INTO `bt_zone_id` VALUES ('1', '25', 'Черная гора');
INSERT INTO `bt_zone_id` VALUES ('1', '36', 'Альтеракские горы');
INSERT INTO `bt_zone_id` VALUES ('1', '4298', 'Чумные земли: Анклав Алого ордена');
INSERT INTO `bt_zone_id` VALUES ('1', '11', 'Болотина');
INSERT INTO `bt_zone_id` VALUES ('1', '8', 'Болото Печали');
INSERT INTO `bt_zone_id` VALUES ('1', '3', 'Бесплодные земли');
INSERT INTO `bt_zone_id` VALUES ('1', '4', 'Выжженные земли');
INSERT INTO `bt_zone_id` VALUES ('1', '47', 'Внутренние земли');
INSERT INTO `bt_zone_id` VALUES ('1', '139', 'Восточные Чумные земли');
INSERT INTO `bt_zone_id` VALUES ('1', '3430', 'Леса Вечной Песни');
INSERT INTO `bt_zone_id` VALUES ('1', '40', 'Западный Край');
INSERT INTO `bt_zone_id` VALUES ('1', '28', 'Западные Чумные земли');
INSERT INTO `bt_zone_id` VALUES ('1', '44', 'Красногорье');
INSERT INTO `bt_zone_id` VALUES ('1', '4080', 'Остров Кель\'Данас');
INSERT INTO `bt_zone_id` VALUES ('1', '3487', 'Луносвет');
INSERT INTO `bt_zone_id` VALUES ('1', '1', 'Дун Морог');
INSERT INTO `bt_zone_id` VALUES ('1', '38', 'Лок Модан');
INSERT INTO `bt_zone_id` VALUES ('1', '41', 'Перевал Мертвого Ветра');
INSERT INTO `bt_zone_id` VALUES ('1', '45', 'Нагорье Арати');
INSERT INTO `bt_zone_id` VALUES ('1', '46', 'Пылающие степи');
INSERT INTO `bt_zone_id` VALUES ('1', '3433', 'Призрачные земли');
INSERT INTO `bt_zone_id` VALUES ('1', '267', 'Предгорья Хилсбрада');
INSERT INTO `bt_zone_id` VALUES ('1', '1497', 'Подгород');
INSERT INTO `bt_zone_id` VALUES ('1', '2257', 'Подземный поезд');
INSERT INTO `bt_zone_id` VALUES ('2', '17', 'Степи');
INSERT INTO `bt_zone_id` VALUES ('2', '1377', 'Силитус');
INSERT INTO `bt_zone_id` VALUES ('2', '457', 'Сокрытое море');
INSERT INTO `bt_zone_id` VALUES ('2', '3557', 'Экзодар');
INSERT INTO `bt_zone_id` VALUES ('2', '331', 'Ясеневый лес');
INSERT INTO `bt_zone_id` VALUES ('2', '400', 'Тысяча Игл');
INSERT INTO `bt_zone_id` VALUES ('2', '440', 'Танарис');
INSERT INTO `bt_zone_id` VALUES ('2', '141', 'Тельдрассил');
INSERT INTO `bt_zone_id` VALUES ('2', '357', 'Фералас');
INSERT INTO `bt_zone_id` VALUES ('2', '16', 'Азшара');
INSERT INTO `bt_zone_id` VALUES ('2', '148', 'Темные берега');
INSERT INTO `bt_zone_id` VALUES ('2', '1638', 'Громовой Утес');
INSERT INTO `bt_zone_id` VALUES ('2', '14', 'Дуротар');
INSERT INTO `bt_zone_id` VALUES ('2', '1657', 'Дарнас');
INSERT INTO `bt_zone_id` VALUES ('2', '618', 'Зимние Ключи');
INSERT INTO `bt_zone_id` VALUES ('2', '490', 'Кратер Ун\'Горо');
INSERT INTO `bt_zone_id` VALUES ('2', '3525', 'Остров Кровавой Дымки');
INSERT INTO `bt_zone_id` VALUES ('2', '406', 'Когтистые горы');
INSERT INTO `bt_zone_id` VALUES ('2', '493', 'Лунная поляна');
INSERT INTO `bt_zone_id` VALUES ('2', '3524', 'Остров Лазурной Дымки');
INSERT INTO `bt_zone_id` VALUES ('2', '215', 'Мулгор');
INSERT INTO `bt_zone_id` VALUES ('2', '361', 'Оскверненный лес');
INSERT INTO `bt_zone_id` VALUES ('2', '1637', 'Оргриммар');
INSERT INTO `bt_zone_id` VALUES ('2', '405', 'Пустоши');
INSERT INTO `bt_zone_id` VALUES ('2', '15', 'Пылевые топи');
INSERT INTO `bt_zone_id` VALUES ('6', '3520', 'Долина Призрачной Луны');
INSERT INTO `bt_zone_id` VALUES ('6', '3521', 'Зангартопь');
INSERT INTO `bt_zone_id` VALUES ('6', '3519', 'Лес Тероккар');
INSERT INTO `bt_zone_id` VALUES ('6', '3518', 'Награнд');
INSERT INTO `bt_zone_id` VALUES ('6', '3522', 'Острогорье');
INSERT INTO `bt_zone_id` VALUES ('6', '3483', 'Полуостров Адского Пламени');
INSERT INTO `bt_zone_id` VALUES ('6', '3523', 'Пустоверть');
INSERT INTO `bt_zone_id` VALUES ('6', '3703', 'Шаттрат');
INSERT INTO `bt_zone_id` VALUES ('8', '3537', 'Борейская тундра');
INSERT INTO `bt_zone_id` VALUES ('8', '67', 'Грозовая Гряда');
INSERT INTO `bt_zone_id` VALUES ('8', '4395', 'Даларан');
INSERT INTO `bt_zone_id` VALUES ('8', '65', 'Драконий Погост');
INSERT INTO `bt_zone_id` VALUES ('8', '66', 'Зул\'Драк');
INSERT INTO `bt_zone_id` VALUES ('8', '4742', 'Лагерь Хротгара');
INSERT INTO `bt_zone_id` VALUES ('8', '210', 'Ледяная Корона');
INSERT INTO `bt_zone_id` VALUES ('8', '2817', 'Лес Хрустальной Песни');
INSERT INTO `bt_zone_id` VALUES ('8', '3711', 'Низина Шолазар');
INSERT INTO `bt_zone_id` VALUES ('8', '4197', 'Озеро Ледяных Оков');
INSERT INTO `bt_zone_id` VALUES ('8', '495', 'Ревущий фьорд');
INSERT INTO `bt_zone_id` VALUES ('8', '394', 'Седые холмы');
INSERT INTO `bt_zone_id` VALUES ('7', '4378', 'Арена Даларана');
INSERT INTO `bt_zone_id` VALUES ('7', '4406', 'Арена Доблести');
INSERT INTO `bt_zone_id` VALUES ('7', '3698', 'Арена Награнда');
INSERT INTO `bt_zone_id` VALUES ('7', '3702', 'Арена Острогорья');
INSERT INTO `bt_zone_id` VALUES ('7', '3968', 'Руины Лордерона');
INSERT INTO `bt_zone_id` VALUES ('5', '2597', 'Альтеракская долина');
INSERT INTO `bt_zone_id` VALUES ('5', '4384', 'Берег Древних');
INSERT INTO `bt_zone_id` VALUES ('5', '3358', 'Низина Арати');
INSERT INTO `bt_zone_id` VALUES ('5', '3820', 'Око Бури');
INSERT INTO `bt_zone_id` VALUES ('5', '4710', 'Остров Завоеваний');
INSERT INTO `bt_zone_id` VALUES ('5', '3277', 'Ущелье Песни Войны');
INSERT INTO `bt_zone_id` VALUES ('3', '2017', 'Стратхольм');
INSERT INTO `bt_zone_id` VALUES ('3', '4100', 'Пещеры Времени: Очищение Стратхольма');
INSERT INTO `bt_zone_id` VALUES ('3', '718', 'Пещеры Стенаний');
INSERT INTO `bt_zone_id` VALUES ('3', '3791', 'Аукиндон: Сетеккские залы');
INSERT INTO `bt_zone_id` VALUES ('3', '4264', 'Ульдуар: Чертоги Камня');
INSERT INTO `bt_zone_id` VALUES ('3', '4272', 'Ульдуар: Чертоги Молний');
INSERT INTO `bt_zone_id` VALUES ('3', '1337', 'Ульдаман');
INSERT INTO `bt_zone_id` VALUES ('3', '717', 'Тюрьма');
INSERT INTO `bt_zone_id` VALUES ('3', '3713', 'Цитадель Адского Пламени: Кузня Крови');
INSERT INTO `bt_zone_id` VALUES ('3', '4813', 'Цитадель Ледяной Короны: Яма Сарона');
INSERT INTO `bt_zone_id` VALUES ('3', '4809', 'Цитадель Ледяной Короны: Кузня Душ');
INSERT INTO `bt_zone_id` VALUES ('3', '1583', 'Пик Черной горы');
INSERT INTO `bt_zone_id` VALUES ('3', '3714', 'Цитадель Адского Пламени: Разрушенные залы');
INSERT INTO `bt_zone_id` VALUES ('3', '3717', 'Резервуар Кривого Клыка: Узилище');
INSERT INTO `bt_zone_id` VALUES ('3', '3716', 'Резервуар Кривого Клыка: Нижетопь');
INSERT INTO `bt_zone_id` VALUES ('3', '3792', 'Аукиндон: Гробницы Маны');
INSERT INTO `bt_zone_id` VALUES ('3', '3789', 'Аукиндон: Темный лабиринт');
INSERT INTO `bt_zone_id` VALUES ('3', '3790', 'Аукиндон: Аукенайские гробницы');
INSERT INTO `bt_zone_id` VALUES ('3', '3846', 'Крепость Бурь: Аркатрац');
INSERT INTO `bt_zone_id` VALUES ('3', '3477', 'Азжол-Неруб: Азжол-Неруб');
INSERT INTO `bt_zone_id` VALUES ('3', '4415', 'Аметистовая крепость');
INSERT INTO `bt_zone_id` VALUES ('3', '3562', 'Цитадель Адского Пламени: Бастионы Адского Пламени');
INSERT INTO `bt_zone_id` VALUES ('3', '3847', 'Крепость Бурь: Ботаника');
INSERT INTO `bt_zone_id` VALUES ('3', '2366', 'Пещеры Времени: Черные топи');
INSERT INTO `bt_zone_id` VALUES ('3', '4375', 'Гундрак');
INSERT INTO `bt_zone_id` VALUES ('3', '1584', 'Глубины Черной горы');
INSERT INTO `bt_zone_id` VALUES ('3', '133', 'Гномреган');
INSERT INTO `bt_zone_id` VALUES ('3', '1417', 'Затонувший храм');
INSERT INTO `bt_zone_id` VALUES ('3', '2557', 'Забытый Город');
INSERT INTO `bt_zone_id` VALUES ('3', '4723', 'Испытание чемпиона');
INSERT INTO `bt_zone_id` VALUES ('3', '722', 'Курганы Иглошкурых');
INSERT INTO `bt_zone_id` VALUES ('3', '491', 'Лабиринты Иглошкурых');
INSERT INTO `bt_zone_id` VALUES ('3', '206', 'Крепость Утгард: Крепость Утгард');
INSERT INTO `bt_zone_id` VALUES ('3', '209', 'Крепость Темного Клыка');
INSERT INTO `bt_zone_id` VALUES ('3', '1196', 'Крепость Утгард: Вершина Утгард');
INSERT INTO `bt_zone_id` VALUES ('3', '3849', 'Крепость Бурь: Механар');
INSERT INTO `bt_zone_id` VALUES ('3', '4494', 'Азжол-Неруб: Ан\'кахет: Старое Королевство');
INSERT INTO `bt_zone_id` VALUES ('3', '2100', 'Мародон');
INSERT INTO `bt_zone_id` VALUES ('3', '4095', 'Терраса Магистров');
INSERT INTO `bt_zone_id` VALUES ('3', '796', 'Монастырь Алого ордена');
INSERT INTO `bt_zone_id` VALUES ('3', '1581', 'Мертвые копи');
INSERT INTO `bt_zone_id` VALUES ('3', '4120', 'Нексус: Нексус');
INSERT INTO `bt_zone_id` VALUES ('3', '4228', 'Нексус: Окулус');
INSERT INTO `bt_zone_id` VALUES ('3', '2057', 'Некроситет');
INSERT INTO `bt_zone_id` VALUES ('3', '719', 'Непроглядная Пучина');
INSERT INTO `bt_zone_id` VALUES ('3', '4820', 'Цитадель Ледяной Короны: Залы Отражений');
INSERT INTO `bt_zone_id` VALUES ('3', '2437', 'Огненная пропасть');
INSERT INTO `bt_zone_id` VALUES ('3', '2367', 'Пещеры Времени: Старые предгорья Хилсбрада');
INSERT INTO `bt_zone_id` VALUES ('3', '3715', 'Резервуар Кривого Клыка: Паровое подземелье');
INSERT INTO `bt_zone_id` VALUES ('4', '4075', 'Плато Солнечного Колодца');
INSERT INTO `bt_zone_id` VALUES ('4', '4273', 'Ульдуар');
INSERT INTO `bt_zone_id` VALUES ('4', '4812', 'Цитадель Ледяной Короны');
INSERT INTO `bt_zone_id` VALUES ('4', '3959', 'Черный храм');
INSERT INTO `bt_zone_id` VALUES ('4', '3607', 'Резервуар Кривого Клыка: Змеиное святилище');
INSERT INTO `bt_zone_id` VALUES ('4', '4603', 'Склеп Аркавона');
INSERT INTO `bt_zone_id` VALUES ('4', '3428', 'Ан\'Кираж');
INSERT INTO `bt_zone_id` VALUES ('4', '3429', 'Руины Ан\'Киража');
INSERT INTO `bt_zone_id` VALUES ('4', '4500', 'Нексус: Око Вечности');
INSERT INTO `bt_zone_id` VALUES ('4', '3606', 'Пещеры Времени: Вершина Хиджала');
INSERT INTO `bt_zone_id` VALUES ('4', '3618', 'Логово Груула');
INSERT INTO `bt_zone_id` VALUES ('4', '4987', 'Храм Драконьего Покоя: Рубиновое святилище');
INSERT INTO `bt_zone_id` VALUES ('4', '3805', 'Зул\'Аман');
INSERT INTO `bt_zone_id` VALUES ('4', '19', 'Зул\'Гуруб');
INSERT INTO `bt_zone_id` VALUES ('4', '4722', 'Испытание крестоносца');
INSERT INTO `bt_zone_id` VALUES ('4', '3842', 'Крепость Бурь: Крепость Бурь');
INSERT INTO `bt_zone_id` VALUES ('4', '2562', 'Каражан');
INSERT INTO `bt_zone_id` VALUES ('4', '2677', 'Логово Крыла Тьмы');
INSERT INTO `bt_zone_id` VALUES ('4', '3836', 'Цитадель Адского Пламени: Логово Магтеридона');
INSERT INTO `bt_zone_id` VALUES ('4', '3456', 'Наксрамас');
INSERT INTO `bt_zone_id` VALUES ('4', '4493', 'Храм Драконьего Покоя: Обсидиановое святилище');
INSERT INTO `bt_zone_id` VALUES ('4', '2717', 'Огненные Недра');
INSERT INTO `bt_zone_id` VALUES ('4', '2159', 'Логово Ониксии');
INSERT INTO `bt_zone_id` VALUES ('3', '978', 'Зул\'Фаррак');