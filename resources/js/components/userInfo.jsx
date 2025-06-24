import React from 'react';
import styles from '../../css/userInfo.module.scss';

const UserInfo = ({ user }) => {
    return (
        <div className={styles.profileHeader}>
            <img className={styles.avatar} src={user.avatar} alt={`${user.name}'s avatar`} />
            <h1>{user.name}</h1>
            <p>Email: {user.email}</p>
            <p>Member since: {new Date(user.joined).toLocaleDateString()}</p>
        </div>
    );
};

export default UserInfo;