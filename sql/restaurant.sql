-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2019. Már 21. 13:06
-- Kiszolgáló verziója: 10.1.31-MariaDB
-- PHP verzió: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `restaurant`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `shipping_address` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `billing_address` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `username` varchar(128) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `addresses`
--

INSERT INTO `addresses` (`id`, `shipping_address`, `billing_address`, `username`) VALUES
(1, 'Kek Str. 19.', 'Kek Str. 20.', 'kekelek'),
(2, 'Tea Hgw. 23/B.', 'Bill Str. 12.', 'tesztelek'),
(3, 'user str. 19.', 'user str. 19', 'username');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `status` varchar(16) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `cart`
--

INSERT INTO `cart` (`id`, `food_id`, `user_id`, `quantity`, `subtotal`, `status`) VALUES
(1, 15, 2, 2, 244, 'order '),
(4, 47, 2, 2, 2380, 'order '),
(5, 46, 2, 1, 650, 'order ');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `subject` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
  `message` text COLLATE utf8_hungarian_ci NOT NULL,
  `submitted_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `submitted_at`) VALUES
(1, 'Kek Elek', 'kek.elek@gmail.com', 'This is a subject', 'This suppose to work fine now!', '2019-02-28'),
(2, 'Akcios Aron', 'akcios.aron@gmail.com', 'Is it working?', 'Hello dear admin!\r\n\r\nVery funny name, indeed....But it is NOT on sale!', '2019-03-01');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `favlists`
--

CREATE TABLE `favlists` (
  `id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `favlist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `foods`
--

CREATE TABLE `foods` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `price` int(11) NOT NULL,
  `type` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `attr` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `imgpath` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `food_desc` text COLLATE utf8_hungarian_ci NOT NULL,
  `class` varchar(32) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `foods`
--

INSERT INTO `foods` (`id`, `name`, `price`, `type`, `attr`, `imgpath`, `food_desc`, `class`) VALUES
(15, 'BBQ', 1450, 'maincourse', 'normal', 'food6.jpg', 'Wonder how good can be the true american barbeque? Find out with us!', 'restaurant'),
(16, 'Shrimp and Salad', 350, 'starter', 'special sugarf', 'food4.jpg', 'If you like the fruits of the seven seas, you may like this salad, which capable to be the part of your special diet as well.', 'restaurant'),
(17, 'Fruit Frenzy', 450, 'starter', 'normal', 'food10.jpg', 'Eat healthy and try our fruit cocktail before your main course. You wont regret it.', 'restaurant'),
(18, 'Citrus Salad', 350, 'starter', 'special glutenf', 'food8.jpg', 'This salad is flavored by lemon and cinnamon. This may seems odd at first, but we boldly recommend you to give it a try.', 'restaurant'),
(19, 'Pancake', 250, 'dessert', 'normal', 'food9.jpg', 'If you have never eat hungarian pancake before, maybe its your time to taste it!', 'restaurant'),
(20, 'Vegan Milan Spaghetti', 450, 'maincourse', 'special', 'food7.jpg', 'If you fond of italian cuisine but you defend animals rights to live, you can still eat this vegan spaghetti. Its cooked on a traditional way, but it doesnt contain any meal.', 'restaurant'),
(21, 'Vegetable Salad', 400, 'starter', 'special lactosef', 'food2.jpg', 'If you are on a diet, maybe this will be your best choice! Delicious salad from fresh ingredients with a lot of vitamin.', 'restaurant'),
(22, 'Fruit Salad', 300, 'starter', 'special', 'food5.jpg', 'If you like fruits and vegetables as well, than this is your salad! This mixture is for the culinary adventurers who like to try many new, or groundbreaking', 'restaurant'),
(46, 'Chicken Gyros', 650, 'maincourse', 'normal', 'chickengyros.jpg', 'This is a chicken gyros made in a traditional greek way. Just try it out, really..', 'webshop'),
(47, 'Pizza', 1190, 'maincourse', 'normal', 'pizza.jpg', 'This is a delicious pizza made in a true italian way...Bon\' a petit!', 'webshop');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `nutrients`
--

CREATE TABLE `nutrients` (
  `nutrient_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `protein` decimal(4,2) NOT NULL,
  `carb` decimal(4,2) NOT NULL,
  `sodium` decimal(4,2) NOT NULL,
  `fiber` decimal(4,2) NOT NULL,
  `fat` decimal(4,2) NOT NULL,
  `sat_fat` decimal(4,2) NOT NULL,
  `sugar` decimal(4,2) NOT NULL,
  `cholesterol` decimal(3,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `nutrients`
--

INSERT INTO `nutrients` (`nutrient_id`, `food_id`, `protein`, `carb`, `sodium`, `fiber`, `fat`, `sat_fat`, `sugar`, `cholesterol`) VALUES
(3, 15, '8.00', '5.00', '1.24', '1.00', '8.00', '18.00', '4.00', '0.39'),
(4, 16, '0.42', '6.00', '0.40', '2.00', '1.00', '12.00', '0.10', '0.00'),
(5, 17, '0.41', '6.00', '0.20', '8.60', '1.20', '12.00', '0.11', '0.00'),
(6, 18, '0.21', '2.22', '0.12', '7.72', '4.11', '1.89', '0.30', '0.00'),
(7, 19, '1.70', '2.00', '0.10', '0.10', '2.30', '4.20', '2.30', '0.00'),
(8, 20, '0.97', '3.60', '0.80', '1.79', '2.00', '4.20', '0.10', '0.00'),
(9, 21, '0.40', '3.00', '0.20', '3.60', '0.70', '2.80', '0.10', '0.00'),
(10, 22, '0.70', '1.80', '0.10', '4.20', '1.20', '2.00', '0.10', '0.00'),
(18, 46, '3.70', '9.40', '0.90', '0.20', '4.70', '7.10', '0.10', '4.00'),
(19, 47, '3.10', '5.60', '0.10', '0.20', '5.40', '7.00', '0.00', '6.10');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `items` text COLLATE utf8_hungarian_ci NOT NULL,
  `progress` varchar(16) COLLATE utf8_hungarian_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `ordered_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `orders`
--

INSERT INTO `orders` (`id`, `items`, `progress`, `user_id`, `total`, `ordered_at`) VALUES
(1, '1', 'open', 2, 244, '2019-03-21 10:18:03'),
(2, '4,5', 'open', 2, 3030, '2019-03-21 12:09:42');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `forWho` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `reserve_date` datetime NOT NULL,
  `reserve_date_end` datetime NOT NULL,
  `pepoleNo` int(11) NOT NULL,
  `message` text COLLATE utf8_hungarian_ci,
  `progress` varchar(16) COLLATE utf8_hungarian_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `bookedat` date NOT NULL,
  `table_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `reservations`
--

INSERT INTO `reservations` (`id`, `forWho`, `reserve_date`, `reserve_date_end`, `pepoleNo`, `message`, `progress`, `user_id`, `bookedat`, `table_id`) VALUES
(1, 'Teszt Elek', '2019-03-31 14:27:00', '2019-03-31 16:27:00', 1, 'kek', 'open', 8, '2019-03-17', 2),
(6, 'Teszt Elek', '2019-03-31 05:15:00', '2019-03-31 07:15:00', 2, 'I am hungry', 'open', 8, '2019-03-17', 1),
(12, 'Kek Elek', '2019-03-24 03:04:00', '2019-03-24 05:04:00', 3, 'No message  given.', 'open', 2, '2019-03-20', 2),
(13, 'Kek Elek', '2019-04-12 04:12:00', '2019-04-12 06:12:00', 1, 'I want to reserve.', 'open', 2, '2019-03-20', 6);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `title` varchar(16) COLLATE utf8_hungarian_ci NOT NULL,
  `message` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `author` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
  `website` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `url` text COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `reviews`
--

INSERT INTO `reviews` (`id`, `title`, `message`, `author`, `website`, `url`) VALUES
(1, 'Simply excellent', 'Excellent place for a pleasant meal! I can only recommend it!', 'Pepe Reeeeee', 'Reee\'s Gastro Blog', 'https://ih1.redbubble.net/image.617787587.9108/ap,550x550,16x12,1,transparent,t.u10.png'),
(2, 'Delicius foods', 'I tried all the foods they sell, and i could not find a single mistake among them...well done!', 'Ebed Elek', 'it s alive with brad', 'https://images-na.ssl-images-amazon.com/images/I/716en1R7HkL._RI_.jpg'),
(3, 'Not Communist', 'Its not nigger or communist, so it must be good!', 'Marty Robbins', 'Marty Robbins Official', 'https://pbs.twimg.com/profile_images/967979216045096960/KjKuk6No.jpg'),
(4, 'Possessive', 'Buckle your pants, everyone! Its a great place!', 'Hatty Hattington', 'Hatty Hattington Offical', 'https://files.gamebanana.com/img/ss/wips/5427e3c23d024.jpg'),
(5, 'Delightful!', 'Very delightful! And this restaurant, is a TRUE treasure trove!', 'Globglogabgalab', 'globglogabgalaboffical.com', 'https://c-sf.smule.com/sf/s80/arr/8a/7b/110e040b-33a4-42d1-9d24-2037bd954de6.jpg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `description` text COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `roles`
--

INSERT INTO `roles` (`id`, `role`, `description`) VALUES
(1, 'admin', 'Full admin rights.'),
(2, 'user', 'Standard user with no special right.'),
(3, 'receptionist', 'With order and reservation managments.'),
(4, 'courier', 'Couriers managing orders and shipping them to specific locations.'),
(5, 'waiter', 'Waiter who can manage invertory.');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `details` text COLLATE utf8_hungarian_ci NOT NULL,
  `space` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `tables`
--

INSERT INTO `tables` (`id`, `details`, `space`) VALUES
(1, 'Small, comfy table for 2 people.', 2),
(2, 'Small, comfy table for 2 people.', 2),
(3, 'Small, comfy table for 2 people.', 2),
(4, 'Small, comfy table for 2 people.', 2),
(5, 'Small, comfy table for 2 people.', 2),
(6, 'moderately small table for 3 people.', 3),
(7, 'moderately small table for 3 people.', 3),
(8, 'An average table, for 4 people', 4),
(9, 'An average table, for 4 people', 4),
(10, 'An average table, for 4 people', 4),
(11, 'An average table, for 4 people', 4),
(12, 'An average table, for 4 people', 4),
(13, 'This table is suitable for families', 10),
(14, 'This table is suitable for families', 10),
(15, 'This event table is Our biggest one to offer right now', 20);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `Fullname` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `PhoneNo` varchar(16) COLLATE utf8_hungarian_ci NOT NULL,
  `profilepic` varchar(128) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `coverpic` varchar(128) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `Fullname`, `PhoneNo`, `profilepic`, `coverpic`, `role_id`) VALUES
(1, 'admin', 'admin@eatwell.com', '827ccb0eea8a706c4c34a16891f84e7b', '', '', NULL, NULL, 1),
(2, 'kekelek', 'kek.elek@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Kek Elek', '06907614896', 'ducati_paingale.jpg', 'kawasaki-motorcycle-black-and-white.jpg', 2),
(8, 'tesztelek', 'teszt.elek@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Teszt Elek', '092654327324', 'ProfilePhoto.jpg', 'mangart.jpg', 2),
(9, 'TheCourier   ', 'the.courier@eatwell.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Jason Stahtam', '06703497870    ', NULL, NULL, 4),
(10, 'waiter', 'yuumei.art@eatwell.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Soros Gyuri', '06904497315   ', NULL, NULL, 5),
(11, 'reception', 'reception.98@eatwell.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Talaber Rita', '006301239874   ', NULL, NULL, 3),
(12, 'Akcios Aron', 'akcios.aron@gmail.com', '7815696ecbf1c96e6894b779456d330e', '', '06301294762', NULL, NULL, 2),
(13, 'username', 'user.name@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'User Name', '06801697356', 'beer-bg2.png', 'cart.jpg', 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `wrappers`
--

CREATE TABLE `wrappers` (
  `id` int(11) NOT NULL,
  `wrappername` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `last_update_by` varchar(64) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `wrappers`
--

INSERT INTO `wrappers` (`id`, `wrappername`, `quantity`, `updated_at`, `last_update_by`) VALUES
(1, 'celofan ', 75, '2019-03-11 00:00:00', 'admin'),
(2, 'alufolia ', 29, '2019-03-10 00:00:00', 'waiter'),
(3, 'ezustpapir ', 21, '2019-03-10 00:00:00', 'waiter'),
(5, 'papirzacsko', 13, '2019-03-10 12:03:28', 'waiter'),
(6, 'kartondoboz', 12, '2019-03-11 18:40:08', 'waiter'),
(7, 'italosdoboz', 3, '2019-03-11 20:15:26', 'waiter');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`username`),
  ADD KEY `username` (`username`);

--
-- A tábla indexei `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_id` (`food_id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `favlists`
--
ALTER TABLE `favlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_id` (`food_id`);

--
-- A tábla indexei `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`favlist_id`),
  ADD KEY `favlist_id` (`favlist_id`);

--
-- A tábla indexei `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `nutrients`
--
ALTER TABLE `nutrients`
  ADD PRIMARY KEY (`nutrient_id`),
  ADD KEY `food_id` (`food_id`);

--
-- A tábla indexei `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `table_id` (`table_id`);

--
-- A tábla indexei `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- A tábla indexei `wrappers`
--
ALTER TABLE `wrappers`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `favlists`
--
ALTER TABLE `favlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT a táblához `nutrients`
--
ALTER TABLE `nutrients`
  MODIFY `nutrient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT a táblához `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT a táblához `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT a táblához `wrappers`
--
ALTER TABLE `wrappers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Megkötések a táblához `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `favlists`
--
ALTER TABLE `favlists`
  ADD CONSTRAINT `favlists_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`);

--
-- Megkötések a táblához `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`favlist_id`) REFERENCES `favlists` (`id`);

--
-- Megkötések a táblához `nutrients`
--
ALTER TABLE `nutrients`
  ADD CONSTRAINT `nutrients_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`);

--
-- Megkötések a táblához `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`);

--
-- Megkötések a táblához `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
