import React, { useState } from 'react';
import LoginForm from '../components/loginForm';
import styles from '../../css/login.module.scss';

const LoginPage = () => {
    const [error, setError] = useState('');
    const [message, setMessage] = useState('');

    const handleLogin = async ({ email, password }) => {
        try {
            setError('');
            const res = await fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                credentials: 'include',
                body: JSON.stringify({ email, password }),
            });

            if (!res.ok) {
                const result = await res.json();
                throw new Error(result.message || 'Login failed');
            }

            setMessage('You are now logged in!');
        } catch (err) {
            setError(err.message);
        }
    };

    return (
        <div className={styles.loginPage}>
            <h1>Login</h1>
            {error && <p className={styles.error}>{error}</p>}
            {message && <p className={styles.message}>{message}</p>}
            <LoginForm onSubmit={handleLogin} />
        </div>
    );
};

export default LoginPage;