CREATE TABLE `RecipeStep` (
    `RecipeStepId` int(11) NOT NULL AUTO_INCREMENT,
    `RecipeId` int(11) NOT NULL,
    `Text` text NOT NULL,
    `SortOrder` int(11) DEFAULT NULL,
    `CreatedDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`RecipeStepId`),
    CONSTRAINT `RecipeStepRecipeId` FOREIGN KEY (`RecipeStepId`) REFERENCES `Recipe` (`RecipeId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;