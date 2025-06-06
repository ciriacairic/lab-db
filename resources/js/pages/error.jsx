import React from 'react';
import styles from '../../css/error.module.scss';

const ErrorPage = ({ error }) => {
    return (
        <section className={styles.errorContainer}>
            <h1 className={styles.errorTitle}>Error</h1>
            <p className={styles.errorInfo}>{error.message || 'An unexpected error occurred.'}</p>
            <p className={styles.errorInfo}>Please try again later.</p>
        </section>
    );
}

export default ErrorPage;