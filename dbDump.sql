CREATE TABLE IF NOT EXISTS `active_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `active_pages` (`id`, `name`, `enabled`) VALUES
(1, 'blog', 1);

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `cookie_law` (
  `id` int(10) UNSIGNED NOT NULL,
  `link` varchar(255) NOT NULL,
  `theme` varchar(20) NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `cookie_law_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `message` varchar(255) NOT NULL,
  `button_text` varchar(50) NOT NULL,
  `learn_more` varchar(50) NOT NULL,
  `abbr` varchar(5) NOT NULL,
  `for_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `cookie_law`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cookie_law_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`abbr`,`for_id`) USING BTREE;

ALTER TABLE `cookie_law`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `cookie_law_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity` varchar(255) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `abbr` varchar(5) NOT NULL,
  `name` varchar(30) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `currencyKey` varchar(5) NOT NULL,
  `flag` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `languages` (`id`, `abbr`, `name`, `currency`, `currencyKey`, `flag`) VALUES
(1, 'bg', 'bulgarian', 'лв', 'BGN', 'bg.jpg'),
(2, 'en', 'english', '$', 'USD', 'en.jpg'),
(3, 'gr', 'greece', 'EUR', 'EUR', 'gr.png');


CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `products` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `referrer` varchar(255) NOT NULL,
  `clean_referrer` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `paypal_status` varchar(10) DEFAULT NULL,
  `processed` tinyint(1) NOT NULL DEFAULT '0',
  `viewed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'viewed status is change when change processed status',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `orders_clients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(20) NOT NULL,
  `post_code` varchar(10) NOT NULL,
  `notes` text NOT NULL,
  `for_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `brand_id` int(10) UNSIGNED NOT NULL,
  `position` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `seo_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `seo_pages` (`id`, `name`) VALUES
(1, 'home'),
(2, 'checkout'),
(3, 'contacts'),
(4, 'blog');


CREATE TABLE IF NOT EXISTS `shopping_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) NOT NULL,
  `article_id` int(11) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `shop_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sub_for` int(11) NOT NULL,
  `position` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `subscribed` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `basic_description` text NOT NULL,
  `price` varchar(20) NOT NULL,
  `old_price` varchar(20) NOT NULL,
  `abbr` varchar(5) NOT NULL,
  `for_id` int(11) NOT NULL COMMENT ' ',
  `type` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `art_id_abbr` (`abbr`,`for_id`,`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `translations` (`id`, `title`, `description`, `basic_description`, `price`, `old_price`, `abbr`, `for_id`, `type`, `name`) VALUES
(1, '', '', '', '', '', 'bg', 1, 'page', ''),
(2, '', '', '', '', '', 'en', 1, 'page', '');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'notifications by email',
  `last_login` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


INSERT INTO `users` (`id`, `username`, `password`, `email`, `notify`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'your@email.com', 0);

CREATE TABLE `bank_accounts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `iban` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `bic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `value_store` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `thekey` varchar(50) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `key` (`thekey`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `value_store` (`id`, `thekey`, `value`) VALUES
(1, 'sitelogo', 'NewLogo.jpg'),
(2, 'navitext', ''),
(3, 'footercopyright', 'Powered by ECC FZE © All right reserved. '),
(4, 'contactspage', 'Hello dear client'),
(5, 'footerContactAddr', ''),
(6, 'footerContactEmail', 'support@shop.dev'),
(7, 'footerContactPhone', ''),
(8, 'googleMaps', '42.671840, 83.279163'),
(9, 'footerAboutUs', ''),
(10, 'footerSocialFacebook', ''),
(11, 'footerSocialTwitter', ''),
(12, 'footerSocialGooglePlus', ''),
(13, 'footerSocialPinterest', ''),
(14, 'footerSocialYoutube', ''),
(16, 'contactsEmailTo', 'contacts@shop.dev'),
(17, 'shippingOrder', '1'),
(18, 'addJs', ''),
(19, 'publicQuantity', '0'),
(20, 'paypal_email', ''),
(21, 'paypal_sandbox', '0'),
(22, 'paypal_currency', 'EUR'),
(23, 'publicDateAdded', '0'),
(24, 'googleApi', ''),
(25, 'template', 'redlabel'),
(26, 'cashondelivery_visibility', '1'),
(27, 'showBrands', '0'),
(28, 'showInSlider', '0');

CREATE TABLE `brands` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
