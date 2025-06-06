import React, { useEffect, useState } from 'react';
import ReviewForm from '../components/reviewForm';
import styles from '../../css/writeReview.module.scss';

const WriteReviewPage = () => {
    const [games, setGames] = useState([]);
    const [message, setMessage] = useState('');

    useEffect(() => {
        fetch('/api/games')
            .then((res) => res.json())
            .then((data) => setGames(data))
            .catch((err) => console.error('Failed to fetch games', err));
    }, []);

    const handleFormSubmit = (data) => {
        console.log('Submitting review:', data);

        fetch('/api/reviews', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
            .then((res) => res.json())
            .then((response) => {
                console.log(response);
                setMessage('Review submitted successfully!');
            })
            .catch((err) => {
                console.error(err);
                setMessage('Something went wrong.');
            });
    };

    return (
        <div className={styles.writeReviewContainer}>
            <h1>Write a Review</h1>
            <ReviewForm games={games} onSubmit={handleFormSubmit} />
            {message && <p className="status">{message}</p>}
        </div>
    );
};

export default WriteReviewPage;