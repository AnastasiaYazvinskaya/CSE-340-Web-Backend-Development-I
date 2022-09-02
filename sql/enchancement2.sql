-- 1.Insert a new client to the clients table (Tony, Stark, tony@starkent.com, Iam1ronM@n, "I am the real Ironman")
INSERT INTO clients
(clientFirstname, clientLastname, clientEmail, clientPassword, comment)
VALUES
("Tony"
,"Stark"
,"tony@starkent.com"
,"Iam1ronM@n"
,"I am the real Ironman");

-- 2. Modify the Tony Stark record to change the clientLevel to 3.
UPDATE clients
SET clientLevel = 3
WHERE clientFirstname = 'Tony' AND clientLastname = 'Stark';

-- 3. Modify the "GM Hummer" record to read "spacious interior" rather than "small interior".
UPDATE inventory
SET invDescription = REPLACE(invDescription, 'small interior', 'spacious interior')
WHERE invMake='GM' AND invModel = 'Hummer';

-- 4. Select the invModel field from the inventory table and the classificationName field from the carclassification table for inventory items that belong to the "SUV" category.
SELECT i.invModel, c.classificationName
FROM inventory i
INNER JOIN carclassification c
ON i.classificationId=c.classificationId
WHERE c.classificationName = 'SUV';

-- 5. Delete the Jeep Wrangler from the database.
DELETE FROM inventory
WHERE invMake = 'Jeep' AND invModel = 'Wrangler';

-- 6. Update all records in the Inventory table to add "/phpmotors" to the beginning of the file path in the invImage and invThumbnail columns.
UPDATE inventory
SET invImage = CONCAT('/phpmotors', invImage),
invThumbnail = CONCAT('/phpmotors', invThumbnail);
