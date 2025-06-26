import { Component, inject, signal } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-user',
  imports: [],
  standalone: true,
  templateUrl: './user.html',
  styleUrl: './user.scss'
})
export class User {
  private _route = inject(ActivatedRoute);
  
  userId = signal<string>('');

  userInfo = signal({
    name: 'Nome do Usuário',
    email: 'sldfjçls@klsjfçlsf',
    joinedDate: '2023-10-01',
    reviewsCount: 5,
    reviews: [
      {
        title: 'Título da Review 1',
        content: 'Conteúdo da review 1.',
        date: '2023-10-01',
        rating: 8.5
      }
    ],
    comments: [
      {
        reviewTitle: 'Título da Review 1',
        content: 'Comentário interessante sobre a review 1.',
        date: '2023-10-01'
      }
    ]
  });
  
  constructor()
  {
    this._route.params.subscribe(params => {
      const userId = params['userId'];
      console.log(`User ID: ${userId}`);
      this.userId.set(userId);
    });
  }
}
