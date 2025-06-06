import React from 'react';
import styles from '../../css/home.module.scss';

const HomePage = () => {
    const featuredGames = [
        { id: 1, title: 'Elden Ring', cover: 'https://upload.wikimedia.org/wikipedia/en/b/b9/Elden_Ring_Box_art.jpg', rating: 9 },
        { id: 2, title: 'God of War Ragnarok', cover: 'https://upload.wikimedia.org/wikipedia/en/e/ee/God_of_War_Ragnar%C3%B6k_cover.jpg', rating: 8.5 },
        { id: 3, title: 'Hades', cover: 'https://upload.wikimedia.org/wikipedia/en/c/cc/Hades_cover_art.jpg', rating: 9 },
    ];

    return (
        <div className={styles.container}>
            <header className={styles.hero}>
                <h1>Welcome to LBD Reviews</h1>
                <p>Discover and review your favorite video games.</p>
            </header>

            <section className={styles.featured}>
                <h2>Featured Games</h2>
                <div className={styles.gameGrid}>
                    {featuredGames.map((game) => (
                        <div key={game.id} className={styles.gameCard}>
                            <img className={styles.gameCardImage} src={game.cover} alt={game.title} />
                            <h3>{game.title}</h3>
                            <p>{game.rating}</p>
                        </div>
                    ))}
                </div>
            </section>
        </div>
    );
};

export default HomePage;