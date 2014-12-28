CREATE TABLE `Meat` (
    `MeatId` int(11) NOT NULL AUTO_INCREMENT,
    `Name` varchar(50) DEFAULT NULL,
    `URLName` varchar(50) DEFAULT NULL,
    `CreatedDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`MeatId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;