/* rajouter un film */
INSERT INTO movie(title, synopsis, duration, image) VALUES ('le meilleur film', 'vraiment le meilleur film', 654, 'image-qui-nexiste-pas.jpg');

/* récupérer tous les noms de films */
SELECT title FROM movie;

/* récupérer les utilisateurs sans doublons */
SELECT DISTINCT email, roles FROM user;

/* supprimer un film */
DELETE FROM movie WHERE id = 8;

/* mise à jour du nom dun film */
UPDATE movie SET title = 'film modifié' WHERE id = 5;

/* liste des films triés par le nom */
SELECT title FROM movie ORDER BY title DESC;

/* Il ny a pas de date de sortie sur les films
liste des films sortis entre 2018 et 2019 */
SELECT * FROM movie WHERE release_date BETWEEN '2018-01-01' AND '2019-12-31';

/* liste des utilisateurs avec un email gmail */
SELECT * FROM user WHERE email LIKE '%@gmail.%';

/* rajouter le champ pseudonyme à la table utilisateur */
ALTER TABLE user ADD pseudonyme VARCHAR(255);

/* récupérer les films sorties il y a deux ans et avec le nom qui commence par un "l" */
SELECT * from movie WHERE release_date BETWEEN DATE(NOW() - INTERVAL 2 YEAR) AND NOW() AND title LIKE 'l%';

/* HAVING */
SELECT title, SUM(duration)
FROM movie
GROUP BY title
HAVING SUM(duration) > 40;

/* SOUS REQUETE */
SELECT *
FROM booking
WHERE user_id = (
    SELECT id
    FROM user
    LIMIT 1
  )

/* LEFT JOIN */
SELECT *
FROM user
LEFT JOIN booking ON user.id = booking.user_id;

/* RIGHT JOIN */
SELECT *
FROM movie
RIGHT JOIN session ON movie.id = session.movie_id;

/* FULL JOIN NOT WORKING ON MYSQL */
SELECT *
FROM movie
FULL JOIN session ON movie.id = session.movie_id;