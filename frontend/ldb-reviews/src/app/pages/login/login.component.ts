import { ChangeDetectorRef, Component, inject, signal } from '@angular/core';
import { Backend } from '../../services/backend';
import { PostLoginPayload } from '../../interfaces/requests/postLoginPayload';
import { Router } from '@angular/router';
import { Store } from '../../services/store';

@Component({
  selector: 'app-login',
  imports: [],
  standalone: true,
  templateUrl: './login.html',
  styleUrl: './login.scss'
})
export class Login {
  private _backendService = inject(Backend);
  private _router = inject(Router);
  private _store = inject(Store);
  private _changeDetectorRef = inject(ChangeDetectorRef);

  username = signal<string>('');
  password = signal<string>('');

  onFieldInput(field: string, event: any)
  {
    switch (field) 
    {
      case 'username':
        this.username.set(event.target.value);
        break;
      case 'password':
        this.password.set(event.target.value);
        break;
      default:
        console.warn(`Unknown field: ${field}`);
        break;
    }
  }

  onLoginClick()
  {
    let payload = {
      email: this.username(),
      password: this.password()
    } as PostLoginPayload;

    this._backendService.postLogin(payload).subscribe({
      next: (data) => {
        console.log('Login successful:', data);
        this._store.guardarItem('current_user', data.user_id);
        this._changeDetectorRef.detectChanges();
        this._router.navigate(['/']);
      },
      error: (error) => {
        console.error('Login failed:', error);
      }
    });
  }

  onRegisterClick()
  {
    this._router.navigate(['/register-user']);
  }
}
