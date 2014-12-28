CREATE TABLE `Recipe` (
    `RecipeId` int(11) NOT NULL AUTO_INCREMENT,
    `Source` varchar(100) DEFAULT NULL,
    `SourceURL` varchar(500) DEFAULT NULL,
    `Name` varchar(500) NOT NULL DEFAULT '',
    `Time` int(11) DEFAULT NULL,
    `AddedBy` varchar(50) DEFAULT NULL,
    `CreatedDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`RecipeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;