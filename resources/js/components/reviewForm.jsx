import React, { useState } from 'react';
import styles from '../../css/reviewForm.module.scss';

const ReviewForm = ({ games, onSubmit }) => {
    const [gameId, setGameId] = useState('');
    const [rating, setRating] = useState('');
    const [comment, setComment] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();

        if (!gameId || !rating || !comment) {
            alert('Please fill in all fields');
            return;
        }

        const review = {
            game_id: gameId,
            rating: parseInt(rating),
            comment,
        };

        onSubmit(review);
    };

    return (
        <form onSubmit={handleSubmit} className={styles.reviewForm}>
            <div>
                <label htmlFor="game">Select game:</label>
                <select className={styles.reviewFormSelect}
                    id="game"
                    value={gameId}
                    onChange={(e) => setGameId(e.target.value)}
                    required
                >
                    <option value="">-- Select a Game --</option>
                    {games.map((game) => (
                        <option key={game.id} value={game.id}>
                            {game.title}
                        </option>
                    ))}
                </select>
            </div>

            <div>
                <label htmlFor="rating">Rating (1-10):</label>
                <input classname={styles.reviewFormInput}
                    type="number"
                    min="1"
                    max="10"
                    value={rating}
                    onChange={(e) => setRating(e.target.value)}
                    required
                />
            </div>

            <div>
                <label htmlFor="comment">Write your review:</label>
                <textarea className={styles.reviewFormTextarea}
                    id="comment"
                    value={comment}
                    onChange={(e) => setComment(e.target.value)}
                    required
                />
            </div>

            <button className={styles.reviewFormButton} type="submit">Submit Review</button>
        </form>
    );
};

export default ReviewForm;