
//flèches pour chaque section et mouvement lors du clique
var sections = document.querySelectorAll('.films-section');
sections.forEach(function (section) {
    var scrollWrapper = section.querySelector('.scrolling-wrapper');
    var scrollStep = 200;
    var scrollButtons = section.querySelectorAll('.scroll-btn');
    scrollButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            if (button.classList.contains('left')) {
                scrollWrapper.scrollLeft -= scrollStep;
            } else {
                scrollWrapper.scrollLeft += scrollStep;
            }
        });
    });
});


$('.carousel').carousel();

document.addEventListener('DOMContentLoaded', (event) => {
    let currentIndex = 0;
    const groups = document.querySelectorAll('.card-group');
    const maxIndex = groups.length;

    setInterval(() => {
        groups[currentIndex].style.display = 'none'; // Cache le groupe actuel
        currentIndex = (currentIndex + 1) % maxIndex; // Calcule l'index du prochain groupe
        groups[currentIndex].style.display = 'block'; // Affiche le prochain groupe
    }, 3000); // Change toutes les 3 secondes
});
document.addEventListener("DOMContentLoaded", function() {
    const apiKey = '9e1d1a23472226616cfee404c0fd33c1';

    // Trouver toutes les images avec un data-tconst
    document.querySelectorAll('img[data-tconst]').forEach(img => {
        const tconst = img.getAttribute('data-tconst');
        
        const url = `https://api.themoviedb.org/3/find/${tconst}?api_key=${apiKey}&language=fr&external_source=imdb_id`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                let imagePath = './images/depannage.jpg'; // Chemin par défaut

                for (const resultType of ['movie_results', 'person_results', 'tv_results', 'tv_episode_results', 'tv_season_results']) {
                    if (data[resultType].length > 0 && (data[resultType][0].poster_path || data[resultType][0].still_path)) {
                        const path = data[resultType][0].poster_path || data[resultType][0].still_path;
                        imagePath = `https://image.tmdb.org/t/p/w500${path}`;
                        // Assigner l'ID TMDB ici
                        break;
                    }
                }

                img.src = imagePath;
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des images:', error);
                img.src = './images/depannage.jpg';
            });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const apiKey = '9e1d1a23472226616cfee404c0fd33c1';
    const modal = document.getElementById('videoModal');
    const iframe = document.getElementById('videoFrame');
    const videoUnavailable = document.getElementById('videoUnavailable');

    document.addEventListener('click', function(event) {
        if (!modal.contains(event.target) && modal.style.display === 'block') {
            modal.style.display = 'none';
            iframe.style.display = 'none';
            iframe.src = '';
            videoUnavailable.style.display = 'none';
        }
    });

    document.querySelectorAll('.openModal').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const tconst = this.getAttribute('data-tconst');
            const url = `https://api.themoviedb.org/3/movie/${tconst}/videos?api_key=${apiKey}&language=fr`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.results.length > 0) {
                        let trailer = data.results.find(video => video.type.toLowerCase() === "trailer" && video.site.toLowerCase() === "youtube");
                        let videoData = trailer || data.results[0];

                        if (videoData && videoData.site.toLowerCase() === 'youtube') {
                            const videoUrl = `https://www.youtube.com/embed/${videoData.key}?autoplay=1`;
                            iframe.src = videoUrl;
                            iframe.style.display = 'block';
                            videoUnavailable.style.display = 'none';
                            modal.style.display = 'block';
                        } else {
                            iframe.style.display = 'none';
                            videoUnavailable.style.display = 'block';
                            modal.style.display = 'block';
                        }
                    } else {
                        iframe.style.display = 'none';
                        videoUnavailable.style.display = 'block';
                        modal.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.log(error);
                    iframe.style.display = 'none';
                    videoUnavailable.style.display = 'block';
                    modal.style.display = 'block';
                });
        });
    });

    document.getElementById('closeModal').addEventListener('click', function() {
        modal.style.display = "none";
        iframe.src = "";
        iframe.style.display = 'none';
        videoUnavailable.style.display = 'none';
    });
});


// Lorsque la souris entre sur la vidéo
document.getElementById('videoModal').addEventListener('mouseenter', function() {
    document.body.classList.add('hovering-over-video');
});

// Lorsque la souris quitte la vidéo
document.getElementById('videoModal').addEventListener('mouseleave', function() {
    document.body.classList.remove('hovering-over-video');
});


