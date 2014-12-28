CREATE TABLE `RecipeCategory` (
    `RecipeId` int(11) NOT NULL,
    `CategoryId` int(11) NOT NULL,
    `CreatedDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    KEY `RecipeCategoryRecipeId` (`RecipeId`),
    KEY `RecipeCategoryCategoryId` (`CategoryId`),
    CONSTRAINT `RecipeCategoryCategoryId` FOREIGN KEY (`CategoryId`) REFERENCES `Category` (`CategoryId`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `RecipeCategoryRecipeId` FOREIGN KEY (`RecipeId`) REFERENCES `Recipe` (`RecipeId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;