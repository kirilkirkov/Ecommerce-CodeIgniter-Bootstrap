-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 18, 2016 at 11:39 AM
-- Server version: 5.5.52-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_pages`
--

CREATE TABLE IF NOT EXISTS `active_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `active_pages`
--

INSERT INTO `active_pages` (`id`, `name`, `enabled`) VALUES
(1, 'blog', 1),
(5, 'test', 0),
(6, 'kiro', 0);

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) CHARACTER SET utf8 NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` int(10) unsigned NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `image`, `url`, `time`) VALUES
(1, '1473750739j1-01-1024x576.png', 'BG--AtoZ-CSS-Quick-Tip-Justifying-Text-and-Using-Flexbox-_1', 1475067773),
(2, '1474963443alex-fitzpatrick-feature.jpg', '-Versioning-Podcast-Episode-10-with-Alex-Fitzpatrick-_2', 1475067812),
(3, '1474960018devops_feature.jpg', 'Conventional-Software-Development-Dev-vs-Ops_3', 1475067856);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity` varchar(255) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `abbr` varchar(5) CHARACTER SET utf8 NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `currency` varchar(10) CHARACTER SET utf8 NOT NULL,
  `flag` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `abbr`, `name`, `currency`, `flag`) VALUES
(1, 'bg', 'bulgarian', 'лв', 'bg.jpg'),
(18, 'en', 'english', '$', 'en.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(20) NOT NULL,
  `post_code` varchar(10) NOT NULL,
  `notes` text NOT NULL,
  `products` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `referrer` varchar(255) NOT NULL,
  `processed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `city`, `post_code`, `notes`, `products`, `date`, `referrer`, `processed`) VALUES
(7, 'dqwdqw', 'dqwqw', 'fqe@dfqe.qf', '321321', 'qwdqw', 'dqwdwq', '321dqw', 'dqw', 'a:1:{i:7;s:1:"2";}', 1475847973, '', 0),
(8, 'fqef', 'qefqe', 'dqw@dqw.dqw', '32112', 'dqwdqw', 'dqwdq', '3232', 'dwqdqw', 'a:1:{i:6;s:1:"3";}', 1475848157, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL COMMENT 'id of products for shop',
  `folder` int(10) unsigned DEFAULT NULL COMMENT 'folder with images',
  `image` varchar(255) NOT NULL,
  `time` int(10) unsigned NOT NULL COMMENT 'time created',
  `time_update` int(10) unsigned NOT NULL COMMENT 'time updated',
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `shop_categorie` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `procurement` int(10) unsigned NOT NULL,
  `in_slider` tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id`, `folder`, `image`, `time`, `time_update`, `visibility`, `shop_categorie`, `quantity`, `procurement`, `in_slider`, `url`) VALUES
(1, 1, NULL, '9506112864286.jpg', 1475067224, 1475067292, 1, 1, 29, 0, 0, 'Лаптоп_ASUS_X554SJXX025D_1'),
(2, 2, NULL, '9029329911838.jpg', 1475067266, 1475067286, 1, 1, 6, 0, 0, 'Плот_за_вграждане_BOSCH_PKK651F17E_2'),
(3, 3, NULL, '8982720315422.jpg', 1475067365, 1475067395, 1, 2, 5, 0, 0, 'Домашнo_кинo_PHILIPS_HTD3510_3'),
(4, 4, NULL, '9506115780638.jpg', 1475067529, 0, 1, 1, 44, 0, 0, 'Домашнo_кинo_PHILIPS_CSS5530G_4'),
(5, 5, NULL, '9018778779678.jpg', 1475067601, 1475067611, 1, 3, 33, 0, 0, 'Инверторен_климатик_SANG_TAC09CHSAHCI_5'),
(6, 6, NULL, 'detail_1244399-401_01.jpg', 1475067684, 1475067699, 1, 4, 22, 3, 0, 'Тениска_Alter_Ego_Compression__6'),
(7, 7, 1476697868, 'Mane-menu-Nike-Air-Max.png', 1475067990, 1476702549, 1, 5, 200, 0, 1, 'Обувки_AIR_MAX_COMMAND_LEA_7');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE IF NOT EXISTS `shopping_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) CHARACTER SET utf8 NOT NULL,
  `article_id` int(11) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shop_categories`
--

CREATE TABLE IF NOT EXISTS `shop_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sub_for` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `shop_categories`
--

