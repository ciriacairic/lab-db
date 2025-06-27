import { Component, inject, signal } from '@angular/core';
import { Backend } from '../../services/backend';
import { Store } from '../../services/store';

@Component({
  selector: 'app-home',
  imports: [],
  standalone: true,
  templateUrl: './home.html',
  styleUrl: './home.scss'
})
export class Home {
  private _backendService = inject(Backend);
  private _store = inject(Store);
  isLoggedIn = signal<boolean>(false);

  constructor() 
  {
    this._store.getItem('current_user').subscribe({
      next: (userId) => {
        if (userId) {
          this.isLoggedIn.set(true);
          console.log('Current user ID:', userId);
          this._backendService.getHomeRecomendations(Number(userId)).subscribe({
            next: (data) => {
              console.log('Home recommendations:', data);
            },
            error: (error) => {
              console.error('Error fetching home recommendations:', error);
            }
          });
        } else {
          this.isLoggedIn.set(false);
          console.warn('No current user found');
        }
      },
      error: (error) => {
        console.error('Error fetching current user:', error);
        this.isLoggedIn.set(false);
      }
    });
  }
}
