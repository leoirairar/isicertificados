-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 26-08-2019 a las 22:03:42
-- Versión del servidor: 5.7.26
-- Versión de PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `isi_certificates`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Andorra', 'ad', NULL, NULL),
(2, 'United Arab Emirates', 'ae', NULL, NULL),
(3, 'Afghanistan', 'af', NULL, NULL),
(4, 'Antigua and Barbuda', 'ag', NULL, NULL),
(5, 'Anguilla', 'ai', NULL, NULL),
(6, 'Albania', 'al', NULL, NULL),
(7, 'Armenia', 'am', NULL, NULL),
(8, 'Netherlands Antilles', 'an', NULL, NULL),
(9, 'Angola', 'ao', NULL, NULL),
(10, 'Argentina', 'ar', NULL, NULL),
(11, 'Austria', 'at', NULL, NULL),
(12, 'Australia', 'au', NULL, NULL),
(13, 'Aruba', 'aw', NULL, NULL),
(14, 'Azerbaijan', 'az', NULL, NULL),
(15, 'Bosnia and Herzegovina', 'ba', NULL, NULL),
(16, 'Barbados', 'bb', NULL, NULL),
(17, 'Bangladesh', 'bd', NULL, NULL),
(18, 'Belgium', 'be', NULL, NULL),
(19, 'Burkina Faso', 'bf', NULL, NULL),
(20, 'Bulgaria', 'bg', NULL, NULL),
(21, 'Bahrain', 'bh', NULL, NULL),
(22, 'Burundi', 'bi', NULL, NULL),
(23, 'Benin', 'bj', NULL, NULL),
(24, 'Bermuda', 'bm', NULL, NULL),
(25, 'Brunei Darussalam', 'bn', NULL, NULL),
(26, 'Bolivia', 'bo', NULL, NULL),
(27, 'Brazil', 'br', NULL, NULL),
(28, 'Bahamas', 'bs', NULL, NULL),
(29, 'Bhutan', 'bt', NULL, NULL),
(30, 'Botswana', 'bw', NULL, NULL),
(31, 'Belarus', 'by', NULL, NULL),
(32, 'Belize', 'bz', NULL, NULL),
(33, 'Canada', 'ca', NULL, NULL),
(34, 'Cocos (Keeling) Islands', 'cc', NULL, NULL),
(35, 'Democratic Republic of the Congo', 'cd', NULL, NULL),
(36, 'Central African Republic', 'cf', NULL, NULL),
(37, 'Congo', 'cg', NULL, NULL),
(38, 'Switzerland', 'ch', NULL, NULL),
(39, 'Cote D\'Ivoire (Ivory Coast)', 'ci', NULL, NULL),
(40, 'Cook Islands', 'ck', NULL, NULL),
(41, 'Chile', 'cl', NULL, NULL),
(42, 'Cameroon', 'cm', NULL, NULL),
(43, 'China', 'cn', NULL, NULL),
(44, 'Colombia', 'co', NULL, NULL),
(45, 'Costa Rica', 'cr', NULL, NULL),
(46, 'Cuba', 'cu', NULL, NULL),
(47, 'Cape Verde', 'cv', NULL, NULL),
(48, 'Christmas Island', 'cx', NULL, NULL),
(49, 'Cyprus', 'cy', NULL, NULL),
(50, 'Czech Republic', 'cz', NULL, NULL),
(51, 'Germany', 'de', NULL, NULL),
(52, 'Djibouti', 'dj', NULL, NULL),
(53, 'Denmark', 'dk', NULL, NULL),
(54, 'Dominica', 'dm', NULL, NULL),
(55, 'Dominican Republic', 'do', NULL, NULL),
(56, 'Algeria', 'dz', NULL, NULL),
(57, 'Ecuador', 'ec', NULL, NULL),
(58, 'Estonia', 'ee', NULL, NULL),
(59, 'Egypt', 'eg', NULL, NULL),
(60, 'Western Sahara', 'eh', NULL, NULL),
(61, 'Eritrea', 'er', NULL, NULL),
(62, 'Spain', 'es', NULL, NULL),
(63, 'Ethiopia', 'et', NULL, NULL),
(64, 'Finland', 'fi', NULL, NULL),
(65, 'Fiji', 'fj', NULL, NULL),
(66, 'Falkland Islands (Malvinas)', 'fk', NULL, NULL),
(67, 'Federated States of Micronesia', 'fm', NULL, NULL),
(68, 'Faroe Islands', 'fo', NULL, NULL),
(69, 'France', 'fr', NULL, NULL),
(70, 'Gabon', 'ga', NULL, NULL),
(71, 'Great Britain (UK)', 'gb', NULL, NULL),
(72, 'Grenada', 'gd', NULL, NULL),
(73, 'Georgia', 'ge', NULL, NULL),
(74, 'French Guiana', 'gf', NULL, NULL),
(75, 'NULL', 'gg', NULL, NULL),
(76, 'Ghana', 'gh', NULL, NULL),
(77, 'Gibraltar', 'gi', NULL, NULL),
(78, 'Greenland', 'gl', NULL, NULL),
(79, 'Gambia', 'gm', NULL, NULL),
(80, 'Guinea', 'gn', NULL, NULL),
(81, 'Guadeloupe', 'gp', NULL, NULL),
(82, 'Equatorial Guinea', 'gq', NULL, NULL),
(83, 'Greece', 'gr', NULL, NULL),
(84, 'S. Georgia and S. Sandwich Islands', 'gs', NULL, NULL),
(85, 'Guatemala', 'gt', NULL, NULL),
(86, 'Guinea-Bissau', 'gw', NULL, NULL),
(87, 'Guyana', 'gy', NULL, NULL),
(88, 'Hong Kong', 'hk', NULL, NULL),
(89, 'Honduras', 'hn', NULL, NULL),
(90, 'Croatia (Hrvatska)', 'hr', NULL, NULL),
(91, 'Haiti', 'ht', NULL, NULL),
(92, 'Hungary', 'hu', NULL, NULL),
(93, 'Indonesia', 'id', NULL, NULL),
(94, 'Ireland', 'ie', NULL, NULL),
(95, 'Israel', 'il', NULL, NULL),
(96, 'India', 'in', NULL, NULL),
(97, 'Iraq', 'iq', NULL, NULL),
(98, 'Iran', 'ir', NULL, NULL),
(99, 'Iceland', 'is', NULL, NULL),
(100, 'Italy', 'it', NULL, NULL),
(101, 'Jamaica', 'jm', NULL, NULL),
(102, 'Jordan', 'jo', NULL, NULL),
(103, 'Japan', 'jp', NULL, NULL),
(104, 'Kenya', 'ke', NULL, NULL),
(105, 'Kyrgyzstan', 'kg', NULL, NULL),
(106, 'Cambodia', 'kh', NULL, NULL),
(107, 'Kiribati', 'ki', NULL, NULL),
(108, 'Comoros', 'km', NULL, NULL),
(109, 'Saint Kitts and Nevis', 'kn', NULL, NULL),
(110, 'Korea (North)', 'kp', NULL, NULL),
(111, 'Korea (South)', 'kr', NULL, NULL),
(112, 'Kuwait', 'kw', NULL, NULL),
(113, 'Cayman Islands', 'ky', NULL, NULL),
(114, 'Kazakhstan', 'kz', NULL, NULL),
(115, 'Laos', 'la', NULL, NULL),
(116, 'Lebanon', 'lb', NULL, NULL),
(117, 'Saint Lucia', 'lc', NULL, NULL),
(118, 'Liechtenstein', 'li', NULL, NULL),
(119, 'Sri Lanka', 'lk', NULL, NULL),
(120, 'Liberia', 'lr', NULL, NULL),
(121, 'Lesotho', 'ls', NULL, NULL),
(122, 'Lithuania', 'lt', NULL, NULL),
(123, 'Luxembourg', 'lu', NULL, NULL),
(124, 'Latvia', 'lv', NULL, NULL),
(125, 'Libya', 'ly', NULL, NULL),
(126, 'Morocco', 'ma', NULL, NULL),
(127, 'Monaco', 'mc', NULL, NULL),
(128, 'Moldova', 'md', NULL, NULL),
(129, 'Madagascar', 'mg', NULL, NULL),
(130, 'Marshall Islands', 'mh', NULL, NULL),
(131, 'Macedonia', 'mk', NULL, NULL),
(132, 'Mali', 'ml', NULL, NULL),
(133, 'Myanmar', 'mm', NULL, NULL),
(134, 'Mongolia', 'mn', NULL, NULL),
(135, 'Macao', 'mo', NULL, NULL),
(136, 'Northern Mariana Islands', 'mp', NULL, NULL),
(137, 'Martinique', 'mq', NULL, NULL),
(138, 'Mauritania', 'mr', NULL, NULL),
(139, 'Montserrat', 'ms', NULL, NULL),
(140, 'Malta', 'mt', NULL, NULL),
(141, 'Mauritius', 'mu', NULL, NULL),
(142, 'Maldives', 'mv', NULL, NULL),
(143, 'Malawi', 'mw', NULL, NULL),
(144, 'Mexico', 'mx', NULL, NULL),
(145, 'Malaysia', 'my', NULL, NULL),
(146, 'Mozambique', 'mz', NULL, NULL),
(147, 'Namibia', 'na', NULL, NULL),
(148, 'New Caledonia', 'nc', NULL, NULL),
(149, 'Niger', 'ne', NULL, NULL),
(150, 'Norfolk Island', 'nf', NULL, NULL),
(151, 'Nigeria', 'ng', NULL, NULL),
(152, 'Nicaragua', 'ni', NULL, NULL),
(153, 'Netherlands', 'nl', NULL, NULL),
(154, 'Norway', 'no', NULL, NULL),
(155, 'Nepal', 'np', NULL, NULL),
(156, 'Nauru', 'nr', NULL, NULL),
(157, 'Niue', 'nu', NULL, NULL),
(158, 'New Zealand (Aotearoa)', 'nz', NULL, NULL),
(159, 'Oman', 'om', NULL, NULL),
(160, 'Panama', 'pa', NULL, NULL),
(161, 'Peru', 'pe', NULL, NULL),
(162, 'French Polynesia', 'pf', NULL, NULL),
(163, 'Papua New Guinea', 'pg', NULL, NULL),
(164, 'Philippines', 'ph', NULL, NULL),
(165, 'Pakistan', 'pk', NULL, NULL),
(166, 'Poland', 'pl', NULL, NULL),
(167, 'Saint Pierre and Miquelon', 'pm', NULL, NULL),
(168, 'Pitcairn', 'pn', NULL, NULL),
(169, 'Palestinian Territory', 'ps', NULL, NULL),
(170, 'Portugal', 'pt', NULL, NULL),
(171, 'Palau', 'pw', NULL, NULL),
(172, 'Paraguay', 'py', NULL, NULL),
(173, 'Qatar', 'qa', NULL, NULL),
(174, 'Reunion', 're', NULL, NULL),
(175, 'Romania', 'ro', NULL, NULL),
(176, 'Russian Federation', 'ru', NULL, NULL),
(177, 'Rwanda', 'rw', NULL, NULL),
(178, 'Saudi Arabia', 'sa', NULL, NULL),
(179, 'Solomon Islands', 'sb', NULL, NULL),
(180, 'Seychelles', 'sc', NULL, NULL),
(181, 'Sudan', 'sd', NULL, NULL),
(182, 'Sweden', 'se', NULL, NULL),
(183, 'Singapore', 'sg', NULL, NULL),
(184, 'Saint Helena', 'sh', NULL, NULL),
(185, 'Slovenia', 'si', NULL, NULL),
(186, 'Svalbard and Jan Mayen', 'sj', NULL, NULL),
(187, 'Slovakia', 'sk', NULL, NULL),
(188, 'Sierra Leone', 'sl', NULL, NULL),
(189, 'San Marino', 'sm', NULL, NULL),
(190, 'Senegal', 'sn', NULL, NULL),
(191, 'Somalia', 'so', NULL, NULL),
(192, 'Suriname', 'sr', NULL, NULL),
(193, 'Sao Tome and Principe', 'st', NULL, NULL),
(194, 'El Salvador', 'sv', NULL, NULL),
(195, 'Syria', 'sy', NULL, NULL),
(196, 'Swaziland', 'sz', NULL, NULL),
(197, 'Turks and Caicos Islands', 'tc', NULL, NULL),
(198, 'Chad', 'td', NULL, NULL),
(199, 'French Southern Territories', 'tf', NULL, NULL),
(200, 'Togo', 'tg', NULL, NULL),
(201, 'Thailand', 'th', NULL, NULL),
(202, 'Tajikistan', 'tj', NULL, NULL),
(203, 'Tokelau', 'tk', NULL, NULL),
(204, 'Turkmenistan', 'tm', NULL, NULL),
(205, 'Tunisia', 'tn', NULL, NULL),
(206, 'Tonga', 'to', NULL, NULL),
(207, 'Turkey', 'tr', NULL, NULL),
(208, 'Trinidad and Tobago', 'tt', NULL, NULL),
(209, 'Tuvalu', 'tv', NULL, NULL),
(210, 'Taiwan', 'tw', NULL, NULL),
(211, 'Tanzania', 'tz', NULL, NULL),
(212, 'Ukraine', 'ua', NULL, NULL),
(213, 'Uganda', 'ug', NULL, NULL),
(214, 'Uruguay', 'uy', NULL, NULL),
(215, 'Uzbekistan', 'uz', NULL, NULL),
(216, 'Saint Vincent and the Grenadines', 'vc', NULL, NULL),
(217, 'Venezuela', 've', NULL, NULL),
(218, 'Virgin Islands (British)', 'vg', NULL, NULL),
(219, 'Virgin Islands (U.S.)', 'vi', NULL, NULL),
(220, 'Viet Nam', 'vn', NULL, NULL),
(221, 'Vanuatu', 'vu', NULL, NULL),
(222, 'Wallis and Futuna', 'wf', NULL, NULL),
(223, 'Samoa', 'ws', NULL, NULL),
(224, 'Yemen', 'ye', NULL, NULL),
(225, 'Mayotte', 'yt', NULL, NULL),
(226, 'South Africa', 'za', NULL, NULL),
(227, 'Zambia', 'zm', NULL, NULL),
(228, 'Zaire (former)', 'zr', NULL, NULL),
(229, 'Zimbabwe', 'zw', NULL, NULL),
(230, 'United States of America', 'us', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