INSERT INTO `shop_categories` (`id`, `sub_for`) VALUES
(1, 0),
(2, 1),
(3, 1),
(4, 0),
(5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subscribed`
--

CREATE TABLE IF NOT EXISTS `subscribed` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE IF NOT EXISTS `translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` longtext CHARACTER SET utf8 NOT NULL,
  `basic_description` text CHARACTER SET utf8 NOT NULL,
  `price` varchar(20) CHARACTER SET utf8 NOT NULL,
  `old_price` varchar(20) CHARACTER SET utf8 NOT NULL,
  `abbr` varchar(5) CHARACTER SET utf8 NOT NULL,
  `for_id` int(11) NOT NULL COMMENT ' ',
  `type` varchar(30) CHARACTER SET utf8 NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `art_id_abbr` (`abbr`,`for_id`,`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `title`, `description`, `basic_description`, `price`, `old_price`, `abbr`, `for_id`, `type`, `name`) VALUES
(1, 'Лаптоп ASUS X554SJ-XX025D', '<ul>\r\n	<li title=""><strong>ТИП</strong> : ЛАПТОП</li>\r\n	<li title=""><strong>КАПАЦИТЕТ RAM</strong> : 8 GB</li>\r\n	<li title=""><strong>КАПАЦИТЕТ HDD</strong> : 1000 GB</li>\r\n	<li title=""><strong>ТИП ПРОЦЕСОР</strong> : INTEL PENTIUM N3700 QUAD</li>\r\n	<li title=""><strong>РАЗМЕР НА ЕКРАНА В INCH</strong> : 15.6 &quot;</li>\r\n	<li title=""><strong>ЧЕСТОТА НА ПРОЦЕСОРА</strong> : 1.60 - 2.40 GHz</li>\r\n	<li title=""><strong>ТИП ГРАФИЧНА КАРТА</strong> : NVIDIA GEFORCE 920M</li>\r\n</ul>\r\n', '', '200', '', 'bg', 1, 'product', ''),
(2, 'Laptop ASUS X554SJ-XX025D', '<ul>\r\n	<li title=""><strong>ТИП</strong> : ЛАПТОП</li>\r\n	<li title=""><strong>КАПАЦИТЕТ RAM</strong> : 8 GB</li>\r\n	<li title=""><strong>КАПАЦИТЕТ HDD</strong> : 1000 GB</li>\r\n	<li title=""><strong>ТИП ПРОЦЕСОР</strong> : INTEL PENTIUM N3700 QUAD</li>\r\n	<li title=""><strong>РАЗМЕР НА ЕКРАНА В INCH</strong> : 15.6 &quot;</li>\r\n	<li title=""><strong>ЧЕСТОТА НА ПРОЦЕСОРА</strong> : 1.60 - 2.40 GHz</li>\r\n	<li title=""><strong>ТИП ГРАФИЧНА КАРТА</strong> : NVIDIA GEFORCE 920M</li>\r\n</ul>\r\n', '', '100', '', 'en', 1, 'product', ''),
(3, 'Плот за вграждане BOSCH PKK651F17E', '<ul>\r\n	<li title=""><strong>ВИД</strong> : 4 КОТЛОНА</li>\r\n	<li title=""><strong>ТИП</strong> : КЕРАМИЧЕН ПЛОТ ЗА ВГРАЖДАНЕ</li>\r\n	<li title=""><strong>БРОЙ НАГРЕВАТЕЛНИ ЗОНИ</strong> : 3(2РАЗШИРЯЕМИ</li>\r\n</ul>\r\n', '', '100', '', 'bg', 2, 'product', ''),
(4, 'Plot BOSCH PKK651F17E', '<ul>\r\n	<li title=""><strong>ВИД</strong> : 4 КОТЛОНА</li>\r\n	<li title=""><strong>ТИП</strong> : КЕРАМИЧЕН ПЛОТ ЗА ВГРАЖДАНЕ</li>\r\n	<li title=""><strong>БРОЙ НАГРЕВАТЕЛНИ ЗОНИ</strong> : 3(2РАЗШИРЯЕМИ</li>\r\n</ul>\r\n', '', '50', '', 'en', 2, 'product', ''),
(5, '', '', '', '', '', 'bg', 1, 'shop_categorie', 'Техника'),
(6, '', '', '', '', '', 'en', 1, 'shop_categorie', 'Technics'),
(7, '', '', '', '', '', 'bg', 2, 'shop_categorie', 'Аудио'),
(8, '', '', '', '', '', 'en', 2, 'shop_categorie', 'Audio'),
(9, 'Домашнo кинo PHILIPS HTD-3510', '<ul>\r\n	<li title=""><strong>БРОЙ КОЛОНИ</strong> : 5.1</li>\r\n	<li title=""><strong>ОБЩА МОЩНОСТ</strong> : 300 W</li>\r\n</ul>\r\n', '', '22', '', 'bg', 3, 'product', ''),
(10, 'Home Kino PHILIPS HTD-3510', '<ul>\r\n	<li title=""><strong>БРОЙ КОЛОНИ</strong> : 5.1</li>\r\n	<li title=""><strong>ОБЩА МОЩНОСТ</strong> : 300 W</li>\r\n</ul>\r\n', '', '33', '', 'en', 3, 'product', ''),
(11, 'Домашнo кинo PHILIPS CSS5530G', '<ul>\r\n	<li title=""><strong>БРОЙ КОЛОНИ</strong> : 5.1</li>\r\n	<li title=""><strong>ОБЩА МОЩНОСТ</strong> : 420 W</li>\r\n</ul>\r\n', '', '22', '', 'bg', 4, 'product', ''),
(12, 'Home Kino PHILIPS CSS5530G', '<ul>\r\n	<li title=""><strong>БРОЙ КОЛОНИ</strong> : 5.1</li>\r\n	<li title=""><strong>ОБЩА МОЩНОСТ</strong> : 420 W</li>\r\n</ul>\r\n', '', '33', '', 'en', 4, 'product', ''),
(13, '', '', '', '', '', 'bg', 3, 'shop_categorie', 'Климатици'),
(14, '', '', '', '', '', 'en', 3, 'shop_categorie', 'Clima'),
(15, 'Инверторен климатик SANG TAC-09CHSA/HCI', '<ul>\r\n	<li title=""><strong>МОЩНОСТ ОХЛАЖДАНЕ</strong> : 2.600 KW</li>\r\n	<li title=""><strong>МОЩНОСТ ОТОПЛЕНИЕ</strong> : 2.600 KW</li>\r\n	<li title=""><strong>ИНВЕРТОРЕН МОТОР</strong></li>\r\n	<li title=""><strong>СЕЗОНЕН EER КОЕФ. НА ТРАНСФ.</strong> : 6.1</li>\r\n	<li title=""><strong>СЕЗОНЕН COP КОЕФ. НА ТРАНСФ.</strong> : 4</li>\r\n</ul>\r\n', '', '22', '', 'bg', 5, 'product', ''),
(16, 'Clima SANG TAC-09CHSA/HCI', '<ul>\r\n	<li title=""><strong>МОЩНОСТ ОХЛАЖДАНЕ</strong> : 2.600 KW</li>\r\n	<li title=""><strong>МОЩНОСТ ОТОПЛЕНИЕ</strong> : 2.600 KW</li>\r\n	<li title=""><strong>ИНВЕРТОРЕН МОТОР</strong></li>\r\n	<li title=""><strong>СЕЗОНЕН EER КОЕФ. НА ТРАНСФ.</strong> : 6.1</li>\r\n	<li title=""><strong>СЕЗОНЕН COP КОЕФ. НА ТРАНСФ.</strong> : 4</li>\r\n</ul>\r\n', '', '33', '', 'en', 5, 'product', ''),
(17, '', '', '', '', '', 'bg', 4, 'shop_categorie', 'Тениски'),
(18, '', '', '', '', '', 'en', 4, 'shop_categorie', 'T-Shorts'),
(19, 'Тениска Alter Ego Compression ', '<p>Тениската HeatGear Armour Alter Ego Compression е изключително лека и осигурява комфорт както по време на тренировка, така и в свободното време.</p>\r\n', '', '22', '', 'bg', 6, 'product', ''),
(20, 'T-Short Alter Ego Compression ', '<p>Тениската HeatGear Armour Alter Ego Compression е изключително лека и осигурява комфорт както по време на тренировка, така и в свободното време.</p>\r\n', '', '33', '', 'en', 6, 'product', ''),
(21, 'BG:  AtoZ CSS Quick Tip: Justifying Text and Using Flexbox ', '<p>Welcome to our AtoZ CSS series! In this series, I&rsquo;ll be exploring different CSS values (and properties) each beginning with a different letter of the alphabet. We know that sometimes screencasts are just not enough, so in this article, I&rsquo;ve added a new quick tip/lesson about justifying text for you.</p>\r\n', '', '', '', 'bg', 1, 'blog', ''),
(22, ' AtoZ CSS Quick Tip: Justifying Text and Using Flexbox ', '<p>Welcome to our AtoZ CSS series! In this series, I&rsquo;ll be exploring different CSS values (and properties) each beginning with a different letter of the alphabet. We know that sometimes screencasts are just not enough, so in this article, I&rsquo;ve added a new quick tip/lesson about justifying text for you.</p>\r\n', '', '', '', 'en', 1, 'blog', ''),
(23, ' Versioning Podcast, Episode 10, with Alex Fitzpatrick ', '<p class="wp-special">In this episode, Tim and David are joined by Alex Fitzpatrick, Deputy Tech Editor for Time Magazine. They discuss the viability of the web as a mass publishing tool, the challenges of monetizing content in the age of the ad blocker, and the battle between walled gardens, silos, paywalls and the open web.</p>\r\n', '', '', '', 'bg', 2, 'blog', ''),
(24, ' Versioning Podcast, Episode 10, with Alex Fitzpatrick ', '<p class="wp-special">In this episode, Tim and David are joined by Alex Fitzpatrick, Deputy Tech Editor for Time Magazine. They discuss the viability of the web as a mass publishing tool, the challenges of monetizing content in the age of the ad blocker, and the battle between walled gardens, silos, paywalls and the open web.</p>\r\n', '', '', '', 'en', 2, 'blog', ''),
(25, 'Conventional Software Development: Dev vs Ops', '<p>Traditionally, there are distinct teams and processes for the different states of a project, from the initial states of <strong>analysis and design</strong> (when a product or idea is conceived), to the actual <strong>development and testing</strong> (e.g. when code is being written or a product is being developed), to finally <strong>deployment and maintenance</strong> (e.g. when a website, application, or product goes live).</p>\r\n\r\n<p>There&rsquo;s good reason for this differentiation: they all demand a different set of skills. However, a strict (and at times even bureaucratic) separation of duties can add a lot of unnecessary delays, and experience proves that blurring some of these lines can be advantageous for all of the parties involved, and for the process as a whole.</p>\r\n\r\n<div class="ArticleBox u-inline">\r\n<h3 class="ArticleBox_header t-bg">More from this author</h3>\r\n\r\n<div class="m-border ArticleBox_content">\r\n<ul class="ArticleBox_list">\r\n	<li class="ArticleBox_listItem"><a class="f-c-grey-500 l-b-n" href="https://www.sitepoint.com/a-side-by-side-comparison-of-aws-google-cloud-and-azure/?utm_source=sitepoint&amp;utm_medium=relatedinline&amp;utm_term=&amp;utm_campaign=relatedauthor">A Side-by-Side Comparison of AWS, Google Cloud and Azure</a></li>\r\n	<li class="ArticleBox_listItem"><a class="f-c-grey-500 l-b-n" href="https://www.sitepoint.com/docker-containers-software-delivery/?utm_source=sitepoint&amp;utm_medium=relatedinline&amp;utm_term=&amp;utm_campaign=relatedauthor">Understanding Docker, Containers and Safer Software Delivery</a></li>\r\n</ul>\r\n</div>\r\n</div>\r\n\r\n<p>This is true not only for software development, but for many industries. Think of Toyota, for example, the Japanese car manufacturer that&rsquo;s had, for many years, a strong culture of reducing what they call &ldquo;waste&rdquo; from the production chain so that they could fasten the flow of changes from development into operations. Furthermore, Toyota&rsquo;s practices have, in fact, heavily influenced the IT</p>\r\n', '', '', '', 'bg', 3, 'blog', ''),
(26, 'Conventional Software Development: Dev vs Ops', '<p>Traditionally, there are distinct teams and processes for the different states of a project, from the initial states of <strong>analysis and design</strong> (when a product or idea is conceived), to the actual <strong>development and testing</strong> (e.g. when code is being written or a product is being developed), to finally <strong>deployment and maintenance</strong> (e.g. when a website, application, or product goes live).</p>\r\n\r\n<p>There&rsquo;s good reason for this differentiation: they all demand a different set of skills. However, a strict (and at times even bureaucratic) separation of duties can add a lot of unnecessary delays, and experience proves that blurring some of these lines can be advantageous for all of the parties involved, and for the process as a whole.</p>\r\n\r\n<div class="ArticleBox u-inline">\r\n<h3 class="ArticleBox_header t-bg">More from this author</h3>\r\n\r\n<div class="m-border ArticleBox_content">\r\n<ul class="ArticleBox_list">\r\n	<li class="ArticleBox_listItem"><a class="f-c-grey-500 l-b-n" href="https://www.sitepoint.com/a-side-by-side-comparison-of-aws-google-cloud-and-azure/?utm_source=sitepoint&amp;utm_medium=relatedinline&amp;utm_term=&amp;utm_campaign=relatedauthor">A Side-by-Side Comparison of AWS, Google Cloud and Azure</a></li>\r\n	<li class="ArticleBox_listItem"><a class="f-c-grey-500 l-b-n" href="https://www.sitepoint.com/docker-containers-software-delivery/?utm_source=sitepoint&amp;utm_medium=relatedinline&amp;utm_term=&amp;utm_campaign=relatedauthor">Understanding Docker, Containers and Safer Software Delivery</a></li>\r\n</ul>\r\n</div>\r\n</div>\r\n\r\n<p>This is true not only for software development, but for many industries. Think of Toyota, for example, the Japanese car manufacturer that&rsquo;s had, for many years, a strong culture of reducing what they call &ldquo;waste&rdquo; from the production chain so that they could fasten the flow of changes from development into operations. Furthermore, Toyota&rsquo;s practices have, in fact, heavily influenced the IT</p>\r\n', '', '', '', 'en', 3, 'blog', ''),
(27, 'Обувки AIR MAX COMMAND LEA', '<p style="float: left; padding: 0 5px; margin: 20px 0">Мъжки спортни обувки подходящи за ежедневието<br />\r\nКласически дизайн и изключителна мекота събрани в едно.</p>\r\n', '<p>Мъжки спортни обувки подходящи за ежедневието Класически дизайн и изключителна мекота събрани в едно.</p>\r\n', '200', '', 'bg', 7, 'product', ''),
(28, 'Shoes AIR MAX COMMAND LEA', '<p style="float: left; padding: 0 5px; margin: 20px 0">Мъжки спортни обувки подходящи за ежедневието<br />\r\nКласически дизайн и изключителна мекота събрани в едно.</p>\r\n', '<p>Мъжки спортни обувки подходящи за ежедневието Класически дизайн и изключителна мекота събрани в едно.</p>\r\n', '178', '', 'en', 7, 'product', ''),
(29, '', '', '', '', '', 'bg', 5, 'shop_categorie', 'Обувки'),
(30, '', '', '', '', '', 'en', 5, 'shop_categorie', 'Shoes'),
(68, '', '<p>тест ми</p>\r\n', '', '', '', 'bg', 5, 'page', 'тест'),
(69, '', '<p>test me</p>\r\n', '', '', '', 'en', 5, 'page', 'test'),
(70, '', '', '', '', '', 'bg', 6, 'page', 'Киро'),
(71, '', '', '', '', '', 'en', 6, 'page', 'kiro');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'notifications by email',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `notify`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'kiro_tyson@abv.bg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `valueStore`
--

