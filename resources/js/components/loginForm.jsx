import React, { useState } from 'react';
import styles from '../../css/loginForm.module.css';

const LoginForm = ({ onSubmit }) => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();
        onSubmit({ email, password });
    };

    return (
        <form onSubmit={handleSubmit} className={styles.loginForm}>
            <div>
                <label>Email:</label>
                <input className={styles.loginFormInput}
                    type="email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                />
            </div>

            <div>
                <label>Password:</label>
                <input className={styles.loginFormInput}
                    type="password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                />
            </div>

            <button className={styles.loginFormButton} type="submit">Login</button>
        </form>
    );
};

export default LoginForm;