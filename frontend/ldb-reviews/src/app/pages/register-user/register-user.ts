import { Component, inject, signal } from '@angular/core';
import { PostUserRegisterPayload } from '../../interfaces/requests/postUserRegisterPayload';
import { Backend } from '../../services/backend';
import { Store } from '../../services/store';
import { Router } from '@angular/router';
@Component({
  selector: 'app-register-user',
  imports: [],
  templateUrl: './register-user.html',
  styleUrl: './register-user.scss'
})
export class RegisterUser {
  private _backendService = inject(Backend);
  private _router = inject(Router);
  private _store = inject(Store);

  userRegisterPayload = signal<PostUserRegisterPayload>({} as PostUserRegisterPayload);

  onFieldInput(field: string, event: any)
  {
    this.userRegisterPayload.set(
      { ...this.userRegisterPayload(), [field]: event.target.value }
    );
  }

  onRegisterClick()
  {
    this._backendService.postUser(this.userRegisterPayload()).subscribe({
      next: (data) => {
        console.log('User registered successfully:', data);
        this._store.guardarItem('current_user', data.user_id);
        this._router.navigate(['/']);
      }
      , error: (error) => {
        console.error('User registration failed:', error);
      }
    });
  }
}
