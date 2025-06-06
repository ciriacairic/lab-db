import React, { useState } from 'react';
import styles from '../../css/registerForm.module.scss';

const RegisterForm = ({ onSubmit }) => {
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        onSubmit(formData);
    };

    return (
        <form onSubmit={handleSubmit} className={styles.registerForm}>
            <div>
                <label>Username</label>
                <input className={styles.registerFormInput} type="text" name="username" value={formData.name} onChange={handleChange} required />
            </div>

            <div>
                <label>Email</label>
                <input className={styles.registerFormInput} type="email" name="email" value={formData.email} onChange={handleChange} required />
            </div>

            <div>
                <label>Password</label>
                <input className={styles.registerFormInput} type="password" name="password" value={formData.password} onChange={handleChange} required />
            </div>

            <div>
                <label>Confirm Password</label>
                <input className={styles.registerFormInput} type="password" name="password_confirmation" value={formData.password_confirmation} onChange={handleChange} required />
            </div>

            <button className={styles.registerFormButton} type="submit">Register</button>
        </form>
    );
};

export default RegisterForm;