DROP TABLE IF EXISTS kcp_admin;

CREATE TABLE `kcp_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(50) NOT NULL DEFAULT '',
  `password` char(100) NOT NULL DEFAULT '',
  `rem_password` varchar(512) NOT NULL,
  `account_type` int(11) NOT NULL COMMENT '0=personal,1=professional,2=Event Manager,3=sponser,4=provider',
  `fname` varchar(222) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(222) NOT NULL,
  `sex` char(30) NOT NULL,
  `phone` char(100) NOT NULL,
  `country_code` int(11) NOT NULL,
  `country_id` int(100) NOT NULL,
  `province` varchar(512) NOT NULL,
  `county` int(11) NOT NULL,
  `city` varchar(1024) NOT NULL,
  `seller_type` int(1) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `admin_type` int(1) NOT NULL,
  `recover_pass` varchar(100) NOT NULL,
  `recover_time` datetime NOT NULL,
  `show_weekly_recurring_events` int(1) NOT NULL,
  `event_show_number` int(7) NOT NULL,
  `post_date` int(11) NOT NULL,
  `activate_status` int(11) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COMMENT='Admin information';

INSERT INTO kcp_admin VALUES("1","administrator","21232f297a57a5a743894a0e4a801fc3","","2","Marcel","Lavabre","ml@kpasapp.com","","","0","0","","0","","0","1","1","admin","0000-00-00 00:00:00","1","15","0","1");
INSERT INTO kcp_admin VALUES("2","amit","e10adc3949ba59abbe56e057f20f883e","123456","2","Amit","Banerjee","amit.unified@gmail.com","M","9876543210","52","138","1","2","27","0","1","0","vlncaws8","2013-06-10 18:50:47","0","0","0","1");
INSERT INTO kcp_admin VALUES("18","amit_bessel@yahoo.co.in","a44c93bbaff030311a179505c6961f22","4o83zvw7","0","Amit","Banerjee","amit_bessel@yahoo.co.in","","","0","0","","0","","0","0","0","","0000-00-00 00:00:00","0","0","1376025361","1");
INSERT INTO kcp_admin VALUES("17","besus.amit@gmail.com","34c3de713a1e9ec684a8fa3738a0255d","4mg9eqg2","0","Amit","Kumar","besus.amit@gmail.com","","","0","0","","0","","0","0","0","","0000-00-00 00:00:00","0","0","1376024973","1");



DROP TABLE IF EXISTS kcp_category_by_event;

CREATE TABLE `kcp_category_by_event` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=947 DEFAULT CHARSET=latin1;

INSERT INTO kcp_category_by_event VALUES("433","10","6");
INSERT INTO kcp_category_by_event VALUES("584","21","3");
INSERT INTO kcp_category_by_event VALUES("585","21","29");
INSERT INTO kcp_category_by_event VALUES("586","21","30");
INSERT INTO kcp_category_by_event VALUES("587","21","37");
INSERT INTO kcp_category_by_event VALUES("608","8","4");
INSERT INTO kcp_category_by_event VALUES("609","8","38");
INSERT INTO kcp_category_by_event VALUES("610","8","39");
INSERT INTO kcp_category_by_event VALUES("611","8","40");
INSERT INTO kcp_category_by_event VALUES("612","8","41");
INSERT INTO kcp_category_by_event VALUES("613","8","42");
INSERT INTO kcp_category_by_event VALUES("614","8","13");
INSERT INTO kcp_category_by_event VALUES("615","8","68");
INSERT INTO kcp_category_by_event VALUES("616","8","70");
INSERT INTO kcp_category_by_event VALUES("617","8","72");
INSERT INTO kcp_category_by_event VALUES("650","2","10");
INSERT INTO kcp_category_by_event VALUES("651","2","11");
INSERT INTO kcp_category_by_event VALUES("652","2","12");
INSERT INTO kcp_category_by_event VALUES("653","23","6");
INSERT INTO kcp_category_by_event VALUES("677","1","6");
INSERT INTO kcp_category_by_event VALUES("678","1","4");
INSERT INTO kcp_category_by_event VALUES("679","1","39");
INSERT INTO kcp_category_by_event VALUES("680","1","42");
INSERT INTO kcp_category_by_event VALUES("681","1","12");
INSERT INTO kcp_category_by_event VALUES("685","12","5");
INSERT INTO kcp_category_by_event VALUES("687","37","6");
INSERT INTO kcp_category_by_event VALUES("700","16","11");
INSERT INTO kcp_category_by_event VALUES("701","16","7");
INSERT INTO kcp_category_by_event VALUES("702","41","3");
INSERT INTO kcp_category_by_event VALUES("704","38","6");
INSERT INTO kcp_category_by_event VALUES("705","18","3");
INSERT INTO kcp_category_by_event VALUES("718","35","7");
INSERT INTO kcp_category_by_event VALUES("719","44","7");
INSERT INTO kcp_category_by_event VALUES("800","46","6");
INSERT INTO kcp_category_by_event VALUES("825","24","6");
INSERT INTO kcp_category_by_event VALUES("826","48","10");
INSERT INTO kcp_category_by_event VALUES("901","47","10");
INSERT INTO kcp_category_by_event VALUES("903","50","10");
INSERT INTO kcp_category_by_event VALUES("904","50","3");
INSERT INTO kcp_category_by_event VALUES("905","50","29");
INSERT INTO kcp_category_by_event VALUES("906","50","30");
INSERT INTO kcp_category_by_event VALUES("907","50","31");
INSERT INTO kcp_category_by_event VALUES("908","50","5");
INSERT INTO kcp_category_by_event VALUES("909","50","43");
INSERT INTO kcp_category_by_event VALUES("910","50","44");
INSERT INTO kcp_category_by_event VALUES("917","45","10");
INSERT INTO kcp_category_by_event VALUES("945","55","10");
INSERT INTO kcp_category_by_event VALUES("946","55","6");



DROP TABLE IF EXISTS kcp_category_by_performer;

CREATE TABLE `kcp_category_by_performer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `performer_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO kcp_category_by_performer VALUES("3","1","10","0");



DROP TABLE IF EXISTS kcp_category_by_sub_event;

CREATE TABLE `kcp_category_by_sub_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `sub_event_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=latin1;

INSERT INTO kcp_category_by_sub_event VALUES("22","15","2","6");
INSERT INTO kcp_category_by_sub_event VALUES("72","15","3","10");
INSERT INTO kcp_category_by_sub_event VALUES("73","15","3","6");
INSERT INTO kcp_category_by_sub_event VALUES("74","15","3","11");
INSERT INTO kcp_category_by_sub_event VALUES("75","15","3","5");
INSERT INTO kcp_category_by_sub_event VALUES("76","15","3","43");
INSERT INTO kcp_category_by_sub_event VALUES("107","15","4","10");
INSERT INTO kcp_category_by_sub_event VALUES("108","15","4","6");
INSERT INTO kcp_category_by_sub_event VALUES("109","15","4","11");
INSERT INTO kcp_category_by_sub_event VALUES("110","15","4","43");
INSERT INTO kcp_category_by_sub_event VALUES("111","15","4","44");
INSERT INTO kcp_category_by_sub_event VALUES("112","15","4","45");
INSERT INTO kcp_category_by_sub_event VALUES("142","25","9","10");
INSERT INTO kcp_category_by_sub_event VALUES("148","25","8","10");
INSERT INTO kcp_category_by_sub_event VALUES("149","25","8","3");
INSERT INTO kcp_category_by_sub_event VALUES("150","25","8","29");
INSERT INTO kcp_category_by_sub_event VALUES("151","25","8","30");



DROP TABLE IF EXISTS kcp_category_by_venue;

CREATE TABLE `kcp_category_by_venue` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `venue_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=380 DEFAULT CHARSET=latin1;

INSERT INTO kcp_category_by_venue VALUES("213","55","12");
INSERT INTO kcp_category_by_venue VALUES("214","55","7");
INSERT INTO kcp_category_by_venue VALUES("225","57","7");
INSERT INTO kcp_category_by_venue VALUES("226","57","51");
INSERT INTO kcp_category_by_venue VALUES("227","59","5");
INSERT INTO kcp_category_by_venue VALUES("228","59","4");
INSERT INTO kcp_category_by_venue VALUES("229","59","38");
INSERT INTO kcp_category_by_venue VALUES("231","61","10");
INSERT INTO kcp_category_by_venue VALUES("232","3","5");
INSERT INTO kcp_category_by_venue VALUES("233","3","8");
INSERT INTO kcp_category_by_venue VALUES("234","3","4");
INSERT INTO kcp_category_by_venue VALUES("235","3","7");
INSERT INTO kcp_category_by_venue VALUES("238","62","7");
INSERT INTO kcp_category_by_venue VALUES("239","62","52");
INSERT INTO kcp_category_by_venue VALUES("240","6","10");
INSERT INTO kcp_category_by_venue VALUES("361","47","3");
INSERT INTO kcp_category_by_venue VALUES("362","47","29");
INSERT INTO kcp_category_by_venue VALUES("363","47","30");
INSERT INTO kcp_category_by_venue VALUES("364","47","14");
INSERT INTO kcp_category_by_venue VALUES("365","47","74");
INSERT INTO kcp_category_by_venue VALUES("366","47","75");
INSERT INTO kcp_category_by_venue VALUES("373","52","3");
INSERT INTO kcp_category_by_venue VALUES("374","52","29");
INSERT INTO kcp_category_by_venue VALUES("375","52","30");
INSERT INTO kcp_category_by_venue VALUES("376","52","14");
INSERT INTO kcp_category_by_venue VALUES("377","52","74");
INSERT INTO kcp_category_by_venue VALUES("378","52","75");
INSERT INTO kcp_category_by_venue VALUES("379","20","10");



DROP TABLE IF EXISTS kcp_city;

CREATE TABLE `kcp_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `county_id` int(11) NOT NULL,
  `city_name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

INSERT INTO kcp_city VALUES("9","1","Ciudad Constitución");
INSERT INTO kcp_city VALUES("10","1","Ciudad Insurgentes");
INSERT INTO kcp_city VALUES("11","1","Puerto San Carlos");
INSERT INTO kcp_city VALUES("12","1","Puerto Adolfo López Mateos");
INSERT INTO kcp_city VALUES("13","1","Villa Ignacio Zaragoza");
INSERT INTO kcp_city VALUES("14","1","Villa Morelos");
INSERT INTO kcp_city VALUES("15","1","Benito Juárez");
INSERT INTO kcp_city VALUES("16","1","Las Barrancas");
INSERT INTO kcp_city VALUES("17","1","San Miguel de Comondú");
INSERT INTO kcp_city VALUES("18","1","Puerto Cortés");
INSERT INTO kcp_city VALUES("19","1","San José de Comondú");
INSERT INTO kcp_city VALUES("20","2","La Paz");
INSERT INTO kcp_city VALUES("21","2","Todos Santos");
INSERT INTO kcp_city VALUES("22","2","El Centenario");
INSERT INTO kcp_city VALUES("23","2","Chametla");
INSERT INTO kcp_city VALUES("24","2","El Pescadero");
INSERT INTO kcp_city VALUES("25","2","El Triunfo");
INSERT INTO kcp_city VALUES("26","2","La Ventana");
INSERT INTO kcp_city VALUES("27","2","Melitón Albáñez Domínguez");
INSERT INTO kcp_city VALUES("28","2","Los Barriles");
INSERT INTO kcp_city VALUES("29","2","San Antonio");
INSERT INTO kcp_city VALUES("30","2","Puerto Chale");
INSERT INTO kcp_city VALUES("31","3","Ensenada Blanca");
INSERT INTO kcp_city VALUES("32","3","Ligüí");
INSERT INTO kcp_city VALUES("33","3","Loreto");
INSERT INTO kcp_city VALUES("34","3","Puerto Agua Verde");
INSERT INTO kcp_city VALUES("35","3","San Javier");
INSERT INTO kcp_city VALUES("36","4","San Jose del Cabo");
INSERT INTO kcp_city VALUES("37","4","Cabo San Lucas");
INSERT INTO kcp_city VALUES("38","4","La Ribera");
INSERT INTO kcp_city VALUES("39","4","Miraflores. ");
INSERT INTO kcp_city VALUES("40","4","Santiago.");
INSERT INTO kcp_city VALUES("41","5","Guerrero Negro");
INSERT INTO kcp_city VALUES("42","5","Santa Rosalía");
INSERT INTO kcp_city VALUES("43","5","Villa Alberto Andrés Alvarado Arámburo");
INSERT INTO kcp_city VALUES("44","5","Mulegé");
INSERT INTO kcp_city VALUES("45","5","Bahía Tortugas");
INSERT INTO kcp_city VALUES("46","5","San Francisco");
INSERT INTO kcp_city VALUES("47","5","Las Margaritas");
INSERT INTO kcp_city VALUES("48","5","Bahía Asunción");
INSERT INTO kcp_city VALUES("49","5","El Silencio");
INSERT INTO kcp_city VALUES("50","5","Gustavo Díaz Ordaz");
INSERT INTO kcp_city VALUES("51","5","Estero de la Bocana");
INSERT INTO kcp_city VALUES("52","5","Punta Abreojos");
INSERT INTO kcp_city VALUES("53","5","San Ignacio");
INSERT INTO kcp_city VALUES("54","1","Los Mártires");
INSERT INTO kcp_city VALUES("55","5","San Bruno");
INSERT INTO kcp_city VALUES("56","1","Ejido San Lucas");



DROP TABLE IF EXISTS kcp_countries;

CREATE TABLE `kcp_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso` char(2) NOT NULL,
  `printable_name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=240 DEFAULT CHARSET=latin1;

INSERT INTO kcp_countries VALUES("1","AF","AFGHANISTAN","Afghanistan","AFG","4","93");
INSERT INTO kcp_countries VALUES("2","AL","ALBANIA","Albania","ALB","8","355");
INSERT INTO kcp_countries VALUES("3","DZ","ALGERIA","Algeria","DZA","12","213");
INSERT INTO kcp_countries VALUES("4","AS","AMERICAN SAMOA","American Samoa","ASM","16","1684");
INSERT INTO kcp_countries VALUES("5","AD","ANDORRA","Andorra","AND","20","376");
INSERT INTO kcp_countries VALUES("6","AO","ANGOLA","Angola","AGO","24","244");
INSERT INTO kcp_countries VALUES("7","AI","ANGUILLA","Anguilla","AIA","660","1264");
INSERT INTO kcp_countries VALUES("8","AQ","ANTARCTICA","Antarctica","","","0");
INSERT INTO kcp_countries VALUES("9","AG","ANTIGUA AND BARBUDA","Antigua and Barbuda","ATG","28","1268");
INSERT INTO kcp_countries VALUES("10","AR","ARGENTINA","Argentina","ARG","32","54");
INSERT INTO kcp_countries VALUES("11","AM","ARMENIA","Armenia","ARM","51","374");
INSERT INTO kcp_countries VALUES("12","AW","ARUBA","Aruba","ABW","533","297");
INSERT INTO kcp_countries VALUES("13","AU","AUSTRALIA","Australia","AUS","36","61");
INSERT INTO kcp_countries VALUES("14","AT","AUSTRIA","Austria","AUT","40","43");
INSERT INTO kcp_countries VALUES("15","AZ","AZERBAIJAN","Azerbaijan","AZE","31","994");
INSERT INTO kcp_countries VALUES("16","BS","BAHAMAS","Bahamas","BHS","44","1242");
INSERT INTO kcp_countries VALUES("17","BH","BAHRAIN","Bahrain","BHR","48","973");
INSERT INTO kcp_countries VALUES("18","BD","BANGLADESH","Bangladesh","BGD","50","880");
INSERT INTO kcp_countries VALUES("19","BB","BARBADOS","Barbados","BRB","52","1246");
INSERT INTO kcp_countries VALUES("20","BY","BELARUS","Belarus","BLR","112","375");
INSERT INTO kcp_countries VALUES("21","BE","BELGIUM","Belgium","BEL","56","32");
INSERT INTO kcp_countries VALUES("22","BZ","BELIZE","Belize","BLZ","84","501");
INSERT INTO kcp_countries VALUES("23","BJ","BENIN","Benin","BEN","204","229");
INSERT INTO kcp_countries VALUES("24","BM","BERMUDA","Bermuda","BMU","60","1441");
INSERT INTO kcp_countries VALUES("25","BT","BHUTAN","Bhutan","BTN","64","975");
INSERT INTO kcp_countries VALUES("26","BO","BOLIVIA","Bolivia","BOL","68","591");
INSERT INTO kcp_countries VALUES("27","BA","BOSNIA AND HERZEGOVINA","Bosnia and Herzegovina","BIH","70","387");
INSERT INTO kcp_countries VALUES("28","BW","BOTSWANA","Botswana","BWA","72","267");
INSERT INTO kcp_countries VALUES("29","BV","BOUVET ISLAND","Bouvet Island","","","0");
INSERT INTO kcp_countries VALUES("30","BR","BRAZIL","Brazil","BRA","76","55");
INSERT INTO kcp_countries VALUES("31","IO","BRITISH INDIAN OCEAN TERRITORY","British Indian Ocean Territory","","","246");
INSERT INTO kcp_countries VALUES("32","BN","BRUNEI DARUSSALAM","Brunei Darussalam","BRN","96","673");
INSERT INTO kcp_countries VALUES("33","BG","BULGARIA","Bulgaria","BGR","100","359");
INSERT INTO kcp_countries VALUES("34","BF","BURKINA FASO","Burkina Faso","BFA","854","226");
INSERT INTO kcp_countries VALUES("35","BI","BURUNDI","Burundi","BDI","108","257");
INSERT INTO kcp_countries VALUES("36","KH","CAMBODIA","Cambodia","KHM","116","855");
INSERT INTO kcp_countries VALUES("37","CM","CAMEROON","Cameroon","CMR","120","237");
INSERT INTO kcp_countries VALUES("38","CA","CANADA","Canada","CAN","124","1");
INSERT INTO kcp_countries VALUES("39","CV","CAPE VERDE","Cape Verde","CPV","132","238");
INSERT INTO kcp_countries VALUES("40","KY","CAYMAN ISLANDS","Cayman Islands","CYM","136","1345");
INSERT INTO kcp_countries VALUES("41","CF","CENTRAL AFRICAN REPUBLIC","Central African Republic","CAF","140","236");
INSERT INTO kcp_countries VALUES("42","TD","CHAD","Chad","TCD","148","235");
INSERT INTO kcp_countries VALUES("43","CL","CHILE","Chile","CHL","152","56");
INSERT INTO kcp_countries VALUES("44","CN","CHINA","China","CHN","156","86");
INSERT INTO kcp_countries VALUES("45","CX","CHRISTMAS ISLAND","Christmas Island","","","61");
INSERT INTO kcp_countries VALUES("46","CC","COCOS (KEELING) ISLANDS","Cocos (Keeling) Islands","","","672");
INSERT INTO kcp_countries VALUES("47","CO","COLOMBIA","Colombia","COL","170","57");
INSERT INTO kcp_countries VALUES("48","KM","COMOROS","Comoros","COM","174","269");
INSERT INTO kcp_countries VALUES("49","CG","CONGO","Congo","COG","178","242");
INSERT INTO kcp_countries VALUES("50","CD","CONGO, THE DEMOCRATIC REPUBLIC OF THE","Congo, the Democratic Republic of the","COD","180","242");
INSERT INTO kcp_countries VALUES("51","CK","COOK ISLANDS","Cook Islands","COK","184","682");
INSERT INTO kcp_countries VALUES("52","CR","COSTA RICA","Costa Rica","CRI","188","506");
INSERT INTO kcp_countries VALUES("53","CI","COTE D\'IVOIRE","Cote D\'Ivoire","CIV","384","225");
INSERT INTO kcp_countries VALUES("54","HR","CROATIA","Croatia","HRV","191","385");
INSERT INTO kcp_countries VALUES("55","CU","CUBA","Cuba","CUB","192","53");
INSERT INTO kcp_countries VALUES("56","CY","CYPRUS","Cyprus","CYP","196","357");
INSERT INTO kcp_countries VALUES("57","CZ","CZECH REPUBLIC","Czech Republic","CZE","203","420");
INSERT INTO kcp_countries VALUES("58","DK","DENMARK","Denmark","DNK","208","45");
INSERT INTO kcp_countries VALUES("59","DJ","DJIBOUTI","Djibouti","DJI","262","253");
INSERT INTO kcp_countries VALUES("60","DM","DOMINICA","Dominica","DMA","212","1767");
INSERT INTO kcp_countries VALUES("61","DO","DOMINICAN REPUBLIC","Dominican Republic","DOM","214","1809");
INSERT INTO kcp_countries VALUES("62","EC","ECUADOR","Ecuador","ECU","218","593");
INSERT INTO kcp_countries VALUES("63","EG","EGYPT","Egypt","EGY","818","20");
INSERT INTO kcp_countries VALUES("64","SV","EL SALVADOR","El Salvador","SLV","222","503");
INSERT INTO kcp_countries VALUES("65","GQ","EQUATORIAL GUINEA","Equatorial Guinea","GNQ","226","240");
INSERT INTO kcp_countries VALUES("66","ER","ERITREA","Eritrea","ERI","232","291");
INSERT INTO kcp_countries VALUES("67","EE","ESTONIA","Estonia","EST","233","372");
INSERT INTO kcp_countries VALUES("68","ET","ETHIOPIA","Ethiopia","ETH","231","251");
INSERT INTO kcp_countries VALUES("69","FK","FALKLAND ISLANDS (MALVINAS)","Falkland Islands (Malvinas)","FLK","238","500");
INSERT INTO kcp_countries VALUES("70","FO","FAROE ISLANDS","Faroe Islands","FRO","234","298");
INSERT INTO kcp_countries VALUES("71","FJ","FIJI","Fiji","FJI","242","679");
INSERT INTO kcp_countries VALUES("72","FI","FINLAND","Finland","FIN","246","358");
INSERT INTO kcp_countries VALUES("73","FR","FRANCE","France","FRA","250","33");
INSERT INTO kcp_countries VALUES("74","GF","FRENCH GUIANA","French Guiana","GUF","254","594");
INSERT INTO kcp_countries VALUES("75","PF","FRENCH POLYNESIA","French Polynesia","PYF","258","689");
INSERT INTO kcp_countries VALUES("76","TF","FRENCH SOUTHERN TERRITORIES","French Southern Territories","","","0");
INSERT INTO kcp_countries VALUES("77","GA","GABON","Gabon","GAB","266","241");
INSERT INTO kcp_countries VALUES("78","GM","GAMBIA","Gambia","GMB","270","220");
INSERT INTO kcp_countries VALUES("79","GE","GEORGIA","Georgia","GEO","268","995");
INSERT INTO kcp_countries VALUES("80","DE","GERMANY","Germany","DEU","276","49");
INSERT INTO kcp_countries VALUES("81","GH","GHANA","Ghana","GHA","288","233");
INSERT INTO kcp_countries VALUES("82","GI","GIBRALTAR","Gibraltar","GIB","292","350");
INSERT INTO kcp_countries VALUES("83","GR","GREECE","Greece","GRC","300","30");
INSERT INTO kcp_countries VALUES("84","GL","GREENLAND","Greenland","GRL","304","299");
INSERT INTO kcp_countries VALUES("85","GD","GRENADA","Grenada","GRD","308","1473");
INSERT INTO kcp_countries VALUES("86","GP","GUADELOUPE","Guadeloupe","GLP","312","590");
INSERT INTO kcp_countries VALUES("87","GU","GUAM","Guam","GUM","316","1671");
INSERT INTO kcp_countries VALUES("88","GT","GUATEMALA","Guatemala","GTM","320","502");
INSERT INTO kcp_countries VALUES("89","GN","GUINEA","Guinea","GIN","324","224");
INSERT INTO kcp_countries VALUES("90","GW","GUINEA-BISSAU","Guinea-Bissau","GNB","624","245");
INSERT INTO kcp_countries VALUES("91","GY","GUYANA","Guyana","GUY","328","592");
INSERT INTO kcp_countries VALUES("92","HT","HAITI","Haiti","HTI","332","509");
INSERT INTO kcp_countries VALUES("93","HM","HEARD ISLAND AND MCDONALD ISLANDS","Heard Island and Mcdonald Islands","","","0");
INSERT INTO kcp_countries VALUES("94","VA","HOLY SEE (VATICAN CITY STATE)","Holy See (Vatican City State)","VAT","336","39");
INSERT INTO kcp_countries VALUES("95","HN","HONDURAS","Honduras","HND","340","504");
INSERT INTO kcp_countries VALUES("96","HK","HONG KONG","Hong Kong","HKG","344","852");
INSERT INTO kcp_countries VALUES("97","HU","HUNGARY","Hungary","HUN","348","36");
INSERT INTO kcp_countries VALUES("98","IS","ICELAND","Iceland","ISL","352","354");
INSERT INTO kcp_countries VALUES("99","IN","INDIA","India","IND","356","91");
INSERT INTO kcp_countries VALUES("100","ID","INDONESIA","Indonesia","IDN","360","62");
INSERT INTO kcp_countries VALUES("101","IR","IRAN, ISLAMIC REPUBLIC OF","Iran, Islamic Republic of","IRN","364","98");
INSERT INTO kcp_countries VALUES("102","IQ","IRAQ","Iraq","IRQ","368","964");
INSERT INTO kcp_countries VALUES("103","IE","IRELAND","Ireland","IRL","372","353");
INSERT INTO kcp_countries VALUES("104","IL","ISRAEL","Israel","ISR","376","972");
INSERT INTO kcp_countries VALUES("105","IT","ITALY","Italy","ITA","380","39");
INSERT INTO kcp_countries VALUES("106","JM","JAMAICA","Jamaica","JAM","388","1876");
INSERT INTO kcp_countries VALUES("107","JP","JAPAN","Japan","JPN","392","81");
INSERT INTO kcp_countries VALUES("108","JO","JORDAN","Jordan","JOR","400","962");
INSERT INTO kcp_countries VALUES("109","KZ","KAZAKHSTAN","Kazakhstan","KAZ","398","7");
INSERT INTO kcp_countries VALUES("110","KE","KENYA","Kenya","KEN","404","254");
INSERT INTO kcp_countries VALUES("111","KI","KIRIBATI","Kiribati","KIR","296","686");
INSERT INTO kcp_countries VALUES("112","KP","KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF","Korea, Democratic People\'s Republic of","PRK","408","850");
INSERT INTO kcp_countries VALUES("113","KR","KOREA, REPUBLIC OF","Korea, Republic of","KOR","410","82");
INSERT INTO kcp_countries VALUES("114","KW","KUWAIT","Kuwait","KWT","414","965");
INSERT INTO kcp_countries VALUES("115","KG","KYRGYZSTAN","Kyrgyzstan","KGZ","417","996");
INSERT INTO kcp_countries VALUES("116","LA","LAO PEOPLE\'S DEMOCRATIC REPUBLIC","Lao People\'s Democratic Republic","LAO","418","856");
INSERT INTO kcp_countries VALUES("117","LV","LATVIA","Latvia","LVA","428","371");
INSERT INTO kcp_countries VALUES("118","LB","LEBANON","Lebanon","LBN","422","961");
INSERT INTO kcp_countries VALUES("119","LS","LESOTHO","Lesotho","LSO","426","266");
INSERT INTO kcp_countries VALUES("120","LR","LIBERIA","Liberia","LBR","430","231");
INSERT INTO kcp_countries VALUES("121","LY","LIBYAN ARAB JAMAHIRIYA","Libyan Arab Jamahiriya","LBY","434","218");
INSERT INTO kcp_countries VALUES("122","LI","LIECHTENSTEIN","Liechtenstein","LIE","438","423");
INSERT INTO kcp_countries VALUES("123","LT","LITHUANIA","Lithuania","LTU","440","370");
INSERT INTO kcp_countries VALUES("124","LU","LUXEMBOURG","Luxembourg","LUX","442","352");
INSERT INTO kcp_countries VALUES("125","MO","MACAO","Macao","MAC","446","853");
INSERT INTO kcp_countries VALUES("126","MK","MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF","Macedonia, the Former Yugoslav Republic of","MKD","807","389");
INSERT INTO kcp_countries VALUES("127","MG","MADAGASCAR","Madagascar","MDG","450","261");
INSERT INTO kcp_countries VALUES("128","MW","MALAWI","Malawi","MWI","454","265");
INSERT INTO kcp_countries VALUES("129","MY","MALAYSIA","Malaysia","MYS","458","60");
INSERT INTO kcp_countries VALUES("130","MV","MALDIVES","Maldives","MDV","462","960");
INSERT INTO kcp_countries VALUES("131","ML","MALI","Mali","MLI","466","223");
INSERT INTO kcp_countries VALUES("132","MT","MALTA","Malta","MLT","470","356");
INSERT INTO kcp_countries VALUES("133","MH","MARSHALL ISLANDS","Marshall Islands","MHL","584","692");
INSERT INTO kcp_countries VALUES("134","MQ","MARTINIQUE","Martinique","MTQ","474","596");
INSERT INTO kcp_countries VALUES("135","MR","MAURITANIA","Mauritania","MRT","478","222");
INSERT INTO kcp_countries VALUES("136","MU","MAURITIUS","Mauritius","MUS","480","230");
INSERT INTO kcp_countries VALUES("137","YT","MAYOTTE","Mayotte","","","269");
INSERT INTO kcp_countries VALUES("138","MX","MEXICO","Mexico","MEX","484","52");
INSERT INTO kcp_countries VALUES("139","FM","MICRONESIA, FEDERATED STATES OF","Micronesia, Federated States of","FSM","583","691");
INSERT INTO kcp_countries VALUES("140","MD","MOLDOVA, REPUBLIC OF","Moldova, Republic of","MDA","498","373");
INSERT INTO kcp_countries VALUES("141","MC","MONACO","Monaco","MCO","492","377");
INSERT INTO kcp_countries VALUES("142","MN","MONGOLIA","Mongolia","MNG","496","976");
INSERT INTO kcp_countries VALUES("143","MS","MONTSERRAT","Montserrat","MSR","500","1664");
INSERT INTO kcp_countries VALUES("144","MA","MOROCCO","Morocco","MAR","504","212");
INSERT INTO kcp_countries VALUES("145","MZ","MOZAMBIQUE","Mozambique","MOZ","508","258");
INSERT INTO kcp_countries VALUES("146","MM","MYANMAR","Myanmar","MMR","104","95");
INSERT INTO kcp_countries VALUES("147","NA","NAMIBIA","Namibia","NAM","516","264");
INSERT INTO kcp_countries VALUES("148","NR","NAURU","Nauru","NRU","520","674");
INSERT INTO kcp_countries VALUES("149","NP","NEPAL","Nepal","NPL","524","977");
INSERT INTO kcp_countries VALUES("150","NL","NETHERLANDS","Netherlands","NLD","528","31");
INSERT INTO kcp_countries VALUES("151","AN","NETHERLANDS ANTILLES","Netherlands Antilles","ANT","530","599");
INSERT INTO kcp_countries VALUES("152","NC","NEW CALEDONIA","New Caledonia","NCL","540","687");
INSERT INTO kcp_countries VALUES("153","NZ","NEW ZEALAND","New Zealand","NZL","554","64");
INSERT INTO kcp_countries VALUES("154","NI","NICARAGUA","Nicaragua","NIC","558","505");
INSERT INTO kcp_countries VALUES("155","NE","NIGER","Niger","NER","562","227");
INSERT INTO kcp_countries VALUES("156","NG","NIGERIA","Nigeria","NGA","566","234");
INSERT INTO kcp_countries VALUES("157","NU","NIUE","Niue","NIU","570","683");
INSERT INTO kcp_countries VALUES("158","NF","NORFOLK ISLAND","Norfolk Island","NFK","574","672");
INSERT INTO kcp_countries VALUES("159","MP","NORTHERN MARIANA ISLANDS","Northern Mariana Islands","MNP","580","1670");
INSERT INTO kcp_countries VALUES("160","NO","NORWAY","Norway","NOR","578","47");
INSERT INTO kcp_countries VALUES("161","OM","OMAN","Oman","OMN","512","968");
INSERT INTO kcp_countries VALUES("162","PK","PAKISTAN","Pakistan","PAK","586","92");
INSERT INTO kcp_countries VALUES("163","PW","PALAU","Palau","PLW","585","680");
INSERT INTO kcp_countries VALUES("164","PS","PALESTINIAN TERRITORY, OCCUPIED","Palestinian Territory, Occupied","","","970");
INSERT INTO kcp_countries VALUES("165","PA","PANAMA","Panama","PAN","591","507");
INSERT INTO kcp_countries VALUES("166","PG","PAPUA NEW GUINEA","Papua New Guinea","PNG","598","675");
INSERT INTO kcp_countries VALUES("167","PY","PARAGUAY","Paraguay","PRY","600","595");
INSERT INTO kcp_countries VALUES("168","PE","PERU","Peru","PER","604","51");
INSERT INTO kcp_countries VALUES("169","PH","PHILIPPINES","Philippines","PHL","608","63");
INSERT INTO kcp_countries VALUES("170","PN","PITCAIRN","Pitcairn","PCN","612","0");
INSERT INTO kcp_countries VALUES("171","PL","POLAND","Poland","POL","616","48");
INSERT INTO kcp_countries VALUES("172","PT","PORTUGAL","Portugal","PRT","620","351");
INSERT INTO kcp_countries VALUES("173","PR","PUERTO RICO","Puerto Rico","PRI","630","1787");
INSERT INTO kcp_countries VALUES("174","QA","QATAR","Qatar","QAT","634","974");
INSERT INTO kcp_countries VALUES("175","RE","REUNION","Reunion","REU","638","262");
INSERT INTO kcp_countries VALUES("176","RO","ROMANIA","Romania","ROM","642","40");
INSERT INTO kcp_countries VALUES("177","RU","RUSSIAN FEDERATION","Russian Federation","RUS","643","70");
INSERT INTO kcp_countries VALUES("178","RW","RWANDA","Rwanda","RWA","646","250");
INSERT INTO kcp_countries VALUES("179","SH","SAINT HELENA","Saint Helena","SHN","654","290");
INSERT INTO kcp_countries VALUES("180","KN","SAINT KITTS AND NEVIS","Saint Kitts and Nevis","KNA","659","1869");
INSERT INTO kcp_countries VALUES("181","LC","SAINT LUCIA","Saint Lucia","LCA","662","1758");
INSERT INTO kcp_countries VALUES("182","PM","SAINT PIERRE AND MIQUELON","Saint Pierre and Miquelon","SPM","666","508");
INSERT INTO kcp_countries VALUES("183","VC","SAINT VINCENT AND THE GRENADINES","Saint Vincent and the Grenadines","VCT","670","1784");
INSERT INTO kcp_countries VALUES("184","WS","SAMOA","Samoa","WSM","882","684");
INSERT INTO kcp_countries VALUES("185","SM","SAN MARINO","San Marino","SMR","674","378");
INSERT INTO kcp_countries VALUES("186","ST","SAO TOME AND PRINCIPE","Sao Tome and Principe","STP","678","239");
INSERT INTO kcp_countries VALUES("187","SA","SAUDI ARABIA","Saudi Arabia","SAU","682","966");
INSERT INTO kcp_countries VALUES("188","SN","SENEGAL","Senegal","SEN","686","221");
INSERT INTO kcp_countries VALUES("189","CS","SERBIA AND MONTENEGRO","Serbia and Montenegro","","","381");
INSERT INTO kcp_countries VALUES("190","SC","SEYCHELLES","Seychelles","SYC","690","248");
INSERT INTO kcp_countries VALUES("191","SL","SIERRA LEONE","Sierra Leone","SLE","694","232");
INSERT INTO kcp_countries VALUES("192","SG","SINGAPORE","Singapore","SGP","702","65");
INSERT INTO kcp_countries VALUES("193","SK","SLOVAKIA","Slovakia","SVK","703","421");
INSERT INTO kcp_countries VALUES("194","SI","SLOVENIA","Slovenia","SVN","705","386");
INSERT INTO kcp_countries VALUES("195","SB","SOLOMON ISLANDS","Solomon Islands","SLB","90","677");
INSERT INTO kcp_countries VALUES("196","SO","SOMALIA","Somalia","SOM","706","252");
INSERT INTO kcp_countries VALUES("197","ZA","SOUTH AFRICA","South Africa","ZAF","710","27");
INSERT INTO kcp_countries VALUES("198","GS","SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS","South Georgia and the South Sandwich Islands","","","0");
INSERT INTO kcp_countries VALUES("199","ES","SPAIN","Spain","ESP","724","34");
INSERT INTO kcp_countries VALUES("200","LK","SRI LANKA","Sri Lanka","LKA","144","94");
INSERT INTO kcp_countries VALUES("201","SD","SUDAN","Sudan","SDN","736","249");
INSERT INTO kcp_countries VALUES("202","SR","SURINAME","Suriname","SUR","740","597");
INSERT INTO kcp_countries VALUES("203","SJ","SVALBARD AND JAN MAYEN","Svalbard and Jan Mayen","SJM","744","47");
INSERT INTO kcp_countries VALUES("204","SZ","SWAZILAND","Swaziland","SWZ","748","268");
INSERT INTO kcp_countries VALUES("205","SE","SWEDEN","Sweden","SWE","752","46");
INSERT INTO kcp_countries VALUES("206","CH","SWITZERLAND","Switzerland","CHE","756","41");
INSERT INTO kcp_countries VALUES("207","SY","SYRIAN ARAB REPUBLIC","Syrian Arab Republic","SYR","760","963");
INSERT INTO kcp_countries VALUES("208","TW","TAIWAN, PROVINCE OF CHINA","Taiwan, Province of China","TWN","158","886");
INSERT INTO kcp_countries VALUES("209","TJ","TAJIKISTAN","Tajikistan","TJK","762","992");
INSERT INTO kcp_countries VALUES("210","TZ","TANZANIA, UNITED REPUBLIC OF","Tanzania, United Republic of","TZA","834","255");
INSERT INTO kcp_countries VALUES("211","TH","THAILAND","Thailand","THA","764","66");
INSERT INTO kcp_countries VALUES("212","TL","TIMOR-LESTE","Timor-Leste","","","670");
INSERT INTO kcp_countries VALUES("213","TG","TOGO","Togo","TGO","768","228");
INSERT INTO kcp_countries VALUES("214","TK","TOKELAU","Tokelau","TKL","772","690");
INSERT INTO kcp_countries VALUES("215","TO","TONGA","Tonga","TON","776","676");
INSERT INTO kcp_countries VALUES("216","TT","TRINIDAD AND TOBAGO","Trinidad and Tobago","TTO","780","1868");
INSERT INTO kcp_countries VALUES("217","TN","TUNISIA","Tunisia","TUN","788","216");
INSERT INTO kcp_countries VALUES("218","TR","TURKEY","Turkey","TUR","792","90");
INSERT INTO kcp_countries VALUES("219","TM","TURKMENISTAN","Turkmenistan","TKM","795","7370");
INSERT INTO kcp_countries VALUES("220","TC","TURKS AND CAICOS ISLANDS","Turks and Caicos Islands","TCA","796","1649");
INSERT INTO kcp_countries VALUES("221","TV","TUVALU","Tuvalu","TUV","798","688");
INSERT INTO kcp_countries VALUES("222","UG","UGANDA","Uganda","UGA","800","256");
INSERT INTO kcp_countries VALUES("223","UA","UKRAINE","Ukraine","UKR","804","380");
INSERT INTO kcp_countries VALUES("224","AE","UNITED ARAB EMIRATES","United Arab Emirates","ARE","784","971");
INSERT INTO kcp_countries VALUES("225","GB","UNITED KINGDOM","United Kingdom","GBR","826","44");
INSERT INTO kcp_countries VALUES("226","US","UNITED STATES","United States","USA","840","1");
INSERT INTO kcp_countries VALUES("227","UM","UNITED STATES MINOR OUTLYING ISLANDS","United States Minor Outlying Islands","","","1");
INSERT INTO kcp_countries VALUES("228","UY","URUGUAY","Uruguay","URY","858","598");
INSERT INTO kcp_countries VALUES("229","UZ","UZBEKISTAN","Uzbekistan","UZB","860","998");
INSERT INTO kcp_countries VALUES("230","VU","VANUATU","Vanuatu","VUT","548","678");
INSERT INTO kcp_countries VALUES("231","VE","VENEZUELA","Venezuela","VEN","862","58");
INSERT INTO kcp_countries VALUES("232","VN","VIET NAM","Viet Nam","VNM","704","84");
INSERT INTO kcp_countries VALUES("233","VG","VIRGIN ISLANDS, BRITISH","Virgin Islands, British","VGB","92","1284");
INSERT INTO kcp_countries VALUES("234","VI","VIRGIN ISLANDS, U.S.","Virgin Islands, U.s.","VIR","850","1340");
INSERT INTO kcp_countries VALUES("235","WF","WALLIS AND FUTUNA","Wallis and Futuna","WLF","876","681");
INSERT INTO kcp_countries VALUES("236","EH","WESTERN SAHARA","Western Sahara","ESH","732","212");
INSERT INTO kcp_countries VALUES("237","YE","YEMEN","Yemen","YEM","887","967");
INSERT INTO kcp_countries VALUES("238","ZM","ZAMBIA","Zambia","ZMB","894","260");
INSERT INTO kcp_countries VALUES("239","ZW","ZIMBABWE","Zimbabwe","ZWE","716","263");



DROP TABLE IF EXISTS kcp_county;

CREATE TABLE `kcp_county` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL,
  `county_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO kcp_county VALUES("1","1","Comondú");
