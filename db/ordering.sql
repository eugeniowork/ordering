-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2022 at 01:37 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ordering`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cash_in_request`
--

CREATE TABLE `cash_in_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `request_amount` decimal(8,2) NOT NULL,
  `cash_amount` decimal(8,2) NOT NULL,
  `date_expiration` datetime NOT NULL,
  `user_in_charge` int(11) NOT NULL,
  `status` varchar(255) NOT NULL COMMENT 'PENDING, CANCELED, DONE',
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_date` datetime NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cash_in_request`
--

INSERT INTO `cash_in_request` (`id`, `user_id`, `reference_no`, `request_amount`, `cash_amount`, `date_expiration`, `user_in_charge`, `status`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`) VALUES
(2, 22, '987654321', '20000.00', '0.00', '2022-05-05 14:00:00', 0, 'CANCELED', '2022-05-05 08:00:00', 22, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(3, 22, '16518065986241', '50000.00', '0.00', '2022-05-06 09:09:58', 0, 'CANCELED', '2022-05-06 11:09:58', 22, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(4, 22, '16518067723271', '50000.00', '0.00', '2022-05-07 11:12:52', 0, 'CANCELED', '2022-05-06 11:12:52', 22, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(5, 22, '16518072514266', '50000.00', '0.00', '2022-05-07 11:20:51', 0, 'CANCELED', '2022-05-06 11:20:51', 22, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(6, 22, '16518074102274', '5000.00', '0.00', '2022-05-07 11:23:30', 0, 'CANCELED', '2022-05-06 11:23:30', 22, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(7, 22, '16518075541227', '50000.00', '0.00', '2022-05-07 11:25:54', 0, 'CANCELED', '2022-05-06 11:25:54', 22, '2022-05-06 17:19:01', 22, '0000-00-00 00:00:00', 0),
(8, 22, '16518287871784', '80000.00', '0.00', '2022-05-07 17:19:47', 0, 'CANCELED', '2022-05-06 17:19:47', 22, '2022-05-06 17:25:02', 22, '0000-00-00 00:00:00', 0),
(9, 22, '16518461457138', '100000.00', '150000.00', '2022-05-07 22:09:05', 18, 'DONE', '2022-05-06 22:09:05', 22, '2022-05-07 16:30:39', 18, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `faces`
--

CREATE TABLE `faces` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `face1_value` longtext NOT NULL,
  `face1_path` text NOT NULL,
  `face2_value` longtext NOT NULL,
  `face2_path` text NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faces`
--

INSERT INTO `faces` (`id`, `user_id`, `face1_value`, `face1_path`, `face2_value`, `face2_path`, `created_date`) VALUES
(21, 22, '{\"0\":-0.058879632502794266,\"1\":0.17773374915122986,\"2\":0.05116034671664238,\"3\":-0.009604362770915031,\"4\":-0.04633139818906784,\"5\":-0.06108523905277252,\"6\":-0.05116760730743408,\"7\":-0.08452959358692169,\"8\":0.16707122325897217,\"9\":-0.07168134301900864,\"10\":0.23422850668430328,\"11\":-0.03949044272303581,\"12\":-0.26852643489837646,\"13\":-0.1382305771112442,\"14\":-0.017921168357133865,\"15\":0.1562761813402176,\"16\":-0.15395283699035645,\"17\":-0.11898290365934372,\"18\":-0.02752543054521084,\"19\":-0.021384866908192635,\"20\":0.13636182248592377,\"21\":0.012949747033417225,\"22\":0.024528782814741135,\"23\":0.02481250651180744,\"24\":-0.16300487518310547,\"25\":-0.2948511838912964,\"26\":-0.09673546254634857,\"27\":-0.10199855268001556,\"28\":-0.007798179984092712,\"29\":-0.047822896391153336,\"30\":-0.07198745012283325,\"31\":-0.05237404629588127,\"32\":-0.2138940840959549,\"33\":-0.12836049497127533,\"34\":0.03350468724966049,\"35\":0.009063332341611385,\"36\":0.013045759871602058,\"37\":-0.03108948841691017,\"38\":0.18479759991168976,\"39\":0.033250387758016586,\"40\":-0.22207926213741302,\"41\":-0.031092345714569092,\"42\":0.003431853372603655,\"43\":0.2578260898590088,\"44\":0.1272432506084442,\"45\":0.07148301601409912,\"46\":0.03475081920623779,\"47\":-0.104471355676651,\"48\":0.08427232503890991,\"49\":-0.11909624934196472,\"50\":0.10375428199768066,\"51\":0.14588214457035065,\"52\":0.12097880989313126,\"53\":0.055054228752851486,\"54\":0.056429989635944366,\"55\":-0.1698707640171051,\"56\":0.0015771457692608237,\"57\":0.12193727493286133,\"58\":-0.14136458933353424,\"59\":0.006234214175492525,\"60\":0.046633388847112656,\"61\":-0.06986483931541443,\"62\":0.007097610738128424,\"63\":-0.028515752404928207,\"64\":0.24688692390918732,\"65\":0.04087844863533974,\"66\":-0.08444830030202866,\"67\":-0.16304832696914673,\"68\":0.14533424377441406,\"69\":-0.0950644314289093,\"70\":-0.06587467342615128,\"71\":0.06085139513015747,\"72\":-0.12313014268875122,\"73\":-0.14656488597393036,\"74\":-0.3525680601596832,\"75\":0.04079391434788704,\"76\":0.38297039270401,\"77\":0.08903279155492783,\"78\":-0.23515890538692474,\"79\":0.04532034695148468,\"80\":-0.08104762434959412,\"81\":-0.0010318501153960824,\"82\":0.150116965174675,\"83\":0.13767647743225098,\"84\":-0.013829972594976425,\"85\":0.11493432521820068,\"86\":-0.09119224548339844,\"87\":-0.005681509152054787,\"88\":0.18973781168460846,\"89\":-0.10028380155563354,\"90\":-0.06933213770389557,\"91\":0.21122242510318756,\"92\":-0.031432341784238815,\"93\":0.04925995320081711,\"94\":0.05731630325317383,\"95\":-0.025355234742164612,\"96\":-0.09075009822845459,\"97\":0.027565034106373787,\"98\":-0.0905989408493042,\"99\":-0.02515990100800991,\"100\":0.10137271136045456,\"101\":-0.04315970093011856,\"102\":-0.00952569767832756,\"103\":0.11788149923086166,\"104\":-0.17198309302330017,\"105\":0.014206911437213421,\"106\":0.03960246220231056,\"107\":-0.009681952185928822,\"108\":-0.04054606333374977,\"109\":0.020140018314123154,\"110\":-0.13517461717128754,\"111\":-0.1142466589808464,\"112\":0.11148959398269653,\"113\":-0.24149256944656372,\"114\":0.24493156373500824,\"115\":0.14660854637622833,\"116\":-0.02444634959101677,\"117\":0.12497567385435104,\"118\":0.11080769449472427,\"119\":0.06767670810222626,\"120\":0.020869180560112,\"121\":-0.03854501247406006,\"122\":-0.1209438219666481,\"123\":-0.05641533434391022,\"124\":0.12669534981250763,\"125\":0.01052898820489645,\"126\":0.14861910045146942,\"127\":-0.009658798575401306}', 'assets/uploads/faces/62714a05d94c0.png', '{\"0\":-0.08602114766836166,\"1\":0.1425589919090271,\"2\":0.0009995012078434229,\"3\":-0.03866095468401909,\"4\":-0.08748448640108109,\"5\":-0.07004772871732712,\"6\":-0.08947693556547165,\"7\":-0.06461013853549957,\"8\":0.1466507911682129,\"9\":-0.08457478135824203,\"10\":0.2027985155582428,\"11\":-0.07761575281620026,\"12\":-0.2777978479862213,\"13\":-0.10944610834121704,\"14\":-0.032129596918821335,\"15\":0.13943135738372803,\"16\":-0.18207837641239166,\"17\":-0.10678289085626602,\"18\":-0.04676435887813568,\"19\":-0.00263988203369081,\"20\":0.08943521976470947,\"21\":0.00288318726234138,\"22\":-0.004490061663091183,\"23\":0.022591836750507355,\"24\":-0.13546434044837952,\"25\":-0.3222864270210266,\"26\":-0.0565558560192585,\"27\":-0.1408003568649292,\"28\":-0.013308912515640259,\"29\":-0.02015308476984501,\"30\":-0.07159411907196045,\"31\":-0.01059152465313673,\"32\":-0.1840437650680542,\"33\":-0.1236748918890953,\"34\":0.05695668235421181,\"35\":0.026087187230587006,\"36\":-0.00004289116259315051,\"37\":0.017108038067817688,\"38\":0.2051970362663269,\"39\":0.04522966966032982,\"40\":-0.2584165036678314,\"41\":-0.07560018450021744,\"42\":0.021636150777339935,\"43\":0.24519897997379303,\"44\":0.1207033023238182,\"45\":0.052887558937072754,\"46\":0.03219592198729515,\"47\":-0.13747155666351318,\"48\":0.12251019477844238,\"49\":-0.13696496188640594,\"50\":0.0642184391617775,\"51\":0.1646609604358673,\"52\":0.14283837378025055,\"53\":0.05858288332819939,\"54\":0.08035200089216232,\"55\":-0.1261499673128128,\"56\":0.030710725113749504,\"57\":0.15837489068508148,\"58\":-0.19289058446884155,\"59\":-0.01637285016477108,\"60\":0.061348218470811844,\"61\":-0.08722477406263351,\"62\":-0.03917468339204788,\"63\":-0.057565804570913315,\"64\":0.25997868180274963,\"65\":0.06404896825551987,\"66\":-0.07378731667995453,\"67\":-0.16114939749240875,\"68\":0.17046234011650085,\"69\":-0.10901515930891037,\"70\":-0.08978023380041122,\"71\":0.0999937653541565,\"72\":-0.06927508860826492,\"73\":-0.15872518718242645,\"74\":-0.33337852358818054,\"75\":0.0015623304061591625,\"76\":0.3525720238685608,\"77\":0.1226382851600647,\"78\":-0.1988351047039032,\"79\":0.04526149481534958,\"80\":-0.06397777795791626,\"81\":-0.07222969830036163,\"82\":0.15952925384044647,\"83\":0.13365115225315094,\"84\":-0.045212045311927795,\"85\":0.12073452025651932,\"86\":-0.022123677656054497,\"87\":-0.014185113832354546,\"88\":0.17264479398727417,\"89\":-0.09400901943445206,\"90\":-0.005636137444525957,\"91\":0.15589004755020142,\"92\":-0.009566686116158962,\"93\":0.04428809881210327,\"94\":0.06296707689762115,\"95\":-0.04072755575180054,\"96\":-0.1030542328953743,\"97\":-0.005804537329822779,\"98\":-0.11715468764305115,\"99\":-0.052373629063367844,\"100\":0.09017094224691391,\"101\":-0.05701170489192009,\"102\":0.017849775031208992,\"103\":0.06726711988449097,\"104\":-0.18243175745010376,\"105\":0.005541250109672546,\"106\":0.027826935052871704,\"107\":-0.06353979557752609,\"108\":-0.03797883912920952,\"109\":-0.03292430192232132,\"110\":-0.045279137790203094,\"111\":-0.09222237765789032,\"112\":0.12238222360610962,\"113\":-0.2495221197605133,\"114\":0.2199927270412445,\"115\":0.11752848327159882,\"116\":-0.004888372030109167,\"117\":0.13830961287021637,\"118\":0.09050356596708298,\"119\":0.021189266815781593,\"120\":-0.013292253948748112,\"121\":-0.07622119784355164,\"122\":-0.1367214322090149,\"123\":-0.0651707723736763,\"124\":0.14460578560829163,\"125\":0.014788957312703133,\"126\":0.13088354468345642,\"127\":-0.06286042183637619}', 'assets/uploads/faces/62714a05d99a9.png', '2022-05-03 23:28:05');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `source_table` varchar(255) NOT NULL,
  `source_id` int(11) NOT NULL,
  `read_status` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `receiver`, `user_id`, `content`, `type`, `source_table`, `source_id`, `read_status`, `created_date`, `created_by`, `updated_date`, `updated_by`) VALUES
(44, 18, 22, 'Customer #customer_name placed an order with Order Number <a href=\'http://localhost/ordering/ongoing-orders-view/2f49685359427376487261356a312f74514e712f6a673d3d\'>1651752370</a>.', 'NEW_ORDER', 'order_history', 13, 1, '2022-05-05 20:06:10', 22, '0000-00-00 00:00:00', 0),
(45, 19, 22, 'Customer #customer_name placed an order with Order Number <a href=\'http://localhost/ordering/ongoing-orders-view/2f49685359427376487261356a312f74514e712f6a673d3d\'>1651752370</a>.', 'NEW_ORDER', 'order_history', 13, 0, '2022-05-05 20:06:10', 22, '0000-00-00 00:00:00', 0),
(46, 22, 18, 'Your order with Order Number <strong>1651752370</strong> is now ready to pickup.', 'CHANGE_ORDER_STATUS', 'order_history', 13, 1, '2022-05-05 20:19:57', 18, '0000-00-00 00:00:00', 0),
(47, 22, 18, 'Payment successful for Order <strong>#1651752370</strong> using FacePay Payment.', 'ORDER_PAYMENT', 'order_history', 13, 1, '2022-05-05 20:22:37', 18, '0000-00-00 00:00:00', 0),
(48, 18, 22, 'Customer #customer_name placed an order with Order Number <a href=\'http://localhost/ordering/ongoing-orders-view/7043684a4143634e6b62566e65734b704950642b31413d3d\'>1651754899</a>.', 'NEW_ORDER', 'order_history', 14, 1, '2022-05-05 20:48:19', 22, '0000-00-00 00:00:00', 0),
(49, 19, 22, 'Customer #customer_name placed an order with Order Number <a href=\'http://localhost/ordering/ongoing-orders-view/7043684a4143634e6b62566e65734b704950642b31413d3d\'>1651754899</a>.', 'NEW_ORDER', 'order_history', 14, 0, '2022-05-05 20:48:19', 22, '0000-00-00 00:00:00', 0),
(50, 22, 18, 'Your order with Order Number <strong>1651754899</strong> is now ready to pickup.', 'CHANGE_ORDER_STATUS', 'order_history', 14, 1, '2022-05-05 20:50:21', 18, '0000-00-00 00:00:00', 0),
(51, 22, 18, 'Payment successful for Order <strong>#1651754899</strong> using FacePay Payment.', 'ORDER_PAYMENT', 'order_history', 14, 1, '2022-05-05 20:55:31', 18, '0000-00-00 00:00:00', 0),
(52, 18, 22, 'Customer #customer_name request Cash In amounting <span>&#8369;</span>50,000.00 with Reference No <a href=\'http://localhost/ordering/cash-in-requests/566a4268583974326a494979453750723165484c37413d3d\'>16518072514266</a>.', 'NEW_ORDER', 'cash_in_request', 5, 1, '2022-05-06 11:20:51', 22, '0000-00-00 00:00:00', 0),
(53, 19, 22, 'Customer #customer_name request Cash In amounting <span>&#8369;</span>50,000.00 with Reference No <a href=\'http://localhost/ordering/cash-in-requests/566a4268583974326a494979453750723165484c37413d3d\'>16518072514266</a>.', 'NEW_ORDER', 'cash_in_request', 5, 0, '2022-05-06 11:20:51', 22, '0000-00-00 00:00:00', 0),
(54, 18, 22, 'Customer #customer_name request Cash In amounting <span>&#8369;</span>5,000.00 with Reference No <a href=\'http://localhost/ordering/cash-in-requests/48676d2f357674696a7436683746436747764e5949513d3d\'>16518074102274</a>.', 'NEW_ORDER', 'cash_in_request', 6, 1, '2022-05-06 11:23:30', 22, '0000-00-00 00:00:00', 0),
(55, 19, 22, 'Customer #customer_name request Cash In amounting <span>&#8369;</span>5,000.00 with Reference No <a href=\'http://localhost/ordering/cash-in-requests/48676d2f357674696a7436683746436747764e5949513d3d\'>16518074102274</a>.', 'NEW_ORDER', 'cash_in_request', 6, 0, '2022-05-06 11:23:30', 22, '0000-00-00 00:00:00', 0),
(56, 18, 22, 'Customer #customer_name request Cash In amounting <span>&#8369;</span>50,000.00 with Reference No <a href=\'http://localhost/ordering/cash-in-requests/394b4569345435444c4b5a45717265767750533872513d3d\'>16518075541227</a>.', 'NEW_ORDER', 'cash_in_request', 7, 1, '2022-05-06 11:25:54', 22, '0000-00-00 00:00:00', 0),
(57, 19, 22, 'Customer #customer_name request Cash In amounting <span>&#8369;</span>50,000.00 with Reference No <a href=\'http://localhost/ordering/cash-in-requests/394b4569345435444c4b5a45717265767750533872513d3d\'>16518075541227</a>.', 'NEW_ORDER', 'cash_in_request', 7, 0, '2022-05-06 11:25:54', 22, '0000-00-00 00:00:00', 0),
(58, 18, 22, 'Customer #customer_name request Cash In amounting <span>&#8369;</span>80,000.00 with Reference No <a href=\'http://localhost/ordering/cash-in-requests/584a746b3975635a4f356d7a2f7038704f7a63424f413d3d\'>16518287871784</a>.', 'NEW_ORDER', 'cash_in_request', 8, 1, '2022-05-06 17:19:47', 22, '0000-00-00 00:00:00', 0),
(59, 19, 22, 'Customer #customer_name request Cash In amounting <span>&#8369;</span>80,000.00 with Reference No <a href=\'http://localhost/ordering/cash-in-requests/584a746b3975635a4f356d7a2f7038704f7a63424f413d3d\'>16518287871784</a>.', 'NEW_ORDER', 'cash_in_request', 8, 0, '2022-05-06 17:19:47', 22, '0000-00-00 00:00:00', 0),
(60, 18, 22, 'Customer #customer_name request Cash In amounting <span>&#8369;</span>100,000.00 with Reference No <a href=\'http://localhost/ordering/cash-in-requests/7237774956784e344d7a494c757a4a503938346552673d3d\'>16518461457138</a>.', 'NEW_ORDER', 'cash_in_request', 9, 1, '2022-05-06 22:09:05', 22, '0000-00-00 00:00:00', 0),
(61, 19, 22, 'Customer #customer_name request Cash In amounting <span>&#8369;</span>100,000.00 with Reference No <a href=\'http://localhost/ordering/cash-in-requests/7237774956784e344d7a494c757a4a503938346552673d3d\'>16518461457138</a>.', 'NEW_ORDER', 'cash_in_request', 9, 0, '2022-05-06 22:09:05', 22, '0000-00-00 00:00:00', 0),
(62, 22, 18, 'Cash In successful with Reference No<strong>16518461457138</strong>.', 'CASH_IN', 'cash_in_request', 9, 1, '2022-05-07 14:23:42', 18, '0000-00-00 00:00:00', 0),
(63, 22, 18, 'Cash In successful with Reference No <strong>16518461457138</strong>.', 'CASH_IN', 'cash_in_request', 9, 1, '2022-05-07 16:27:16', 18, '0000-00-00 00:00:00', 0),
(64, 22, 18, 'Cash In successful with Reference No <strong>16518461457138</strong>.', 'CASH_IN', 'cash_in_request', 9, 1, '2022-05-07 16:27:21', 18, '0000-00-00 00:00:00', 0),
(65, 22, 18, 'Cash In successful with Reference No <strong>16518461457138</strong>.', 'CASH_IN', 'cash_in_request', 9, 1, '2022-05-07 16:28:15', 18, '0000-00-00 00:00:00', 0),
(66, 22, 18, 'Cash In successful with Reference No <strong>16518461457138</strong>.', 'CASH_IN', 'cash_in_request', 9, 1, '2022-05-07 16:28:29', 18, '0000-00-00 00:00:00', 0),
(67, 22, 18, 'Cash In successful with Reference No <strong>16518461457138</strong>.', 'CASH_IN', 'cash_in_request', 9, 1, '2022-05-07 16:28:50', 18, '0000-00-00 00:00:00', 0),
(68, 22, 18, 'Cash In successful with Reference No <strong>16518461457138</strong>.', 'CASH_IN', 'cash_in_request', 9, 1, '2022-05-07 16:30:39', 18, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_history`
--

CREATE TABLE `order_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `total_quantity` int(11) NOT NULL,
  `total_amount` decimal(8,2) NOT NULL,
  `date_pickup` date NOT NULL,
  `actual_date_pickup` datetime NOT NULL,
  `mode_of_payment` varchar(255) NOT NULL COMMENT 'FACE PAY, CASH',
  `status` varchar(255) NOT NULL COMMENT ',FOR PROCESS, FOR PICKUP, PICKED UP, CANCELED',
  `status_remarks` varchar(255) NOT NULL,
  `cash_payment_amount` decimal(8,2) NOT NULL,
  `user_in_charge` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_date` datetime NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_history`
--

INSERT INTO `order_history` (`id`, `user_id`, `order_number`, `total_quantity`, `total_amount`, `date_pickup`, `actual_date_pickup`, `mode_of_payment`, `status`, `status_remarks`, `cash_payment_amount`, `user_in_charge`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`) VALUES
(13, 22, '1651752370', 6, '20414.00', '2022-05-05', '2022-05-05 20:22:37', 'FACE PAY', 'FOR PICKUP', '', '0.00', 18, '2022-05-05 20:06:10', 22, '2022-05-05 20:22:37', 18, '0000-00-00 00:00:00', 0),
(14, 22, '1651754899', 2, '19900.00', '2022-05-05', '2022-05-05 20:55:31', 'FACE PAY', 'PICKED UP', '', '0.00', 18, '2022-05-05 20:48:19', 22, '2022-05-05 20:55:31', 18, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_history_products`
--

CREATE TABLE `order_history_products` (
  `id` int(11) NOT NULL,
  `order_history_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_date` datetime NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_history_products`
--

INSERT INTO `order_history_products` (`id`, `order_history_id`, `product_id`, `name`, `category_name`, `quantity`, `price`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`) VALUES
(25, 13, 80, 'Pencil', 'School Supplies', '2', '7.00', '2022-05-05 20:06:10', 22, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(26, 13, 81, 'Bond Paper', 'School Supplies', '2', '250.00', '2022-05-05 20:06:10', 22, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(27, 13, 83, 'TV', 'Appliances', '2', '9950.00', '2022-05-05 20:06:10', 22, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(28, 14, 83, 'TV', 'Appliances', '2', '9950.00', '2022-05-05 20:48:19', 22, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_verified` int(11) NOT NULL,
  `module` varchar(255) NOT NULL,
  `date_expiration` datetime DEFAULT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `otp`
--

INSERT INTO `otp` (`id`, `email`, `code`, `is_active`, `is_verified`, `module`, `date_expiration`, `created_date`) VALUES
(1, 'eugenioderick@gmail.com', '491032', 0, 0, 'order_payment_verification', '2022-05-05 20:40:50', '2022-05-05 20:20:50'),
(2, 'eugenioderick@gmail.com', '868758', 0, 0, 'order_payment_verification', '2022-05-05 21:05:49', '2022-05-05 20:45:49'),
(3, 'eugenioderick@gmail.com', '125985', 0, 0, 'order_payment_verification', '2022-05-05 21:06:33', '2022-05-05 20:46:33'),
(4, 'eugenioderick@gmail.com', '788779', 0, 0, 'order_payment_verification', '2022-05-05 21:07:03', '2022-05-05 20:47:03'),
(5, 'eugenioderick@gmail.com', '808392', 0, 0, 'order_payment_verification', '2022-05-05 21:11:46', '2022-05-05 20:51:46'),
(6, 'eugenioderick@gmail.com', '293941', 0, 1, 'order_payment_verification', '2022-05-05 21:12:41', '2022-05-05 20:52:41'),
(7, 'eugenioderick@gmail.com', '529686', 0, 1, 'order_payment_verification', '2022-05-05 21:14:03', '2022-05-05 20:54:03'),
(8, 'eugenioderick@gmail.com', '136703', 0, 1, 'order_payment_verification', '2022-05-05 21:14:42', '2022-05-05 20:54:42'),
(9, 'eugenioderick@gmail.com', '703878', 0, 0, 'cash_in_verification', '2022-05-07 12:19:45', '2022-05-07 11:59:45'),
(10, 'eugenioderick@gmail.com', '185744', 0, 0, 'cash_in_verification', '2022-05-07 12:23:04', '2022-05-07 12:03:04'),
(11, 'eugenioderick@gmail.com', '618554', 0, 0, 'cash_in_verification', '2022-05-07 12:23:20', '2022-05-07 12:03:20'),
(12, 'eugenioderick@gmail.com', '809671', 0, 0, 'cash_in_verification', '2022-05-07 12:27:48', '2022-05-07 12:07:48'),
(13, 'eugenioderick@gmail.com', '901899', 0, 0, 'cash_in_verification', '2022-05-07 12:43:05', '2022-05-07 12:23:05'),
(14, 'eugenioderick@gmail.com', '513418', 0, 0, 'cash_in_verification', '2022-05-07 12:52:37', '2022-05-07 12:32:37'),
(15, 'eugenioderick@gmail.com', '248447', 0, 1, 'cash_in_verification', '2022-05-07 12:52:46', '2022-05-07 12:32:46'),
(16, 'eugenioderick@gmail.com', '328804', 0, 1, 'cash_in_verification', '2022-05-07 13:28:38', '2022-05-07 13:08:38'),
(17, 'eugenioderick@gmail.com', '492261', 0, 0, 'cash_in_verification', '2022-05-07 13:29:15', '2022-05-07 13:09:15'),
(18, 'eugenioderick@gmail.com', '460999', 0, 0, 'cash_in_verification', '2022-05-07 13:40:50', '2022-05-07 13:20:50'),
(19, 'eugenioderick@gmail.com', '896260', 0, 1, 'cash_in_verification', '2022-05-07 13:52:08', '2022-05-07 13:32:08'),
(20, 'eugenioderick@gmail.com', '749247', 0, 1, 'cash_in_verification', '2022-05-07 13:53:23', '2022-05-07 13:33:23'),
(21, 'eugenioderick@gmail.com', '428208', 0, 1, 'cash_in_verification', '2022-05-07 13:53:48', '2022-05-07 13:33:48');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `image_path` text NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_date` datetime NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `code`, `price`, `stock`, `category_id`, `image_path`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`) VALUES
(80, 'Pencil', 'pencil', '7.00', 3, 1, 'assets/uploads/products/pencil.jpg\r\n', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(81, 'Bond Paper', 'bond paper', '250.00', 59, 1, 'assets/uploads/products/bond_paper.jfif\r\n', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(82, 'Electric Fan', 'fan', '950.00', 0, 2, 'assets/uploads/products/fan.jpg\r\n', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(83, 'TV', 'tv', '9950.00', 30, 2, 'assets/uploads/products/tv.jpg\r\n', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(84, 'test', '', '500.00', 50, 2, 'assets/uploads/products/627699652b2c9.png', '2022-05-08 00:08:05', 18, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(85, 'test', '', '500.00', 1, 2, 'assets/uploads/products/no-image-available.jpg', '2022-05-08 00:08:26', 18, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(86, 'product test', 'pt1', '3.00', 123, 2, 'assets/uploads/products/no-image-available.jpg', '2022-05-08 00:11:57', 18, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(87, 'test2', '', '500.00', 25, 2, 'assets/uploads/products/no-image-available.jpg', '2022-05-08 00:14:31', 18, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_date` datetime NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `name`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`) VALUES
(1, 'School Supplies', '2022-04-28 13:32:01', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(2, 'Appliances', '2022-04-28 13:32:19', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(3, 'Food', '2022-04-28 13:32:28', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL COMMENT 'user, admin, staff',
  `is_verified` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `profile_path` varchar(255) NOT NULL,
  `facepay_wallet_balance` decimal(8,2) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_date` datetime NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `account_number`, `lastname`, `firstname`, `middlename`, `phone_number`, `email`, `password`, `user_type`, `is_verified`, `is_active`, `profile_path`, `facepay_wallet_balance`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`) VALUES
(18, '', 'ADMIN', 'ADMIN', '', '09208823665', 'eugenioderick23@gmail.com', '$2y$10$IXUnWVWGeGndSa/LNzX2A.7CcCeMlrFbZic656lhhN6uqBwGHaVn2', 'admin', 1, 1, 'assets/uploads/profile/default-user-icon.jpg', '0.00', '2022-04-27 22:43:23', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(19, '', 'STAFF', 'STAFF', '', '09208823665', 'eugenioderick2323@gmail.com', '$2y$10$IXUnWVWGeGndSa/LNzX2A.7CcCeMlrFbZic656lhhN6uqBwGHaVn2', 'staff', 1, 1, 'assets/uploads/profile/default-user-icon.jpg', '0.00', '2022-04-27 22:43:23', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(22, '', 'EUGENIO', 'DERICK', 'BRUL', '09208823665', 'eugenioderick@gmail.com', '$2y$10$720ZdxkBI/OhwG/dHaeOd.9iO1Mb0QLxeXGxHFJqQNRVAOc.06OLy', 'user', 1, 1, 'assets/uploads/profile/default-user-icon.jpg', '709686.00', '2022-05-03 23:28:05', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `views_cart`
-- (See below for the actual view)
--
CREATE TABLE `views_cart` (
`id` int(11)
,`user_id` int(11)
,`product_id` int(11)
,`quantity` int(11)
,`created_date` datetime
,`created_by` int(11)
,`updated_date` datetime
,`updated_by` int(11)
,`name` varchar(255)
,`code` varchar(255)
,`price` decimal(8,2)
,`stock` int(11)
,`category_name` varchar(255)
,`image_path` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `views_cash_in_request`
-- (See below for the actual view)
--
CREATE TABLE `views_cash_in_request` (
`id` int(11)
,`user_id` int(11)
,`reference_no` varchar(255)
,`request_amount` decimal(8,2)
,`cash_amount` decimal(8,2)
,`date_expiration` datetime
,`user_in_charge` int(11)
,`status` varchar(255)
,`created_date` datetime
,`created_by` int(11)
,`updated_date` datetime
,`updated_by` int(11)
,`deleted_date` datetime
,`deleted_by` int(11)
,`fullname` varchar(511)
,`email` varchar(255)
,`facepay_wallet_balance` decimal(8,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `views_notifications`
-- (See below for the actual view)
--
CREATE TABLE `views_notifications` (
`id` int(11)
,`receiver` int(11)
,`user_id` int(11)
,`content` varchar(255)
,`type` varchar(255)
,`source_table` varchar(255)
,`source_id` int(11)
,`read_status` int(11)
,`created_date` datetime
,`created_by` int(11)
,`updated_date` datetime
,`updated_by` int(11)
,`customer_name` varchar(511)
,`customer_profile_path` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `views_order_history`
-- (See below for the actual view)
--
CREATE TABLE `views_order_history` (
`id` int(11)
,`user_id` int(11)
,`order_number` varchar(255)
,`total_quantity` int(11)
,`total_amount` decimal(8,2)
,`date_pickup` date
,`actual_date_pickup` datetime
,`mode_of_payment` varchar(255)
,`status` varchar(255)
,`status_remarks` varchar(255)
,`cash_payment_amount` decimal(8,2)
,`user_in_charge` int(11)
,`created_date` datetime
,`created_by` int(11)
,`updated_date` datetime
,`updated_by` int(11)
,`deleted_date` datetime
,`deleted_by` int(11)
,`fullname` varchar(511)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `views_products`
-- (See below for the actual view)
--
CREATE TABLE `views_products` (
`id` int(11)
,`name` varchar(255)
,`code` varchar(255)
,`price` decimal(8,2)
,`stock` int(11)
,`category_id` int(11)
,`image_path` text
,`created_date` datetime
,`created_by` int(11)
,`updated_date` datetime
,`updated_by` int(11)
,`deleted_date` datetime
,`deleted_by` int(11)
,`category_name` varchar(255)
,`full_name` varchar(511)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `views_users`
-- (See below for the actual view)
--
CREATE TABLE `views_users` (
`id` int(11)
,`lastname` varchar(255)
,`firstname` varchar(255)
,`middlename` varchar(255)
,`phone_number` varchar(255)
,`email` varchar(255)
,`password` varchar(255)
,`user_type` varchar(255)
,`is_verified` int(11)
,`is_active` int(11)
,`profile_path` varchar(255)
,`created_date` datetime
,`created_by` int(11)
,`updated_date` datetime
,`updated_by` int(11)
,`deleted_date` datetime
,`deleted_by` int(11)
,`face1_value` longtext
,`face2_value` longtext
);

-- --------------------------------------------------------

--
-- Table structure for table `wallet_activity`
--

CREATE TABLE `wallet_activity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `debit` decimal(8,2) NOT NULL,
  `credit` decimal(8,2) NOT NULL,
  `balance` decimal(8,2) NOT NULL,
  `source_table` varchar(255) NOT NULL,
  `source_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wallet_activity`
--

INSERT INTO `wallet_activity` (`id`, `user_id`, `reference_no`, `description`, `debit`, `credit`, `balance`, `source_table`, `source_id`, `created_date`, `created_by`) VALUES
(8, 22, '16517533578938', 'Order payment', '0.00', '20414.00', '29586.00', 'order_history', 13, '2022-05-05 20:22:37', 18),
(9, 22, '16517553314968', 'Order payment', '0.00', '19900.00', '9686.00', 'order_history', 14, '2022-05-05 20:55:31', 18),
(10, 22, '16518461457138', 'Cash In', '100000.00', '0.00', '109686.00', 'cash_in_request', 9, '2022-05-07 14:23:42', 18),
(11, 22, '16518461457138', 'Cash In', '100000.00', '0.00', '209686.00', 'cash_in_request', 9, '2022-05-07 16:27:16', 18),
(12, 22, '16518461457138', 'Cash In', '100000.00', '0.00', '309686.00', 'cash_in_request', 9, '2022-05-07 16:27:21', 18),
(13, 22, '16518461457138', 'Cash In', '100000.00', '0.00', '409686.00', 'cash_in_request', 9, '2022-05-07 16:28:15', 18),
(14, 22, '16518461457138', 'Cash In', '100000.00', '0.00', '509686.00', 'cash_in_request', 9, '2022-05-07 16:28:29', 18),
(15, 22, '16518461457138', 'Cash In', '100000.00', '0.00', '609686.00', 'cash_in_request', 9, '2022-05-07 16:28:50', 18),
(16, 22, '16518461457138', 'Cash In', '100000.00', '0.00', '709686.00', 'cash_in_request', 9, '2022-05-07 16:30:39', 18);

-- --------------------------------------------------------

--
-- Structure for view `views_cart`
--
DROP TABLE IF EXISTS `views_cart`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `views_cart`  AS  select `cart`.`id` AS `id`,`cart`.`user_id` AS `user_id`,`cart`.`product_id` AS `product_id`,`cart`.`quantity` AS `quantity`,`cart`.`created_date` AS `created_date`,`cart`.`created_by` AS `created_by`,`cart`.`updated_date` AS `updated_date`,`cart`.`updated_by` AS `updated_by`,`products`.`name` AS `name`,`products`.`code` AS `code`,`products`.`price` AS `price`,`products`.`stock` AS `stock`,`products`.`category_name` AS `category_name`,`products`.`image_path` AS `image_path` from (`cart` left join `views_products` `products` on((`cart`.`product_id` = `products`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `views_cash_in_request`
--
DROP TABLE IF EXISTS `views_cash_in_request`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `views_cash_in_request`  AS  select `cash_in_request`.`id` AS `id`,`cash_in_request`.`user_id` AS `user_id`,`cash_in_request`.`reference_no` AS `reference_no`,`cash_in_request`.`request_amount` AS `request_amount`,`cash_in_request`.`cash_amount` AS `cash_amount`,`cash_in_request`.`date_expiration` AS `date_expiration`,`cash_in_request`.`user_in_charge` AS `user_in_charge`,`cash_in_request`.`status` AS `status`,`cash_in_request`.`created_date` AS `created_date`,`cash_in_request`.`created_by` AS `created_by`,`cash_in_request`.`updated_date` AS `updated_date`,`cash_in_request`.`updated_by` AS `updated_by`,`cash_in_request`.`deleted_date` AS `deleted_date`,`cash_in_request`.`deleted_by` AS `deleted_by`,concat(`users`.`firstname`,' ',`users`.`lastname`) AS `fullname`,`users`.`email` AS `email`,`users`.`facepay_wallet_balance` AS `facepay_wallet_balance` from (`cash_in_request` left join `users` on((`cash_in_request`.`user_id` = `users`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `views_notifications`
--
DROP TABLE IF EXISTS `views_notifications`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `views_notifications`  AS  select `notifications`.`id` AS `id`,`notifications`.`receiver` AS `receiver`,`notifications`.`user_id` AS `user_id`,`notifications`.`content` AS `content`,`notifications`.`type` AS `type`,`notifications`.`source_table` AS `source_table`,`notifications`.`source_id` AS `source_id`,`notifications`.`read_status` AS `read_status`,`notifications`.`created_date` AS `created_date`,`notifications`.`created_by` AS `created_by`,`notifications`.`updated_date` AS `updated_date`,`notifications`.`updated_by` AS `updated_by`,concat(`users`.`firstname`,' ',`users`.`lastname`) AS `customer_name`,`users`.`profile_path` AS `customer_profile_path` from (`notifications` left join `users` on((`notifications`.`user_id` = `users`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `views_order_history`
--
DROP TABLE IF EXISTS `views_order_history`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `views_order_history`  AS  select `order_history`.`id` AS `id`,`order_history`.`user_id` AS `user_id`,`order_history`.`order_number` AS `order_number`,`order_history`.`total_quantity` AS `total_quantity`,`order_history`.`total_amount` AS `total_amount`,`order_history`.`date_pickup` AS `date_pickup`,`order_history`.`actual_date_pickup` AS `actual_date_pickup`,`order_history`.`mode_of_payment` AS `mode_of_payment`,`order_history`.`status` AS `status`,`order_history`.`status_remarks` AS `status_remarks`,`order_history`.`cash_payment_amount` AS `cash_payment_amount`,`order_history`.`user_in_charge` AS `user_in_charge`,`order_history`.`created_date` AS `created_date`,`order_history`.`created_by` AS `created_by`,`order_history`.`updated_date` AS `updated_date`,`order_history`.`updated_by` AS `updated_by`,`order_history`.`deleted_date` AS `deleted_date`,`order_history`.`deleted_by` AS `deleted_by`,concat(`users`.`firstname`,' ',`users`.`lastname`) AS `fullname` from (`order_history` left join `users` on((`users`.`id` = `order_history`.`user_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `views_products`
--
DROP TABLE IF EXISTS `views_products`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `views_products`  AS  select `products`.`id` AS `id`,`products`.`name` AS `name`,`products`.`code` AS `code`,`products`.`price` AS `price`,`products`.`stock` AS `stock`,`products`.`category_id` AS `category_id`,`products`.`image_path` AS `image_path`,`products`.`created_date` AS `created_date`,`products`.`created_by` AS `created_by`,`products`.`updated_date` AS `updated_date`,`products`.`updated_by` AS `updated_by`,`products`.`deleted_date` AS `deleted_date`,`products`.`deleted_by` AS `deleted_by`,`product_category`.`name` AS `category_name`,concat(`users`.`firstname`,' ',`users`.`lastname`) AS `full_name` from ((`products` left join `product_category` on((`products`.`category_id` = `product_category`.`id`))) left join `users` on((`products`.`created_by` = `users`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `views_users`
--
DROP TABLE IF EXISTS `views_users`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `views_users`  AS  select `users`.`id` AS `id`,`users`.`lastname` AS `lastname`,`users`.`firstname` AS `firstname`,`users`.`middlename` AS `middlename`,`users`.`phone_number` AS `phone_number`,`users`.`email` AS `email`,`users`.`password` AS `password`,`users`.`user_type` AS `user_type`,`users`.`is_verified` AS `is_verified`,`users`.`is_active` AS `is_active`,`users`.`profile_path` AS `profile_path`,`users`.`created_date` AS `created_date`,`users`.`created_by` AS `created_by`,`users`.`updated_date` AS `updated_date`,`users`.`updated_by` AS `updated_by`,`users`.`deleted_date` AS `deleted_date`,`users`.`deleted_by` AS `deleted_by`,`faces`.`face1_value` AS `face1_value`,`faces`.`face2_value` AS `face2_value` from (`users` left join `faces` on((`users`.`id` = `faces`.`user_id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_in_request`
--
ALTER TABLE `cash_in_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faces`
--
ALTER TABLE `faces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_history_products`
--
ALTER TABLE `order_history_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet_activity`
--
ALTER TABLE `wallet_activity`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_in_request`
--
ALTER TABLE `cash_in_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `faces`
--
ALTER TABLE `faces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_history_products`
--
ALTER TABLE `order_history_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `wallet_activity`
--
ALTER TABLE `wallet_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `faces`
--
ALTER TABLE `faces`
  ADD CONSTRAINT `faces_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
