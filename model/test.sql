-- TEST DATA

INSERT INTO `accounts` (`ID`, `fname`, `lname`, `email`, `phone`, `password`, `registered`, `reminders`, `cookieData`) VALUES
(1, 'Robert', 'Gerdisch', 'rgerdisch3@gmail.com', 9917527, '3ru29823ruoi', 1, 0, 'eo2i23uey23oriy23rlu32yro9wl3i2uyr'),
(2, 'Laurel', 'Fink', 'lfink@gmail.com', 9917527, '3ru29823ruoi', 1, 0, 'eo2i23uey23oriy23rlu32yro9wl3i2uyr'),
(7, 'Matt', 'Gerd', 'mg3099@gmail.com', 1239, '8d93d6bad1571f4baac53ac813a7fb57', 1, 0, '90f39964e663267e610834586e053f2e');


INSERT INTO `events` (`ID`, `accountID`, `date`, `title`, `description`) VALUES
(1, 1, '2014-04-26', 'Fall Family Festival', 'This is the fall family festival!');


INSERT INTO `tasks` (`ID`, `eventID`, `description`, `numSlots`) VALUES
(1, 1, 'Man the dunk tank', 5),
(2, 1, 'Bring all the food', 8);