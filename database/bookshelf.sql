USE bookshelf;

-- CREATE TABLE `admin` (
--   `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- CREATE TABLE `all_copies_of_books` (
--   `copy_id` int(11) NOT NULL,
--   `ISBN` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
--   `borrowed` tinyint(1) DEFAULT 0
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- INSERT INTO `all_copies_of_books` (`copy_id`, `ISBN`, `borrowed`) VALUES
-- (01, '1000111', 0),
-- (02, '1000112', 0),
-- (03, '1000113', 0),
-- (04, '1000114', 0),
-- (05, '1000115', 0),
-- (06, '1000116', 0),
-- (07, '1000117', 0),
-- (08, '1000118', 0),
-- (09, '1000119', 0),
-- (10, '1000120', 0);


-- CREATE TABLE `book` (
--   `ISBN` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `edition` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `publisher` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL);


-- INSERT INTO `book` (`ISBN`, `name`, `author`, `edition`, `publisher`, `image`) VALUES
-- ('1100122', 'feluda', 'George R.R. Martin', '3', 'HBO', 'uiu.png');


-- CREATE TABLE `book_location_delivery` (
--   `delivery_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `ISBN` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `copy_id` int(11) NOT NULL,
--   `location_id` decimal(10,0) NOT NULL,
--   `delivery_date` datetime NOT NULL
-- );




-- CREATE TABLE `book_location_retrieval` (
--   `retrieval_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `ISBN` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `copy_id` int(11) NOT NULL,
--   `location_id` decimal(10,0) NOT NULL,
--   `retrieval_date` datetime NOT NULL
-- );


-- CREATE TABLE `customer` (
--   `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `contact_no` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `fine_amount` decimal(4,0) NOT NULL,
--   `effective_date` datetime NOT NULL,
--   `status` tinyint(1) DEFAULT 0,
--   `picture` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
-- );



-- INSERT INTO `customer` (`email`, `name`, `contact_no`, `fine_amount`, `effective_date`, `status`, `picture`) VALUES
-- ('dummmy@gmail.com', 'dummy', '01754454216', '0', '0000-00-00 00:00:00', 0, 'php.png');



-- CREATE TABLE `customer_book` (
--   `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `ISBN` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `copy_id` int(11) NOT NULL,
--   `return_date` datetime NOT NULL,
--   `issue_date` datetime NOT NULL
-- );


-- INSERT INTO `customer_book` (`email`, `ISBN`, `copy_id`, `return_date`, `issue_date`) VALUES
-- ('dummmy@gmail.com', '1100122', 10, '2025-01-12 00:00:00', '2025-01-06 00:00:00');


-- CREATE TABLE `deliveryman` (
--   `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `contact_no` decimal(11,0) DEFAULT NULL,
--   `area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `location_id` decimal(10,0) DEFAULT NULL,
--   `picture` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
-- ) ;


-- INSERT INTO `deliveryman` (`email`, `name`, `contact_no`, `area`, `location_id`, `picture`) VALUES
-- ('man@gmail.com', 'man', '01621177570', '', '', 'uiu.png');



-- CREATE TABLE `location` (
--   `location_id` decimal(10,0) NOT NULL,
--   `area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `delivery_point` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `day_of_week` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
-- );



-- INSERT INTO `location` (`location_id`, `area`, `delivery_point`, `day_of_week`) VALUES
-- ('1', 'Gulshan','Gulshan-2', 'Friday'),
-- ('2', 'Banani','Banani-11', 'Tuesday'),
-- ('3', 'Bashundhara', 'Apollo Gate', 'Wednesday'),
-- ('4', 'Dhanmondi', 'Sath Mosjid Road', 'Thursday'),
-- ('5', 'Uttara', 'House Building', 'Friday'),
-- ('6', 'Nikunja',  'Nikunja-1', 'Monday'),
-- ('7', 'Baridhara', 'Baridhara DOHS', 'Tuesday'),
-- ('8', 'Mirpur', 'Mirpur-10', 'Wednesday'),
-- ('9', 'Shymoli', 'Shishumela', 'Thursday'),
-- ('10', 'Mohammadpur','Mohammodpur Bus Stand', 'Friday');



-- CREATE TABLE `users` (
--   `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
--   `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
-- );


