import React from 'react';
import { createRoot } from 'react-dom/client';
import {
  BrowserRouter,
  Routes,
  Route,
} from 'react-router-dom';

import '../css/app.scss';

import HomePage from './pages/home';
import LoginPage from './pages/login';
import ProfilePage from './pages/user';
import GameInfoPage from './pages/game';
import WriteReviewPage from './pages/writeReview';
import ReadReviewPage from './pages/readReview';
import ErrorPage from './pages/error';

const App = () => (
  <BrowserRouter>
    <Routes>
      <Route path="/" element={<HomePage />} />
      <Route path="/login" element={<LoginPage />} />
      <Route path="/profile/:userId" element={<ProfilePage />} />
      <Route path="/games/:gameId" element={<GameInfoPage />} />
      <Route path="/games/:gameId/review" element={<WriteReviewPage />} />
      <Route path="/games/:gameId/reviews" element={<ReadReviewPage />} />
      <Route path="*" element={<ErrorPage></ErrorPage>} />
    </Routes>
  </BrowserRouter>
);

const root = createRoot(document.getElementById('app'));
root.render(<App />);