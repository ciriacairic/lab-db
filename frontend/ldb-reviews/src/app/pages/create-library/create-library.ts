import { Component, inject, signal } from '@angular/core';
import { Store } from '../../services/store';
import { Router } from '@angular/router';
import { Backend } from '../../services/backend';
import { PostCreateLibraryPayload } from '../../interfaces/requests/postCreateLibraryPayload';

@Component({
  selector: 'app-create-library',
  imports: [],
  templateUrl: './create-library.html',
  styleUrl: './create-library.scss'
})
export class CreateLibrary {
  private _store = inject(Store);
  private _router = inject(Router);
  private _backendService = inject(Backend);

  userId = signal<number>(0);
  createLibraryPayload = signal<PostCreateLibraryPayload>({
    name: '',
    owner_id: -1,
    description: ''
  });

  constructor()
  {
    this._store.getItem('current_user').subscribe({
      next: (userId) => {
        if (userId)
        {
          this.userId.set(Number(userId));
          this.createLibraryPayload.set({
            ...this.createLibraryPayload(),
            owner_id: Number(userId)
          });
        }
        else
        {
          console.error('No current user found in store');
          this._router.navigate(['/login']);
        }
      },
      error: (error) => {
        console.error('Error fetching current user:', error);
        this._router.navigate(['/login']);
      }
    });
  }

  onFieldInput(field: string, event: any)
  {
    this.createLibraryPayload.set(
      { ...this.createLibraryPayload(), [field]: event.target.value }
    );
  }

  onCreateLibraryClick()
  {
    this._backendService.postLibrary(this.createLibraryPayload()).subscribe({
      next: (response) => {
        console.log('Library created successfully:', response);
        this._router.navigate(['/libraries', this.userId()]);
      },
      error: (error) => {
        console.error('Error creating library:', error);
        alert('Failed to create library. Please try again.');
      }
    });
  }
      
}
