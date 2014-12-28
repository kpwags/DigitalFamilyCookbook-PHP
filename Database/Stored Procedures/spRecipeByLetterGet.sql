DELIMITER //
DROP PROCEDURE IF EXISTS spRecipeByLetterGet//
CREATE PROCEDURE spRecipeByLetterGet()
BEGIN
    SELECT
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'A%') AS 'A',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'B%') AS 'B',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'C%') AS 'C',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'D%') AS 'D',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'E%') AS 'E',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'F%') AS 'F',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'G%') AS 'G',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'H%') AS 'H',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'I%') AS 'I',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'J%') AS 'J',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'K%') AS 'K',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'L%') AS 'L',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'M%') AS 'M',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'N%') AS 'N',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'O%') AS 'O',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'P%') AS 'P',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'Q%') AS 'Q',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'R%') AS 'R',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'S%') AS 'S',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'T%') AS 'T',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'U%') AS 'U',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'V%') AS 'V',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'W%') AS 'W',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'X%') AS 'X',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'Y%') AS 'Y',
        (SELECT COUNT(RecipeId) FROM Recipe WHERE Name LIKE 'Z%') AS 'Z';
END//
DELIMITER ;