CREATE TABLE `RecipeMeat` (
    `RecipeId` int(11) NOT NULL,
    `MeatId` int(11) DEFAULT NULL,
    `CreatedDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    KEY `RecipeMeatMeatId` (`RecipeId`),
    CONSTRAINT `RecipeMeatMeatId` FOREIGN KEY (`RecipeId`) REFERENCES `Meat` (`MeatId`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `RecipeMeatRecipeId` FOREIGN KEY (`RecipeId`) REFERENCES `Recipe` (`RecipeId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;