-- INSERT INTO `users` (`email`, `password`, `role`) VALUES
-- ('dummmy@gmail.com', '', 'Customer'),
-- ('dummy01@gmail.com', '', 'DeliveryMan'),
-- ('dummy02@gmail.com', '', 'Admin');

-- ALTER TABLE `admin`
--   ADD PRIMARY KEY (`email`);

-- ALTER TABLE `all_copies_of_books`
--   ADD PRIMARY KEY (`copy_id`);

-- ALTER TABLE `book`
--   ADD PRIMARY KEY (`ISBN`);



-- ALTER TABLE `book_location_delivery`
--   ADD PRIMARY KEY (`delivery_id`),
--   ADD KEY `fk_book_location_delivery1` (`location_id`),
--   ADD KEY `fk_book_location_delivery2` (`copy_id`),
--   ADD KEY `fk_book_location_delivery3` (`email`),
--   ADD KEY `fk_book_location_delivery4` (`ISBN`);

-- ALTER TABLE `book_location_retrieval`
--   ADD PRIMARY KEY (`retrieval_id`),
--   ADD KEY `fk_book_location_retrieval1` (`location_id`),
--   ADD KEY `fk_book_location_retrieval2` (`copy_id`),
--   ADD KEY `fk_book_location_retrieval3` (`ISBN`),
--   ADD KEY `fk_book_location_retrieval4` (`email`);


-- ALTER TABLE `customer`
--   ADD PRIMARY KEY (`email`);


-- ALTER TABLE `customer_book`
--   ADD PRIMARY KEY (`email`,`ISBN`,`copy_id`),
--   ADD KEY `fk_customer_book1` (`ISBN`),
--   ADD KEY `fk_customer_book2` (`copy_id`);


-- ALTER TABLE `deliveryman`
--   ADD PRIMARY KEY (`email`),
--   ADD UNIQUE KEY `email` (`email`),
--   ADD KEY `location_id` (`location_id`);


-- ALTER TABLE `location`
--   ADD PRIMARY KEY (`location_id`);


-- ALTER TABLE `users`
--   ADD PRIMARY KEY (`email`),
--   ADD UNIQUE KEY `email` (`email`);


-- ALTER TABLE `all_copies_of_books`
--    MODIFY `copy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

-- ALTER TABLE `admin`
--   ADD CONSTRAINT `admin_fk` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

-- ALTER TABLE `book_location_delivery`
--   ADD CONSTRAINT `fk_book_location_delivery1` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`) ON DELETE CASCADE ON UPDATE CASCADE,
--   ADD CONSTRAINT `fk_book_location_delivery2` FOREIGN KEY (`copy_id`) REFERENCES `customer_book` (`copy_id`) ON DELETE CASCADE ON UPDATE CASCADE,
--   ADD CONSTRAINT `fk_book_location_delivery3` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
--   ADD CONSTRAINT `fk_book_location_delivery4` FOREIGN KEY (`ISBN`) REFERENCES `customer_book` (`ISBN`) ON DELETE CASCADE ON UPDATE CASCADE;

-- ALTER TABLE `book_location_retrieval`
--   ADD CONSTRAINT `fk_book_location_retrieval1` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`) ON DELETE CASCADE ON UPDATE CASCADE,
--   ADD CONSTRAINT `fk_book_location_retrieval2` FOREIGN KEY (`copy_id`) REFERENCES `customer_book` (`copy_id`) ON DELETE CASCADE ON UPDATE CASCADE,
--   ADD CONSTRAINT `fk_book_location_retrieval3` FOREIGN KEY (`ISBN`) REFERENCES `customer_book` (`ISBN`) ON DELETE CASCADE ON UPDATE CASCADE,
--   ADD CONSTRAINT `fk_book_location_retrieval4` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;


--  ALTER TABLE `customer`
--   ADD CONSTRAINT `customer_fk` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

-- ALTER TABLE `customer_book`
--  ADD CONSTRAINT `fk_customer_book1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
--   ADD CONSTRAINT `fk_customer_book2` FOREIGN KEY (`copy_id`) REFERENCES `all_copies_of_books` (`copy_id`) ON DELETE CASCADE ON UPDATE CASCADE,
--   ADD CONSTRAINT `fk_customer_book3` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`) ON DELETE CASCADE ON UPDATE CASCADE;

-- ALTER TABLE `deliveryman`
--  ADD CONSTRAINT `deliveryMan_fk` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
--  COMMIT;