CREATE TABLE IF NOT EXISTS `valueStore` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `thekey` varchar(50) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `key` (`thekey`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `valueStore`
--

INSERT INTO `valueStore` (`id`, `thekey`, `value`) VALUES
(1, 'sitelogo', 'logo1.png'),
(2, 'navitext', 'My Online Shop'),
(3, 'footercopyright', 'Copyright © Footer E-commerce Plugin 2014. All right reserved. '),
(4, 'contactspage', '<address><strong>Twitter, Inc.</strong><br />\r\n795 Folsom Ave, Suite 600<br />\r\nSan Francisco, CA 94107<br />\r\n<abbr title="Phone">P:</abbr> (123) 456-7890</address>\r\n\r\n<address><strong>Full Name</strong><br />\r\n<a href="mailto:#">first.last@example.com</'),
(5, 'footerContactAddr', ''),
(6, 'footerContactEmail', ''),
(7, 'footerContactPhone', 'asd'),
(8, 'googleMaps', '42.676850, 23.379063'),
(9, 'footerAboutUs', 'test'),
(10, 'footerSocialFacebook', '1'),
(11, 'footerSocialTwitter', '2'),
(12, 'footerSocialGooglePlus', '3'),
(13, 'footerSocialPinterest', '4'),
(14, 'footerSocialYoutube', '5'),
(16, 'contactsEmailTo', 'kiro@abv.bg'),
(17, 'shippingOrder', '50'),
(18, 'addJs', ''),
(19, 'publicQuantity', '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
