import { Component, inject, signal } from '@angular/core';
import { Router, RouterOutlet } from '@angular/router';
import { Store } from './services/store';
import { Backend } from './services/backend';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet],
  templateUrl: './app.html',
  styleUrl: './app.scss'
})
export class App {
  private _router = inject(Router)
  private _store = inject(Store);
  private _backend = inject(Backend)

  protected title = 'ldb-reviews';
  searchInput = signal<string>('');
  isLoggedIn = signal<boolean>(false);
  userAvatar = signal<string>('');
  userId = signal<number>(0);
  username = signal<string>('');

  constructor() {
    this._store.getItem('current_user').subscribe({
      next: (userId) => {
        if (userId) {
          this.isLoggedIn.set(true);
          this.userId.set(Number(userId));
          this._backend.getUser(Number(userId)).subscribe({
            next: (user) => {
              this._store.guardarItem('current_user_info', user);
              this.username.set(user.name || '');
              this.userAvatar.set(user.avatar || '');
            },
            error: (error) => {
              this.isLoggedIn.set(false);
              this.userAvatar.set('');
            }
          });
        } else {
          this.isLoggedIn.set(false);
          this.userAvatar.set('');
          this.username.set('');
          this.userId.set(0);
        }
      },
      error: () => {
        this.isLoggedIn.set(false);
        this.userAvatar.set('');
        this.username.set('');
        this.userId.set(0);
      }
    });
  }

  onSearchInput(event: Event)
  {
    const inputElement = event.target as HTMLInputElement;
    if (inputElement)
      this.searchInput.set(inputElement.value);
    else
      console.warn('Search input event target is not an HTMLInputElement');
  }

  onHomeClick()
  {
    this._router.navigate(['/']);
  }

  onLoginClick()
  {
    if(this.isLoggedIn())
      this._router.navigate(['/user', this.userId()]);
    else
      this._router.navigate(['/login']);
  }

  onSearchClick()
  {
    const searchValue = this.searchInput();
    if (searchValue.trim() !== '') {
      const currentUrl = this._router.url.split('?')[0];
      const targetUrl = '/search';
      const queryParams = { q: searchValue };

      if (currentUrl === targetUrl)
        this._router.navigateByUrl('/', { skipLocationChange: true }).then(() => {
          this._router.navigate([targetUrl], { queryParams });
        });
      else
        this._router.navigate([targetUrl], { queryParams });
    } else {
      console.warn('Search input is empty');
    }
  }
}
