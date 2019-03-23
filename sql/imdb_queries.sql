SELECT * 
FROM movies 
WHERE year = 1995;


SELECT COUNT(*) 
FROM roles r 
JOIN movies m ON m.id = r.movie_id 
WHERE m.name="Lost in Translation";


SELECT first_name, last_name 
FROM actors AS A 
JOIN roles R ON A.id=R.actor_id
JOIN movies AS M ON M.id = R.movie_id
WHERE M.name = "Lost in Translation";


SELECT first_name, last_name 
FROM directors AS D 
JOIN movies_directors as MD ON D.id= MD.director_id
JOIN movies as M ON m.id = MD.movie_id 
WHERE M.name = "Fight Club";


SELECT COUNT(*) 
FROM movies_directors as MD 
JOIN directors as D ON D.id = MD.director_id 
JOIN movies as M ON MD.movie_id=M.id 
WHERE D.first_name = "Clint" AND D.last_name = "Eastwood"


SELECT name FROM movies AS M 
JOIN movies_directors AS MD ON M.id = MD.movie_id 
JOIN directors AS D ON D.id = MD.director_id 
WHERE D.first_name = "Clint" AND D.last_name = "Eastwood"


SELECT first_name, last_name 
FROM directors AS D 
JOIN movies_directors AS MD ON D.id = MD.director_id 
JOIN movies as M ON M.id = MD.movie_id 
JOIN movies_genres as MG ON M.id = MG.movie_id 
WHERE MG.genre = "Horror"

SELECT A.first_name, A.last_name 
FROM actors AS A 
JOIN roles AS R ON A.id = R.actor_id 
JOIN movies AS M ON M.id = R.movie_id 
JOIN movies_directors AS MD ON MD.movie_id = M.id 
JOIN directors as D ON MD.director_id = D.id 
WHERE D.first_name = "Christopher" AND D.last_name = "Nolan"


