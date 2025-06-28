import { Routes } from '@angular/router';
import { Home } from './pages/home/home.component';
import { Game } from './pages/game/game.component';
import { Login } from './pages/login/login.component';
import { Search } from './pages/search/search.component';
import { ReviewRead } from './pages/review-read/review-read.component';
import { ReviewWrite } from './pages/review-write/review-write.component';
import { User } from './pages/user/user.component';
import { Library } from './pages/library/library';
import { Libraries } from './pages/libraries/libraries';
import { RegisterUser } from './pages/register-user/register-user';
import { CreateLibrary } from './pages/create-library/create-library';

export const routes: Routes = [
  {
    path: '',
    component: Home,
  },
  {
    path: 'game/:gameId',
    component: Game,
  },
  {
    path: 'login',
    component: Login,
  },
  {
    path: 'search',
    component: Search,
  },
  {
    path: 'review/:reviewId',
    component: ReviewRead,
  },
  {
    path: 'review-write/:gameId',
    component: ReviewWrite,
  },
  {
    path: 'user/:userId',
    component: User,
  },
  {
    path: 'library/:libraryId',
    component: Library
  },
  {
    path: 'libraries/:userId',
    component: Libraries
  },
  {
    path: 'create-libraries',
    component: CreateLibrary
  },
  {
    path: 'register-user',
    component: RegisterUser
  }
];
