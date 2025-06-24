import React, { useEffect, useState } from 'react';
import UserInfo from '../components/userInfo';
import UserReviews from '../components/userReviews';
import styles from '../../css/user.module.scss';

const ProfilePage = () => {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetch('/api/user')
            .then((res) => res.json())
            .then((data) => {
                setUser(data);
                setLoading(false);
            })
            .catch((err) => {
                console.error('Error fetching user:', err);
                setLoading(false);
            });
    }, []);

    if (loading) return <p>Loading profile...</p>;
    if (!user) return <p>User not found.</p>;

    return (
        <div className={styles.profilePage}>
            <UserInfo user={user} />
            <UserReviews reviews={user.reviews} />
        </div>
    );
};

export default ProfilePage;