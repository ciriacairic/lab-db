import { Component, signal } from '@angular/core';

@Component({
  selector: 'app-login',
  imports: [],
  standalone: true,
  templateUrl: './login.html',
  styleUrl: './login.scss'
})
export class Login {

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
      username: this.username(),
      password: this.password()
    }
  }
}
