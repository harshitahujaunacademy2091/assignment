-- phpMyAdmin SQL
-- Execute this query to setup own databse for the project
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(32) NOT NULL,
  `email` text NOT NULL,
  `hash` varchar(32) DEFAULT NULL,
  `active` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

