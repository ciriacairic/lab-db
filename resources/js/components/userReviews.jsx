import React from 'react';
import styles from '../../css/userReviews.module.scss';

const UserReviews = ({ reviews }) => {
    if (!reviews || reviews.length === 0)
        return <p>No reviews yet.</p>;

    return (
        <div className={styles.userReviews}>
            <h2>My Reviews</h2>
            {reviews.map((review) => (
                <div key={review.id} className={styles.reviewCard}>
                    <strong>{review.game}</strong>
                    <p>Rating: {review.rating}/10</p>
                    <p>{review.comment}</p>
                    <small>Posted: {new Date(review.created_at).toLocaleDateString()}</small>
                </div>
            ))}
        </div>
    );
};

export default UserReviews;