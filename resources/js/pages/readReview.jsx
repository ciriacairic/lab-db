import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import ReviewCard from '../components/reviewCard';
import styles from '../../css/readReview.module.scss';

const ReadReviewPage = () => {
    const { gameId } = useParams(); 
    const [game, setGame] = useState(null);
    const [reviews, setReviews] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetch(`/api/games/${gameId}`)
            .then((res) => res.json())
            .then((data) => {
                setGame(data.game);
                setReviews(data.reviews);
                setLoading(false);
            })
            .catch(err => {
                console.error('Failed to fetch game', err);
                setLoading(false);
            });
    }, [gameId]);

    if (loading) return <p>Loading...</p>;
    if (!game) return <p>Game not found.</p>;

    return (
        <div className={styles.reviewPage}>
            <h1>{game.title}</h1>
            <p><strong>Developer:</strong> {game.developer}</p>
            <p><strong>Genre:</strong> {game.genres?.join(', ')}</p>
            <img src={game.coverImage} alt={game.title} width="200" />

            <h2>{reviews.length} Review{reviews.length !== 1 ? 's' : ''}</h2>
            {reviews.length > 0 ? (
                reviews.map((review) => (
                    <ReviewCard key={review.id} review={review} />
                ))
            ) : (
                <p>No reviews yet for this game.</p>
            )}
        </div>
    );
};

export default ReadReviewPage;