import React from 'react';
import styles from '../../css/game.module.scss';

const GameDetailPage = ({ game }) => {
    if (!game) return <p>Loading game details...</p>;

    return (
        <div className={styles.gameDetail}>
            <header className={styles.gameHeader}>
                <h1 className={styles.gameHeaderTitle}>{game.title}</h1>
                <p className={styles.meta}>
                    {game.platform.join(', ')} &nbsp;&bull;&nbsp;
                    {game.releaseDate}
                </p>
            </header>

            <section className={styles.gameContent}>
                <div className={styles.gameCover}>
                    <img className={styles.gameCoverImage} src={game.coverImage} alt={`${game.title} cover`} />
                </div>
                <div className={styles.gameInfo}>
                    <p className={styles.gameInfoText}><strong>Genre:</strong> {game.genres.join(', ')}</p>
                    <p className={styles.gameInfoText}><strong>Developer:</strong> {game.developer}</p>
                    <p className={styles.gameInfoText}><strong>Publisher:</strong> {game.publisher}</p>
                    <p className={styles.gameInfoText}><strong>Description:</strong></p>
                    <p className={styles.gameInfoText}>{game.description}</p>
                </div>
            </section>

            <section className={styles.gameRating}>
                <h2 className={styles.gameRatingText}>User Rating</h2>
                <p>{game.rating} / 10</p>
            </section>

            <section className={styles.reviews}>
                <h2 className={styles.reviewsText}>Reviews</h2>
                {game.reviews && game.reviews.length > 0 ? (
                    game.reviews.map((review, index) => (
                        <div key={index} className={styles.review}>
                            <p><strong>{review.user}</strong> said:</p>
                            <blockquote>{review.comment}</blockquote>
                        </div>
                    ))
                ) : (
                    <p>No reviews yet. Be the first to write one!</p>
                )}
            </section>
        </div>
    );
};

export default GameDetailPage;