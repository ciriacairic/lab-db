import { Component, inject, signal } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Spinner } from "../../components/spinner/spinner";
import { Backend } from '../../services/backend';
import { LibraryCard } from "./components/library-card/library-card";
import { Store } from '../../services/store';

@Component({
  selector: 'app-libraries',
  imports: [Spinner, LibraryCard],
  templateUrl: './libraries.html',
  styleUrl: './libraries.scss'
})
export class Libraries {
  private _backendService = inject(Backend)
  private _route = inject(ActivatedRoute);
  private _router = inject(Router);
  private _store = inject(Store);

  userId = signal<number>(0);
  libraries = signal<any[]>([]);
  loading = signal<boolean>(true);
  isLoggedIn = signal<boolean>(false);
  showNoResultsMessage = signal<boolean>(false);

  constructor()
  {
    this._route.params.subscribe(params => {
      const userId = params['userId'];
      if (userId) 
      {
        this.userId.set(Number(userId));
        console.log('User ID set to:', this.userId());
      }
      else
      {
        console.warn('No user ID provided in route parameters');
        this._router.navigate(['/login']);
      }
    });

    this._store.getItem('current_user').subscribe({
      next: (user) => {
        if (user && user !== '') {
          this.isLoggedIn.set(true);
          console.log('Current user:', user);
        }
        else {
          this.isLoggedIn.set(false);
          console.warn('No current user found in store');
        }
      },
      error: (error) => {
        console.error('Error fetching current user from store:', error);
        this.isLoggedIn.set(false);
        this._router.navigate(['/login']);
      }
    }); 
  }

  ngOnInit()
  {
    this._backendService.getUserLibraries(this.userId()).subscribe({
      next: (data) => {
        console.log('Libraries results:', data);
        if(data.length === 0)
          this.showNoResultsMessage.set(true);
        else
          this.libraries.set(data);
        this.loading.set(false);
      },
      error: (error) => {
        console.error('Error fetching search results:', error);
      }
    });
  }

  onCreateLibraryClick()
  {
    if (this.isLoggedIn())
    {
      console.log('User is logged in, redirecting to create library page');
      this._router.navigate(['/libraries/create']);
    }
    else
    {
      console.warn('User is not logged in, redirecting to login page');
      this._router.navigate(['/login']);
    }
  }
}
