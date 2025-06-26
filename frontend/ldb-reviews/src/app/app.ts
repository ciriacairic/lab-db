import { Component, inject, signal } from '@angular/core';
import { Router, RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet],
  templateUrl: './app.html',
  styleUrl: './app.scss'
})
export class App {
  private _router = inject(Router)
  protected title = 'ldb-reviews';
  searchInput = signal<string>('');
  isLoggedIn = signal<boolean>(false);

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
    this._router.navigate(['/login']);
  }

  onSearchClick()
  {
    const searchValue = this.searchInput();
    if (searchValue.trim() !== '')
      this._router.navigate(['/search'], { queryParams: { q: searchValue } });
    else
      console.warn('Search input is empty');
  }
}
