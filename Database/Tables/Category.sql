CREATE TABLE `Category` (
    `CategoryId` int(11) NOT NULL AUTO_INCREMENT,
    `Name` varchar(100) NOT NULL DEFAULT '',
    `URLName` varchar(100) NOT NULL DEFAULT '',
    `CreatedDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`CategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;