import React from 'react';
import styles from '../../css/reviewCard.module.scss';

const ReviewCard = ({ review }) => {
    return (
        <div className={styles.reviewCard}>
            <header className={styles.reviewHeader}>
                <strong>{review.user}</strong> • <span>{new Date(review.created_at).toLocaleDateString()}</span>
            </header>
            <div className={styles.reviewRating}>{review.rating} / 10</div>
            <p className={styles.reviewComment}>{review.comment}</p>
        </div>
    );
};

export default ReviewCard;