INSERT INTO kcp_county VALUES("2","1","La Paz");
INSERT INTO kcp_county VALUES("3","1","Loreto");
INSERT INTO kcp_county VALUES("4","1","Los Cabos");
INSERT INTO kcp_county VALUES("5","1","Mulegé");



DROP TABLE IF EXISTS kcp_event_category;

CREATE TABLE `kcp_event_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(333) NOT NULL,
  `category_name_sp` varchar(512) NOT NULL,
  `parent_category` int(11) NOT NULL,
  `category_status` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;

INSERT INTO kcp_event_category VALUES("1","Fiesta popular - Carnaval","Fiesta popular - Carnival","2","Y");
INSERT INTO kcp_event_category VALUES("2","Music","M�sica","0","Y");
INSERT INTO kcp_event_category VALUES("3","Arts & Culture - Performing arts","Arte y Cultura - Artes esc�nicas","0","Y");
INSERT INTO kcp_event_category VALUES("4","Nightlife","Vida Nocturna","0","Y");
INSERT INTO kcp_event_category VALUES("5","Food & wine","Comida y Vino","0","Y");
INSERT INTO kcp_event_category VALUES("6","Cinema","Cine","0","Y");
INSERT INTO kcp_event_category VALUES("7","Sport & outdoors","Deporte y aire libre","0","Y");
INSERT INTO kcp_event_category VALUES("8","Health & Wellness/Self-improvement","Salud y bienestar/Superaci�n personal","0","Y");
INSERT INTO kcp_event_category VALUES("9","Politics","Pol�tica","0","Y");
INSERT INTO kcp_event_category VALUES("10","Activism","Activismo","0","Y");
INSERT INTO kcp_event_category VALUES("11","Community","Comunitario","0","Y");
INSERT INTO kcp_event_category VALUES("12","Social events/mixers/Reunions","Eventos sociales / mezcladores / Reuniones","0","Y");
INSERT INTO kcp_event_category VALUES("13","Professional","Profesional","0","Y");
INSERT INTO kcp_event_category VALUES("14","Private","Privado","0","Y");
INSERT INTO kcp_event_category VALUES("15","Folkloric/Traditional Mexican","Folkl�rica / Tradicional Mexicana","2","Y");
INSERT INTO kcp_event_category VALUES("16","Troba","Troba","2","Y");
INSERT INTO kcp_event_category VALUES("17","Banda - nortena","Banda - norte�a","2","Y");
INSERT INTO kcp_event_category VALUES("18","Latin - Salsa/meringue/cumbia","Latina - Salsa / Merengue / cumbia","2","Y");
INSERT INTO kcp_event_category VALUES("19","Rock-pop","rock-pop","2","Y");
INSERT INTO kcp_event_category VALUES("20","Dance/Electronic/Transe","Dance / Electronic / Transe","2","Y");
INSERT INTO kcp_event_category VALUES("21","Country and Folk","Country y Folk","2","Y");
INSERT INTO kcp_event_category VALUES("22","Reggae","Reggae","2","Y");
INSERT INTO kcp_event_category VALUES("23","Rap, Hip-Hop, R&B","Rap, Hip-Hop, R & B","2","Y");
INSERT INTO kcp_event_category VALUES("24","Jazz & Blues","Jazz y Blues","2","Y");
INSERT INTO kcp_event_category VALUES("25","Ethnic - World Music","Ethnic - M�sica del mundo","2","Y");
INSERT INTO kcp_event_category VALUES("26","New Age and Spiritual","New Age y espirituales","2","Y");
INSERT INTO kcp_event_category VALUES("27","Classical/Opera","Cl�sica / �pera","2","Y");
INSERT INTO kcp_event_category VALUES("28","Other","Otras","2","Y");
INSERT INTO kcp_event_category VALUES("29","Arts","Artes","3","Y");
INSERT INTO kcp_event_category VALUES("30","Musical","Musical","3","Y");
INSERT INTO kcp_event_category VALUES("31","Ballet & Dance","Ballet y Danza","3","Y");
INSERT INTO kcp_event_category VALUES("32","Theater","Teatro","3","Y");
INSERT INTO kcp_event_category VALUES("33","Comedy","Comedia","3","Y");
INSERT INTO kcp_event_category VALUES("34","Magic show","Magic Show","3","Y");
INSERT INTO kcp_event_category VALUES("35","Circus","Circus","3","Y");
INSERT INTO kcp_event_category VALUES("36","Street animation","Animaci�n de calle","3","Y");
INSERT INTO kcp_event_category VALUES("37","handicrafts","artesan�as","3","Y");
INSERT INTO kcp_event_category VALUES("38","Live music","Musical","4","Y");
INSERT INTO kcp_event_category VALUES("39","Show","Show","4","Y");
INSERT INTO kcp_event_category VALUES("40","Cabaret","Cabaret","4","Y");
INSERT INTO kcp_event_category VALUES("41","DJ","DJ","4","Y");
INSERT INTO kcp_event_category VALUES("42","Party","Party","4","Y");
INSERT INTO kcp_event_category VALUES("43","Gastronomy","Gastronom�a","5","Y");
INSERT INTO kcp_event_category VALUES("44","Wine tasting","Cata de vinos","5","Y");
INSERT INTO kcp_event_category VALUES("45","Organic/health food","org�nicos / alimentos saludables","5","Y");
INSERT INTO kcp_event_category VALUES("46","Athletics","Atletismo","7","Y");
INSERT INTO kcp_event_category VALUES("47","Combat sports","Deportes de lucha","7","Y");
INSERT INTO kcp_event_category VALUES("48","Team sports (soccer, football, baseball, etc.)","Deportes de equipo (f�tbol, f�tbol, b�isbol, etc)","7","Y");
INSERT INTO kcp_event_category VALUES("49","tennis","tenis","7","Y");
INSERT INTO kcp_event_category VALUES("50","Golf","Golf","7","Y");
INSERT INTO kcp_event_category VALUES("51","Off-road, car racing","Off-road, coche de carreras de","7","Y");
INSERT INTO kcp_event_category VALUES("52","Sport fishing","pesca deportiva","7","Y");
INSERT INTO kcp_event_category VALUES("53","Water sports (surf, kitesurfing, diving, etc.)","Deportes acu�ticos (surf, kitesurf, buceo,","7","Y");
INSERT INTO kcp_event_category VALUES("54","Outdoors","Aire libre","7","Y");
INSERT INTO kcp_event_category VALUES("55","Others","otros","7","Y");
INSERT INTO kcp_event_category VALUES("56","Nutrition","nutrici�n","8","Y");
INSERT INTO kcp_event_category VALUES("57","Zumba/Aerobic/Dance","Zumba / Aerobic / Dance","8","Y");
INSERT INTO kcp_event_category VALUES("58","Healing","Curaci�n","8","Y");
INSERT INTO kcp_event_category VALUES("59","Yoga","yoga","8","Y");
INSERT INTO kcp_event_category VALUES("60","Pilates","Pilates","8","Y");
INSERT INTO kcp_event_category VALUES("61","Meditation","meditaci�n","8","Y");
INSERT INTO kcp_event_category VALUES("62","Spirituality","espiritualidad","8","Y");
INSERT INTO kcp_event_category VALUES("63","Religion ","religi�n","8","Y");
INSERT INTO kcp_event_category VALUES("64","Motivation","motivaci�n","8","Y");
INSERT INTO kcp_event_category VALUES("65","Personal finances","Finanzas Personales","8","Y");
INSERT INTO kcp_event_category VALUES("66","Education","educaci�n","13","Y");
INSERT INTO kcp_event_category VALUES("67","Business","negocios","13","Y");
INSERT INTO kcp_event_category VALUES("68","Technology","tecnolog�a","13","Y");
INSERT INTO kcp_event_category VALUES("69","Graphic/web design","Dise�o","13","Y");
INSERT INTO kcp_event_category VALUES("70","Video editing","Edici�n de v�deo","13","Y");
INSERT INTO kcp_event_category VALUES("71","accounting","contabilidad","13","Y");
INSERT INTO kcp_event_category VALUES("72","Finances","Finanzas","13","Y");
INSERT INTO kcp_event_category VALUES("73","Sales","Ventas","13","Y");
INSERT INTO kcp_event_category VALUES("74","Baby shower","Baby shower","14","Y");
INSERT INTO kcp_event_category VALUES("75","Baptism","bautismo","14","Y");
INSERT INTO kcp_event_category VALUES("76","birthday","cumplea�os","14","Y");
INSERT INTO kcp_event_category VALUES("77","Quincea�era","del quinceanera del","14","Y");
INSERT INTO kcp_event_category VALUES("78","Sweet sixteen","dulce diecis�is","14","Y");
INSERT INTO kcp_event_category VALUES("79","Graduation","Graduaci�n","14","Y");
INSERT INTO kcp_event_category VALUES("80","Bachelor party","Despedida de soltero","14","Y");
INSERT INTO kcp_event_category VALUES("81","Wedding","boda","14","Y");
INSERT INTO kcp_event_category VALUES("82","Anniversary","aniversario de","14","Y");
INSERT INTO kcp_event_category VALUES("83","Wakes & Funerals","despierta y Funerales","14","Y");
INSERT INTO kcp_event_category VALUES("84","posada","posada","14","Y");
INSERT INTO kcp_event_category VALUES("85","Christmas","Navidad","14","Y");
INSERT INTO kcp_event_category VALUES("86","New Year\'s eve","A�o Nuevo","0","Y");
INSERT INTO kcp_event_category VALUES("87","others","otros","14","Y");



DROP TABLE IF EXISTS kcp_event_types;

CREATE TABLE `kcp_event_types` (
  `event_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `event_master_type_id` int(11) NOT NULL,
  PRIMARY KEY (`event_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=478 DEFAULT CHARSET=latin1;

INSERT INTO kcp_event_types VALUES("354","1","6");
INSERT INTO kcp_event_types VALUES("353","1","4");
INSERT INTO kcp_event_types VALUES("352","1","1");
INSERT INTO kcp_event_types VALUES("345","2","8");
INSERT INTO kcp_event_types VALUES("344","2","6");
INSERT INTO kcp_event_types VALUES("343","2","2");
INSERT INTO kcp_event_types VALUES("301","8","9");
INSERT INTO kcp_event_types VALUES("300","8","1");
INSERT INTO kcp_event_types VALUES("245","15","2");
INSERT INTO kcp_event_types VALUES("244","15","1");
INSERT INTO kcp_event_types VALUES("295","21","2");
INSERT INTO kcp_event_types VALUES("294","21","1");
INSERT INTO kcp_event_types VALUES("305","22","1");
INSERT INTO kcp_event_types VALUES("318","25","2");
INSERT INTO kcp_event_types VALUES("317","25","1");
INSERT INTO kcp_event_types VALUES("361","12","3");
INSERT INTO kcp_event_types VALUES("387","35","7");
INSERT INTO kcp_event_types VALUES("365","37","2");
INSERT INTO kcp_event_types VALUES("374","18","1");
INSERT INTO kcp_event_types VALUES("370","16","7");
INSERT INTO kcp_event_types VALUES("372","41","1");
INSERT INTO kcp_event_types VALUES("373","38","2");
INSERT INTO kcp_event_types VALUES("388","44","7");
INSERT INTO kcp_event_types VALUES("444","47","1");
INSERT INTO kcp_event_types VALUES("477","55","2");
INSERT INTO kcp_event_types VALUES("476","55","1");



DROP TABLE IF EXISTS kcp_events;

CREATE TABLE `kcp_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(222) NOT NULL,
  `event_date` datetime NOT NULL,
  `venue` int(100) NOT NULL,
  `description` longtext NOT NULL,
  `on_sale_date` datetime NOT NULL,
  `sale_close_date` datetime NOT NULL,
  `category_id` int(11) NOT NULL,
  `age` varchar(222) NOT NULL,
  `event_web_site` varchar(222) NOT NULL,
  `icon_image` varchar(256) NOT NULL,
  `event_image` varchar(222) NOT NULL,
  `inventory_capacity` int(100) NOT NULL,
  `event_status` int(1) NOT NULL,
  `print_at_home` int(11) NOT NULL,
  `print_date_enable` datetime NOT NULL,
  `print_date_disable` datetime NOT NULL,
  `print_add_desc` longtext NOT NULL,
  `will_call` int(11) NOT NULL,
  `will_date_enable` datetime NOT NULL,
  `will_date_disable` datetime NOT NULL,
  `will_add_desc` longtext NOT NULL,
  `donation_enable` int(1) NOT NULL,
  `donation_name` varchar(222) NOT NULL,
  `online_service_fee` float NOT NULL,
  `ticket_note` varchar(222) NOT NULL,
  `ticket_transaction_limit` float NOT NULL,
  `checkout_time_limit` int(100) NOT NULL,
  `private_event` int(1) NOT NULL,
  `url_short_name` varchar(222) NOT NULL,
  `custom_fee` int(1) NOT NULL,
  `custom_fee_name` varchar(333) NOT NULL,
  `custom_fee_type` int(1) NOT NULL,
  `custom_fee_amt` float NOT NULL,
  `custom_apply_fee` int(1) NOT NULL,
  `event_step` int(10) NOT NULL,
  `event_launch` int(1) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `organization_id` int(100) NOT NULL,
  `commission` float NOT NULL,
  `home_page_event` int(1) NOT NULL,
  `event_ads1` varchar(333) NOT NULL,
  `event_ads2` varchar(333) NOT NULL,
  `event_order` int(100) NOT NULL,
  `event_views` int(100) NOT NULL,
  `pause_sale` int(1) NOT NULL,
  `send_newsletter` int(11) NOT NULL,
  `newsletter_sent` int(11) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO kcp_events VALUES("1","Test Event","2013-06-07 04:10:00","1","Test","2013-05-31 15:21:00","2013-06-06 01:00:00","1","18","http://tickethype.com/register/2","","","0","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","","0","0000-00-00 00:00:00","0000-00-00 00:00:00","","0","","0","","0","0","0","","0","","0","0","0","1","0","2","1","0","0","","","0","0","0","0","0");



DROP TABLE IF EXISTS kcp_final_multi_event;

CREATE TABLE `kcp_final_multi_event` (
  `multi_id` int(255) NOT NULL AUTO_INCREMENT,
  `event_id` int(255) NOT NULL,
  `admin_id` int(255) NOT NULL,
  `event_start_date_time` datetime NOT NULL,
  `event_start_ampm` varchar(255) NOT NULL,
  `event_end_date_time` datetime NOT NULL,
  `event_end_ampm` varchar(255) NOT NULL,
  `multi_venue_state` int(255) NOT NULL,
  `venue_county_multi` int(255) NOT NULL,
  `multi_venue_city` int(255) NOT NULL,
  `multi_venue` int(255) NOT NULL,
  `unique_id` int(255) NOT NULL,
  `post_date` int(255) NOT NULL,
  PRIMARY KEY (`multi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

INSERT INTO kcp_final_multi_event VALUES("1","1","2","2013-07-31 23:00:00","PM","0000-00-00 00:00:00","","1","2","20","42","1375189911","1375190175");
INSERT INTO kcp_final_multi_event VALUES("2","1","2","2013-08-02 17:00:00","PM","0000-00-00 00:00:00","","1","4","36","27","1375189911","1375190193");
INSERT INTO kcp_final_multi_event VALUES("3","1","2","2013-08-21 18:00:00","PM","0000-00-00 00:00:00","","1","4","37","11","1202833559","1375191088");
INSERT INTO kcp_final_multi_event VALUES("4","10","2","2013-08-10 20:00:00","PM","2013-08-10 05:00:00","AM","1","4","37","6","1375196529","1375198976");
INSERT INTO kcp_final_multi_event VALUES("5","10","2","2013-08-11 17:00:00","PM","2013-08-11 19:00:00","PM","1","4","36","1","1375196529","1375199042");
INSERT INTO kcp_final_multi_event VALUES("11","10","2","2013-08-11 19:00:00","PM","2013-08-13 21:00:00","PM","1","2","20","47","1889426626","1375427779");
INSERT INTO kcp_final_multi_event VALUES("12","18","1","2013-08-24 20:00:00","PM","2013-08-24 21:00:00","PM","1","4","37","6","1376164562","1376165043");
INSERT INTO kcp_final_multi_event VALUES("13","18","1","2013-08-25 17:00:00","PM","2013-08-25 19:00:00","PM","1","4","37","6","1376164562","1376165091");
INSERT INTO kcp_final_multi_event VALUES("14","18","1","2013-08-25 20:00:00","PM","2013-08-25 22:00:00","PM","1","4","37","6","1376164562","1376165148");
INSERT INTO kcp_final_multi_event VALUES("17","17","1","2013-08-12 06:30:00","AM","2013-08-15 21:00:00","PM","1","4","37","14","1376297553","1376297581");
INSERT INTO kcp_final_multi_event VALUES("21","35","1","2013-08-13 01:00:00","AM","2013-08-15 09:00:00","AM","1","2","21","22","1376302812","1376302831");
INSERT INTO kcp_final_multi_event VALUES("23","42","2","2013-08-12 06:30:00","AM","0000-00-00 00:00:00","","1","4","37","14","1376297553","1376297581");
INSERT INTO kcp_final_multi_event VALUES("24","43","2","2013-08-12 06:30:00","AM","0000-00-00 00:00:00","","1","4","37","14","1376297553","1376297581");
INSERT INTO kcp_final_multi_event VALUES("25","44","2","2013-08-13 01:00:00","AM","0000-00-00 00:00:00","","1","2","21","22","1376302812","1376302831");



DROP TABLE IF EXISTS kcp_final_tickets;

CREATE TABLE `kcp_final_tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(111) NOT NULL,
  `ticket_name_en` varchar(255) NOT NULL,
  `ticket_name_sp` varchar(255) NOT NULL,
  `description_en` longtext NOT NULL,
  `description_sp` longtext NOT NULL,
  `price_mx` float(10,2) NOT NULL,
  `price_us` float(10,2) NOT NULL,
  `ticket_num` int(11) NOT NULL,
  `from_ticket` varchar(255) NOT NULL,
  `to_ticket` varchar(255) NOT NULL,
  `eairly_dis_percen` float(5,2) NOT NULL,
  `eairly_days` int(10) NOT NULL,
  `group_dis_per` float(5,2) NOT NULL,
  `group_dis_days` int(10) NOT NULL,
  `ticket_icon` varchar(200) NOT NULL,
  `members_only` varchar(10) NOT NULL,
  `unique_id` varchar(100) NOT NULL,
  `post_date` int(30) NOT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO kcp_final_tickets VALUES("1","1","Ticket1","Ticket1","Ticket1 desc","Ticket1 desc","20.00","25.00","125","1376073000","1376505000","6.00","10","7.00","85","","1","1375189911","1375190568");
INSERT INTO kcp_final_tickets VALUES("2","1","Ticket2","Ticket2","Ticket2","ticket2","25.00","30.00","200","1375381800","1373394600","4.00","7","10.50","100","","1","1375189911","1375190695");
INSERT INTO kcp_final_tickets VALUES("3","1","Ticket3","Ticket3","Ticket3","Ticket3","35.00","40.00","75","1375295400","1372962600","8.00","5","11.00","60","","1","1202833559","1375191313");
INSERT INTO kcp_final_tickets VALUES("4","11","General admission","Entrada general","Short description","Breve descripción","100.00","0.00","200","1375122600","1376073000","0.00","0","0.00","0","","0","1788062656","1375200742");
INSERT INTO kcp_final_tickets VALUES("5","11","VIP","VIP","Description","Descripción","200.00","0.00","25","1375122600","1376073000","0.00","0","0.00","0","","1","1788062656","1375200790");



DROP TABLE IF EXISTS kcp_general_events;

CREATE TABLE `kcp_general_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `event_name_en` text NOT NULL,
  `event_name_sp` text NOT NULL,
  `event_short_desc_en` varchar(255) NOT NULL,
  `event_short_desc_sp` varchar(255) NOT NULL,
  `event_start_date_time` datetime NOT NULL,
  `event_start_ampm` varchar(10) NOT NULL,
  `event_end_date_time` datetime NOT NULL,
  `event_end_ampm` varchar(10) NOT NULL,
  `event_venue_state` int(11) NOT NULL,
  `event_venue_county` int(11) NOT NULL,
  `event_venue_city` int(11) NOT NULL,
  `event_venue` int(11) NOT NULL,
  `event_details_en` longtext NOT NULL,
  `event_details_sp` longtext NOT NULL,
  `event_tag` varchar(255) NOT NULL,
  `event_photo` varchar(200) NOT NULL,
  `identical_function` int(1) NOT NULL,
  `recurring` int(1) NOT NULL,
  `sub_events` int(1) NOT NULL,
  `event_status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `post_date` int(30) NOT NULL,
  `Paypal` int(255) NOT NULL,
  `Bank_deposite` int(255) NOT NULL,
  `Oxxo_Payment` int(255) NOT NULL,
  `Mobile_Payment` int(255) NOT NULL,
  `Offline_Payment` int(255) NOT NULL,
  `paper_less_mob_ticket` int(11) NOT NULL,
  `print` int(11) NOT NULL,
  `will_call` int(11) NOT NULL,
  `set_privacy` int(1) NOT NULL,
  `share_date` int(11) NOT NULL,
  `attendees_share` int(11) NOT NULL,
  `attendees_invitation` int(11) NOT NULL,
  `password_protect` int(11) NOT NULL,
  `password_protect_text` varchar(128) NOT NULL,
  `publish_date` date NOT NULL,
  `event_time` varchar(255) NOT NULL,
  `event_time_period` varchar(255) NOT NULL,
  `r_month` varchar(255) NOT NULL,
  `r_month_day` varchar(255) NOT NULL,
  `mon` int(255) NOT NULL,
  `tue` int(255) NOT NULL,
  `wed` int(255) NOT NULL,
  `thu` int(255) NOT NULL,
  `fri` int(255) NOT NULL,
  `sat` int(255) NOT NULL,
  `sun` int(255) NOT NULL,
  `r_span_start` date NOT NULL,
  `r_span_end` date NOT NULL,
  `event_start` varchar(255) NOT NULL,
  `event_end` varchar(255) NOT NULL,
  `all_day` int(255) NOT NULL,
  `event_lasts` varchar(255) NOT NULL,
  `include_payment` int(11) NOT NULL,
  `include_promotion` int(11) NOT NULL,
  `all_access` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

INSERT INTO kcp_general_events VALUES("1","2","2nd international congress of alternative tourism ","II congreso internacional de turismo alternativo ","","","2013-11-07 09:30:00","AM","2013-11-09 17:00:00","PM","1","4","37","6","<p>\n	<span id=\"result_box\" lang=\"en\"><span class=\"hps\">AGATA</span>&nbsp;Todos Santos, <span class=\"hps\">Mexico</span> <span class=\"hps\">invites</span>&nbsp;you to&nbsp;<span class=\"hps\">its second</span> <span class=\"hps\">international congress of</span> <span class=\"hps atn\">alternative tourism &quot;</span><span class=\"alt-edited\">Leveraging</span> <span class=\"hps\">Ideas&quot;</span><br />\n	<br />\n	<span class=\"hps\">Rural tourism,</span> <span class=\"hps\">adventure and ecotourism</span> <span class=\"hps\">will be</span> <span class=\"hps\">some of</span> <span class=\"hps\">the lectures</span> <span class=\"hps\">will be given</span> <span class=\"hps\">by</span> <span class=\"hps\">international speakers</span> <span class=\"hps\">from</span> <span class=\"hps\">Spain</span>, France, United States, <span class=\"hps\">Costa Rica</span> <span class=\"hps\">and</span> <span class=\"hps\">Mexico</span>.<br />\n	<br />\n	<span class=\"hps\">More</span> <span class=\"hps\">information</span><span>:</span></span></p>\n<p>\n	Tel: (624) 1468597<br />\n	<a href=\"http://www.agata.mx/\" target=\"_blank\">WWW.AGATA.MX</a><br />\n	<a href=\"mailto:RESERVACIONES@AGATA.MX\">RESERVACIONES@AGATA.MX</a></p>\n","<p>\n	<span class=\"textoContenido\">AGATA todos santos, M&eacute;xico invita a su II congreso internacional de turismo alternativo &quot;Impulsando ideas&quot;<br />\n	<br />\n	Turismo rural, de aventura y ecoturismo seran algunas de las conferencias que se daran por parte de conferencistas internacionales de Espa&ntilde;a, Francia, Estados Unidos, Costa Rica y M&eacute;xico.<br />\n	<br />\n	M&aacute;s informaci&oacute;n:<br />\n	Tel: (624) 1468597<br />\n	<a href=\"http://www.agata.mx/\" target=\"_blank\">WWW.AGATA.MX</a><br />\n	<a href=\"mailto:RESERVACIONES@AGATA.MX\">RESERVACIONES@AGATA.MX</a></span></p>\n","","1376056651Congresoturismoalternativo.png","0","0","0","Y","1371043974","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-09","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","12:00 AM","12:00 AM","0","","0","0","1","","draft");
INSERT INTO kcp_general_events VALUES("3","2","Sunset Shakti Naam Masterclass","Sunset Shakti Naam Masterclass","","","2013-06-19 18:30:00","PM","2013-06-19 20:30:00","PM","1","4","37","10","<p>\n	<font color=\"#232438\" face=\"Verdana\" style=\"font-size: 9.5pt\">Shakti Naam works with the fifth element within us, that ocean of energy that gives life to our being. It is referred to as the yoga of immortality by those that know the full extent of its power. During this very special class, Dr. Levry will teach these advanced techniques designed to build and expand your electromagnetic field and nurture your life force. Here we are, at the very eve of the Age of Love. This is the Age of group energy. It is so important that we come together and support each other as we perform our spiritual work. Doing so will not only bless us and burn away our karma, but bless and heal everyone with whom we are sharing this special place in time. We invite you to join us as we come together in the Spirit of Love, with our beloved teacher, to heal and bless the Earth. This powerful class is designed to illuminate your life, so that you may ride the wave of your highest Destiny straight into the heart of the Divine.</font></p>\n","<p>\n	<font color=\"#232438\" face=\"Verdana\" style=\"font-size: 9.5pt\">&ldquo;SHAKTI NAAM es una practica rara y muy poco conocida en el Occidente que cuida del cuerpo humano como un todo, desde de tu cabeza hasta los dedos de tus pies. No hay ninguna parte del cuerpo que no se beneficie con Shakti Naam, todos tus huesos, tus m&uacute;sculos, tus &oacute;rganos, as&iacute; como los sistemas glandular y nervioso. La pr&aacute;ctica de Shakti Naam ocasiona que los m&uacute;sculos dispersen energ&iacute;a en todo el cuerpo y el cerebro empieza a responder&rdquo;.<br />\n	<i>-Palabras del Dr. Levry a Antonio Esquinca en su programa en Alfa 91.3</i><br />\n	<br />\n	DURANTE ESTE EVENTO TAN ESPECIAL Dr. Levry ense&ntilde;ar&aacute; t&eacute;cnicas avanzadas que est&aacute;n dise&ntilde;adas para prevenir el estress y la enfermedad. Clase abierta a todas las edades y niveles.</font></p>\n","","1372378431SunsetShaktiNaamMasterclass-flyer.jpg","0","0","0","Y","1371096165","0","0","0","0","0","0","0","0","0","0","0","0","0","","0000-00-00","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","","","0","","0","0","0","","");
INSERT INTO kcp_general_events VALUES("4","1","Design Time Los Cabos\'s","Design Time Los Cabos\'s","","","2013-07-11 09:00:00","AM","2013-07-13 20:00:00","PM","1","4","37","11","<p>\n	<span id=\"result_box\" lang=\"en\" tabindex=\"-1\"><span class=\"hps\">We are pleased</span> <span class=\"hps\">to present</span> <span class=\"hps\">our</span> <span class=\"hps\">third consecutive</span> <span class=\"hps\">Lecture</span> <span class=\"hps\">and Workshop</span>, <span class=\"hps\">themed</span> <span class=\"hps\">graphic design, advertising</span><span>, MKT</span>, art, photography, <span class=\"hps\">communication</span> <span class=\"hps\">and the latest</span> <span class=\"hps\">digital trends</span>. <span class=\"hps\">With</span> <span class=\"hps\">nine guests</span> <span class=\"hps\">of the highest level</span>, which <span class=\"hps\">are internationally recognized</span>, <span class=\"hps\">who will share with</span> <span class=\"hps\">our participants</span> <span class=\"hps\">interesting information</span> <span class=\"hps\">that will help them</span> <span class=\"hps\">have a better</span> <span class=\"hps\">competitive perspective</span>.<br />\n	<span class=\"hps\">Our 8</span> <span class=\"hps\">conferences</span> <span class=\"hps\">will be</span> <span class=\"hps\">on Saturday,</span> <span class=\"hps\">July 13</span>, while <span class=\"hps atn\">our 3</span>&nbsp;<span class=\"hps\">workshops will</span>&nbsp;be&nbsp;<span class=\"hps\">Thursday11</span> <span class=\"hps\">and Friday</span> <span class=\"hps\">July 12</span>.<br />\n	<span class=\"hps\">The workshops will be</span> <span class=\"hps\">creating</span> <span class=\"hps\">characters with</span> <span class=\"hps\">illustration techniques</span> <span class=\"hps\">taught by</span> <span class=\"hps\">C&eacute;sar</span> <span class=\"hps\">N&aacute;ndez</span>, <span class=\"hps\">InDesign</span> <span class=\"hps\">CS6</span> <span class=\"hps\">digital</span> <span class=\"hps\">publications</span> <span class=\"hps\">taught by</span> <span class=\"hps\">Adobe</span> <span class=\"hps\">&reg;</span> <span class=\"hps\">Influencer</span> <span class=\"hps\">Aldo</span> <span class=\"hps\">de la Fuente</span> <span class=\"hps\">and</span> <span class=\"hps\">web</span> <span class=\"hps\">sites</span> <span class=\"hps\">for any</span> <span class=\"hps\">given</span> <span class=\"hps\">screen</span> <span class=\"hps\">by</span> <span class=\"hps\">Monky</span> <span class=\"hps\">Adobe</span> <span class=\"hps\">&reg;</span> <span class=\"hps\">Certified</span> <span class=\"hps\">Instructor</span>. <span class=\"hps\">All</span> <span class=\"hps\">9-hour</span> <span class=\"hps\">workshops</span> <span class=\"hps\">with a diploma</span> <span class=\"hps\">curriculum</span>.</span></p>\n","<p>\n	Estamos muy contentos de presentarles por tercer a&ntilde;o consecutivo nuestro Ciclo de Conferencias y Talleres, con temas de dise&ntilde;o gr&aacute;fico, publicidad, MKT, arte, fotograf&iacute;a, comunicaci&oacute;n y lo &uacute;ltimo en tendencias digitales. Con nueve invitados de primer&iacute;simo nivel, que cuentan con reconocimiento internacional, quienes compartir&aacute;n con nuestros participantes interesantes datos que les ayudar&aacute;n a tener una mejor perspectiva competitiva.</p>\n<p>\n	Nuestras 8 conferencias ser&aacute;n el d&iacute;a s&aacute;bado 13 de Julio, mientras que nuestro 3 talleres ser&aacute;n los d&iacute;as jueves11 y viernes 12 de Julio.<br />\n	Los talleres ser&aacute;n Creando personajes con t&eacute;cnicas de ilustraci&oacute;n impartidas por C&eacute;sar N&aacute;ndez; Publicaciones digitales con InDesign CS6 impartido por el Adobe&reg; Influencer Aldo de la Fuente y Sitios web para cualquier pantalla impartido por el Adobe&reg; Certified Instructor Monky. Todos los talleres de 9 horas con diploma curricular.</p>\n","","1372378287design time-2talleres.jpg","0","0","0","Y","1371098335","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-16","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","","","0","","0","0","0","","saved");
INSERT INTO kcp_general_events VALUES("5","2","ASP 6-Star Los Cabos Open of Surf","ASP 6-Star Los Cabos Open of Surf","","","2013-06-17 08:00:00","AM","2013-06-23 16:00:00","PM","1","4","36","7","<p>\n	<span class=\"textoContenido\">The Association of Surfing Professionals 6-Star Los Cabos Open of Surf has officially been added to the ASP North America schedule, unfolding at Cabos righthand cobblestone pointbreak of Zippers.<br />\n	The Los Cabos Open of Surf will also include a series of beach concerts with international artists and DJs, beach bars, a food fair offering fresh, local cuisine, fashion shows featuring some of the top surf brands, art walks and eco-friendly activities, showcasing the best of the surf lifestyle.</span></p>\n<p>\n	Official schedule&nbsp;<a href=\"http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/\">http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/</a></p>\n","<p>\n	<span id=\"result_box\" lang=\"es\" tabindex=\"-1\"><span class=\"hps\">La Asociaci&oacute;n</span> <span class=\"hps\">de Profesionales del</span> <span class=\"hps\">Surf</span> <span class=\"hps\">6</span>-Star <span class=\"hps\">en Los</span> <span class=\"hps\">Cabos</span>&nbsp;Open of&nbsp;<span class=\"hps\">Surf</span> <span class=\"hps\">ha sido oficialmente</span> <span class=\"hps\">a&ntilde;adido a la</span>&nbsp;</span>programaci&oacute;n&nbsp;ASP&nbsp;<span class=\"hps\">Am&eacute;rica del</span> <span class=\"hps\">Norte</span>, despleg&aacute;ndose <span class=\"hps\">en</span> <span class=\"hps\">Cabos</span> <span class=\"hps\">derecha</span> <span class=\"hps\">adoquines</span> <span class=\"hps\">pointbreak</span> <span class=\"hps\">de</span> <span class=\"hps\">Zippers</span>.</p>\n<p>\n	<span lang=\"es\" tabindex=\"-1\"><span class=\"hps\">El</span> <span class=\"hps\">Los</span> <span class=\"hps\">Cabos</span>&nbsp;Open of&nbsp;<span class=\"hps\">Surf</span> <span class=\"hps\">tambi&eacute;n incluir&aacute;</span> <span class=\"hps\">una serie de conciertos</span> <span class=\"hps\">en la playa con</span> <span class=\"hps\">artistas internacionales</span> <span class=\"hps\">y DJs</span>, bares de playa, <span class=\"hps\">una feria</span> <span class=\"hps\">que ofrece</span> <span class=\"hps\">alimentos frescos</span><span>, cocina local</span>, <span class=\"hps\">desfiles de moda</span> <span class=\"hps\">con algunos de los</span> <span class=\"hps\">mejores</span> <span class=\"hps\">marcas de surf</span>, paseos <span class=\"hps\">de arte y actividades</span> <span class=\"hps\">ecol&oacute;gicas</span>, <span class=\"hps\">mostrando lo mejor</span> <span class=\"hps\">del estilo de vida</span> <span class=\"hps\">surf.</span></span></p>\n<p>\n	Programa oficial &nbsp;<a href=\"http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/\">http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/</a></p>\n","","1376056436LosCabosopenofSurf.jpg","1","0","0","Y","1371144385","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-12","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","12:00 AM","12:00 AM","0","","0","0","0","","draft");
INSERT INTO kcp_general_events VALUES("6","2","ASP 6-Star Los Cabos Open of Surf","ASP 6-Star Los Cabos Open of Surf","","","2013-06-17 08:00:00","AM","2013-06-23 16:00:00","PM","1","4","37","3","<p>\n	<span class=\"textoContenido\">The Association of Surfing Professionals 6-Star Los Cabos Open of Surf has officially been added to the ASP North America schedule, unfolding at Cabos righthand cobblestone pointbreak of Zippers.<br />\n	The Los Cabos Open of Surf will also include a series of beach concerts with international artists and DJs, beach bars, a food fair offering fresh, local cuisine, fashion shows featuring some of the top surf brands, art walks and eco-friendly activities, showcasing the best of the surf lifestyle.</span></p>\n<p>\n	Official schedule&nbsp;<a href=\"http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/\">http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/</a></p>\n","<p>\n	<span id=\"result_box\" lang=\"es\" tabindex=\"-1\"><span class=\"hps\">La Asociaci&oacute;n</span> <span class=\"hps\">de Profesionales del</span> <span class=\"hps\">Surf</span> <span class=\"hps\">6</span>-Star <span class=\"hps\">en Los</span> <span class=\"hps\">Cabos</span>&nbsp;Open of&nbsp;<span class=\"hps\">Surf</span> <span class=\"hps\">ha sido oficialmente</span> <span class=\"hps\">a&ntilde;adido a la</span>&nbsp;</span>programaci&oacute;n&nbsp;ASP&nbsp;<span class=\"hps\">Am&eacute;rica del</span> <span class=\"hps\">Norte</span>, despleg&aacute;ndose <span class=\"hps\">en</span> <span class=\"hps\">Cabos</span> <span class=\"hps\">derecha</span> <span class=\"hps\">adoquines</span> <span class=\"hps\">pointbreak</span> <span class=\"hps\">de</span> <span class=\"hps\">Zippers</span>.</p>\n<p>\n	<span lang=\"es\" tabindex=\"-1\"><span class=\"hps\">El</span> <span class=\"hps\">Los</span> <span class=\"hps\">Cabos</span>&nbsp;Open of&nbsp;<span class=\"hps\">Surf</span> <span class=\"hps\">tambi&eacute;n incluir&aacute;</span> <span class=\"hps\">una serie de conciertos</span> <span class=\"hps\">en la playa con</span> <span class=\"hps\">artistas internacionales</span> <span class=\"hps\">y DJs</span>, bares de playa, <span class=\"hps\">una feria</span> <span class=\"hps\">que ofrece</span> <span class=\"hps\">alimentos frescos</span><span>, cocina local</span>, <span class=\"hps\">desfiles de moda</span> <span class=\"hps\">con algunos de los</span> <span class=\"hps\">mejores</span> <span class=\"hps\">marcas de surf</span>, paseos <span class=\"hps\">de arte y actividades</span> <span class=\"hps\">ecol&oacute;gicas</span>, <span class=\"hps\">mostrando lo mejor</span> <span class=\"hps\">del estilo de vida</span> <span class=\"hps\">surf.</span></span></p>\n<p>\n	Programa oficial &nbsp;<a href=\"http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/\">http://loscabosopenofsurf.com/news/OFFICIAL-SCHEDULE/</a></p>\n","","1376056436LosCabosopenofSurf.jpg","0","0","0","Y","1371144521","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-09","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","12:00 AM","12:00 AM","0","","0","0","0","","saved");
INSERT INTO kcp_general_events VALUES("7","2","vdvd","vsdv","","","2013-06-13 07:00:00","PM","2013-06-13 09:00:00","PM","1","4","36","0","","","","","0","0","0","Y","1371145766","0","0","0","0","0","0","0","0","0","0","0","0","0","","0000-00-00","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","","","0","","0","0","0","","");
INSERT INTO kcp_general_events VALUES("8","2","Test1","Test1 SP","","","2013-06-21 07:00:00","PM","2013-06-21 09:00:00","PM","1","4","36","0","<p>\n	test</p>\n","","","","0","0","0","Y","1371198778","0","0","0","0","0","0","0","0","0","0","0","0","0","","0000-00-00","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","","","0","","0","0","0","","");
INSERT INTO kcp_general_events VALUES("10","2","ASP 6-Star Los Cabos Open of Surf","ASP 6-Star Los Cabos Open of Surf","","","2013-06-17 08:00:00","AM","2013-06-23 19:00:00","PM","1","4","36","25","<p>\n	<span>The Association of Surfing Professionals 6-Star Los Cabos Open of Surf has officially been added to the ASP North America schedule, unfolding at Cabos righthand cobblestone pointbreak of Zippers.<br />\n	The Los Cabos Open of Surf will also include a series of beach concerts with international artists and DJs, beach bars, a food fair offering fresh, local cuisine, fashion shows featuring some of the top surf brands, art walks and eco-friendly activities, showcasing the best of the surf lifestyle.</span></p>\n","<div id=\"\">\n	<div dir=\"\" style=\"\">\n		<span id=\"\" lang=\"\"><span>La Asociaci&oacute;n</span> <span>de Profesionales del</span> <span>Surf</span> <span>6</span>-Star&nbsp;</span><span>Los</span>&nbsp;<span>Cabos&nbsp;</span>Open of&nbsp;<span>Surf</span>&nbsp;<span>ha sido oficialmente</span> <span>a&ntilde;adido a la</span>&nbsp;<span>programaci&oacute;n</span>&nbsp;<span>ASP de&nbsp;</span><span>Am&eacute;rica del</span> <span>Norte</span>, despleg&aacute;ndose <span>en</span> <span>Cabos</span> <span>derecha</span> <span>adoquines</span> <span>pointbreak</span> <span>de</span> <span>Zippers</span>.</div>\n	<div dir=\"\" style=\"\">\n		<span lang=\"\"><span>El</span> <span>Los</span> <span>Cabos</span>&nbsp;Open of&nbsp;<span>Surf</span> <span>tambi&eacute;n incluir&aacute;</span> <span>una serie de conciertos</span> <span>en la playa con</span> <span>artistas internacionales</span> <span>y DJs</span>, bares de playa, <span>una feria</span> <span>que ofrece</span> <span>alimentos frescos</span><span>, cocina local</span>, <span>desfiles de moda</span> <span>con algunos de los</span> <span>mejores</span> <span>marcas de surf</span>, paseos <span>de arte y actividades</span> <span>ecol&oacute;gicas</span>, <span>mostrando lo mejor</span> <span>del estilo de vida</span> <span>surf.</span></span></div>\n</div>\n","","1372378035Los Cabos open of Surf.jpg","0","0","0","Y","1371220313","0","0","0","0","0","0","0","0","0","0","0","0","0","","0000-00-00","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","","","0","","0","0","0","","");
INSERT INTO kcp_general_events VALUES("11","2","Organic Market Pedregal","Mercado Organico en Pedregal","","","2013-06-15 07:00:00","AM","2013-06-15 12:00:00","PM","1","4","37","0","<h1>\n	Organic Farmers Market</h1>\n<h2>\n	<strong>Cabo San Lucas, Los Cabos, Baja California Sur, Mexico</strong></h2>\n<p>\n	What you eat can affect how your body functions. To maintain optimal nutrition, a variety of healthy food from all food groups and healthy eating habits can keep you on the road to better health. Food, one of life&rsquo;s great pleasures, is the foundation to a healthy lifestyle.</p>\n<p>\n	The Cabo San Lucas Organic Farmer&rsquo;s Market has an amazing variety of fresh produce, seafood, organic chicken, eggs, cheeses, herbs and fruits, along with a selection of prepared foods. It&rsquo;s a happening place on<strong>&nbsp;Wednesday and Saturday mornings from 8 a.m. to noon, all year long</strong>, where you can meet up with friends, shop for the best organic foods, and make your appointments for the coming week for the various services.</p>\n","<p>\n	<span id=\"result_box\" lang=\"es\" tabindex=\"-1\"><span class=\"hps alt-edited\">Mercado Org&aacute;nico</span><span class=\"hps alt-edited\">&nbsp;de productores</span><br />\n	<span class=\"hps\">Cabo</span> <span class=\"hps\">San</span> <span class=\"hps\">Lucas</span><span>, Los</span> <span class=\"hps\">Cabos,</span> <span class=\"hps\">Baja</span> <span class=\"hps\">California Sur,</span> <span class=\"hps\">M&eacute;xico</span><br />\n	<br />\n	<span class=\"hps\">Lo que usted come</span> <span class=\"hps\">puede afectar</span> <span class=\"hps\">la forma en</span> <span class=\"hps\">que funciona su cuerpo</span><span>.</span> <span class=\"hps\">Para mantener</span> <span class=\"hps\">una nutrici&oacute;n &oacute;ptima</span><span>, una variedad de</span> <span class=\"hps\">alimentos saludables</span> <span class=\"hps\">de todos los</span> <span class=\"hps\">grupos de alimentos</span> <span class=\"hps\">y los h&aacute;bitos</span> <span class=\"hps\">saludables de alimentaci&oacute;n</span><span class=\"hps\">&nbsp;puede</span>&nbsp;ser<span class=\"hps\">&nbsp;el camino hacia</span> <span class=\"hps\">una mejor salud.</span> <span class=\"hps\">La comida,</span> <span class=\"hps\">uno de los grandes</span> <span class=\"hps\">placeres de la vida</span><span>,</span> <span class=\"hps\">es la base para</span> <span class=\"hps\">una vida sana</span><span>.</span><br />\n	<br />\n	<span class=\"hps\"><span class=\"hps\">El&nbsp;</span>Mercado</span> Org&aacute;nico&nbsp;<span class=\"hps\">Cabo</span> <span class=\"hps\">San</span> <span class=\"hps\">Lucas</span> &nbsp;<span class=\"hps\">de productores&nbsp;</span><span class=\"hps\">tiene una incre&iacute;ble</span> <span class=\"hps\">variedad de</span> <span class=\"hps\">productos frescos</span><span>, mariscos</span><span>, pollo</span><span>, huevos</span><span>, quesos</span><span>,</span> <span class=\"hps\">hierbas y frutas</span><span>, junto</span> <span class=\"hps\">con una selecci&oacute;n de</span> <span class=\"hps\">comidas preparadas.</span> <span class=\"hps\">Es</span> <span class=\"hps\">un lugar muy animado</span> <span class=\"hps\">los mi&eacute;rcoles y</span> <span class=\"hps\">s&aacute;bados por la ma&ntilde;ana</span> <span class=\"hps\">desde las 8 am</span> <span class=\"hps\">hasta el mediod&iacute;a</span><span>,</span> <span class=\"hps\">todo el a&ntilde;o,</span> <span class=\"hps\">donde podr&aacute;</span> <span class=\"hps\">reunirse con los amigos</span><span>, comprar</span> <span class=\"hps\">los mejores alimentos</span> <span class=\"hps\">org&aacute;nicos</span><span>,</span> <span class=\"hps\">y hacer</span> <span class=\"hps\">sus citas</span> <span class=\"hps\">para la pr&oacute;xima semana</span> <span class=\"hps\">por los diferentes servicios</span><span>.</span></span></p>\n","","","0","0","0","Y","1371223922","0","0","0","0","0","0","0","0","0","0","0","0","0","","0000-00-00","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","","","0","","0","0","0","","");
INSERT INTO kcp_general_events VALUES("12","0","Organic Market Pedregal","Mercado Organico en Pedregal","Organic market from local producers in Pedregal","Mercado Orgánico de productores\nen Pedregal","2013-06-29 07:30:00","AM","2013-06-29 13:00:00","PM","1","4","37","13","<h1>\n	Organic Farmers Market</h1>\n<h2>\n	<strong>Cabo San Lucas, Los Cabos, Baja California Sur, Mexico</strong></h2>\n<p>\n	What you eat can affect how your body functions. To maintain optimal nutrition, a variety of healthy food from all food groups and healthy eating habits can keep you on the road to better health. Food, one of life&rsquo;s great pleasures, is the foundation to a healthy lifestyle.</p>\n<p>\n	The Cabo San Lucas Organic Farmer&rsquo;s Market has an amazing variety of fresh produce, seafood, organic chicken, eggs, cheeses, herbs and fruits, along with a selection of prepared foods. It&rsquo;s a happening place on<strong>&nbsp;Wednesday and Saturday mornings from 8 a.m. to noon, all year long</strong>, where you can meet up with friends, shop for the best organic foods, and make your appointments for the coming week for the various services.</p>\n","<p>\n	<span id=\"result_box\" lang=\"es\" tabindex=\"-1\"><span class=\"hps alt-edited\">Mercado Org&aacute;nico</span><span class=\"hps alt-edited\">&nbsp;de productores</span><br />\n	<span class=\"hps\">Cabo</span> <span class=\"hps\">San</span> <span class=\"hps\">Lucas</span><span>, Los</span> <span class=\"hps\">Cabos,</span> <span class=\"hps\">Baja</span> <span class=\"hps\">California Sur,</span> <span class=\"hps\">M&eacute;xico</span><br />\n	<br />\n	<span class=\"hps\">Lo que usted come</span> <span class=\"hps\">puede afectar</span> <span class=\"hps\">la forma en</span> <span class=\"hps\">que funciona su cuerpo</span><span>.</span> <span class=\"hps\">Para mantener</span> <span class=\"hps\">una nutrici&oacute;n &oacute;ptima</span><span>, una variedad de</span> <span class=\"hps\">alimentos saludables</span> <span class=\"hps\">de todos los</span> <span class=\"hps\">grupos de alimentos</span> <span class=\"hps\">y los h&aacute;bitos</span> <span class=\"hps\">saludables de alimentaci&oacute;n</span><span class=\"hps\">&nbsp;puede</span>&nbsp;ser<span class=\"hps\">&nbsp;el camino hacia</span> <span class=\"hps\">una mejor salud.</span> <span class=\"hps\">La comida,</span> <span class=\"hps\">uno de los grandes</span> <span class=\"hps\">placeres de la vida</span><span>,</span> <span class=\"hps\">es la base para</span> <span class=\"hps\">una vida sana</span><span>.</span><br />\n	<br />\n	<span class=\"hps\"><span class=\"hps\">El&nbsp;</span>Mercado</span> Org&aacute;nico&nbsp;<span class=\"hps\">Cabo</span> <span class=\"hps\">San</span> <span class=\"hps\">Lucas</span> &nbsp;<span class=\"hps\">de productores&nbsp;</span><span class=\"hps\">tiene una incre&iacute;ble</span> <span class=\"hps\">variedad de</span> <span class=\"hps\">productos frescos</span><span>, mariscos</span><span>, pollo</span><span>, huevos</span><span>, quesos</span><span>,</span> <span class=\"hps\">hierbas y frutas</span><span>, junto</span> <span class=\"hps\">con una selecci&oacute;n de</span> <span class=\"hps\">comidas preparadas.</span> <span class=\"hps\">Es</span> <span class=\"hps\">un lugar muy animado</span> <span class=\"hps\">los mi&eacute;rcoles y</span> <span class=\"hps\">s&aacute;bados por la ma&ntilde;ana</span> <span class=\"hps\">desde las 8 am</span> <span class=\"hps\">hasta el mediod&iacute;a</span><span>,</span> <span class=\"hps\">todo el a&ntilde;o,</span> <span class=\"hps\">donde podr&aacute;</span> <span class=\"hps\">reunirse con los amigos</span><span>, comprar</span> <span class=\"hps\">los mejores alimentos</span> <span class=\"hps\">org&aacute;nicos</span><span>,</span> <span class=\"hps\">y hacer</span> <span class=\"hps\">sus citas</span> <span class=\"hps\">para la pr&oacute;xima semana</span> <span class=\"hps\">por los diferentes servicios</span><span>.</span></span></p>\n","","","0","1","0","Y","1371224020","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-10","Weekly","1","","","0","0","1","0","0","1","0","0000-00-00","0000-00-00","07:00 AM","01:00 PM","0","","0","0","0","","publish");
INSERT INTO kcp_general_events VALUES("14","2","Organic Market Pedregal","Mercado Organico en Pedregal","","","2013-06-22 08:00:00","AM","2013-06-22 12:00:00","PM","1","0","0","0","<h1>\n	Organic Farmers Market</h1>\n<h2>\n	<strong>Cabo San Lucas, Los Cabos, Baja California Sur, Mexico</strong></h2>\n<p>\n	What you eat can affect how your body functions. To maintain optimal nutrition, a variety of healthy food from all food groups and healthy eating habits can keep you on the road to better health. Food, one of life&rsquo;s great pleasures, is the foundation to a healthy lifestyle.</p>\n<p>\n	The Cabo San Lucas Organic Farmer&rsquo;s Market has an amazing variety of fresh produce, seafood, organic chicken, eggs, cheeses, herbs and fruits, along with a selection of prepared foods. It&rsquo;s a happening place on<strong>&nbsp;Wednesday and Saturday mornings from 8 a.m. to noon, all year long</strong>, where you can meet up with friends, shop for the best organic foods, and make your appointments for the coming week for the various services.</p>\n","<p>\n	<span id=\"result_box\" lang=\"es\" tabindex=\"-1\"><span class=\"hps alt-edited\">Mercado Org&aacute;nico</span><span class=\"hps alt-edited\">&nbsp;de productores</span><br />\n	<span class=\"hps\">Cabo</span> <span class=\"hps\">San</span> <span class=\"hps\">Lucas</span><span>, Los</span> <span class=\"hps\">Cabos,</span> <span class=\"hps\">Baja</span> <span class=\"hps\">California Sur,</span> <span class=\"hps\">M&eacute;xico</span><br />\n	<br />\n	<span class=\"hps\">Lo que usted come</span> <span class=\"hps\">puede afectar</span> <span class=\"hps\">la forma en</span> <span class=\"hps\">que funciona su cuerpo</span><span>.</span> <span class=\"hps\">Para mantener</span> <span class=\"hps\">una nutrici&oacute;n &oacute;ptima</span><span>, una variedad de</span> <span class=\"hps\">alimentos saludables</span> <span class=\"hps\">de todos los</span> <span class=\"hps\">grupos de alimentos</span> <span class=\"hps\">y los h&aacute;bitos</span> <span class=\"hps\">saludables de alimentaci&oacute;n</span><span class=\"hps\">&nbsp;puede</span>&nbsp;ser<span class=\"hps\">&nbsp;el camino hacia</span> <span class=\"hps\">una mejor salud.</span> <span class=\"hps\">La comida,</span> <span class=\"hps\">uno de los grandes</span> <span class=\"hps\">placeres de la vida</span><span>,</span> <span class=\"hps\">es la base para</span> <span class=\"hps\">una vida sana</span><span>.</span><br />\n	<br />\n	<span class=\"hps\"><span class=\"hps\">El&nbsp;</span>Mercado</span> Org&aacute;nico&nbsp;<span class=\"hps\">Cabo</span> <span class=\"hps\">San</span> <span class=\"hps\">Lucas</span> &nbsp;<span class=\"hps\">de productores&nbsp;</span><span class=\"hps\">tiene una incre&iacute;ble</span> <span class=\"hps\">variedad de</span> <span class=\"hps\">productos frescos</span><span>, mariscos</span><span>, pollo</span><span>, huevos</span><span>, quesos</span><span>,</span> <span class=\"hps\">hierbas y frutas</span><span>, junto</span> <span class=\"hps\">con una selecci&oacute;n de</span> <span class=\"hps\">comidas preparadas.</span> <span class=\"hps\">Es</span> <span class=\"hps\">un lugar muy animado</span> <span class=\"hps\">los mi&eacute;rcoles y</span> <span class=\"hps\">s&aacute;bados por la ma&ntilde;ana</span> <span class=\"hps\">desde las 8 am</span> <span class=\"hps\">hasta el mediod&iacute;a</span><span>,</span> <span class=\"hps\">todo el a&ntilde;o,</span> <span class=\"hps\">donde podr&aacute;</span> <span class=\"hps\">reunirse con los amigos</span><span>, comprar</span> <span class=\"hps\">los mejores alimentos</span> <span class=\"hps\">org&aacute;nicos</span><span>,</span> <span class=\"hps\">y hacer</span> <span class=\"hps\">sus citas</span> <span class=\"hps\">para la pr&oacute;xima semana</span> <span class=\"hps\">por los diferentes servicios</span><span>.</span></span></p>\n","","","0","0","0","Y","1371224242","0","0","0","0","0","0","0","0","0","0","0","0","0","","0000-00-00","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","","","0","","0","0","0","","");
INSERT INTO kcp_general_events VALUES("16","1","CICLOVÍA 3rd ANNIVERSARY ","CICLOVÍA 3ER Aniversario","","","2013-06-30 07:00:00","AM","2013-06-30 11:00:00","AM","1","4","37","17","<p>\n	Sunday morning with Amigos de Cabo San Lucas.<br />\n	The main drag is closed to vehicle traffic, great opportunity to exercise and mingle with local families... Bicycle, walk, skate, pet walk, sometimes even music, aerobics, zumba, spinning</p>\n<p>\n	Join the fun with 3 different races for all levels and conditions:</p>\n<ul>\n	<li>\n		<span class=\"st\">Perrot&oacute;n - a 2.5 km walk with your dog - Inscription MXP100</span></li>\n	<li>\n		Fun run - 5 km&nbsp;Inscription MXP150</li>\n	<li>\n		The pros - 15 km Inscription MXP250</li>\n</ul>\n<p>\n	<a href=\"mailto:amigosdecabosanlucas@gmail.com\">amigosdecabosanlucas@gmail.com</a></p>\n","<p>\n	Preparan celebraci&oacute;n del tercer aniversario de inicio de la ciclov&iacute;a, cuyo proyecto se ha venido desarrollando exitosamente con la participaci&oacute;n cada vez mayor de m&aacute;s familias sanluque&ntilde;as e invitados.<br />\n	<br />\n	Mario Meave invita a la ciudadan&iacute;a a la ciclov&iacute;a, para juntos celebrar el tercer aniversario, el jueves 30 de junio 2013 en el par vial, para quienes desconozcan el lugar, es por Boulevard L&aacute;zaro C&aacute;rdenas, todos los domingos, de 7:00 a.m. a 11:00 a.m.</p>\n<p>\n	<span id=\"result_box\" lang=\"es\" tabindex=\"-1\"><span class=\"hps\">Participa a la diversi&oacute;n</span> <span class=\"hps\">con 3</span> <span class=\"hps alt-edited\">carreras</span> <span class=\"hps\">diferentes para</span> <span class=\"hps\">todos los niveles</span> <span class=\"hps\">y condiciones:</span><br />\n	<br />\n	<span class=\"hps\">Perroton</span> <span class=\"hps\">-</span> <span class=\"hps\">un</span> <span class=\"hps\">2,5 kilometros</span> <span class=\"hps\">a pie</span> <span class=\"hps\">con su perro</span> <span class=\"hps\">- Inscripci&oacute;n</span> <span class=\"hps\">MXP100</span><br />\n	<span class=\"hps alt-edited\">Carrera recreativa</span> &nbsp;<span class=\"hps\">- 5 km</span> <span class=\"hps\">inscripci&oacute;n</span> <span class=\"hps\">MXP150</span><br />\n	<span class=\"hps\">Los</span> <span class=\"hps\">pros</span> <span class=\"hps\">-</span> <span class=\"hps\">15 kilometros</span> <span class=\"hps\">Inscripci&oacute;n</span> <span class=\"hps\">MXP250</span></span><br />\n	<br />\n	Record&oacute; ser un programa sin autos para las familias, a donde pueden acudir con bicicletas, patines y mascotas, para que juntos poder disfrutar de este divertido y ejercitado paseo bajo la Direcci&oacute;n del Club Cactus Bike.<br />\n	<br />\n	Mario Meave, mencion&oacute; que este proyecto se concret&oacute; gracias a Club Cactus Bike y Amigos de Cabo San Lucas A.C., cuyo programa fue proyectado pensando en el bienestar de las familias de esta ciudad para que hagan ejercicio y al mismo tiempo estar ayudando a la convivencia familiar.<br />\n	<br />\n	Para ello, habr&aacute; festival de arte en la Plaza Amelia Wilkes, &quot;reviviendo lo nuestro del segundo aniversario&quot;, con exhibici&oacute;n y venta gastron&oacute;mica de algunos restaurantes del centro de Cabo San Lucas, evento cultural, m&uacute;sica en vivo, en s&iacute;, diversi&oacute;n familiar.<br />\n	<br />\n	Record&oacute; que como forman parte de la campa&ntilde;a Imagina Los Cabos que dirige la direcci&oacute;n de Imagen Urbana y el Consejo Coordinador, invitan igualmente a sumarse a las labores de limpia de playas, de calles, a la campa&ntilde;a antigraffiti, todo por una buena imagen ante el turista y de todos los que vivimos en Los Cabos, as&iacute; como se han sumado al comit&eacute; del carnaval para el 2014.<br />\n	<br />\n	Finalmente, coment&oacute; Mario Meave que se da continuidad al programa de apoyo a la ni&ntilde;ez sana, para que no sea explotada, para ello han implementando carteles donde se dice &quot;no compres, no regales dinero a los ni&ntilde;os ambulantes, en la marina y playa es por su bien son nuestros futuros ciudadanos&quot;.&nbsp;</p>\n","","13723762243ro aniversario ciclovia.jpg","0","0","0","Y","1371237085","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-10","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","12:00 AM","12:00 AM","0","","0","0","0","","publish");
INSERT INTO kcp_general_events VALUES("17","2","Fete de la musique","Fiesta de la Música","","","2013-06-21 16:00:00","PM","2013-06-22 01:00:00","AM","1","4","36","7","<p>\n	<span id=\"result_box\" lang=\"en\" tabindex=\"-1\"><span title=\"El próximo 21 de junio se llevará a cabo la quinta edición de la “Fiesta de la Música” en San José del Cabo, a partir de las 16:00 hrs.\">The next June 21 will be held the fifth edition of the &quot;Festival of Music&quot; in San Jose del Cabo, from 16:00 hrs. </span><span title=\"en las calles del centro histórico.\">on the streets of the historic center. </span><span title=\"Este es un evento internacional que nació en Francia en 1982 para festejar la música y así rendir homenaje a todos los estilos musicales.\">This is an international event that was born in France in 1982 to celebrate the music and so pay tribute to all musical styles.</span><br />\n	<br />\n	The Association Civil&nbsp;Cultural Promotion Vivarte, through organizing committee invites the largest musical celebration of the world in the centro historico with 15 stage sets, with local groups and singers.</span><br />\n	&nbsp;</p>\n<p>\n	<span lang=\"en\" tabindex=\"-1\">The scenario VIVARTE fill your program with &nbsp;musicians representative of the&nbsp;regional talent such as:<br />\n	<br />\n	<span title=\"Totoy, Divier Guive, Los Shamanes y Black Maria, además contará con la participación especial de la compañía de espectáculos ˝Rouge˝ y la presentación estelar de Mexican Dubweiser.\">Totoy, Divier Guiver, Shamans and Black Maria, and will feature special entertainment company &Euml;� &Euml;� Rouge and Dubweiser Mexican stellar presentation.</span><br />\n	<span title=\"También se podrá apreciar la presencia de, Les Heritiers de Manden, Acoustic-Paradoxx, Dz-Karga, Judas\'klan, Summertime Blues Band, Antares Guereña, Armando d\' Anna, Art de Garrrid, Bahia Beat, Baja Rhythm Band, Brian Flynn\">We will also appreciate the presence of, Les Heritiers of Manden, Acoustic-Paradoxx, Dz-Karga, Judas&#39;klan, Summertime Blues Band, Antares Guere&ntilde;a, Armando d &#39;Anna, Art Garrrid, Bahia Beat, Lower Rhythm Band, Brian Flynn </span><span title=\"Band, Cábula, Cambio de Corazón, Cats, Chaosspell, Charlene Mignault, Colectivo Urbano, Dinna Overlock, Djavu, Drop The Bass, Francisco Gabriel García, Hugo Moreno, Javier Jaxhet Sigala, Jeanette, Jhonny Rockstar, José Ramón, Karma Rush, Katarsys\">Band, c&aacute;bula, Change of Heart, Cats, Chaosspell, Charlene Mignault, Urban Collective, Dinna Overlock, Djavu, Drop The Bass, Francisco Gabriel Garcia, Hugo Moreno, Javier Jaxhet Sigala, Jeanette, Johnny Rockstar, Jos&eacute; Ram&oacute;n, Karma Rush, Katarsys </span><span title=\", Kethe Salceda, La Cruz, Los Chales de la Tía, Lunacustica, Mistica Vibración, Nidia Barajas, Panihari, Percubeta, Percusion Limanya, Ro &amp; Rockdriguez Band, Señor Gordo, Syncopated, The Blacksowords, Tim Mullen, Tops Cats, James Brooking,\">, Kethe Salceda, The Cross, The Aunt Shawls, Lunacustica, Mystic Vibration, Nidia Barajas, Panihari, Percubeta, Percussion Limanya, Ro &amp; Rockdriguez Band, Mr. Gordo, Syncopated, The Blacksowords, Tim Mullen, Tops Cats, James Brooking, </span><span title=\"Lizzie Moran, Bong the Bong´s, Vyk Pichardo, Distorzion, Victor Caballero, Pollo Galo, Rodrigo, Richard O, Disco Diablo, Eduardo P, Lucky M + Franz, Extra-Large, y Grupo Tropical Cielo Azul, Adicción Norteña, Los\">Lizzie Moran, the Bong Bong&#39;s, Vyk Pichardo, Distorzion, Victor Knight, Chicken Gallus, Rodrigo, Richard O, Disco Devil, Edward P, Lucky M + Franz, Extra-Large, and Tropical Blue Sky Group, Northern Addiction, The </span><span title=\"Auténticos y más.\">Authentic and more.</span><br />\n	<span title=\"El festival dará inicio a partir de las 16:00 hrs concluyendo a las 01:00 hrs.\">The festival will start from 16:00 hrs until at 01:00 hrs. </span><span title=\"del siguiente día.\">the next day.</span><br />\n	<br />\n	<span title=\"La circulación vehicular de las calles del primer cuadro de la zona centro permanecerá cerrada a partir de las 10:00 hrs.\">The streets of the historic center will be closed to traffic from 10:00 hrs. </span><span title=\"y se abrirá después de que el evento se dé por concluido alrededor de las 01:00hrs.\">and will be opened after the event is terminated by around 01:00 hrs.</span><br />\n	<br />\n	<span title=\"El montaje del escenario Plaza Mijares y locaciones aledañas se realizará desde el día anterior ya lo largo del día del evento, tanto en la Plaza Mijares como en diferentes zonas del área Centro.\">The stage set Mijares Square and surrounding locations will be from the day before and throughout the day of the event, in the Plaza Mijares and in different areas of the center area.</span><br />\n	<br />\n	<span title=\"Si eres músico, te puedes inscribir organizando tu propio escenario y registrarlo con VIVARTE, o si no tienes escenario contacta al comité organizador y te asignarán un espacio en un escenario.\">If you are a musician, you can register by organizing your own stage and record with VIVARTE, or if you do not contact the organizing committee stage and you will be assigned a space on stage. </span><span title=\"Para los empresarios que gusten colaborar y enriquecer este festival, hay dos opciones de participación: organizando su escenario con sus músicos y enviar la información al comité o bien solicitando un espacio en coordinación con el comité para crear un programa.\">For business owners who want to collaborate and enrich the festival, there are two options for participation: organizing your stage with musicians and send the information to the committee or by requesting a space in coordination with the committee to create a program. </span><span title=\"Para mayores informes se pueden contactar al email, fiestadelamusicaloscabos@gmail.com\">For more information you can contact the email, fiestadelamusicaloscabos@gmail.com</span><br />\n	<br />\n	<br />\n	<br />\n	<span title=\"Más información\">More information</span><br />\n	<br />\n	<span title=\"http://www.fiestadelamusicaloscabos.com/\">http://www.fiestadelamusicaloscabos.com/</span><br />\n	<span title=\"http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/\">http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/</span></span></p>\n","<p>\n	El pr&oacute;ximo 21 de junio se llevar&aacute; a cabo la quinta edici&oacute;n de la &ldquo;Fiesta de la M&uacute;sica&rdquo; en San Jos&eacute; del Cabo, a partir de las 16:00 hrs. en las calles del centro hist&oacute;rico. Este es un evento internacional que naci&oacute; en Francia en 1982 para festejar la m&uacute;sica y as&iacute; rendir homenaje a todos los estilos musicales.</p>\n<p>\n	&nbsp;</p>\n<p>\n	La Asociaci&oacute;n Civil Promotora Cultural Vivarte, a trav&eacute;s del comit&eacute; organizador invita a la celebraci&oacute;n musical m&aacute;s grande del mundo, en el primer cuadro de la zona centro donde se distribuir&aacute;n 15 escenarios, contando con agrupaciones y cantantes de la localidad.</p>\n<p>\n	El escenario VIVARTE llenar&aacute; su programa con la propuesta de m&uacute;sicos representativos del talento regional como:</p>\n<ul>\n	<li>\n		<strong>Totoy, Divier Guive, Los Shamanes</strong> y <strong>Black Maria</strong>, adem&aacute;s contar&aacute; con la participaci&oacute;n especial de la compa&ntilde;&iacute;a de espect&aacute;culos &Euml;�Rouge&Euml;� y la presentaci&oacute;n estelar de <strong>Mexican Dubweiser</strong>.</li>\n	<li>\n		Tambi&eacute;n se podr&aacute; apreciar la presencia de, <strong>Les Heritiers de Manden, Acoustic-Paradoxx, Dz-Karga, Judas&rsquo;klan, Summertime Blues Band, Antares Guere&ntilde;a, Armando d&rsquo; Anna, Art de Garrrid, Bahia Beat, Baja Rhythm Band, Brian Flynn Band, C&aacute;bula, Cambio de Coraz&oacute;n, Cats, Chaosspell, Charlene Mignault, Colectivo Urbano, Dinna Overlock, Djavu, Drop The Bass, Francisco Gabriel Garc&iacute;a, Hugo Moreno, Javier Jaxhet Sigala, Jeanette, Jhonny Rockstar, Jos&eacute; Ram&oacute;n, Karma Rush, Katarsys, Kethe Salceda, La Cruz, Los Chales de la T&iacute;a, Lunacustica, Mistica Vibraci&oacute;n, Nidia Barajas, Panihari, Percubeta, Percusion Limanya, Ro &amp; Rockdriguez Band, Se&ntilde;or Gordo, Syncopated, The Blacksowords, Tim Mullen, Tops Cats, James Brooking, Lizzie Moran, Bong the Bong&acute;s, Vyk Pichardo, Distorzion, Victor Caballero, Pollo Galo, Rodrigo, Richard O, Disco Diablo, Eduardo P, Lucky M + Franz, Extra-Large, y Grupo Tropical Cielo Azul, Adicci&oacute;n Norte&ntilde;a, Los Aut&eacute;nticos</strong> y m&aacute;s.</li>\n</ul>\n<p>\n	El festival dar&aacute; inicio a partir de las 16:00 hrs concluyendo a las 01:00 hrs. del siguiente d&iacute;a.</p>\n<p>\n	La circulaci&oacute;n vehicular de las calles del primer cuadro de la zona centro permanecer&aacute; cerrada a partir de las 10:00 hrs. y se abrir&aacute; despu&eacute;s de que el evento se d&eacute; por concluido alrededor de las 01:00hrs.</p>\n<p>\n	El montaje del escenario Plaza Mijares y locaciones aleda&ntilde;as se realizar&aacute; desde el d&iacute;a anterior y a lo largo del d&iacute;a del evento, tanto en la Plaza Mijares como en diferentes zonas del &aacute;rea Centro.</p>\n<p>\n	Si eres m&uacute;sico, te puedes inscribir organizando tu propio escenario y registrarlo con VIVARTE, o si no tienes escenario contacta al comit&eacute; organizador y te asignar&aacute;n un espacio en un escenario. Para los empresarios que gusten colaborar y enriquecer este festival, hay dos opciones de participaci&oacute;n: organizando su escenario con sus m&uacute;sicos y enviar la informaci&oacute;n al comit&eacute; o bien solicitando un espacio en coordinaci&oacute;n con el comit&eacute; para crear un programa. Para mayores informes se pueden contactar al email, fiestadelamusicaloscabos@gmail.com</p>\n<p>\n	&nbsp;</p>\n<h2>\n	M&aacute;s informaci&oacute;n</h2>\n<p>\n	<a href=\"http://www.fiestadelamusicaloscabos.com/\" target=\"_blank\" title=\"Fiesta de la musica Los Cabos.com\">http://www.fiestadelamusicaloscabos.com/</a><br />\n	<a href=\"http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/\" target=\"_blank\" title=\"Fiesta de la musica Los Cabos.com\">http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/</a></p>\n","","1372378520SJD mercado organico1.jpg","1","0","0","Y","1371239012","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-12","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","12:00 AM","12:00 AM","0","","0","0","0","","draft");
INSERT INTO kcp_general_events VALUES("18","1","Cats – The musical","Cats – El musical","","","2013-08-24 17:00:00","PM","2013-08-24 19:00:00","PM","1","4","37","6","<div class=\"almost_half_cell\" id=\"gt-res-content\">\n	<div dir=\"ltr\" style=\"zoom:1\">\n		<span id=\"result_box\" lang=\"en\" tabindex=\"-1\"><span class=\"hps\">Henry</span> <span class=\"hps\">Lopez</span> <span class=\"hps\">Studio</span> <span class=\"hps\">presents</span>.<br />\n		<span class=\"hps\">JUNE</span>, <span class=\"hps\">Saturday 22</span> <span class=\"hps\">and</span> <span class=\"hps\">Sunday 23</span><br />\n		<span class=\"hps\">Functions</span><span>: 5:00</span> <span class=\"hps\">pm</span> <span class=\"hps\">and</span> <span class=\"hps\">8:00 pm</span> <span class=\"hps\">both days</span><br />\n		<span class=\"hps\">$ 150</span> <span class=\"hps\">p</span> <span class=\"hps\">/</span> <span class=\"hps\">p</span><span>,</span> <span class=\"hps\">general admission</span> <span class=\"hps\">Tel</span> <span class=\"hps\">/ Info</span> <span class=\"hps\">*</span> <span class=\"hps\">624</span> <span class=\"hps\">358-6111</span></span></div>\n</div>\n","<p>\n	Henry L&oacute;pez Studio presenta.<br />\n	JUNIO, S&aacute;bado 22 y Domingo 23<br />\n	Funciones: 5:00pm y 8:00pm los dos d&iacute;as<br />\n	$150 p/p , entrada general Tel/Info* 624 358-6111</p>\n","","","1","0","0","Y","1371240376","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-11","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","12:00 AM","12:00 AM","0","","0","0","0","","publish");
INSERT INTO kcp_general_events VALUES("20","2","Que Brujadas! ","Que Brujadas! ","","","2013-06-29 20:00:00","PM","2013-06-29 22:00:00","PM","1","4","36","1","<p>\n	The Theater Company Mascaras presents &quot;Que Brujadas!&quot;&nbsp;</p>\n","<p>\n	<span class=\"Head\">La Compa&ntilde;&iacute;a de Teatro Mascaras presenta la obra &quot;Que Brujadas!&quot;&nbsp;</span></p>\n","","","0","0","0","Y","1371243867","0","0","0","0","0","0","0","0","0","0","0","0","0","","0000-00-00","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","","","0","","0","0","0","","");
INSERT INTO kcp_general_events VALUES("21","2","Exclusive evening with world-renowned CHEF JEAN GEORGES at MARKET Restaurant","Noche exclusiva con el famoso chef Jean-Georges en el restaurante Market","","","2013-06-21 19:00:00","PM","2013-06-21 22:00:00","PM","1","4","36","29","<p>\n	<strong>Chef Jean-Georges is Coming&hellip;</strong></p>\n<p>\n	Legendary restaurateur and Michelin-starred Chef Jean-Georges Vongerichten will be visiting One&amp;Only Palmilla in June and to mark the occasion, Sebastien Agnes, Market Executive Chef and his culinary team are so happy announce a unique culinary evening at Market Restaurant. The details are as follows:<br />\n	<strong>Place:</strong> Market Restaurant at the legendary One&amp;Only Palmilla<br />\n	<strong>Date:</strong> Friday June 21, 2013<br />\n	<br />\n	<strong>Time:</strong> 7:00 pm Cocktail Reception at the One&amp;Only Lounge<br />\n	8:00 pm Dinner at Market (one sitting only)<br />\n	<br />\n	<strong>Menu:</strong> A very special and unique 6 course menu specially prepared by Chef Jean-Georges<br />\n	<br />\n	<strong>Wines:</strong> Paired with wines from our exclusive Market wine Cellar by Ernesto Mendoza, Wine Director of One&amp;Only Palmilla<br />\n	<br />\n	<strong>Cost:</strong> 195.00 USD Plus tax and service charge<br />\n	<br />\n	<strong>Reservations:</strong> Limited Space. For reservations call Market Restaurant directly on 624-146-7000.<br />\n	<br />\n	<strong>Attire:</strong> Resort Elegant</p>\n<p>\n	<strong>Market Fine Dining Restaurant by Jean-Georges Vongerichten</strong></p>\n<p>\n	Chef Jean-Georges Vongerichten presents a unique dining concept in Market, his first outpost South of the Border. In understated elegance, Market features Euro-Asian cuisine with Mexican inspirations along with the country&rsquo;s most complete wine list.<br />\n	<br />\n	Designed with an understated elegance of warm natural colours and original artwork, Market brings to life Jean-Georges&#39; French roots with Asian influence to reflect his travels in the region and the freshness and variety of Mexico&rsquo;s rich culinary tradition and ingredients.<br />\n	<br />\n	Open for dinner daily, reservations suggested. Resort Elegant attire.</p>\n","<h2>\n	<span id=\"result_box\" lang=\"es\" tabindex=\"-1\"><span class=\"hps\">Chef</span> <span class=\"hps\">Jean</span><span>-Georges</span> <span class=\"hps\">est&aacute; viniendo</span> <span class=\"hps\">...</span></span></h2>\n<p>\n	<span lang=\"es\" tabindex=\"-1\"><span class=\"hps\">Restaurador</span> <span class=\"hps alt-edited\">legendario</span> <span class=\"hps\">y</span> <span class=\"hps alt-edited\">estrellado Michelin</span> <span class=\"hps\">Chef</span> <span class=\"hps\">Jean</span><span>-Georges</span> <span class=\"hps\">Vongerichten</span> <span class=\"hps alt-edited\">estar&aacute; visitando</span> <span class=\"hps\">One &amp; Only</span> <span class=\"hps\">Palmilla</span> <span class=\"hps\">en junio y</span> <span class=\"hps\">para celebrar</span> <span class=\"hps\">la ocasi&oacute;n,</span> <span class=\"hps\">Sebastien</span> <span class=\"hps\">Agnes</span><span>,</span> <span class=\"hps\">Market Chef</span> <span class=\"hps\">Ejecutivo y su</span> <span class=\"hps\">equipo culinario</span> <span class=\"hps\">son tan felices</span> <span class=\"hps\">anunciar</span> <span class=\"hps\">una velada</span> <span class=\"hps\">culinaria &uacute;nica</span> <span class=\"hps alt-edited\">en el Market</span> <span class=\"hps\">Restaurant.</span> <span class=\"hps\">Los detalles</span> <span class=\"hps\">son los siguientes</span><span>:</span><br />\n	<span class=\"hps\">Lugar</span><span>: Restaurante</span> <span class=\"hps alt-edited\">Market</span> <span class=\"hps\">en el legendario</span> <span class=\"hps\">One &amp; Only</span> <span class=\"hps\">Palmilla</span><br />\n	<span class=\"hps\">Fecha:</span> <span class=\"hps\">Viernes</span> <span class=\"hps\">21 de junio 2013</span><br />\n	<br />\n	<span class=\"hps\">Hora</span><span>: 7:00 pm</span> <span class=\"hps\">C&oacute;ctel de Bienvenida</span> <span class=\"hps\">en el One</span> <span class=\"hps\">&amp; Only</span> <span class=\"hps\">Lounge</span><br />\n	<span class=\"hps\">20:00</span> <span class=\"hps\">Cena en el</span> <span class=\"hps atn alt-edited\">Market (</span><span>&uacute;nicamente</span> <span class=\"hps\">una sola sesi&oacute;n</span><span>)</span><br />\n	<br />\n	<span class=\"hps\">Men&uacute;:</span> <span class=\"hps\">Un</span> <span class=\"hps\">men&uacute; muy</span> <span class=\"hps\">especial y &uacute;nico</span> <span class=\"hps\">de 6 platos</span> <span class=\"hps\">especialmente preparados</span> <span class=\"hps\">por el chef</span> <span class=\"hps\">Jean</span><span>-Georges</span><br />\n	<br />\n	<span class=\"hps\">Vinos</span><span>:</span> <span class=\"hps alt-edited\">Emparejados con</span> <span class=\"hps\">los vinos de</span> <span class=\"hps\">nuestra</span> <span class=\"hps\">exclusiva</span> <span class=\"hps\">bodega</span> <span class=\"hps\">de vinos</span> <span class=\"hps alt-edited\">Market</span> <span class=\"hps\">de Ernesto</span> <span class=\"hps\">Mendoza</span><span>, Director</span> <span class=\"hps\">de</span> <span class=\"hps\">Wine</span> <span class=\"hps\">One &amp; Only</span> <span class=\"hps\">Palmilla</span><br />\n	<br />\n	<span class=\"hps\">Costo:</span> <span class=\"hps\">195.00</span> <span class=\"hps\">USD</span> <span class=\"hps\">Plus</span> <span class=\"hps\">IVA y servicio</span><br />\n	<br />\n	<span class=\"hps\">Reservaciones:</span> <span class=\"hps\">espacio limitado.</span> <span class=\"hps\">Para reservaciones llame al</span> <span class=\"hps\">Market Restaurant</span> <span class=\"hps\">directamente en</span> <span class=\"hps\">624-146-7000</span><span>.</span></span><br />\n	<br />\n	<span lang=\"es\" tabindex=\"-1\">&nbsp;V</span>estimento:&nbsp;&nbsp;<span class=\"hps\">elegancia Resort</span><span>.</span></p>\n<p>\n	<img alt=\"Restaurant Market at One&amp;Only Palmilla\" src=\"/ckfinder/userfiles/images/One&amp;Only Palmilla-Market restaurant.jpg\" style=\"width: 320px; height:auto; float: right;\" /></p>\n<h2>\n	<span lang=\"es\" tabindex=\"-1\"><span class=\"hps alt-edited\">Market</span> <span class=\"hps\">Fine Dining</span> <span class=\"hps\">Restaurant by</span> <span class=\"hps\">Jean</span><span>-Georges</span> <span class=\"hps\">Vongerichten</span></span></h2>\n<p>\n	<span lang=\"es\" tabindex=\"-1\"><span class=\"hps\">Chef</span> <span class=\"hps\">Jean</span><span>-Georges</span> <span class=\"hps\">Vongerichten</span> <span class=\"hps\">presenta un</span> <span class=\"hps\">concepto de restauraci&oacute;n</span> <span class=\"hps\">&uacute;nico en el</span> <span class=\"hps\">mercado</span><span>, su primer</span> <span class=\"hps\">puesto de</span> <span class=\"hps\">sur de la frontera</span><span>.</span> <span class=\"hps\">En la</span> <span class=\"hps alt-edited\">discreta elegancia,</span><span class=\"alt-edited\"> Market</span> <span class=\"hps\">ofrece cocina</span> <span class=\"hps atn\">euro-</span><span>asi&aacute;tica con</span> <span class=\"hps\">inspiraciones</span> <span class=\"hps\">mexicanos</span><span>, junto con</span> <span class=\"hps alt-edited\">la carta de vinos</span> <span class=\"hps\">m&aacute;s completa</span> <span class=\"hps\">del pa&iacute;s.</span><br />\n	<br />\n	<span class=\"hps\">Dise&ntilde;ado con</span> <span class=\"hps alt-edited\">una elegancia minimisada</span> <span class=\"hps\">de los colores</span> <span class=\"hps\">c&aacute;lidos y naturales</span> <span class=\"hps\">y</span> <span class=\"hps\">obras de arte originales</span><span class=\"alt-edited\">, Market</span> <span class=\"hps\">da vida a</span> <span class=\"hps alt-edited\">las ra&iacute;ces francesas</span> <span class=\"hps alt-edited\">de Jean</span><span>-Georges</span> <span>con</span> <span class=\"hps\">influencia asi&aacute;tica</span> <span class=\"hps\">para reflejar</span> <span class=\"hps\">sus viajes por</span> <span class=\"hps\">la regi&oacute;n</span> <span class=\"hps\">y la frescura</span> <span class=\"hps\">y variedad de</span> <span class=\"hps\">rica tradici&oacute;n</span> <span class=\"hps\">y los ingredientes</span> <span class=\"hps\">culinarios</span> <span class=\"hps\">de</span> <span class=\"hps\">M&eacute;xico</span><span>.</span><br />\n	<br />\n	<span class=\"hps\">Abierto para la</span> <span class=\"hps\">cena todos los d&iacute;as</span><span>,</span> <span class=\"hps\">se sugiere reservar</span><span>.</span>&nbsp;V</span>estimento:&nbsp;&nbsp;<span class=\"hps\">elegancia Resort</span><span>.</span></p>\n","","1372376092Chef Jean-Georges.jpg","0","0","0","Y","1371491169","0","0","0","0","0","0","0","0","0","0","0","0","0","","0000-00-00","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","","","0","","0","0","0","","");
INSERT INTO kcp_general_events VALUES("23","1","Cine club documental SJD","Cine Club documentary SJD","","","2013-07-02 20:00:00","PM","2013-07-02 22:00:00","PM","1","4","36","31","<p>\n	<span id=\"result_box\" lang=\"en\" tabindex=\"-1\"><span class=\"hps\">Documentary</span> <span class=\"hps\">Film</span> <span class=\"hps\">Club</span><br />\n	<span class=\"hps\">Casa de Cultura</span> <span class=\"hps\">San</span> <span class=\"hps\">Jose del</span> <span class=\"hps\">Cabo</span><br />\n	<span class=\"hps alt-edited\">Every</span> <span class=\"hps\">Tuesday 20:00</span> <span class=\"hps\">Hours</span><br />\n	<span class=\"hps\">free admission</span></span></p>\n","<div>\n	<div>\n		<strong>Cine Club Documental</strong></div>\n</div>\n<div>\n	<div>\n		<strong>Casa de Cultura San Jos&eacute; del Cabo</strong></div>\n</div>\n<div>\n	<div>\n		<strong>Todos los M&aacute;rtes 20:00 Horas</strong></div>\n	<div>\n		<strong>Entrada libre</strong></div>\n</div>\n","","1372376154casa de la cultura SJD.jpg","0","1","0","Y","1371506572","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-09","Weekly","1","","","0","1","0","0","0","0","0","0000-00-00","0000-00-00","08:00 PM","10:00 PM","0","","0","0","0","","publish");
INSERT INTO kcp_general_events VALUES("24","2","Cine Club Pabelon cultural","Cine Club Pabelon cultural","","","2013-08-15 19:30:00","PM","2013-08-31 21:30:00","PM","1","4","37","6","<p>\n	<span id=\"result_box\" lang=\"en\" tabindex=\"-1\"><span class=\"hps\">Every Thursday</span> <span class=\"hps\">at 7:30</span> <span class=\"hps\">pm</span><span>, join</span>&nbsp;the&nbsp;<span class=\"hps alt-edited\">cinephiles</span> <span class=\"hps\">of Los</span> <span class=\"hps\">Cabos.</span></span></p>\n","<p>\n	<span class=\"fbLongBlurb\">Todos los jueves a las 7:30 pm, se juntan los cin&eacute;filos de Los Cabos.</span></p>\n","","","0","1","0","Y","1371508077","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-11","Daily","1","Last","Monday","0","0","0","0","0","0","0","2013-08-15","2013-08-31","07:30 PM","09:30 PM","0","","0","0","0","","publish");
INSERT INTO kcp_general_events VALUES("28","2","test","testsp","","","2013-06-30 07:00:00","PM","2013-06-30 09:00:00","PM","1","0","0","0","","","","","0","0","0","Y","1371618107","0","0","0","0","0","0","0","0","0","0","0","0","0","","0000-00-00","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","","","0","","0","0","0","","");
INSERT INTO kcp_general_events VALUES("31","2","Elba Esther no era guerrera, era ratera","Elba Esther no era guerrera, era ratera","","","2013-07-17 19:00:00","PM","2013-07-17 21:00:00","PM","1","4","37","6","<p>\n	<span id=\"result_box\" lang=\"en\" tabindex=\"-1\"><span class=\"hps\">During</span> <span class=\"hps alt-edited\">the trajectory of</span> <span class=\"hps\">one of the</span> comedians&nbsp;<span class=\"hps\">most beloved</span>&nbsp;<span class=\"hps\">by the public</span>, <span class=\"hps\">ALBERTO</span> <span class=\"hps\">ROJAS</span> <span class=\"hps atn\">&quot;</span>The Horse&quot;, <span class=\"hps\">has</span> <span class=\"hps\">shown</span> <span class=\"hps\">countless&nbsp;</span>&nbsp;<span id=\"result_box\" lang=\"en\" tabindex=\"-1\"><span class=\"hps alt-edited\">performances</span></span>&nbsp;<span class=\"hps\">as is</span> <span class=\"hps\">tradition</span>, this time <span class=\"hps\">addressing the</span> <span class=\"hps\">political issues</span> <span class=\"hps\">of the moment,</span> <span class=\"hps\">now</span> <span class=\"hps\">brings</span> <span class=\"hps\">us</span> <span class=\"hps\">his latest</span> <span class=\"hps alt-edited\">staging,</span> <span class=\"hps\">written</span> <span class=\"hps\">some time</span> <span class=\"hps\">ago</span>, <span class=\"hps\">but given the</span> <span class=\"hps\">most recent developments</span> <span class=\"hps\">on this topic</span> <span class=\"hps\">rewrites</span> <span class=\"hps\">and updates</span> <span class=\"hps\">the</span> <span class=\"hps\">resulting</span>&nbsp;in the current&nbsp;<span class=\"hps\">staging</span>: <span class=\"hps\">ELBA</span> <span class=\"hps\">ESTHER</span><span>,</span> <span class=\"hps\">NO</span> <span class=\"hps\">ERA</span> <span class=\"hps\">wARRIOR</span>, <span class=\"hps\">ERA</span> <span class=\"hps\">...</span> <span class=\"hps\">which</span> <span class=\"hps\">we are sure</span> <span class=\"hps\">will meet</span> <span class=\"hps\">full</span> <span class=\"hps\">of</span> <span class=\"hps alt-edited\">appreciation the</span> <span class=\"hps\">Mexican public</span> <span class=\"hps\">to which</span> <span class=\"hps\">we guarantee</span> <span class=\"hps\">more than</span> <span class=\"hps\">90 minutes</span> <span class=\"hps\">of laughter</span> <span class=\"hps\">and</span> <span class=\"hps\">fun</span> <span class=\"hps\">for</span> <span class=\"hps\">the whole family</span></span></p>\n","<p>\n	Durante la trayectoria de uno de los comediantes mas queridos por el publico, ALBERTO ROJAS&nbsp; &ldquo;El Caballo&rdquo;, ha representado un sin fin de espect&aacute;culos como ya es tradicion, en esta ocasi&oacute;n aborda los temas pol&iacute;ticos del momento, ahora trae para nosotros su mas reciente puesta en escena, escrita ya hace algun tiempo, pero dados los acontecimientos mas recientes sobre este tema la reescribe y actualiza dando como resultado la puesta en escena:&nbsp;<strong id=\"yui_3_7_2_1_1363113497014_4930\"><em id=\"yui_3_7_2_1_1363113497014_4929\">ELBA ESTHER, NO ERA GUERRERA, ERA&hellip;</em></strong>,&nbsp;la cual estamos seguros sera del completo agrado del publico mexicano al cual le garantizamos mas de 90 minutos de carcajadas y diversion en compa&ntilde;ia de toda la familia&nbsp;</p>\n","","1372377912Elba Esther ratera.jpg","0","0","0","Y","1371685853","0","0","0","0","0","0","0","0","0","0","0","0","0","","0000-00-00","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","","","0","","0","0","0","","");
INSERT INTO kcp_general_events VALUES("34","2","Retreat with Dharmesh Anand","Retiro con Dharmesh Anand","","","2013-06-29 07:00:00","AM","2013-06-30 17:00:00","PM","1","4","36","32","<h2>\n	Discover the silence of your heart</h2>\n<p>\n	<span id=\"result_box\" lang=\"en\" tabindex=\"-1\"><span class=\"hps\">From the</span> <span class=\"hps\">tenderness</span> <span class=\"hps\">and compassion</span> <span class=\"hps\">of an open heart</span> <span class=\"hps\">and anchored</span> <span class=\"hps\">in the present,</span> <span class=\"hps\">Dharmesh</span> <span class=\"hps\">Anand</span> <span class=\"hps\">shares with us a</span> <span class=\"hps\">simple and profound</span> <span class=\"hps\">message</span> <span class=\"hps\">that</span> <span class=\"hps\">can radically change</span> <span class=\"hps\">your life</span>. <span class=\"hps\">He</span> <span class=\"hps\">talks about</span> <span class=\"hps\">our ability to be</span> <span class=\"hps\">happy in any</span> <span class=\"hps\">circumstance</span>, and invites us to <span class=\"hps\">see</span> <span class=\"hps\">and realize that</span> <span class=\"hps\">happiness</span> <span class=\"hps\">is our natural state</span>, <span class=\"hps\">that life is</span> <span class=\"hps\">a mystery</span> <span class=\"hps\">to live</span>, not a <span class=\"hps\">problem to solve</span>. <span class=\"hps\">From</span> <span class=\"hps\">a totally</span> <span class=\"hps\">refreshing</span> <span class=\"hps\">and full of</span> <span class=\"hps\">sense of humor,</span> <span class=\"hps\">Dharmesh</span> <span class=\"hps\">gives us</span> <span class=\"hps\">the space to explore</span> <span class=\"hps\">all our</span> <span class=\"hps\">concerns and questions</span> <span class=\"hps\">with complete honesty</span>, <span class=\"hps\">contained</span> <span class=\"hps\">in love.</span> <span class=\"hps\">Dare</span> <span class=\"hps\">to live</span> <span class=\"hps\">this experience is</span> <span class=\"hps\">daring to</span> <span class=\"hps\">live your</span> <span class=\"hps\">life to the fullest</span> <span class=\"hps\">and discover the</span> <span class=\"hps\">blissful</span> <span class=\"hps\">peace</span> <span class=\"hps\">and freedom that</span> <span class=\"hps\">is available to you</span> <span class=\"hps\">at every moment.</span> <span class=\"hps\">Wake up to</span> <span class=\"hps\">this eternal</span> <span class=\"hps\">present moment.</span></span></p>\n","<h2 style=\"\">\n	Descubre el silencio de tu coraz&oacute;n</h2>\n<p style=\"\">\n	Desde la dulzura y compasi&oacute;n de un coraz&oacute;n abierto y anclado en el presente, <a data-hovercard=\"/ajax/hovercard/user.php?id=656752815&amp;extragetparams=%7B%22directed_target_id%22%3A0%7D\" href=\"https://www.facebook.com/dharmesh.anand?directed_target_id=0\">Dharmesh Anand</a> nos comparte un mensaje tan sencillo y profundo que puede cambiar radicalmente tu vida. Nos habla de nuestra capacidad de ser felices en cualquier circunstancia, nos invita a ver y realizar que la dicha es nuestro estado natural, que la vida es un misterio que vivir y no un problema que resolver. De una manera totalmente refrescante y llena de sentido del humor, Dharmesh nos da el espacio para explorar todas nuestras inquietudes y dudas con total honestidad, contenidos en el amor. Atreverte a vivir esta experiencia es atreverte a vivir tu vida en plenitud y descubrir la dichosa paz y la libertad que esta disponible para ti a cada instante. Despierta a este eterno momento presente.</p>\n<p style=\"\">\n	&nbsp;</p>\n","","","0","0","0","Y","1372058647","0","0","0","0","0","0","0","0","0","0","0","0","0","","0000-00-00","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","","","0","","0","0","0","","");
INSERT INTO kcp_general_events VALUES("35","1","Dorado International Fishing Tournament","Torneo Internacional de Pesca El Dorado","","","2013-07-01 17:00:00","PM","2013-07-02 22:00:00","PM","1","3","33","20","<p align=\"center\">\n	<strong>LORETO DORADO TOURNAMENT</strong></p>\n<p align=\"center\">\n	<strong>June 30 - July 2 2013</strong></p>\n<p>\n	&nbsp;</p>\n<p>\n	Tournament headquarters will again be the grand Oasis Hotel which did a great job. The two day Tournament last July was a huge success. Beautiful Loreto is the site of this long-time Vag Tournament that usually captures during this time frame the largest dorado in the season for the June-July period.</p>\n<p>\n	<br />\n	Registration and orientation will be on Sunday, June 30, 5 p.m. at the Oasis. Rules will be available then. There will be raffles and great prizes. The Awards Banquet will be on Tuesday evening. This is a fun Tournament in which family participation is encouraged. The fish weigh in station will be at the Oasis at 2 p.m. for fish from Loreto, or 3 p.m. for those bringing fish in from Puerto Escondido/Juncalito. For those guys/ladies who are not fishing or not fishing every day, we would appreciate your help at the weigh in, registration, photos or other tasks. A super group of volunteers stepped up last time who made a real difference - <strong>Solveig Franklin, Jutta Barnett, Don and Karen Brown, and Bob Lane</strong>.</p>\n<p>\n	<br />\n	The Oasis is a premiere Loreto traditional hotel with quiet ocean front rooms, tropical gardens, many spacious areas for parking, and an acclaimed restaurant. For reservations you can contact them at -- toll free: U.S. - &nbsp;1-866-482-0247&nbsp;; Mexico - 613-135-0211; Fax - 613-135-0795. There will be special rates for rooms and for fishing. If you are interested in traveling down with a group or need a buddy on the road, check with Vag HQ or sign up on the Travel Buddies Calendar (TBC) at <a href=\"http://www.vagabundos.com/TBC.html\">http://www.vagabundos.com/TBC.html</a>. There are great reviews from members using the TBC.<br />\n	Call Vag HQ at &nbsp;800-474-2252&nbsp; to sign up and pay the fee. The registration fee is $120 per boat. If you pre-register at the office you will be entered into a special drawing. Proceeds will be donated to a local non-profit organization. Contact<strong>Coordinator Paulette Gochie </strong>at loretoplaya@gmail.com.&nbsp;</p>\n","<p>\n	<strong>Torneo de las Misiones</strong>, un Torneo de pesca de caridad que se dio inici&oacute; en 1993 y perdura con el tiempo, cada a&ntilde;o con mas competidores. <strong>Loreto Dorado International Fishing Tournament</strong>, es uno de los tornes internacionales de pesca m&aacute;s importantes de todo el estado en donde miles de participantes de diferentes partes del mundo viene en busca del trofeo m&aacute;s deseado que es el dorado.</p>\n","","1372375871Vagabuno del mar DORADO TOURNAMENT POSTER.jpg","1","0","0","Y","1372094969","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-11","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","12:00 AM","12:00 AM","0","","0","0","0","","publish");
INSERT INTO kcp_general_events VALUES("36","2","Kundalini Meditation ","Meditacion activa kundalini","","","2013-06-28 19:00:00","PM","2013-06-28 20:30:00","PM","1","4","36","32","<p>\n	<span class=\"short_text\" id=\"result_box\" lang=\"en\" tabindex=\"-1\"><span class=\"hps\"><span style=\"font-family: Arial, sans-serif; line-height: 13px;\">Active kundalini m</span>editation</span></span><span style=\"font-family: Arial, sans-serif; line-height: 13px;\">&nbsp;with Dharmesh Anand&nbsp;</span><span class=\"hps\">open</span> <span class=\"hps\">to the public</span></p>\n","<p>\n	<span lang=\"ES\" style=\"font-size: 9pt; line-height: 115%; font-family: Arial, sans-serif; background-position: initial initial; background-repeat: initial initial;\">Meditaci&oacute;n activa kundalini&nbsp;con Dharmesh Anand&nbsp;abierta al p&uacute;blico&nbsp;</span></p>\n<p>\n	&nbsp;</p>\n","","1372096686Darmesh Anand program.jpg","0","0","0","Y","1372096519","0","0","0","0","0","0","0","0","0","0","0","0","0","","0000-00-00","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","","","0","","0","0","0","","");
INSERT INTO kcp_general_events VALUES("37","1","Mexican Film Festival","Muestra de Cine Mexicano","","","2013-06-28 19:30:00","PM","2013-06-28 21:30:00","PM","1","4","37","33","","<p>\n	1a. Muestra de Cine Mexicano Los Cabos</p>\n<p>\n	PROGRAMA</p>\n<p>\n	<span style=\"text-decoration: underline;\">Viernes 28 de junio</span></p>\n<p>\n	INAUGURACI&Oacute;N</p>\n<p>\n	7:30 P.M. Pel&iacute;cula &quot;La ley de Herodes&quot;, con la presencia de Dami&aacute;n Alc&aacute;zar.</p>\n<p>\n	BAJA CANTINA PLAYA- $100 (incluye coctel de bienvenida).</p>\n","","13721030131er muestra cine MX Los Cabos.jpg","0","0","0","Y","1372103246","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-10","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","12:00 AM","12:00 AM","0","","0","0","0","","publish");
INSERT INTO kcp_general_events VALUES("38","1","1st festival of Mexican cinema","1a. Muestra de Cine Mexicano Los Cabos","","","2013-06-29 17:00:00","PM","2013-06-30 19:00:00","PM","1","4","37","6","","<p>\n	<span style=\"text-decoration: underline;\">S&aacute;bado 29 de junio</span></p>\n<p>\n	5:00 P.M. Cortometraje &quot;Hugol&quot;. Dir. Emilio Portes</p>\n<p>\n	6:00 P.M. Documental &quot;Cuates de Australia&quot; Dir. Everardo Gonz&aacute;lez.</p>\n<p>\n	Sesi&oacute;n de preguntas con ambos directores.</p>\n<p>\n	PABELL&Oacute;N CULTURAL -Entrada libre</p>\n<p>\n	&nbsp;</p>\n<p>\n	<span style=\"text-decoration: underline;\">Domingo 30 de junio</span></p>\n<p>\n	5:00 PM. Cortometraje &quot;El otro Jos&eacute;&quot; Dir. Alejandro Guzm&aacute;n.</p>\n<p>\n	6:00 PM. Pel&iacute;cula &quot;El viol&iacute;n&quot; Dir. Francisco Vargas.</p>\n<p>\n	Sesi&oacute;n de preguntas con Alejandro Guzm&aacute;n.</p>\n<p>\n	CLAUSURA</p>\n","","13723755031er muestra cine MX Los Cabos.jpg","0","0","0","Y","1372103411","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-10","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","12:00 AM","12:00 AM","0","","0","0","0","","publish");
INSERT INTO kcp_general_events VALUES("40","2","Dance Gala Mexico","Gala de danza Mexico","","","2013-06-30 17:00:00","PM","2013-06-30 19:00:00","PM","1","0","0","0","<p>\n	&nbsp;</p>\n<h2>\n	American Ballet, Bolshoi Ballet, San Francisco Ballet and more</h2>\n<p>\n	<span class=\"eventGreyText\">International Guests artists from companies around the world. Sunday, June 30th, 5:00pm at Pabellon Cultural For tickets and info: Tel. (624) 151 5424 and (624) 188 3113</span></p>\n","<h2>\n	American Ballet, Bolshoi Ballet, San Francisco Ballet y m&aacute;s</h2>\n<p>\n	<span id=\"result_box\" lang=\"es\" tabindex=\"-1\"><span class=\"hps\">Artistas&nbsp;<span class=\"hps\">internacionales&nbsp;</span>Invitados</span>&nbsp;</span><span class=\"hps\">de</span> <span class=\"hps alt-edited\">compa&ntilde;&iacute;as alrededor</span> <span class=\"hps alt-edited\">del mundo</span>. <span class=\"hps\">Domingo, 30 de junio</span>, a las 5:00 <span class=\"hps\">pm en el</span> <span class=\"hps\">Pabell&oacute;n</span> <span class=\"hps\">Cultural</span> <span class=\"hps\">Para boletos</span> <span class=\"hps\">e informaci&oacute;n</span>: <span class=\"hps\">Tel</span>. <span class=\"hps\">(624) 151 5424</span> <span class=\"hps\">y</span> <span class=\"hps\">(624) 188 3113</span></p>\n","","","0","0","0","Y","1372109023","0","0","0","0","0","0","0","0","0","0","0","0","0","","0000-00-00","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","","","0","","0","0","0","","");
INSERT INTO kcp_general_events VALUES("41","1","Dance Gala Mexico","Gala de danza Mexico","","","2013-06-30 17:00:00","PM","2013-06-30 19:00:00","PM","1","4","37","6","<h2>\n	American Ballet, Bolshoi Ballet, San Francisco Ballet and more</h2>\n<p>\n	International Guests artists from companies around the world. Sunday, June 30th, 5:00pm at Pabellon Cultural For tickets and info: Tel. (624) 151 5424 and (624) 188 3113</p>\n","<h2>\n	<span class=\"Head\">American Ballet, Bolshoi Ballet, San Francisco Ballet y m&aacute;s !!!!</span></h2>\n<p>\n	Artistas&nbsp;<span class=\"hps\">internacionales i</span><span class=\"hps\">nvitados</span> <span class=\"hps\">de</span> <span class=\"hps alt-edited\">compa&ntilde;&iacute;as alrededor</span> <span class=\"hps alt-edited\">del mundo</span>. <span class=\"hps\">Domingo, 30 de junio</span><span>, a las 5:00</span> <span class=\"hps\">pm en el</span> <span class=\"hps\">Pabell&oacute;n</span> <span class=\"hps\">Cultural</span> <span class=\"hps\">Para boletos</span> <span class=\"hps\">e informaci&oacute;n</span>: <span class=\"hps\">Tel</span>. <span class=\"hps\">(624) 151 5424</span> <span class=\"hps\">y</span> <span class=\"hps\">(624) 188 3113</span></p>\n","","1372375459Gala danse CSL 06-30-2013.jpg","0","0","0","Y","1372109611","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-10","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","12:00 AM","12:00 AM","0","","0","0","0","","publish");
INSERT INTO kcp_general_events VALUES("42","2","Fete de la musique","Fiesta de la Música","","","2013-06-21 16:00:00","PM","2013-06-22 01:00:00","AM","1","4","36","0","<p>\n	<span id=\"result_box\" lang=\"en\" tabindex=\"-1\"><span title=\"El próximo 21 de junio se llevará a cabo la quinta edición de la “Fiesta de la Música” en San José del Cabo, a partir de las 16:00 hrs.\">The next June 21 will be held the fifth edition of the &quot;Festival of Music&quot; in San Jose del Cabo, from 16:00 hrs. </span><span title=\"en las calles del centro histórico.\">on the streets of the historic center. </span><span title=\"Este es un evento internacional que nació en Francia en 1982 para festejar la música y así rendir homenaje a todos los estilos musicales.\">This is an international event that was born in France in 1982 to celebrate the music and so pay tribute to all musical styles.</span><br />\n	<br />\n	The Association Civil&nbsp;Cultural Promotion Vivarte, through organizing committee invites the largest musical celebration of the world in the centro historico with 15 stage sets, with local groups and singers.</span><br />\n	&nbsp;</p>\n<p>\n	<span lang=\"en\" tabindex=\"-1\">The scenario VIVARTE fill your program with &nbsp;musicians representative of the&nbsp;regional talent such as:<br />\n	<br />\n	<span title=\"Totoy, Divier Guive, Los Shamanes y Black Maria, además contará con la participación especial de la compañía de espectáculos ˝Rouge˝ y la presentación estelar de Mexican Dubweiser.\">Totoy, Divier Guiver, Shamans and Black Maria, and will feature special entertainment company &Euml;� &Euml;� Rouge and Dubweiser Mexican stellar presentation.</span><br />\n	<span title=\"También se podrá apreciar la presencia de, Les Heritiers de Manden, Acoustic-Paradoxx, Dz-Karga, Judas\'klan, Summertime Blues Band, Antares Guereña, Armando d\' Anna, Art de Garrrid, Bahia Beat, Baja Rhythm Band, Brian Flynn\">We will also appreciate the presence of, Les Heritiers of Manden, Acoustic-Paradoxx, Dz-Karga, Judas&#39;klan, Summertime Blues Band, Antares Guere&ntilde;a, Armando d &#39;Anna, Art Garrrid, Bahia Beat, Lower Rhythm Band, Brian Flynn </span><span title=\"Band, Cábula, Cambio de Corazón, Cats, Chaosspell, Charlene Mignault, Colectivo Urbano, Dinna Overlock, Djavu, Drop The Bass, Francisco Gabriel García, Hugo Moreno, Javier Jaxhet Sigala, Jeanette, Jhonny Rockstar, José Ramón, Karma Rush, Katarsys\">Band, c&aacute;bula, Change of Heart, Cats, Chaosspell, Charlene Mignault, Urban Collective, Dinna Overlock, Djavu, Drop The Bass, Francisco Gabriel Garcia, Hugo Moreno, Javier Jaxhet Sigala, Jeanette, Johnny Rockstar, Jos&eacute; Ram&oacute;n, Karma Rush, Katarsys </span><span title=\", Kethe Salceda, La Cruz, Los Chales de la Tía, Lunacustica, Mistica Vibración, Nidia Barajas, Panihari, Percubeta, Percusion Limanya, Ro &amp; Rockdriguez Band, Señor Gordo, Syncopated, The Blacksowords, Tim Mullen, Tops Cats, James Brooking,\">, Kethe Salceda, The Cross, The Aunt Shawls, Lunacustica, Mystic Vibration, Nidia Barajas, Panihari, Percubeta, Percussion Limanya, Ro &amp; Rockdriguez Band, Mr. Gordo, Syncopated, The Blacksowords, Tim Mullen, Tops Cats, James Brooking, </span><span title=\"Lizzie Moran, Bong the Bong´s, Vyk Pichardo, Distorzion, Victor Caballero, Pollo Galo, Rodrigo, Richard O, Disco Diablo, Eduardo P, Lucky M + Franz, Extra-Large, y Grupo Tropical Cielo Azul, Adicción Norteña, Los\">Lizzie Moran, the Bong Bong&#39;s, Vyk Pichardo, Distorzion, Victor Knight, Chicken Gallus, Rodrigo, Richard O, Disco Devil, Edward P, Lucky M + Franz, Extra-Large, and Tropical Blue Sky Group, Northern Addiction, The </span><span title=\"Auténticos y más.\">Authentic and more.</span><br />\n	<span title=\"El festival dará inicio a partir de las 16:00 hrs concluyendo a las 01:00 hrs.\">The festival will start from 16:00 hrs until at 01:00 hrs. </span><span title=\"del siguiente día.\">the next day.</span><br />\n	<br />\n	<span title=\"La circulación vehicular de las calles del primer cuadro de la zona centro permanecerá cerrada a partir de las 10:00 hrs.\">The streets of the historic center will be closed to traffic from 10:00 hrs. </span><span title=\"y se abrirá después de que el evento se dé por concluido alrededor de las 01:00hrs.\">and will be opened after the event is terminated by around 01:00 hrs.</span><br />\n	<br />\n	<span title=\"El montaje del escenario Plaza Mijares y locaciones aledañas se realizará desde el día anterior ya lo largo del día del evento, tanto en la Plaza Mijares como en diferentes zonas del área Centro.\">The stage set Mijares Square and surrounding locations will be from the day before and throughout the day of the event, in the Plaza Mijares and in different areas of the center area.</span><br />\n	<br />\n	<span title=\"Si eres músico, te puedes inscribir organizando tu propio escenario y registrarlo con VIVARTE, o si no tienes escenario contacta al comité organizador y te asignarán un espacio en un escenario.\">If you are a musician, you can register by organizing your own stage and record with VIVARTE, or if you do not contact the organizing committee stage and you will be assigned a space on stage. </span><span title=\"Para los empresarios que gusten colaborar y enriquecer este festival, hay dos opciones de participación: organizando su escenario con sus músicos y enviar la información al comité o bien solicitando un espacio en coordinación con el comité para crear un programa.\">For business owners who want to collaborate and enrich the festival, there are two options for participation: organizing your stage with musicians and send the information to the committee or by requesting a space in coordination with the committee to create a program. </span><span title=\"Para mayores informes se pueden contactar al email, fiestadelamusicaloscabos@gmail.com\">For more information you can contact the email, fiestadelamusicaloscabos@gmail.com</span><br />\n	<br />\n	<br />\n	<br />\n	<span title=\"Más información\">More information</span><br />\n	<br />\n	<span title=\"http://www.fiestadelamusicaloscabos.com/\">http://www.fiestadelamusicaloscabos.com/</span><br />\n	<span title=\"http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/\">http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/</span></span></p>\n","<p>\n	El pr&oacute;ximo 21 de junio se llevar&aacute; a cabo la quinta edici&oacute;n de la &ldquo;Fiesta de la M&uacute;sica&rdquo; en San Jos&eacute; del Cabo, a partir de las 16:00 hrs. en las calles del centro hist&oacute;rico. Este es un evento internacional que naci&oacute; en Francia en 1982 para festejar la m&uacute;sica y as&iacute; rendir homenaje a todos los estilos musicales.</p>\n<p>\n	&nbsp;</p>\n<p>\n	La Asociaci&oacute;n Civil Promotora Cultural Vivarte, a trav&eacute;s del comit&eacute; organizador invita a la celebraci&oacute;n musical m&aacute;s grande del mundo, en el primer cuadro de la zona centro donde se distribuir&aacute;n 15 escenarios, contando con agrupaciones y cantantes de la localidad.</p>\n<p>\n	El escenario VIVARTE llenar&aacute; su programa con la propuesta de m&uacute;sicos representativos del talento regional como:</p>\n<ul>\n	<li>\n		<strong>Totoy, Divier Guive, Los Shamanes</strong> y <strong>Black Maria</strong>, adem&aacute;s contar&aacute; con la participaci&oacute;n especial de la compa&ntilde;&iacute;a de espect&aacute;culos &Euml;�Rouge&Euml;� y la presentaci&oacute;n estelar de <strong>Mexican Dubweiser</strong>.</li>\n	<li>\n		Tambi&eacute;n se podr&aacute; apreciar la presencia de, <strong>Les Heritiers de Manden, Acoustic-Paradoxx, Dz-Karga, Judas&rsquo;klan, Summertime Blues Band, Antares Guere&ntilde;a, Armando d&rsquo; Anna, Art de Garrrid, Bahia Beat, Baja Rhythm Band, Brian Flynn Band, C&aacute;bula, Cambio de Coraz&oacute;n, Cats, Chaosspell, Charlene Mignault, Colectivo Urbano, Dinna Overlock, Djavu, Drop The Bass, Francisco Gabriel Garc&iacute;a, Hugo Moreno, Javier Jaxhet Sigala, Jeanette, Jhonny Rockstar, Jos&eacute; Ram&oacute;n, Karma Rush, Katarsys, Kethe Salceda, La Cruz, Los Chales de la T&iacute;a, Lunacustica, Mistica Vibraci&oacute;n, Nidia Barajas, Panihari, Percubeta, Percusion Limanya, Ro &amp; Rockdriguez Band, Se&ntilde;or Gordo, Syncopated, The Blacksowords, Tim Mullen, Tops Cats, James Brooking, Lizzie Moran, Bong the Bong&acute;s, Vyk Pichardo, Distorzion, Victor Caballero, Pollo Galo, Rodrigo, Richard O, Disco Diablo, Eduardo P, Lucky M + Franz, Extra-Large, y Grupo Tropical Cielo Azul, Adicci&oacute;n Norte&ntilde;a, Los Aut&eacute;nticos</strong> y m&aacute;s.</li>\n</ul>\n<p>\n	El festival dar&aacute; inicio a partir de las 16:00 hrs concluyendo a las 01:00 hrs. del siguiente d&iacute;a.</p>\n<p>\n	La circulaci&oacute;n vehicular de las calles del primer cuadro de la zona centro permanecer&aacute; cerrada a partir de las 10:00 hrs. y se abrir&aacute; despu&eacute;s de que el evento se d&eacute; por concluido alrededor de las 01:00hrs.</p>\n<p>\n	El montaje del escenario Plaza Mijares y locaciones aleda&ntilde;as se realizar&aacute; desde el d&iacute;a anterior y a lo largo del d&iacute;a del evento, tanto en la Plaza Mijares como en diferentes zonas del &aacute;rea Centro.</p>\n<p>\n	Si eres m&uacute;sico, te puedes inscribir organizando tu propio escenario y registrarlo con VIVARTE, o si no tienes escenario contacta al comit&eacute; organizador y te asignar&aacute;n un espacio en un escenario. Para los empresarios que gusten colaborar y enriquecer este festival, hay dos opciones de participaci&oacute;n: organizando su escenario con sus m&uacute;sicos y enviar la informaci&oacute;n al comit&eacute; o bien solicitando un espacio en coordinaci&oacute;n con el comit&eacute; para crear un programa. Para mayores informes se pueden contactar al email, fiestadelamusicaloscabos@gmail.com</p>\n<p>\n	&nbsp;</p>\n<h2>\n	M&aacute;s informaci&oacute;n</h2>\n<p>\n	<a href=\"http://www.fiestadelamusicaloscabos.com/\" target=\"_blank\" title=\"Fiesta de la musica Los Cabos.com\">http://www.fiestadelamusicaloscabos.com/</a><br />\n	<a href=\"http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/\" target=\"_blank\" title=\"Fiesta de la musica Los Cabos.com\">http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/</a></p>\n","","","1","0","0","Y","1371239012","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-12","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","12:00 AM","12:00 AM","0","","0","0","0","","draft");
INSERT INTO kcp_general_events VALUES("43","2","Fete de la musique","Fiesta de la Música","","","2013-06-21 16:00:00","PM","2013-06-22 01:00:00","AM","1","4","36","0","<p>\n	<span id=\"result_box\" lang=\"en\" tabindex=\"-1\"><span title=\"El próximo 21 de junio se llevará a cabo la quinta edición de la “Fiesta de la Música” en San José del Cabo, a partir de las 16:00 hrs.\">The next June 21 will be held the fifth edition of the &quot;Festival of Music&quot; in San Jose del Cabo, from 16:00 hrs. </span><span title=\"en las calles del centro histórico.\">on the streets of the historic center. </span><span title=\"Este es un evento internacional que nació en Francia en 1982 para festejar la música y así rendir homenaje a todos los estilos musicales.\">This is an international event that was born in France in 1982 to celebrate the music and so pay tribute to all musical styles.</span><br />\n	<br />\n	The Association Civil&nbsp;Cultural Promotion Vivarte, through organizing committee invites the largest musical celebration of the world in the centro historico with 15 stage sets, with local groups and singers.</span><br />\n	&nbsp;</p>\n<p>\n	<span lang=\"en\" tabindex=\"-1\">The scenario VIVARTE fill your program with &nbsp;musicians representative of the&nbsp;regional talent such as:<br />\n	<br />\n	<span title=\"Totoy, Divier Guive, Los Shamanes y Black Maria, además contará con la participación especial de la compañía de espectáculos ˝Rouge˝ y la presentación estelar de Mexican Dubweiser.\">Totoy, Divier Guiver, Shamans and Black Maria, and will feature special entertainment company &Euml;� &Euml;� Rouge and Dubweiser Mexican stellar presentation.</span><br />\n	<span title=\"También se podrá apreciar la presencia de, Les Heritiers de Manden, Acoustic-Paradoxx, Dz-Karga, Judas\'klan, Summertime Blues Band, Antares Guereña, Armando d\' Anna, Art de Garrrid, Bahia Beat, Baja Rhythm Band, Brian Flynn\">We will also appreciate the presence of, Les Heritiers of Manden, Acoustic-Paradoxx, Dz-Karga, Judas&#39;klan, Summertime Blues Band, Antares Guere&ntilde;a, Armando d &#39;Anna, Art Garrrid, Bahia Beat, Lower Rhythm Band, Brian Flynn </span><span title=\"Band, Cábula, Cambio de Corazón, Cats, Chaosspell, Charlene Mignault, Colectivo Urbano, Dinna Overlock, Djavu, Drop The Bass, Francisco Gabriel García, Hugo Moreno, Javier Jaxhet Sigala, Jeanette, Jhonny Rockstar, José Ramón, Karma Rush, Katarsys\">Band, c&aacute;bula, Change of Heart, Cats, Chaosspell, Charlene Mignault, Urban Collective, Dinna Overlock, Djavu, Drop The Bass, Francisco Gabriel Garcia, Hugo Moreno, Javier Jaxhet Sigala, Jeanette, Johnny Rockstar, Jos&eacute; Ram&oacute;n, Karma Rush, Katarsys </span><span title=\", Kethe Salceda, La Cruz, Los Chales de la Tía, Lunacustica, Mistica Vibración, Nidia Barajas, Panihari, Percubeta, Percusion Limanya, Ro &amp; Rockdriguez Band, Señor Gordo, Syncopated, The Blacksowords, Tim Mullen, Tops Cats, James Brooking,\">, Kethe Salceda, The Cross, The Aunt Shawls, Lunacustica, Mystic Vibration, Nidia Barajas, Panihari, Percubeta, Percussion Limanya, Ro &amp; Rockdriguez Band, Mr. Gordo, Syncopated, The Blacksowords, Tim Mullen, Tops Cats, James Brooking, </span><span title=\"Lizzie Moran, Bong the Bong´s, Vyk Pichardo, Distorzion, Victor Caballero, Pollo Galo, Rodrigo, Richard O, Disco Diablo, Eduardo P, Lucky M + Franz, Extra-Large, y Grupo Tropical Cielo Azul, Adicción Norteña, Los\">Lizzie Moran, the Bong Bong&#39;s, Vyk Pichardo, Distorzion, Victor Knight, Chicken Gallus, Rodrigo, Richard O, Disco Devil, Edward P, Lucky M + Franz, Extra-Large, and Tropical Blue Sky Group, Northern Addiction, The </span><span title=\"Auténticos y más.\">Authentic and more.</span><br />\n	<span title=\"El festival dará inicio a partir de las 16:00 hrs concluyendo a las 01:00 hrs.\">The festival will start from 16:00 hrs until at 01:00 hrs. </span><span title=\"del siguiente día.\">the next day.</span><br />\n	<br />\n	<span title=\"La circulación vehicular de las calles del primer cuadro de la zona centro permanecerá cerrada a partir de las 10:00 hrs.\">The streets of the historic center will be closed to traffic from 10:00 hrs. </span><span title=\"y se abrirá después de que el evento se dé por concluido alrededor de las 01:00hrs.\">and will be opened after the event is terminated by around 01:00 hrs.</span><br />\n	<br />\n	<span title=\"El montaje del escenario Plaza Mijares y locaciones aledañas se realizará desde el día anterior ya lo largo del día del evento, tanto en la Plaza Mijares como en diferentes zonas del área Centro.\">The stage set Mijares Square and surrounding locations will be from the day before and throughout the day of the event, in the Plaza Mijares and in different areas of the center area.</span><br />\n	<br />\n	<span title=\"Si eres músico, te puedes inscribir organizando tu propio escenario y registrarlo con VIVARTE, o si no tienes escenario contacta al comité organizador y te asignarán un espacio en un escenario.\">If you are a musician, you can register by organizing your own stage and record with VIVARTE, or if you do not contact the organizing committee stage and you will be assigned a space on stage. </span><span title=\"Para los empresarios que gusten colaborar y enriquecer este festival, hay dos opciones de participación: organizando su escenario con sus músicos y enviar la información al comité o bien solicitando un espacio en coordinación con el comité para crear un programa.\">For business owners who want to collaborate and enrich the festival, there are two options for participation: organizing your stage with musicians and send the information to the committee or by requesting a space in coordination with the committee to create a program. </span><span title=\"Para mayores informes se pueden contactar al email, fiestadelamusicaloscabos@gmail.com\">For more information you can contact the email, fiestadelamusicaloscabos@gmail.com</span><br />\n	<br />\n	<br />\n	<br />\n	<span title=\"Más información\">More information</span><br />\n	<br />\n	<span title=\"http://www.fiestadelamusicaloscabos.com/\">http://www.fiestadelamusicaloscabos.com/</span><br />\n	<span title=\"http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/\">http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/</span></span></p>\n","<p>\n	El pr&oacute;ximo 21 de junio se llevar&aacute; a cabo la quinta edici&oacute;n de la &ldquo;Fiesta de la M&uacute;sica&rdquo; en San Jos&eacute; del Cabo, a partir de las 16:00 hrs. en las calles del centro hist&oacute;rico. Este es un evento internacional que naci&oacute; en Francia en 1982 para festejar la m&uacute;sica y as&iacute; rendir homenaje a todos los estilos musicales.</p>\n<p>\n	&nbsp;</p>\n<p>\n	La Asociaci&oacute;n Civil Promotora Cultural Vivarte, a trav&eacute;s del comit&eacute; organizador invita a la celebraci&oacute;n musical m&aacute;s grande del mundo, en el primer cuadro de la zona centro donde se distribuir&aacute;n 15 escenarios, contando con agrupaciones y cantantes de la localidad.</p>\n<p>\n	El escenario VIVARTE llenar&aacute; su programa con la propuesta de m&uacute;sicos representativos del talento regional como:</p>\n<ul>\n	<li>\n		<strong>Totoy, Divier Guive, Los Shamanes</strong> y <strong>Black Maria</strong>, adem&aacute;s contar&aacute; con la participaci&oacute;n especial de la compa&ntilde;&iacute;a de espect&aacute;culos &Euml;�Rouge&Euml;� y la presentaci&oacute;n estelar de <strong>Mexican Dubweiser</strong>.</li>\n	<li>\n		Tambi&eacute;n se podr&aacute; apreciar la presencia de, <strong>Les Heritiers de Manden, Acoustic-Paradoxx, Dz-Karga, Judas&rsquo;klan, Summertime Blues Band, Antares Guere&ntilde;a, Armando d&rsquo; Anna, Art de Garrrid, Bahia Beat, Baja Rhythm Band, Brian Flynn Band, C&aacute;bula, Cambio de Coraz&oacute;n, Cats, Chaosspell, Charlene Mignault, Colectivo Urbano, Dinna Overlock, Djavu, Drop The Bass, Francisco Gabriel Garc&iacute;a, Hugo Moreno, Javier Jaxhet Sigala, Jeanette, Jhonny Rockstar, Jos&eacute; Ram&oacute;n, Karma Rush, Katarsys, Kethe Salceda, La Cruz, Los Chales de la T&iacute;a, Lunacustica, Mistica Vibraci&oacute;n, Nidia Barajas, Panihari, Percubeta, Percusion Limanya, Ro &amp; Rockdriguez Band, Se&ntilde;or Gordo, Syncopated, The Blacksowords, Tim Mullen, Tops Cats, James Brooking, Lizzie Moran, Bong the Bong&acute;s, Vyk Pichardo, Distorzion, Victor Caballero, Pollo Galo, Rodrigo, Richard O, Disco Diablo, Eduardo P, Lucky M + Franz, Extra-Large, y Grupo Tropical Cielo Azul, Adicci&oacute;n Norte&ntilde;a, Los Aut&eacute;nticos</strong> y m&aacute;s.</li>\n</ul>\n<p>\n	El festival dar&aacute; inicio a partir de las 16:00 hrs concluyendo a las 01:00 hrs. del siguiente d&iacute;a.</p>\n<p>\n	La circulaci&oacute;n vehicular de las calles del primer cuadro de la zona centro permanecer&aacute; cerrada a partir de las 10:00 hrs. y se abrir&aacute; despu&eacute;s de que el evento se d&eacute; por concluido alrededor de las 01:00hrs.</p>\n<p>\n	El montaje del escenario Plaza Mijares y locaciones aleda&ntilde;as se realizar&aacute; desde el d&iacute;a anterior y a lo largo del d&iacute;a del evento, tanto en la Plaza Mijares como en diferentes zonas del &aacute;rea Centro.</p>\n<p>\n	Si eres m&uacute;sico, te puedes inscribir organizando tu propio escenario y registrarlo con VIVARTE, o si no tienes escenario contacta al comit&eacute; organizador y te asignar&aacute;n un espacio en un escenario. Para los empresarios que gusten colaborar y enriquecer este festival, hay dos opciones de participaci&oacute;n: organizando su escenario con sus m&uacute;sicos y enviar la informaci&oacute;n al comit&eacute; o bien solicitando un espacio en coordinaci&oacute;n con el comit&eacute; para crear un programa. Para mayores informes se pueden contactar al email, fiestadelamusicaloscabos@gmail.com</p>\n<p>\n	&nbsp;</p>\n<h2>\n	M&aacute;s informaci&oacute;n</h2>\n<p>\n	<a href=\"http://www.fiestadelamusicaloscabos.com/\" target=\"_blank\" title=\"Fiesta de la musica Los Cabos.com\">http://www.fiestadelamusicaloscabos.com/</a><br />\n	<a href=\"http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/\" target=\"_blank\" title=\"Fiesta de la musica Los Cabos.com\">http://www.fetedelamusique.culture.fr/es/Internacional/mundo/p_monde-57/</a></p>\n","","","1","0","0","Y","1371239012","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-12","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","12:00 AM","12:00 AM","0","","0","0","0","","draft");
INSERT INTO kcp_general_events VALUES("44","2","Dorado International Fishing Tournament","Torneo Internacional de Pesca El Dorado","","","2013-07-01 17:00:00","PM","2013-07-02 22:00:00","PM","1","3","33","0","<p align=\"center\">\n	<strong>LORETO DORADO TOURNAMENT</strong></p>\n<p align=\"center\">\n	<strong>June 30 - July 2 2013</strong></p>\n<p>\n	&nbsp;</p>\n<p>\n	Tournament headquarters will again be the grand Oasis Hotel which did a great job. The two day Tournament last July was a huge success. Beautiful Loreto is the site of this long-time Vag Tournament that usually captures during this time frame the largest dorado in the season for the June-July period.</p>\n<p>\n	<br />\n	Registration and orientation will be on Sunday, June 30, 5 p.m. at the Oasis. Rules will be available then. There will be raffles and great prizes. The Awards Banquet will be on Tuesday evening. This is a fun Tournament in which family participation is encouraged. The fish weigh in station will be at the Oasis at 2 p.m. for fish from Loreto, or 3 p.m. for those bringing fish in from Puerto Escondido/Juncalito. For those guys/ladies who are not fishing or not fishing every day, we would appreciate your help at the weigh in, registration, photos or other tasks. A super group of volunteers stepped up last time who made a real difference - <strong>Solveig Franklin, Jutta Barnett, Don and Karen Brown, and Bob Lane</strong>.</p>\n<p>\n	<br />\n	The Oasis is a premiere Loreto traditional hotel with quiet ocean front rooms, tropical gardens, many spacious areas for parking, and an acclaimed restaurant. For reservations you can contact them at -- toll free: U.S. - &nbsp;1-866-482-0247&nbsp;; Mexico - 613-135-0211; Fax - 613-135-0795. There will be special rates for rooms and for fishing. If you are interested in traveling down with a group or need a buddy on the road, check with Vag HQ or sign up on the Travel Buddies Calendar (TBC) at <a href=\"http://www.vagabundos.com/TBC.html\">http://www.vagabundos.com/TBC.html</a>. There are great reviews from members using the TBC.<br />\n	Call Vag HQ at &nbsp;800-474-2252&nbsp; to sign up and pay the fee. The registration fee is $120 per boat. If you pre-register at the office you will be entered into a special drawing. Proceeds will be donated to a local non-profit organization. Contact<strong>Coordinator Paulette Gochie </strong>at loretoplaya@gmail.com.&nbsp;</p>\n","<p>\n	<strong>Torneo de las Misiones</strong>, un Torneo de pesca de caridad que se dio inici&oacute; en 1993 y perdura con el tiempo, cada a&ntilde;o con mas competidores. <strong>Loreto Dorado International Fishing Tournament</strong>, es uno de los tornes internacionales de pesca m&aacute;s importantes de todo el estado en donde miles de participantes de diferentes partes del mundo viene en busca del trofeo m&aacute;s deseado que es el dorado.</p>\n","","","1","0","0","Y","1372094969","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-11","","","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","12:00 AM","12:00 AM","0","","0","0","0","","draft");
INSERT INTO kcp_general_events VALUES("45","1","Amit Event Englishs","Amit Event Spanish","TEST","TEST","2013-08-18 03:10:00","AM","2013-08-20 17:10:00","PM","1","3","33","20","","","","","0","1","0","Y","1376309847","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-10","Weekly","1","","","1","0","0","1","1","0","0","2013-08-18","2014-08-18","","","1","","0","0","0","1376309837","publish");
INSERT INTO kcp_general_events VALUES("47","2","Monthly recurring event","Monthly Recurring Test","This is a recurring test.","This is a recurring test.","2013-08-01 19:30:00","PM","2013-12-31 21:30:00","PM","1","4","37","3","<p>\n	<span id=\"result_box\" lang=\"en\" tabindex=\"-1\"><span class=\"hps\">Every Thursday</span> <span class=\"hps\">at 7:30</span> <span class=\"hps\">pm</span><span>, join</span>&nbsp;the&nbsp;<span class=\"hps alt-edited\">cinephiles</span> <span class=\"hps\">of Los</span> <span class=\"hps\">Cabos.</span></span></p>\n","<p>\n	<span class=\"fbLongBlurb\">Todos los jueves a las 7:30 pm, se juntan los cin&eacute;filos de Los Cabos.</span></p>\n","","","0","1","0","Y","1376396760","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-15","Monthly","1","Last","Wednesday","0","0","0","0","0","0","0","2013-08-01","2013-12-31","07:30 PM","09:30 PM","0","","0","0","0","1376396668","publish");
INSERT INTO kcp_general_events VALUES("48","2","Amit Event Englishs","Amit Event Spanish","TEST","TEST","2013-08-15 03:10:00","AM","2013-08-30 17:10:00","PM","1","3","33","0","","","","","0","1","0","","1376309847","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-10","Weekly","1","","","1","0","0","0","1","0","0","2013-08-15","2013-08-30","12:15 AM","03:00 PM","0","1","0","0","0","1376309837","draft");
INSERT INTO kcp_general_events VALUES("50","1","Weekly recurring Amit English","Weekly recurring Amit Spanish","Test","TEST","2013-08-16 03:10:00","AM","2013-08-16 17:10:00","PM","1","3","33","20","","<p>\n	This is a test deesciption</p>\n","Tag1, Tag2","","0","1","0","","1376309847","0","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-14","Weekly","1","","","0","1","0","0","1","0","0","2013-08-16","2014-08-16","","","0","1","0","0","0","1376309837","publish");
INSERT INTO kcp_general_events VALUES("52","1","Name","Nombre","","","0000-00-00 19:00:00","PM","0000-00-00 21:00:00","PM","0","0","0","0","","","","","0","1","0","Y","1376489064","0","0","0","0","0","0","0","0","0","0","0","0","0","","0000-00-00","","1","","","0","0","0","0","0","0","0","2013-08-14","2013-08-14","12:00 AM","12:00 AM","0","1","0","0","0","1376489030","draft");
INSERT INTO kcp_general_events VALUES("55","1","Recurring Chirs","Recurring\'s Chris ","This is how I want to test.","This is how I want to test.","2013-08-16 15:40:00","PM","2013-08-18 17:00:00","PM","1","3","33","20","<p>\n	This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test .......</p>\n<p>\n	&nbsp;</p>\n<p>\n	This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test .......</p>\n","<p>\n	This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test ....... This is test .......</p>\n","","","0","1","0","Y","1376646260","1","0","0","0","0","0","0","0","0","0","0","0","0","","2013-08-16","Yearly","1","","","0","0","0","0","0","1","1","2013-08-16","2015-08-30","","","1","","0","0","0","1376646255","saved");



DROP TABLE IF EXISTS kcp_general_subevents;

CREATE TABLE `kcp_general_subevents` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(255) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `event_name_en` text NOT NULL,
  `event_name_sp` text NOT NULL,
  `event_short_desc_en` varchar(255) NOT NULL,
  `event_short_desc_sp` varchar(255) NOT NULL,
  `event_start_date_time` datetime NOT NULL,
  `event_start_ampm` varchar(10) NOT NULL,
  `event_end_date_time` datetime NOT NULL,
  `event_end_ampm` varchar(10) NOT NULL,
  `event_venue_state` int(11) NOT NULL,
  `event_venue_county` int(11) NOT NULL,
  `event_venue_city` int(11) NOT NULL,
  `event_venue` int(11) NOT NULL,
  `event_details_en` longtext NOT NULL,
  `event_details_sp` longtext NOT NULL,
  `event_tag` varchar(255) NOT NULL,
  `event_photo` varchar(200) NOT NULL,
  `identical_function` int(1) NOT NULL,
  `recurring` int(1) NOT NULL,
  `sub_events` int(1) NOT NULL,
  `event_status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `post_date` int(30) NOT NULL,
  `Paypal` int(255) NOT NULL,
  `Bank_deposite` int(255) NOT NULL,
  `Oxxo_Payment` int(255) NOT NULL,
  `Mobile_Payment` int(255) NOT NULL,
  `Offline_Payment` int(255) NOT NULL,
  `paper_less_mob_ticket` int(11) NOT NULL,
  `print` int(11) NOT NULL,
  `will_call` int(11) NOT NULL,
  `set_privacy` int(11) NOT NULL,
  `private_privacy` int(11) NOT NULL,
  `attendees_share` int(11) NOT NULL,
  `attendees_invitation` int(11) NOT NULL,
  `password_protect` int(11) NOT NULL,
  `password_protect_text` varchar(128) NOT NULL,
  `publish_date` datetime NOT NULL,
  `event_time` varchar(255) NOT NULL,
  `event_time_period` varchar(255) NOT NULL,
  `r_month` varchar(255) NOT NULL,
  `r_month_day` varchar(255) NOT NULL,
  `mon` int(255) NOT NULL,
  `tue` int(255) NOT NULL,
  `wed` int(255) NOT NULL,
  `thu` int(255) NOT NULL,
  `fri` int(255) NOT NULL,
  `sat` int(255) NOT NULL,
  `sun` int(255) NOT NULL,
  `r_span_start` date NOT NULL,
  `r_span_end` date NOT NULL,
  `event_start` varchar(255) NOT NULL,
  `event_end` varchar(255) NOT NULL,
  `all_day` int(255) NOT NULL,
  `event_lasts` varchar(255) NOT NULL,
  `include_payment` int(11) NOT NULL,
  `include_promotion` int(11) NOT NULL,
  `all_access` int(11) NOT NULL COMMENT '0=free,1=ticket,2=master_ticket',
  `unique_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS kcp_google_user;

CREATE TABLE `kcp_google_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `google_id` varchar(512) NOT NULL,
  `google_email` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS kcp_master_event_types;

CREATE TABLE `kcp_master_event_types` (
  `event_master_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_types` varchar(512) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`event_master_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO kcp_master_event_types VALUES("1","Show/concert/performance","1");
INSERT INTO kcp_master_event_types VALUES("2","Festivals","1");
INSERT INTO kcp_master_event_types VALUES("3","Market/fairs","1");
INSERT INTO kcp_master_event_types VALUES("4","Expos/Conventions/tradeshow","1");
INSERT INTO kcp_master_event_types VALUES("5","Seminars/lectures/classes/workshops","1");
INSERT INTO kcp_master_event_types VALUES("6","Fiesta Popular - Carnival","1");
INSERT INTO kcp_master_event_types VALUES("7","Competition/Race/Tournament","1");
INSERT INTO kcp_master_event_types VALUES("8","Charity/fundraiser","1");
INSERT INTO kcp_master_event_types VALUES("9","Celebration","1");



DROP TABLE IF EXISTS kcp_master_performer_types;

CREATE TABLE `kcp_master_performer_types` (
  `performer_master_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `performer_types_en` varchar(512) NOT NULL,
  `performer_types_sp` varchar(512) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`performer_master_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO kcp_master_performer_types VALUES("1","Performing artist - Music","Artista Esc�nica  - M�sica","1");
INSERT INTO kcp_master_performer_types VALUES("2","Performing band - Orchestra","Banda - Orquesta","1");
INSERT INTO kcp_master_performer_types VALUES("3","Performing artist - Others","Artista Esc�nica  - Otros","1");
INSERT INTO kcp_master_performer_types VALUES("4","Performing group or company","Grupo o compania de Artes Esc�nicas - Otros","1");
INSERT INTO kcp_master_performer_types VALUES("5","Sports Player - Fighter","Jugador - Luchador","1");
INSERT INTO kcp_master_performer_types VALUES("6","Sports team","Equipo Deportivo","1");
INSERT INTO kcp_master_performer_types VALUES("7","Speaker - Lecturer - Instructor","Locutor - Conferencista - Instructor","1");
INSERT INTO kcp_master_performer_types VALUES("8","Chef - Somelier","Chef - Sommelier","1");
INSERT INTO kcp_master_performer_types VALUES("9","Spiritual or religious leader","L�der Espiritual o Religioso","1");
INSERT INTO kcp_master_performer_types VALUES("10","Other","Otros","1");



DROP TABLE IF EXISTS kcp_order;

CREATE TABLE `kcp_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `amount` float NOT NULL,
  `f_name` varchar(100) NOT NULL,
  `l_name` varchar(100) NOT NULL,
  `email` varchar(333) NOT NULL,
  `address` varchar(333) NOT NULL,
  `address2` longtext NOT NULL,
  `country` varchar(222) NOT NULL,
  `state` varchar(222) NOT NULL,
  `city` varchar(222) NOT NULL,
  `zip` varchar(222) NOT NULL,
  `event_id` int(100) NOT NULL,
  `phone` char(50) NOT NULL,
  `qr_code` varchar(20) NOT NULL,
  `confirmation_id` varchar(222) NOT NULL,
  `user_id` int(100) NOT NULL,
  `ticket_holder` varchar(333) NOT NULL,
  `option_value` varchar(222) NOT NULL,
  `discount_amt` float NOT NULL,
  `coupon_event_id` int(11) NOT NULL,
  `order_voided` int(1) NOT NULL,
  `delivery_option` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS kcp_order_detail;

CREATE TABLE `kcp_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(100) NOT NULL,
  `barcode` varchar(222) NOT NULL,
  `price_level_id` int(100) NOT NULL,
  `ticket_holder` varchar(333) NOT NULL,
  `ticket_status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS kcp_organization;

CREATE TABLE `kcp_organization` (
  `organization_id` int(11) NOT NULL AUTO_INCREMENT,
  `org_fname` varchar(333) NOT NULL,
  `org_lname` varchar(333) NOT NULL,
  `organization_name` varchar(333) NOT NULL,
  `org_country` int(11) NOT NULL,
  `org_address1` varchar(333) NOT NULL,
  `org_address2` varchar(333) NOT NULL,
  `org_city` varchar(222) NOT NULL,
  `org_state` varchar(222) NOT NULL,
  `org_zip` varchar(100) NOT NULL,
  `org_phone` varchar(50) NOT NULL,
  `org_fax` varchar(50) NOT NULL,
  `payable_to` varchar(333) NOT NULL,
  `pay_address` varchar(333) NOT NULL,
  `pay_address2` varchar(333) NOT NULL,
  `pay_city` varchar(222) NOT NULL,
  `pay_state` varchar(222) NOT NULL,
  `pay_zip` varchar(222) NOT NULL,
  `total_earning` float NOT NULL,
  `organization_status` int(1) NOT NULL,
  `paypal_id` varchar(222) NOT NULL,
  `wire_bankname` varchar(256) NOT NULL,
  `wire_bankaddr` varchar(256) NOT NULL,
  `wire_rtno` varchar(256) NOT NULL,
  `wire_acname` varchar(256) NOT NULL,
  `wire_acaddress` varchar(256) NOT NULL,
  `wire_acnumber` varchar(256) NOT NULL,
  `upcoming_url` varchar(256) NOT NULL,
  `send_newsletter` int(11) NOT NULL,
  PRIMARY KEY (`organization_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO kcp_organization VALUES("1","Gareth","Little","The Circle LLC","226","299 East 3rd Street","","New York","New York","10009","","203-260-8763","The Winners Circle LLC","299 east 3rd street suite 2E","","New York","New York","10009","0","0","contact@thecirclellc.com","","","","","","","","0");



DROP TABLE IF EXISTS kcp_organization_sale;

CREATE TABLE `kcp_organization_sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(100) NOT NULL,
  `organization_id` int(100) NOT NULL,
  `total_amount` float NOT NULL,
  `commission_amount` float NOT NULL,
  `without_commission` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS kcp_page;

CREATE TABLE `kcp_page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) NOT NULL,
  `page_content` longtext NOT NULL,
  `page_link` varchar(255) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO kcp_page VALUES("1"," About KCPasa","<h1>\n	About KPasapp</h1>\n<h2>\n	Why KPasapp?</h2>\n<p>\n	Whether you live in Baja California Sur or are a frequent visitor, you most likely found out too often after the facts about what is going on down here in our beautiful corner of the world. Time and again, this has been my experience, and I grew so frustrated that I decided to do something about it. Here it is: <strong>KPassapp.com</strong>, a full-featured event management and promotion platform that is a web portal and a mobile application all in one. From now on, all the events in all of Baja California Sur from Guerrero Negro to Los Cabos are just 1 click away from your computer or from your mobile device &ndash; smart phone or tablet.</p>\n<p>\n	<strong>KPassapp.com</strong> is the most complete platform for event-goers and events professionals alike. We even help you manage your private events from baby showers to funerals and all the events in between &ndash; birthdays, graduations, posadas, Quinzenadas, weddings, anniversaries, etc. From tables and chairs or silverware, to catering services to sound and lighting, to entertainment, whether you look for fine French cuisine or taco services, a mariachi band, a classical music pianist, a tenor, a clown, a magician or a contortionist, you will find it here in KPasapp.com, your full-service event management and promotion service.</p>\n<h2>\n	As an end user, KPassapp.com allows you to:</h2>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Find out about all of the events in all of Baja California Sur</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Securely make reservations and purchase tickets either online via Paypal, Credit or Debit cards, or direct bank deposit; or off-line via the Oxxo chain of convenience stores.</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Download your ticket paperlessly to your mobile device, or print it on your own printer</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Check in at the event via your paperless mobile ticket or with printed ticket</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Filter events by category, municipio, city, venue, date range or keywords</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sign up for alerts via email, SMS or social networks,</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Set up your profile and personalize your alerts. You can follow event categories, cities, venues, performers, etc.</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Synchronize your profile with the major social networks such as Facebook, Twitter or Google+</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Save events and create events wish-lists</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Invite your friends to your favorite events</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; And much more</p>\n<h2>\n	Event management</h2>\n<p>\n	<strong>KPassapp.com</strong> can manage all kinds of events, from festivals, conventions or tournaments, to recurring events, concerts, sporting events, educational events,&nbsp; yoga retreats, and everything in between, as well, of course as all your private events. As an event management or promotion professional, <strong>KPassapp.com</strong> offers you:</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; An efficient dedicated platform to promote and manage all your events via a multiplicity of media: targeted email campaigns, SMS, social networks, Whatsapp, and of course, the <strong>KPassapp.com</strong> website and mobile application.</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A secure platform to sell tickets to your events, and to manage invitations, reservations and RSVPs</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A seamless secure ticketing solution from reservation to check-in at the event itself with cutting-edge paperless mobile ticketing technology.</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A powerful alert system for your prospects and reminder system for your attendees</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Comprehensive resources to fill all your needs in the preparation of your event: venues, supplies and furniture, catering services, entertainment services, etc.</p>\n<p>\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A secure platform to post your request for services, to look for qualified service providers, and to hire and manage sub-contractors and service providers. With our escrow services, monies are released only when preset timelines have been met to your satisfaction.&nbsp; You can even signup for our dispute management and resolution service with selected event-services providers on an event by event basis or on a monthly or yearly basis.</p>\n<h2>\n	Event-service provider</h2>\n<p>\n	Finally, if you are an event-service provider -venue management, catering services, supply and furniture rental, sound, lighting, performer (musician, artist, performer, speaker, etc.) KPasapp.com offers you:</p>\n<p style=\"margin-left:37.5pt;\">\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A unique, dedicated platform to advertise your skills and services</p>\n<p style=\"margin-left:37.5pt;\">\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Create detailed profiles and portfolios</p>\n<p style=\"margin-left:37.5pt;\">\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; The opportunity to bid on request for services from event managers</p>\n<p style=\"margin-left:37.5pt;\">\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A secure platform to get hired and paid. You negotiate timelines with your event manager; funds are deposited in our secure escrow account; they are released when timelines are met to both party satisfaction. .&nbsp; You can even signup for our dispute management and resolution service with selected event-managers on an event by event basis or on a monthly or yearly basis.</p>\n<p style=\"margin-left:37.5pt;\">\n	&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Get feedback and ratings for previous jobs</p>\n<p>\n	To event-goers, event managers and event-service providers, <strong>KPassapp.com</strong> offers the most comprehensive and most advanced event management solution in the world.</p>\n","kpasapp");
INSERT INTO kcp_page VALUES("2","About Baja Sur","<p>\n	About Baja Sur - Lorem ipsum dolor sit amet, qui audire persius inermis id. Debet quando oportere ea usu, vis eu lorem commune. Postea graecis salutatus has ne, melius corpora argumentum te nec, mea et vivendum efficiendi. Et eum discere vulputate, quod feugait expetenda ei his, cu solum audiam vocibus per. Consetetur interesset pri cu, legimus perpetua consulatu his ad, his cu tation altera nusquam.<br />\n	<br />\n	Ex doming putant possim eum, melius sanctus reprehendunt per an. Case dicam pri in. Cu quod error veniam eam, an illud appetere nam, eu oblique labores principes vix. In quidam propriae vim, prima adipisci vix eu.<br />\n	<br />\n	Ne qui iusto cetero percipitur. Ad mandamus intellegam his, te vocent tractatos eam. Ei mea aeque salutatus, vis in debet aliquip. In quod cibo deserunt usu, vis fabellas theophrastus id. Cum an oblique conceptam, est in aeque soluta.<br />\n	<br />\n	Maiorum invenire est eu. Ocurreret voluptatum conclusionemque mea cu. An equidem adversarium vel, vel ne utamur nostrud salutatus, ei dico adversarium nec. Nobis legimus ea mea. Sit fabulas nominati at, ad dictas mnesarchum vituperatoribus per.</p>\n","about-baja-sur");
INSERT INTO kcp_page VALUES("3","Features","<p>\n	Event-goers</p>\n<ul>\n	<li>\n		extensive event search capabilities\n		<ul>\n			<li>\n				Date range</li>\n			<li>\n				Categories</li>\n			<li>\n				State, county, city, venues</li>\n			<li>\n				Keywords/tags</li>\n		</ul>\n	</li>\n</ul>\n","feature");
INSERT INTO kcp_page VALUES("4","Plans & Pricing","<p>\n	&nbsp;</p>\n<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\">\n	<tbody>\n		<tr>\n			<td>\n				<p>\n					&nbsp;</p>\n			</td>\n			<td>\n				<p>\n					<strong><u>Free listing</u></strong></p>\n			</td>\n			<td>\n				<p>\n					<strong><u>promoted listing</u></strong></p>\n				<p>\n					Ticketing fee &amp;</p>\n				<p>\n					Promotion fee</p>\n				<p>\n					Added to ticket price &ndash;</p>\n				<p>\n					Min charge:</p>\n				<p>\n					10MXP/$0.89/ticket</p>\n			</td>\n			<td>\n				<p>\n					<strong><u>Super-promoted listing</u></strong></p>\n				<p>\n					Ticketing fee Included in ticket price</p>\n				<p>\n					Promotion added ticket price</p>\n				<p>\n					Min charge:</p>\n				<p>\n					10MXP/$0.89/ticket</p>\n			</td>\n			<td>\n				<p>\n					<strong><u>VIP listing</u></strong></p>\n				<p>\n					Ticketing fee &amp;</p>\n				<p>\n					Promotion fee</p>\n				<p>\n					Included in ticket price</p>\n				<p>\n					Min charge:</p>\n				<p>\n					10MXP/$0.89/ticket</p>\n			</td>\n		</tr>\n		<tr>\n			<td colspan=\"5\">\n				<h2 align=\"center\">\n					Placement on KPassap event listing page</h2>\n			</td>\n		</tr>\n		<tr>\n			<td>\n				<p>\n					Listing on KPasapp</p>\n			</td>\n			<td>\n				<p>\n					included</p>\n			</td>\n			<td>\n				<p>\n					Included</p>\n			</td>\n			<td>\n				<p>\n					Included</p>\n			</td>\n			<td>\n				<p>\n					included</p>\n			</td>\n		</tr>\n		<tr>\n			<td>\n				<p>\n					Spotlight placement</p>\n			</td>\n			<td>\n				<p>\n					Xtra - PPC</p>\n			</td>\n			<td>\n				<p>\n					Xtra &ndash; PPC</p>\n			</td>\n			<td>\n				<p>\n					Xtra &ndash; PPC</p>\n			</td>\n			<td>\n				<p>\n					Included</p>\n			</td>\n		</tr>\n		<tr>\n			<td>\n				<p>\n					Hot ticket placement</p>\n			</td>\n			<td>\n				<p>\n					Xtra - PPC</p>\n			</td>\n			<td>\n				<p>\n					Xtra &ndash; PPC</p>\n			</td>\n			<td>\n				<p>\n					Included</p>\n			</td>\n			<td>\n				<p>\n					&nbsp;</p>\n			</td>\n		</tr>\n		<tr>\n			<td>\n				<p>\n					Promoted placement &ndash;</p>\n				<p>\n					upper sidebar</p>\n			</td>\n			<td>\n				<p>\n					Xtra &ndash; PPC</p>\n			</td>\n			<td>\n				<p>\n					Included</p>\n			</td>\n			<td>\n				<p>\n					&nbsp;</p>\n			</td>\n			<td>\n				<p>\n					&nbsp;</p>\n			</td>\n		</tr>\n		<tr>\n			<td>\n				<p>\n					Highlighted event</p>\n			</td>\n			<td>\n				<p>\n					Xtra &ndash; PPC</p>\n			</td>\n			<td>\n				<p>\n					Included</p>\n			</td>\n			<td>\n				<p>\n					Included</p>\n			</td>\n			<td>\n				<p>\n					Included</p>\n			</td>\n		</tr>\n		<tr>\n			<td>\n				<p>\n					&nbsp;</p>\n			</td>\n			<td>\n				<p>\n					&nbsp;</p>\n			</td>\n			<td>\n				<p>\n					&nbsp;</p>\n			</td>\n			<td>\n				<p>\n					&nbsp;</p>\n			</td>\n			<td>\n				<p>\n					&nbsp;</p>\n			</td>\n		</tr>\n		<tr>\n			<td colspan=\"5\">\n				<h2 align=\"center\">\n					Notifications</h2>\n			</td>\n		</tr>\n		<tr>\n			<td>\n				<p>\n					Max Notifications</p>\n			</td>\n			<td>\n				<p>\n					1</p>\n			</td>\n			<td>\n				<p>\n					2</p>\n			</td>\n			<td>\n				<p>\n					3</p>\n			</td>\n			<td>\n				<p>\n					Up to 5</p>\n			</td>\n		</tr>\n		<tr>\n			<td>\n				<p>\n					KPassap social media</p>\n			</td>\n			<td>\n				<p>\n					1</p>\n			</td>\n			<td>\n				<p>\n					2</p>\n			</td>\n			<td>\n				<p>\n					3</p>\n			</td>\n			<td>\n				<p>\n					Up to 5</p>\n			</td>\n		</tr>\n		<tr>\n			<td>\n				<p>\n					Your social media</p>\n			</td>\n			<td>\n				<p>\n					1</p>\n			</td>\n			<td>\n				<p>\n					2</p>\n			</td>\n			<td>\n				<p>\n					3</p>\n			</td>\n			<td>\n				<p>\n					Up to 5</p>\n			</td>\n		</tr>\n		<tr>\n			<td>\n				<p>\n					Your emaillist</p>\n			</td>\n			<td>\n				<p>\n					Free up to 50</p>\n			</td>\n			<td>\n				<p>\n					2</p>\n			</td>\n			<td>\n				<p>\n					3</p>\n			</td>\n			<td>\n				<p>\n					Up to 3</p>\n			</td>\n		</tr>\n		<tr>\n			<td>\n				<p>\n					Your SMS list</p>\n			</td>\n			<td>\n				<p>\n					Free up to 10</p>\n			</td>\n			<td>\n				<p>\n					2</p>\n			</td>\n			<td>\n				<p>\n					3</p>\n			</td>\n			<td>\n				<p>\n					Up to 3</p>\n			</td>\n		</tr>\n		<tr>\n			<td>\n				<p>\n					KPassap targeted emaillist</p>\n			</td>\n			<td>\n				<p>\n					Xtra</p>\n			</td>\n			<td>\n				<p>\n					2</p>\n			</td>\n			<td>\n				<p>\n					2</p>\n			</td>\n			<td>\n				<p>\n					Up to 3</p>\n			</td>\n		</tr>\n		<tr>\n			<td>\n				<p>\n					KPasapp targeted MSM list</p>\n			</td>\n			<td>\n				<p>\n					Xtra</p>\n			</td>\n			<td>\n				<p>\n					2</p>\n			</td>\n			<td>\n				<p>\n					2</p>\n			</td>\n			<td>\n				<p>\n					Up to 3</p>\n			</td>\n		</tr>\n	</tbody>\n</table>\n<p>\n	&nbsp;</p>\n","plan-pricing");



DROP TABLE IF EXISTS kcp_performer;

CREATE TABLE `kcp_performer` (
  `performer_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `performer_name_en` varchar(512) NOT NULL,
  `performer_name_sp` varchar(512) NOT NULL,
  `performer_short_add_en` varchar(1024) NOT NULL,
  `performer_short_add_sp` varchar(1024) NOT NULL,
  `performer_state` int(11) NOT NULL,
  `performer_county` int(11) NOT NULL,
  `performer_city` int(11) NOT NULL,
  `performer_zip` varchar(256) NOT NULL,
  `performer_address` varchar(1024) NOT NULL,
  `performer_contact_name` varchar(512) NOT NULL,
  `performer_phone` varchar(512) NOT NULL,
  `performer_fax` varchar(512) NOT NULL,
  `performer_cell` varchar(512) NOT NULL,
  `performer_email` varchar(512) NOT NULL,
  `performer_url` varchar(512) NOT NULL,
  `avail_performanace` varchar(512) NOT NULL,
  `manager_name` varchar(512) NOT NULL,
  `manager_phone` varchar(512) NOT NULL,
  `manager_fax` varchar(512) NOT NULL,
  `manager_cell` varchar(512) NOT NULL,
  `manager_email` varchar(512) NOT NULL,
  `manager_url` varchar(512) NOT NULL,
  `performer_description_en` text NOT NULL,
  `performer_description_sp` text NOT NULL,
  `performer_photo` varchar(256) NOT NULL,
  `privacy` int(11) NOT NULL COMMENT '1=public,0=private',
  `st_rate` int(11) NOT NULL COMMENT '1=standard rates,0=no standard rates',
  `activate_status` int(11) NOT NULL COMMENT '1=saved,2=publish,0=draft',
  `performer_tags` varchar(1024) NOT NULL,
  `publish_date` int(11) NOT NULL,
  `post_date` int(11) NOT NULL,
  `unique_id` varchar(512) NOT NULL,
  PRIMARY KEY (`performer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO kcp_performer VALUES("1","2","My Performer English","My Performer Spanish","Short Description","Breve Descripción","1","2","21","987546201","New Pally","Amit Banerjee","","","5546520","amitstarta@gmail.com","","Statewide","Test","987546210","5564001","987546200","a@gmail.com","","","","1374588083birds_wallpaper_19.jpg","1","1","0","","0","1374587835","1374587819");



DROP TABLE IF EXISTS kcp_performer_rates;

CREATE TABLE `kcp_performer_rates` (
  `performer_rates_id` int(11) NOT NULL AUTO_INCREMENT,
  `performer_id` int(11) NOT NULL,
  `rate_name_en` varchar(512) NOT NULL,
  `rate_name_sp` varchar(512) NOT NULL,
  `description_sp` varchar(512) NOT NULL,
  `description_en` varchar(512) NOT NULL,
  `price_mx` double NOT NULL,
  `price_us` double NOT NULL,
  PRIMARY KEY (`performer_rates_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO kcp_performer_rates VALUES("1","1","New rate","New rate","Breve descripción","Short description","125","129");
INSERT INTO kcp_performer_rates VALUES("2","1","Release rate","Release rate","Descripción","Description","125","5500");



DROP TABLE IF EXISTS kcp_performer_types;

CREATE TABLE `kcp_performer_types` (
  `performer_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `performer_id` int(11) NOT NULL,
  `performer_master_type_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`performer_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO kcp_performer_types VALUES("5","1","10","0");
INSERT INTO kcp_performer_types VALUES("4","1","9","0");



DROP TABLE IF EXISTS kcp_price_level;

CREATE TABLE `kcp_price_level` (
  `price_level_id` int(11) NOT NULL AUTO_INCREMENT,
  `price_name` varchar(222) NOT NULL,
  `price_amount` float NOT NULL,
  `ticket_limit` int(255) NOT NULL,
  `ticket_sold` int(255) NOT NULL,
  `price_status` int(1) NOT NULL,
  `price_description` longtext NOT NULL,
  `event_id` int(11) NOT NULL,
  `price_level_status` int(1) NOT NULL,
  PRIMARY KEY (`price_level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS kcp_saved_category_event;

CREATE TABLE `kcp_saved_category_event` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `saved_event_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=149 DEFAULT CHARSET=latin1;

INSERT INTO kcp_saved_category_event VALUES("5","1","3");
INSERT INTO kcp_saved_category_event VALUES("4","1","10");
INSERT INTO kcp_saved_category_event VALUES("6","1","29");
INSERT INTO kcp_saved_category_event VALUES("8","2","3");
INSERT INTO kcp_saved_category_event VALUES("9","2","29");
INSERT INTO kcp_saved_category_event VALUES("11","3","3");
INSERT INTO kcp_saved_category_event VALUES("12","3","29");
INSERT INTO kcp_saved_category_event VALUES("14","78","5");
INSERT INTO kcp_saved_category_event VALUES("15","78","43");
INSERT INTO kcp_saved_category_event VALUES("17","81","14");
INSERT INTO kcp_saved_category_event VALUES("18","81","74");
INSERT INTO kcp_saved_category_event VALUES("20","82","4");
INSERT INTO kcp_saved_category_event VALUES("21","82","38");
INSERT INTO kcp_saved_category_event VALUES("23","83","3");
INSERT INTO kcp_saved_category_event VALUES("24","83","29");
INSERT INTO kcp_saved_category_event VALUES("26","93","2");
INSERT INTO kcp_saved_category_event VALUES("27","93","1");
INSERT INTO kcp_saved_category_event VALUES("29","95","14");
INSERT INTO kcp_saved_category_event VALUES("30","95","74");
INSERT INTO kcp_saved_category_event VALUES("39","101","12");
INSERT INTO kcp_saved_category_event VALUES("38","101","13");
INSERT INTO kcp_saved_category_event VALUES("40","103","4");
INSERT INTO kcp_saved_category_event VALUES("41","104","7");
INSERT INTO kcp_saved_category_event VALUES("43","108","4");
INSERT INTO kcp_saved_category_event VALUES("44","108","38");
INSERT INTO kcp_saved_category_event VALUES("46","109","5");
INSERT INTO kcp_saved_category_event VALUES("47","109","45");
INSERT INTO kcp_saved_category_event VALUES("48","109","8");
INSERT INTO kcp_saved_category_event VALUES("49","0","5");
INSERT INTO kcp_saved_category_event VALUES("50","0","45");
INSERT INTO kcp_saved_category_event VALUES("51","0","8");
INSERT INTO kcp_saved_category_event VALUES("52","0","56");
INSERT INTO kcp_saved_category_event VALUES("148","110","56");
INSERT INTO kcp_saved_category_event VALUES("147","110","8");
INSERT INTO kcp_saved_category_event VALUES("146","110","45");
INSERT INTO kcp_saved_category_event VALUES("145","110","5");



DROP TABLE IF EXISTS kcp_saved_events;

CREATE TABLE `kcp_saved_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `event_name_en` text NOT NULL,
  `event_name_sp` text NOT NULL,
  `event_short_desc_en` varchar(255) NOT NULL,
  `event_short_desc_sp` varchar(255) NOT NULL,
  `event_start_date_time` datetime NOT NULL,
  `event_start_ampm` varchar(10) NOT NULL,
  `event_end_date_time` datetime NOT NULL,
  `event_end_ampm` varchar(10) NOT NULL,
  `event_venue_state` int(11) NOT NULL,
  `event_venue_county` int(11) NOT NULL,
  `event_venue_city` int(11) NOT NULL,
  `event_venue` int(11) NOT NULL,
  `event_details_en` longtext NOT NULL,
  `event_details_sp` longtext NOT NULL,
  `event_tag` varchar(255) NOT NULL,
  `event_photo` varchar(200) NOT NULL,
  `identical_function` int(1) NOT NULL,
  `recurring` int(1) NOT NULL,
  `sub_events` int(1) NOT NULL,
  `event_status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `post_date` int(30) NOT NULL,
  `Paypal` int(255) NOT NULL,
  `Bank_deposite` int(255) NOT NULL,
  `Oxxo_Payment` int(255) NOT NULL,
  `Mobile_Payment` int(255) NOT NULL,
  `Offline_Payment` int(255) NOT NULL,
  `paper_less_mob_ticket` int(11) NOT NULL,
  `print` int(11) NOT NULL,
  `will_call` int(11) NOT NULL,
  `public_privacy` int(11) NOT NULL,
  `private_privacy` int(11) NOT NULL,
  `attendees_share` int(11) NOT NULL,
  `attendees_invitation` int(11) NOT NULL,
  `password_protect` int(11) NOT NULL,
  `password_protect_text` varchar(128) NOT NULL,
  `publish_date` datetime NOT NULL,
  `event_time` varchar(255) NOT NULL,
  `event_time_period` varchar(255) NOT NULL,
  `r_month` varchar(255) NOT NULL,
  `r_month_day` varchar(255) NOT NULL,
  `mon` int(255) NOT NULL,
  `tue` int(255) NOT NULL,
  `wed` int(255) NOT NULL,
  `thu` int(255) NOT NULL,
  `fri` int(255) NOT NULL,
  `sat` int(255) NOT NULL,
  `sun` int(255) NOT NULL,
  `r_span_start` date NOT NULL,
  `r_span_end` date NOT NULL,
  `event_start` varchar(255) NOT NULL,
  `event_end` varchar(255) NOT NULL,
  `all_day` int(255) NOT NULL,
  `event_lasts` varchar(255) NOT NULL,
  `include_payment` int(11) NOT NULL,
  `include_promotion` int(11) NOT NULL,
  `all_access` int(11) NOT NULL,
  `unique_id` int(255) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO kcp_saved_events VALUES("1","2","Zomb","Zombie","party","party","2013-07-01 19:00:00","PM","2013-07-31 21:00:00","PM","1","2","20","42","","","","","1","1","0","Y","1374157558","1","1","1","1","1","0","0","0","0","0","0","0","0","","2013-07-31 00:00:00","Weekly","5","","","1","0","1","0","1","0","1","2013-07-01","2013-07-31","02:00 AM","03:45 AM","1","5","0","0","0","14914");
INSERT INTO kcp_saved_events VALUES("2","2","unified","Unified","infotech","infotech","2013-07-01 19:00:00","PM","2013-07-31 21:00:00","PM","1","2","20","41","","","","","1","1","0","Y","1374159305","1","1","1","1","1","1","1","1","0","0","1","1","1","test","0000-00-00 00:00:00","Weekly","5","","","1","1","1","1","1","1","1","2013-07-01","2013-07-31","02:45 AM","04:45 AM","1","5","0","0","0","28050");
INSERT INTO kcp_saved_events VALUES("3","2","India","dance","dancer","dance","2013-07-01 19:00:00","PM","2013-07-31 21:00:00","PM","1","2","20","41","","","","","1","1","0","Y","1374159635","1","1","1","1","1","1","1","1","0","0","1","1","1","test","0000-00-00 00:00:00","Weekly","5","","","1","1","1","1","1","1","1","2013-07-01","2013-07-31","12:15 AM","02:45 AM","1","5","0","0","0","4441");
INSERT INTO kcp_saved_events VALUES("4","2","Nombre del evento","Nombre","","","0000-00-00 19:00:00","PM","0000-00-00 21:00:00","PM","0","0","0","0","","","","","0","0","1","Y","1374214395","0","0","0","0","0","0","0","0","0","0","0","0","0","","0000-00-00 00:00:00","Daily","0","","","0","0","0","0","0","0","0","0000-00-00","0000-00-00","12:00 AM","12:00 AM","0","0","0","0","0","31181");



DROP TABLE IF EXISTS kcp_saved_temporary_multi_events;

CREATE TABLE `kcp_saved_temporary_multi_events` (
  `temp_multi_event_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `event_start_date_time` datetime NOT NULL,
  `event_start_ampm` varchar(10) NOT NULL,
  `multi_venue_state` int(11) NOT NULL,
  `venue_county_multi` int(11) NOT NULL,
  `multi_venue_city` int(11) NOT NULL,
  `multi_venue` int(11) NOT NULL,
  `unique_id` int(30) NOT NULL,
  `post_date` int(30) NOT NULL,
  PRIMARY KEY (`temp_multi_event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO kcp_saved_temporary_multi_events VALUES("1","2","2013-07-01 22:00:00","PM","1","2","20","37","14914","1374157700");
INSERT INTO kcp_saved_temporary_multi_events VALUES("2","2","2013-07-01 19:00:00","PM","1","2","20","42","28050","1374159348");
INSERT INTO kcp_saved_temporary_multi_events VALUES("3","2","2013-07-01 19:00:00","PM","1","2","20","42","4441","1374159754");



DROP TABLE IF EXISTS kcp_saved_tickets;

CREATE TABLE `kcp_saved_tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(111) NOT NULL,
  `ticket_name_en` varchar(255) NOT NULL,
  `ticket_name_sp` varchar(255) NOT NULL,
  `description_en` longtext NOT NULL,
  `description_sp` longtext NOT NULL,
  `price_mx` float(10,2) NOT NULL,
  `price_us` float(10,2) NOT NULL,
  `ticket_num` int(11) NOT NULL,
  `from_ticket` varchar(255) NOT NULL,
  `to_ticket` varchar(255) NOT NULL,
  `eairly_dis_percen` float(5,2) NOT NULL,
  `eairly_days` int(10) NOT NULL,
  `group_dis_per` float(5,2) NOT NULL,
  `group_dis_days` int(10) NOT NULL,
  `ticket_icon` varchar(200) NOT NULL,
  `members_only` varchar(10) NOT NULL,
  `unique_id` varchar(100) NOT NULL,
  `post_date` int(30) NOT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

INSERT INTO kcp_saved_tickets VALUES("9","100","Test Ticket1","Test Ticket1","Test Ticket1 des","Test Ticket1 des","256.00","0.00","200","1375209000","1376159400","0.00","0","0.00","0","","1","868232652","1374338852");
INSERT INTO kcp_saved_tickets VALUES("10","100","English Ticket 2","Ticket 2","Test","Test","150.00","130.00","256","1375295400","1373567400","10.00","0","0.00","0","","1","868232652","1374338923");
INSERT INTO kcp_saved_tickets VALUES("13","104","General inscription for all categories","inscripción general para todas las categorías","Short description","Breve descripción","3000.00","0.00","100","1374258600","1374345000","0.00","0","0.00","0","","1","768613090","1374351287");



DROP TABLE IF EXISTS kcp_setting;

CREATE TABLE `kcp_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(333) NOT NULL,
  `api_login_id` varchar(255) NOT NULL,
  `transaction_key` varchar(255) NOT NULL,
  `authorizenet_sandbox` char(20) NOT NULL,
  `smtp_host` varchar(50) NOT NULL,
  `smtp_port` varchar(50) NOT NULL,
  `smtp_username` varchar(50) NOT NULL,
  `smtp_password` varchar(50) NOT NULL,
  `smtp_active` int(1) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `contact_no` char(50) NOT NULL,
  `gmap_api` varchar(333) NOT NULL,
  `fb_app_id` varchar(256) NOT NULL,
  `fb_secret` varchar(256) NOT NULL,
  `topbanner_link` varchar(256) NOT NULL,
  `topbanner_image` varchar(256) NOT NULL,
  `sidebanner_link` varchar(256) NOT NULL,
  `sidebanner_image` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO kcp_setting VALUES("1","","","","","","","","","0","","","","","","","top_1262447899_01358_D PIC 4 MAS KA RAID_004.jpg","","");



DROP TABLE IF EXISTS kcp_social_login;

CREATE TABLE `kcp_social_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(70) DEFAULT NULL,
  `oauth_uid` varchar(200) DEFAULT NULL,
  `oauth_provider` varchar(200) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `twitter_oauth_token` varchar(200) DEFAULT NULL,
  `twitter_oauth_token_secret` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO kcp_social_login VALUES("1","besus.amit@gmail.com","100002934544470","facebook","besus.amit","","");
INSERT INTO kcp_social_login VALUES("2","amit_bessel@yahoo.co.in","100001288872389","facebook","amitbessel","","");
INSERT INTO kcp_social_login VALUES("3","ml@kpasapp.com","100006413731741","facebook","master.kpasapp","","");



DROP TABLE IF EXISTS kcp_state;

CREATE TABLE `kcp_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `state_name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO kcp_state VALUES("1","138","Baja California Sur");
INSERT INTO kcp_state VALUES("2","96","West Bengal");



DROP TABLE IF EXISTS kcp_sub_event_tickets;

CREATE TABLE `kcp_sub_event_tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(111) NOT NULL,
  `event_id` int(111) NOT NULL,
  `ticket_name_en` varchar(255) NOT NULL,
  `ticket_name_sp` varchar(255) NOT NULL,
  `description_en` longtext NOT NULL,
  `description_sp` longtext NOT NULL,
  `price_mx` float(10,2) NOT NULL,
  `price_us` float(10,2) NOT NULL,
  `ticket_num` int(11) NOT NULL,
  `from_ticket` varchar(255) NOT NULL,
  `to_ticket` varchar(255) NOT NULL,
  `eairly_dis_percen` float(5,2) NOT NULL,
  `eairly_days` int(10) NOT NULL,
  `group_dis_per` float(5,2) NOT NULL,
  `group_dis_days` int(10) NOT NULL,
  `ticket_icon` varchar(200) NOT NULL,
  `members_only` varchar(10) NOT NULL,
  `unique_id` varchar(100) NOT NULL,
  `post_date` int(30) NOT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO kcp_sub_event_tickets VALUES("9","22","6","Ticket1","Ticket1","Ticket1","Ticket1","1200.00","2560.00","60","1375986600","1377023400","0.00","0","0.00","0","","1","1376031205","1376031272");
INSERT INTO kcp_sub_event_tickets VALUES("10","25","9","Ticket1","Ticket1","Ticket1","Ticket1","125.00","1300.00","300","1375986600","1376505000","0.00","0","0.00","0","13760323371371243867teatro ciudad sjs jun 29 brujas 2013.jpg","1","1376032264","1376032339");
INSERT INTO kcp_sub_event_tickets VALUES("12","25","9","Ticket New En","Ticket New Sp","Ticket New","Ticket New","150.00","1040.00","150","1375900200","1376505000","0.00","0","0.00","0","","1","1376032350","1376032469");



DROP TABLE IF EXISTS kcp_temporary_multi_events;

CREATE TABLE `kcp_temporary_multi_events` (
  `temp_multi_event_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `event_start_date_time` datetime NOT NULL,
  `event_start_ampm` varchar(10) NOT NULL,
  `multi_venue_state` int(11) NOT NULL,
  `venue_county_multi` int(11) NOT NULL,
  `multi_venue_city` int(11) NOT NULL,
  `multi_venue` int(11) NOT NULL,
  `unique_id` int(30) NOT NULL,
  `post_date` int(30) NOT NULL,
  PRIMARY KEY (`temp_multi_event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO kcp_temporary_multi_events VALUES("1","2","2013-07-01 13:00:00","PM","1","2","20","51","7590","1374239991");
INSERT INTO kcp_temporary_multi_events VALUES("2","2","2013-07-01 19:00:00","PM","1","2","20","55","23961","1374240401");
INSERT INTO kcp_temporary_multi_events VALUES("3","2","2013-07-31 14:00:00","PM","1","2","20","52","426357927","1374245955");
INSERT INTO kcp_temporary_multi_events VALUES("4","2","2013-07-01 14:00:00","PM","1","2","20","52","1537300154","1374246691");
INSERT INTO kcp_temporary_multi_events VALUES("5","2","2013-08-07 14:00:00","PM","1","2","21","22","1756395155","1374340127");
INSERT INTO kcp_temporary_multi_events VALUES("7","2","2013-08-06 17:10:00","PM","1","2","21","21","1756395155","1374340185");
INSERT INTO kcp_temporary_multi_events VALUES("8","2","2013-08-06 17:10:00","PM","1","2","21","22","1756395155","1374340187");



DROP TABLE IF EXISTS kcp_temporary_tickets;

CREATE TABLE `kcp_temporary_tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(111) NOT NULL,
  `ticket_name_en` varchar(255) NOT NULL,
  `ticket_name_sp` varchar(255) NOT NULL,
  `description_en` longtext NOT NULL,
  `description_sp` longtext NOT NULL,
  `price_mx` float(10,2) NOT NULL,
  `price_us` float(10,2) NOT NULL,
  `ticket_num` int(11) NOT NULL,
  `from_ticket` varchar(255) NOT NULL,
  `to_ticket` varchar(255) NOT NULL,
  `eairly_dis_percen` float(5,2) NOT NULL,
  `eairly_days` int(10) NOT NULL,
  `group_dis_per` float(5,2) NOT NULL,
  `group_dis_days` int(10) NOT NULL,
  `ticket_icon` varchar(200) NOT NULL,
  `members_only` varchar(10) NOT NULL,
  `unique_id` varchar(100) NOT NULL,
  `post_date` int(30) NOT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO kcp_temporary_tickets VALUES("1","0","General","General","General","General","150.00","250.00","300","1371493800","1372444200","0.00","0","0.00","0","","Y","1373976688","1373976688");
INSERT INTO kcp_temporary_tickets VALUES("2","0","General entry","Entrada general","Description","Descripción","150.00","0.00","800","1371407400","1371925800","0.00","0","0.00","0","","","1373976688","1373976688");
INSERT INTO kcp_temporary_tickets VALUES("3","0","General admission","Entrada general","Description","Descripción","150.00","1000.00","200","1371506400","1372456800","0.00","0","0.00","0","","1","1373976688","1373976688");
INSERT INTO kcp_temporary_tickets VALUES("4","0","General","General","General","General","150.00","250.00","300","1371493800","1372444200","0.00","0","0.00","0","","Y","1374047095","1374047095");
INSERT INTO kcp_temporary_tickets VALUES("5","0","General entry","Entrada general","Description","Descripción","150.00","0.00","800","1371407400","1371925800","0.00","0","0.00","0","","","1374047095","1374047095");
INSERT INTO kcp_temporary_tickets VALUES("6","0","General admission","Entrada general","Description","Descripción","150.00","0.00","200","1371580200","1372530600","0.00","0","0.00","0","","","1374047095","1374047095");
INSERT INTO kcp_temporary_tickets VALUES("7","0","General admission","Entrada general","Description","Descripci�n","20.00","0.00","200","1373308200","1374166860","0.00","0","0.00","0","","","1374233693","1374233693");
INSERT INTO kcp_temporary_tickets VALUES("11","0","Vendor fee","Cuota de vendedor","Description","Descripción","120.00","10.00","0","","","0.00","0","0.00","0","","N","1374597747","1374597747");
INSERT INTO kcp_temporary_tickets VALUES("12","0","Vendor level 2 fee","Cuota de vendedor nivel2","Description","Descripci�n","240.00","20.00","6","1371666600","1371839400","0.00","0","0.00","0","","","1374597747","1374597747");
INSERT INTO kcp_temporary_tickets VALUES("13","0","Vendor fee","Cuota de vendedor","Description","Descripción","120.00","10.00","0","","","0.00","0","0.00","0","","N","1374645897","1374645897");
INSERT INTO kcp_temporary_tickets VALUES("14","0","Vendor level 2 fee","Cuota de vendedor nivel2","Description","Descripci�n","240.00","20.00","6","1371666600","1371839400","0.00","0","0.00","0","","","1374645897","1374645897");



DROP TABLE IF EXISTS kcp_type_by_sub_event;

CREATE TABLE `kcp_type_by_sub_event` (
  `sub_event_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `sub_event_id` int(11) NOT NULL,
  `event_master_type_id` int(11) NOT NULL,
  PRIMARY KEY (`sub_event_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=latin1;

INSERT INTO kcp_type_by_sub_event VALUES("36","15","2","1");
INSERT INTO kcp_type_by_sub_event VALUES("37","15","2","2");
INSERT INTO kcp_type_by_sub_event VALUES("79","15","3","1");
INSERT INTO kcp_type_by_sub_event VALUES("80","15","3","3");
INSERT INTO kcp_type_by_sub_event VALUES("81","15","3","4");
INSERT INTO kcp_type_by_sub_event VALUES("97","15","4","1");
INSERT INTO kcp_type_by_sub_event VALUES("98","15","4","3");
INSERT INTO kcp_type_by_sub_event VALUES("99","15","4","4");
INSERT INTO kcp_type_by_sub_event VALUES("136","25","9","1");
INSERT INTO kcp_type_by_sub_event VALUES("137","25","9","2");
INSERT INTO kcp_type_by_sub_event VALUES("156","25","8","8");
INSERT INTO kcp_type_by_sub_event VALUES("157","25","8","9");



DROP TABLE IF EXISTS kcp_user;

CREATE TABLE `kcp_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `father_name` varchar(256) NOT NULL,
  `mother_name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `phone` varchar(256) NOT NULL,
  `country` int(11) NOT NULL,
  `country_code` varchar(256) NOT NULL,
  `city` varchar(256) NOT NULL,
  `state` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `confirmation_email` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS kcp_user_saved_events;

CREATE TABLE `kcp_user_saved_events` (
  `saved_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`saved_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO kcp_user_saved_events VALUES("5","2","10","2013-08-07 19:28:38");
INSERT INTO kcp_user_saved_events VALUES("6","2","2","2013-08-07 19:28:44");



DROP TABLE IF EXISTS kcp_venue;

CREATE TABLE `kcp_venue` (
  `venue_id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_name` varchar(333) NOT NULL,
  `venue_name_sp` varchar(255) NOT NULL,
  `venue_country` int(7) NOT NULL,
  `venue_address` varchar(333) NOT NULL,
  `venue_short_add_sp` text NOT NULL,
  `venue_short_add_en` text NOT NULL,
  `venue_city` int(7) NOT NULL,
  `venue_state` int(7) NOT NULL,
  `venue_county` int(7) NOT NULL,
  `venue_zip` varchar(333) NOT NULL,
  `event_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `venue_active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `venue_contact_name` varchar(333) NOT NULL,
  `venue_head_manager` varchar(256) NOT NULL,
  `venue_authorize_manager` varchar(256) NOT NULL,
  `venue_description` text NOT NULL,
  `venue_description_sp` text NOT NULL,
  `venue_capacity` int(100) NOT NULL,
  `venue_url` varchar(333) NOT NULL,
  `venue_phone` varchar(50) NOT NULL,
  `venue_cell` varchar(256) NOT NULL,
  `venue_fax` varchar(50) NOT NULL,
  `venue_email` varchar(333) NOT NULL,
  `venue_map` varchar(256) NOT NULL,
  `venue_media_gallery` varchar(256) NOT NULL,
  `venue_image` varchar(222) NOT NULL,
  `allowed_commments` int(11) NOT NULL,
  `allowed_share` int(11) NOT NULL,
  `show_FB_like` int(11) NOT NULL,
  `public_privacy` int(11) NOT NULL,
  `private_privacy` int(11) NOT NULL,
  `tags` varchar(1024) NOT NULL,
  `publish_date` datetime NOT NULL,
  `post_date` int(11) NOT NULL,
  `venue_stat` int(11) NOT NULL COMMENT '1=saved,2=publish',
  `unique_id` varchar(256) NOT NULL,
  PRIMARY KEY (`venue_id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

INSERT INTO kcp_venue VALUES("1","Teatro de la Ciudad \"Miguel Lomeli Cese&ntilde;a\"","","138","Calle Ignacio Zaragoza","","","36","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("3","Playa Medano","Medano Beach","138","Playa Medano","","","37","1","4","","0","1","1","Y","None","","","","","0","","none","none","","admin@kpasapp.com","","","","0","0","0","1","0","","2013-08-09 00:00:00","0","2","");
INSERT INTO kcp_venue VALUES("6","pabellon cultural de la republica","pabellón cultural de la republica","138","Blvd Marina","","","37","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","1","0","","0000-00-00 00:00:00","0","1","");
INSERT INTO kcp_venue VALUES("7","Art District","","138","Calle Alvaro Obregon","","","36","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("10","Pueblo Bonito Pacifica Resort & Spa","","138","Pacifico","","","37","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("11","Wyndham Cabo San Lucas Resort","","138",", Boulevard Marina S/N Lote 9 y 10","","","37","1","4","23450","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("12","Nikki Beach Cabo San Lucas","","138","ME Cabo Playa El Medano","","","37","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("13","Mar A Dentro","","138","Camino del Colegio, Colonia Pedregal","","","37","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("14","El Squid Roe, Cabo san Lucas","","138","Lázaro Cárdenas Sn, colonia Centro","","","37","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("15","The Shoppes at Palmilla","","138","Car Transpeninsular km 27.5","","","36","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("16","Huerta Maria","","138","Camino a Las Animas","","","36","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("17","Ciclovia San Lucas","","138","Blvd Marina","","","37","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("18","Hotel Buena Vista Beach Resort","","138","Carr. Federal #1 Km. 105, Buena Vista ","","","28","1","2","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("21","El Pescadero","","138","El Pescadero","","","21","1","2","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("20","Loreto Malecon costero","Loreto Malecón costero","138","Paseo A. Lopez Mateos","","","33","1","3","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","1","0","","0000-00-00 00:00:00","0","1","");
INSERT INTO kcp_venue VALUES("22","Central Plaza","","138","Central Plaza","","","21","1","2","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("25","Zippers beach","","138","Costa Azul,  carretera transpeninsular Km.28.5","","","36","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("24","Tsegyalgar West ","","138","Rancho Los Naranjos","","","36","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("26","Centro historico","","138","centro","","","36","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("27","Plaza Mijares","","138","Plaza Mijares","","","36","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("28","Estadio de basebol","","138","Estadio de basebol","","","36","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("29","Restaurant Market at One&Only Palmilla","","138","Carretera Transpeninsular (Carretera Federal 1) Km. 7.5","","","36","1","4","23400","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("30","One&Only Palmilla","","138","Carretera Transpeninsular (Carretera Federal 1) Km. 7.5","","","36","1","4","23400","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("31","Casa de la Cultura SJD","","138"," Plaza Mijares Y Calle Alvaro Obregón","","","36","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("32","Hotel Westin los Cabos","","138","Carretera Transpeninsular KM 22.5","","","36","1","4","23400","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("33","Baja Cantina Medano","","138","Playa Medano","","","37","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("34","Casa de la cultura del estado","","138","Navarro y Héroes de Independencia, Zona Centro","","","20","1","2","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("35","Alianza Francesa","","138","Gomez Farias 525, between República and Guerrero","","","20","1","2","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("36","CICIMAR (Centro Interdisciplinario de Ciencias Marinas)","","138","Av. Instituto Politécnico Nacional","","","20","1","2","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("37","Casa de Cultura Municipal","","138","Calle Queretaro esqu. Yucatan #1810","","","20","1","2","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("38","Malecon","","138","Alvaro Obregon","","","20","1","2","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("39","Centro Cultural La Paz","","138","16 de Septiembre esqu. Belisario Dominguez","","","20","1","2","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("40","Kiosko en el Malec�n","","138","16 de Septiembre y Alvaro obregon","","","20","1","2","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("41","Palacio de Gobierno","","138","Plaza de la Reforma, Isabel la Católica entre Bravo y Rosales","","","20","1","2","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("42","Teatro de la Ciudad ","","138","Navarro y Héroes de Independencia","","","20","1","2","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("43","Parque Gral. Melita � n Albaa � ez","","138","Barrio San Ignacio","","","21","1","2","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("44","Circoteka Centro Cultural ","","138","Angela Ceseña Entre Barlovento Y Transpeninsular, Rosarito","","","36","1","4","23407","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("45","Walmart Plaza","","138","Plaza San Lucas","","","37","1","4","23454","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("46","Hotel Palmas de Cortez","","138","Avenida 2o de Noviembre S/N ","","","28","1","2","23330","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("47","Amit Venue English","Amit Venue Spanish","0","New Road, Street lane\n\nGanguly Street","TEST","	Venue listing:\n\n	venue, city, county, state, public/private, edit/duplicate/delete, preview\n\n	Sorted on state, county, city\n\n	In venue listing all venu","20","1","2","9876543210","0","2","0","Y","Amit Banerjee","Sudip Ghosh","Nirmal Ghosh","<p dir=\"ltr\" style=\"line-height:1.15;margin-top:0pt;margin-bottom:0pt;\">\n	<b id=\"docs-internal-guid-46262a06-f1f2-393a-319d-a0c96503780d\" style=\"font-weight:normal;\"><span style=\"font-size:15px;font-family:Arial;color:#000000;background-color:transparent;font-weight:normal;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\">Venue listing:</span></b></p>\n<p dir=\"ltr\" style=\"line-height:1.15;margin-top:0pt;margin-bottom:0pt;\">\n	<b id=\"docs-internal-guid-46262a06-f1f2-393a-319d-a0c96503780d\" style=\"font-weight:normal;\"><span style=\"font-size:15px;font-family:Arial;color:#000000;background-color:transparent;font-weight:normal;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\">venue, city, county, state, public/private, edit/duplicate/delete, preview</span></b></p>\n<p dir=\"ltr\" style=\"line-height:1.15;margin-top:0pt;margin-bottom:0pt;\">\n	<b id=\"docs-internal-guid-46262a06-f1f2-393a-319d-a0c96503780d\" style=\"font-weight:normal;\"><span style=\"font-size:15px;font-family:Arial;color:#000000;background-color:transparent;font-weight:normal;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\">Sorted on state, county, city</span></b></p>\n<p dir=\"ltr\" style=\"line-height:1.15;margin-top:0pt;margin-bottom:0pt;\">\n	<b id=\"docs-internal-guid-46262a06-f1f2-393a-319d-a0c96503780d\" style=\"font-weight:normal;\"><span style=\"font-size:15px;font-family:Arial;color:#000000;background-color:transparent;font-weight:normal;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\">In venue listing all venue created by that professional user will show</span></b></p>\n<p>\n	<b id=\"docs-internal-guid-46262a06-f1f2-393a-319d-a0c96503780d\" style=\"font-weight:normal;\"><span style=\"font-size:15px;font-family:Arial;color:#000000;background-color:transparent;font-weight:normal;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\">private venues will show in backend for venue manager only</span></b></p>\n","<ul style=\"margin-top:0pt;margin-bottom:0pt;\">\n	<li dir=\"ltr\" style=\"list-style-type:disc;font-size:15px;font-family:Arial;color:#ff0000;font-weight:normal;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;\">\n		<p dir=\"ltr\" style=\"line-height:1.15;margin-top:0pt;margin-bottom:0pt;\">\n			<span style=\"color:#f0ffff;\"><b id=\"docs-internal-guid-52dc6a0a-7255-0cd2-72cc-18cc4a550451\" style=\"font-weight:normal;\"><span style=\"font-size: 15px; font-family: Arial; font-weight: normal; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span style=\"background-color: rgb(0, 0, 128);\">Finish the event section and the signin/signup!!!!</span></span></b></span></p>\n	</li>\n	<li dir=\"ltr\" style=\"list-style-type:disc;font-size:15px;font-family:Arial;color:#ff0000;background-color:#ffff00;font-weight:normal;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;\">\n		<p dir=\"ltr\" style=\"line-height:1.15;margin-top:0pt;margin-bottom:0pt;\">\n			<span style=\"color:#f0ffff;\"><b id=\"docs-internal-guid-52dc6a0a-7255-0cd2-72cc-18cc4a550451\" style=\"font-weight:normal;\"><span style=\"font-size: 15px; font-family: Arial; font-weight: normal; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span style=\"background-color: rgb(0, 0, 128);\">Then finish venues section.</span></span></b></span></p>\n	</li>\n	<li dir=\"ltr\" style=\"list-style-type:disc;font-size:15px;font-family:Arial;color:#ff0000;background-color:#ffff00;font-weight:normal;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;\">\n		<span style=\"color:#f0ffff;\"><b id=\"docs-internal-guid-52dc6a0a-7255-0cd2-72cc-18cc4a550451\" style=\"font-weight:normal;\"><span style=\"font-size: 15px; font-family: Arial; font-weight: normal; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span style=\"background-color: rgb(0, 0, 128);\">Then you can move on to performers &amp; providers.</span></span></b></span></li>\n</ul>\n<p>\n	<br />\n	&nbsp;</p>\n","40","http://google.com","998754210","987654210","5564210","test@gmail.com","2","10","","0","1","1","0","1","Players,Test","2013-08-11 00:00:00","1374153848","2","");
INSERT INTO kcp_venue VALUES("52","Well","Amit Venue Sp1 New","0","75/1 New Road, Street lane\n\nGanguly Street","TEST","	Venue listing:\n\n	venue, city, county, state, public/private, edit/duplicate/delete, preview\n\n	Sorted on state, county, city\n\n	In venue listing all venu","20","1","2","9876543210","0","2","0","Y","Amit Banerjee","Sudip Ghosh","Nirmal Ghosh","<p dir=\"ltr\" style=\"line-height:1.15;margin-top:0pt;margin-bottom:0pt;\">\n	<b id=\"docs-internal-guid-46262a06-f1f2-393a-319d-a0c96503780d\" style=\"font-weight:normal;\"><span style=\"font-size:15px;font-family:Arial;color:#000000;background-color:transparent;font-weight:normal;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\">Venue listing:</span></b></p>\n<p dir=\"ltr\" style=\"line-height:1.15;margin-top:0pt;margin-bottom:0pt;\">\n	<b id=\"docs-internal-guid-46262a06-f1f2-393a-319d-a0c96503780d\" style=\"font-weight:normal;\"><span style=\"font-size:15px;font-family:Arial;color:#000000;background-color:transparent;font-weight:normal;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\">venue, city, county, state, public/private, edit/duplicate/delete, preview</span></b></p>\n<p dir=\"ltr\" style=\"line-height:1.15;margin-top:0pt;margin-bottom:0pt;\">\n	<b id=\"docs-internal-guid-46262a06-f1f2-393a-319d-a0c96503780d\" style=\"font-weight:normal;\"><span style=\"font-size:15px;font-family:Arial;color:#000000;background-color:transparent;font-weight:normal;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\">Sorted on state, county, city</span></b></p>\n<p dir=\"ltr\" style=\"line-height:1.15;margin-top:0pt;margin-bottom:0pt;\">\n	<b id=\"docs-internal-guid-46262a06-f1f2-393a-319d-a0c96503780d\" style=\"font-weight:normal;\"><span style=\"font-size:15px;font-family:Arial;color:#000000;background-color:transparent;font-weight:normal;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\">In venue listing all venue created by that professional user will show</span></b></p>\n<p>\n	<b id=\"docs-internal-guid-46262a06-f1f2-393a-319d-a0c96503780d\" style=\"font-weight:normal;\"><span style=\"font-size:15px;font-family:Arial;color:#000000;background-color:transparent;font-weight:normal;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\">private venues will show in backend for venue manager only</span></b></p>\n","<p dir=\"ltr\" style=\"line-height:1.15;margin-top:0pt;margin-bottom:0pt;\">\n	<b id=\"docs-internal-guid-46262a06-f1f2-4dec-1da4-05295cf0bbce\" style=\"font-weight:normal;\"><span style=\"font-size:15px;font-family:Arial;color:#000000;background-color:transparent;font-weight:normal;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\">They will not show on frontend, except for authorized users</span></b></p>\n<p dir=\"ltr\" style=\"line-height:1.15;margin-top:0pt;margin-bottom:0pt;\">\n	<b id=\"docs-internal-guid-46262a06-f1f2-4dec-1da4-05295cf0bbce\" style=\"font-weight:normal;\"><span style=\"font-size:15px;font-family:Arial;color:#000000;background-color:transparent;font-weight:normal;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\">venue manager can filter by state,county, city</span></b></p>\n","40","http://google.com","998754210","987654210","5564210","test@gmail.com","2","10","","0","1","1","0","1","Players,Test","2013-08-22 00:00:00","1374235446","2","");
INSERT INTO kcp_venue VALUES("55","Rec","Recent","0","fef","fef","fef","20","1","2","Zipcode","0","2","0","Y","Amit Banerjee","Sudip Ghosh","","<p>\n	fsfsf</p>\n","<p>\n	dfsdf</p>\n","0","http://www.tickethype.com/admin/venue/1/edit","9871100","911100","2323","amit.unified@gmail.com","","","","1","1","1","0","1","","2013-07-19 00:00:00","1374235669","2","");
INSERT INTO kcp_venue VALUES("57","250 km off-road Comondu circuit ","Ruta de off-road Comondu 250km","0","Frente del Palacio Municipal","Referencias de ruta. Carrera Expo Comondú 250:\n\n	•\n\n	Entrada a zona de arranque por Boulevard de Ciudad Insurgentes / La Toba, de sur a norte","Short Description","9","1","1","Zipcode","0","2","0","Y","Racing Baja Road","","","","<div>\n	Referencias de ruta. Carrera Expo Comond&uacute; 250:</div>\n<div>\n	&bull;</div>\n<div>\n	Entrada a zona de arranque por Boulevard de Ciudad Insurgentes / La Toba, de sur a norte esquina de negocio &ldquo;El&eacute;ctrica y Plomer&iacute;a Sudcaliforniana&rdquo;, a la izq., hasta el fondo a topar con &ldquo;Los Pinos&rdquo;.</div>\n<div>\n	&bull;</div>\n<div>\n	Arranque de carrera: Zona de &ldquo;Los Pinos&rdquo; junto a plantaci&oacute;n de sorgo.</div>\n<div>\n	&bull;</div>\n<div>\n	Primer curva a la derecha (zona no apta para aficionados pro la parte de afuera: izquierda)</div>\n<div>\n	&bull;</div>\n<div>\n	Km 4.6 de carrera: cruce de carretera L&oacute;pez Mateos a la derecha.</div>\n<div>\n	&bull;</div>\n<div>\n	Km. 6.4 junto a bordo de lodo, es por la derecha en ambas ocasiones, no subir bordo.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 15.3, a la derecha en camino reci&eacute;n raspado.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 17 camino paralelo a l&iacute;nea de torres el&eacute;ctricas.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 24, despu&eacute;s de l&iacute;nea de torres vuelta a la izquierda en camino con grava.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 28.5 a la derecha en Pata de Gallo Pante&oacute;n</div>\n<div>\n	&bull;</div>\n<div>\n	Km 29.5 cruce de camino raspado en poblado &ldquo;Mar&iacute;a Auxiliadora&rdquo;. Check Point #1. Radio Aficionados.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 69.5 cruce de carretera L&oacute;pez Mateos. Derecho por l&iacute;nea de postes. Ambulancia.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 79.5 a la izquierda en peque&ntilde;a estaci&oacute;n el&eacute;ctrica y basurero.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 76.5 talco de aprox 300 metros. Zona libre por cualquier l&iacute;nea.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 82.5 Guardaganado, empieza poster&iacute;a.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 86.5 pata de gallo: derecho.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 87 Check Point #2. Seguridad p&uacute;blica / Ambulancia / radio Aficionados</div>\n<div>\n	&bull;</div>\n<div>\n	Km 104.5 a la izquierda en camino de salitral</div>\n<div>\n	&bull;</div>\n<div>\n	Km 117 camino paralelo a salitrales con cerco</div>\n<div>\n	&bull;</div>\n<div>\n	Km 125 Cruce de carretera a San Carlos km 41. Check Point #3. Seguridad P&uacute;blica / Ambulancia / Radio Aficionados</div>\n<div>\n	&bull;</div>\n<div>\n	Km 127.5, despu&eacute;s del cruce de carretera, virar a la izquierda en camino por l&iacute;nea de torres.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 135.5 a la derecha en entrada del &ldquo;Sif&oacute;n&rdquo;.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 160 vuelta a la derecha Check Point #4. Radio Aficionados.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 176.2 vuelta en &ldquo;U&rdquo;.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 184 &ldquo;Llanos de Irai&rdquo; a la izquierda.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 189.5 &ldquo;El Refugio&rdquo;.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 213 guarda ganado.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 226.3 carretera a San Carlos km 13, Check Point #5. La carrera sigue por debajo de la carretera paralelamente. Seguridad p&uacute;blica / Ambulancia / Radio Aficionados.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 227. Cuidado. Peligroso!</div>\n<div>\n	&bull;</div>\n<div>\n	Km 229 vuelta a la derecha en molino.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 231 Al final del cerco a la izquierda.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 239. Al llegar a la carretera a la derecha.</div>\n<div>\n	&bull;</div>\n<div>\n	Km 243.5 Bodega Fertimex. Alto total, Meta, corte de tiempo, ingreso a bodega a velocidad moderada.</div>\n","0","","613-1234567","613-1234568","","rbr@kpasapp.com","","","1374502694Comondu 250 Ruta.jpg","1","1","1","1","0","","2013-07-20 00:00:00","1374350344","1","");
INSERT INTO kcp_venue VALUES("58","Flora Farm","","138","Las Animas Bajas, East Cape Road, left at Cemex plant","","","36","1","4","","0","1","1","Y","","","","","","0","","","","","","","","","0","0","0","0","0","","0000-00-00 00:00:00","0","0","");
INSERT INTO kcp_venue VALUES("59","Rock & Brew Los Cabos","Rock & Brew Los Cabos","0","Paseo Malecon San Jose Del Cabo, Plaza Del Pescador, Local 1","Casual, ideal para familias, bar al aire libre con tema de rock y un restaurante conocido por una amplia selección de cervezas y asequible, cocina americana de alta calidad. Ahora en San José Del Cabo","Casual, family friendly, rock-themed beer garden and restaurant known for broad selection of beers and affordable, high quality American cuisine. Now open in San Jose del Cabo","36","1","4","Zipcode","0","2","0","Y","Manager","","","<p>\n	Our first international destination, Rock &amp; Brews Los Cabos embodies the youthful energy of one of the world&rsquo;s most popular spring break destinations. With a full bar and live music several nights a week, our Los Cabos installment takes our backstage concept and brings it front stage, making the restaurant a serious contender in the local club scene. At Rock &amp; Brews Los Cabos, you can be a concert-goer, a club-savvy college student, a casual beer drinker, or a family man&mdash;but regardless of who you are, we make all of our guests feel like rock stars.</p>\n","<p>\n	<span id=\"result_box\" lang=\"es\" tabindex=\"-1\"><span class=\"hps\">Nuestro primer</span> <span class=\"hps\">destino internacional</span>, <span class=\"hps\">Rock &amp;</span> <span class=\"hps\">Brews</span> <span class=\"hps\">Los</span> <span class=\"hps\">Cabos</span> <span class=\"hps\">encarna la energ&iacute;a</span> <span class=\"hps\">juvenil de</span> <span class=\"hps\">uno de los destinos</span> <span class=\"hps\">de vacaciones de primavera</span> <span class=\"hps\">m&aacute;s populares</span> <span class=\"hps\">del mundo.</span> <span class=\"hps\">Con</span> <span class=\"hps\">un completo bar y</span> <span class=\"hps\">m&uacute;sica en vivo</span> <span class=\"hps\">varias noches a la</span> <span class=\"hps\">semana</span>, <span class=\"hps\">nuestra</span> <span class=\"hps\">entrega</span> <span class=\"hps\">Los</span> <span class=\"hps\">Cabos</span> <span class=\"hps\">toma nuestro</span> <span class=\"hps\">backstage</span> <span class=\"hps\">concepto</span> <span class=\"hps\">y lo lleva</span> <span class=\"hps\">frente del escenario</span>, por lo que <span class=\"hps\">el restaurante</span> <span class=\"hps\">un contendiente</span> <span class=\"hps\">serio en</span> <span class=\"hps\">la escena del club</span> <span class=\"hps\">local.</span> <span class=\"hps\">En</span> <span class=\"hps\">Rock &amp;</span> <span class=\"hps\">Brews</span> <span class=\"hps\">Los</span> <span class=\"hps\">Cabos</span>, puede <span class=\"hps\">ser</span> <span class=\"hps\">un concierto</span><span>-asistente</span>, <span class=\"hps\">un estudiante universitario</span> <span class=\"hps\">del club</span> <span class=\"hps\">con experiencia,</span> <span class=\"hps\">un bebedor de cerveza</span> <span class=\"hps\">ocasional</span>, <span class=\"hps\">o</span> <span class=\"hps\">un</span> <span class=\"hps\">hombre de familia</span>, pero <span class=\"hps\">independientemente</span> <span class=\"hps\">de lo que eres</span>, lo hacemos <span class=\"hps\">todos nuestros</span> <span class=\"hps\">hu&eacute;spedes se sientan</span> <span class=\"hps\">como estrellas de rock</span>.</span></p>\n","200","http://rockandbrews.com/loscabos/","(624) 105-2705","(624) 105-2705","","loscabos@rockandbrews.com","","","1375165369Rock&amp;Brew-loscabos.jpg","1","1","1","1","0","","2013-07-29 00:00:00","1375165402","0","");
INSERT INTO kcp_venue VALUES("62","Marina Cabo San lucas","Marina Cabo San lucas","0","Lote A-18 De la Darsena","Marina Cabo San Lucas es un establecimiento moderno ubicado estratégicamente en el puerto de Cabo San Lucas, en la punta de la península de Baja.","Marina Cabo San Lucas is a modern facility strategically located in the harbor of Cabo San Lucas, at the very tip of the Baja Peninsula. ","37","1","4","Zipcode","0","1","0","Y","Manager","","","<p>\n	Marina Cabo San Lucas is a modern facility strategically located in the harbor of Cabo San Lucas, at the very tip of the Baja Peninsula.&nbsp; All services expected in a first-class Cabo San Lucas marina are available to our guests.&nbsp; Unquestionably one of the world&#39;s foremost yachting, sport fishing and mega-yacht lifestyle destinations, this Cabo San Lucas marina offers an outstanding range of on-site conveniences for luxury yacht owners, their guests and crew members. As the central hub for the world&rsquo;s largest and most popular sportfish tournaments, this Cabo San Lucas marina is a busy center of activity focused on water sports, luxury shopping and dining. Of all Cabo San Lucas marinas, this one is at the mouth of the Sea of Cortez &ndash; the most sought-after location in the peninsula. Featuring 380 slips and accommodating yachts up to 375 feet, this Cabo San Lucas marina also has 24-hour security, crew facilities, WiFi and cable.&nbsp;</p>\n<p>\n	Come on down to one of the hottest cruising destinations on the Pacific coast.&nbsp; Cabo San Lucas Marina is located on one of the main cruiser routes at the tip of the Baja Peninsula.&nbsp; Right on the main harbour, but tucked away from any serious weather, the Cabo San Lucas Marina, one of the world-wide IGY marinas, can accommodate up to 380 yachts up to 375 feet long.<br />\n	<br />\n	Of all the Cabo San Lucas marinas you can count on best-in-class service and facilities at this IGY marina.&nbsp; Our experienced and professional staff will work with you to ensure a safe and pleasant stay.&nbsp; Cabo San Lucas Marina is equipped to handle any boating need you might have. Our boatyard can do minor repairs, an upgrade or a complete overhaul of your vessel.&nbsp; Need a haul-out? The marina&rsquo;s 80-ton lift can accommodate boats up to 80 feet.<br />\n	<br />\n	When you cruise down the Baja you&rsquo;ll find there are a number of Cabo San Lucas Marinas.&nbsp; We believe we have the best facility to handle all your boating needs.&nbsp; At the modern fuel dock we can pump 70 gallons a minute and close by we&rsquo;ll look after your wastewater and sewage disposal needs.<br />\n	<br />\n	When you cruise into one of the Cabo San Lucas Marinas security might be a concern.&nbsp; Rest assured that our world-class IGY facility provides 24-hour surveillance using guards, electronic key card access and video coverage.&nbsp; Your person and property will be safe and secure during your stay with us.<br />\n	<br />\n	Need provisions or water?&nbsp; Our friendly staff will assist you with both of these needs. With our own 40,000 gallons per day water desalination and reverse osmosis plant we can top up your water tanks in no time at all.&nbsp; The retail shops in the Cabo San Lucas marinas and others in the immediate neighbourhood will cater to your every need for food and drink.<br />\n	<br />\n	There are over 50 restaurants to choose from just a few steps from the marina.&nbsp;&nbsp; You&rsquo;ll find that there&rsquo;s an eatery for every taste and occasion from fast food chains to top-end international dining opportunities.&nbsp; If you want do some shopping, just steps from the marina you&rsquo;ll find Plaza Paraiso, the largest mall in the area with a broad range of stores.<br />\n	<br />\n	And if you want some action, the waters off Cabo San Lucas Marinas provide some of the best sea fishing in the world.&nbsp; Do some snorkelling along the coast or take a sunset cruise, tee up at one of our eight beautiful golf courses.&nbsp; The possibilities for recreation are endless at Cabo San Lucas Marina.</p>\n<p style=\"text-align: center;\">\n	Lote A-18 De la Darsena<br />\n	Cabo San Lucas,<br />\n	Baja California Sur, Mexico<br />\n	T +52-624-173- 9140<br />\n	F +52-624-14-312-53<br />\n	E <a href=\"mailto:CSL@igymarinas.com\">CSL@igymarinas.com</a> &nbsp;<br />\n	<a href=\"http://www.igy-cabosanlucas.com/\">www.igy-cabosanlucas.com</a></p>\n","","0","www.igy-cabosanlucas.com","624-173 9140","624-173 9140","","csl@iggymarinas.com","","","1376232878cabo.san.lucas.marinas.jpg","1","1","1","1","0","","2013-08-09 00:00:00","1376232925","2","");



DROP TABLE IF EXISTS kcp_venue_types;

CREATE TABLE `kcp_venue_types` (
  `venue_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_id` int(11) NOT NULL,
  `event_master_type_id` int(11) NOT NULL,
  PRIMARY KEY (`venue_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=220 DEFAULT CHARSET=latin1;

INSERT INTO kcp_venue_types VALUES("211","47","9");
INSERT INTO kcp_venue_types VALUES("210","47","8");
INSERT INTO kcp_venue_types VALUES("209","47","2");
INSERT INTO kcp_venue_types VALUES("208","47","1");
INSERT INTO kcp_venue_types VALUES("219","52","9");
INSERT INTO kcp_venue_types VALUES("218","52","8");
INSERT INTO kcp_venue_types VALUES("217","52","2");
INSERT INTO kcp_venue_types VALUES("216","52","1");
INSERT INTO kcp_venue_types VALUES("106","0","7");
INSERT INTO kcp_venue_types VALUES("114","57","7");
INSERT INTO kcp_venue_types VALUES("115","1","1");
INSERT INTO kcp_venue_types VALUES("116","1","4");
INSERT INTO kcp_venue_types VALUES("117","1","6");
INSERT INTO kcp_venue_types VALUES("118","2","2");
INSERT INTO kcp_venue_types VALUES("119","2","6");
INSERT INTO kcp_venue_types VALUES("120","2","8");
INSERT INTO kcp_venue_types VALUES("121","15","1");
INSERT INTO kcp_venue_types VALUES("122","15","2");
INSERT INTO kcp_venue_types VALUES("123","21","1");
INSERT INTO kcp_venue_types VALUES("124","21","2");
INSERT INTO kcp_venue_types VALUES("125","3","7");
INSERT INTO kcp_venue_types VALUES("127","62","7");



