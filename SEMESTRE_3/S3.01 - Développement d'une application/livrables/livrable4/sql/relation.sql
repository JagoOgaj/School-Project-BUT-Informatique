-- Add foreign key relationship for title_episode
ALTER TABLE title_episode
ADD CONSTRAINT fk_title_episode_title_basics
FOREIGN KEY (tconst) REFERENCES title_basics(tconst);

-- Add foreign key relationship for title_ratings
ALTER TABLE title_ratings
ADD CONSTRAINT fk_title_ratings_title_basics
FOREIGN KEY (tconst) REFERENCES title_basics(tconst);
