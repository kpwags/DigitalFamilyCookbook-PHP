CREATE TABLE `RecipeIngredient` (
    `RecipeIngredientId` int(11) NOT NULL AUTO_INCREMENT,
    `RecipeId` int(11) NOT NULL,
    `Ingredient` text NOT NULL,
    `SortOrder` int(11) DEFAULT NULL,
    `CreatedDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`RecipeIngredientId`),
    CONSTRAINT `RecipeIngredientRecipeId` FOREIGN KEY (`RecipeIngredientId`) REFERENCES `Recipe` (`RecipeId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;