import React, { useState } from 'react';
import RegisterForm from '../components/registerForm';
import styles from '../../css/register.module.scss';

const RegisterPage = () => {
    const [message, setMessage] = useState('');
    const [errors, setErrors] = useState({});

    const handleRegister = async (formData) => {
        setMessage('');
        setErrors({});

        try {
            const response = await fetch('/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                },
                credentials: 'include',
                body: JSON.stringify(formData),
            });

            if (!response.ok) {
                const resData = await response.json();
                setErrors(resData.errors || { general: resData.message });
                return;
            }

            const resData = await response.json();
            setMessage(resData.message || 'Registration successful!');
        } catch (err) {
            setErrors({ general: 'An unexpected error occurred.' });
        }
    };

    return (
        <div className={styles.registerPageContainer}>
            <h1>Register</h1>

            {message && <p className={styles.success}>{message}</p>}
            {Object.values(errors).map((err, i) => (
                <p key={i} className={styles.error}>{Array.isArray(err) ? err[0] : err}</p>
            ))}

            <RegisterForm onSubmit={handleRegister} />
        </div>
    );
};

export default RegisterPage;