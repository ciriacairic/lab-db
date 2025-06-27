import { Component, inject, signal } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Comments } from "./components/comments/comments.component";
import { Backend } from '../../services/backend';
import { MarkdownComponent } from 'ngx-markdown';

@Component({
  selector: 'app-review-read',
  imports: [Comments, MarkdownComponent],
  standalone: true,
  templateUrl: './review-read.html',
  styleUrl: './review-read.scss'
})
export class ReviewRead {
  private _route = inject(ActivatedRoute);
  private _backendService = inject(Backend);

  reviewId = signal<string>('');
  reviewInfo = signal({
    title: 'Título da Review',
    content: 'Conteúdo da review detalhada.',
    autor: 'Autor da Review',
    data: '2023-10-01',
    notaTecnica: 9.0,
    notaSubjetiva: 8.5,
    comentarios: [
      {
        autor: 'Usuario1',
        data: '2023-10-01',
        conteudo: 'Comentário interessante sobre a review.'
      },
      {
        autor: 'Usuario1',
        data: '2023-10-01',
        conteudo: 'Comentário interessante sobre a review.'
      }
    ]
  });

  constructor()
  {
    this._route.params.subscribe(params => {
      const reviewId = params['reviewId'];
      this.reviewId.set(`Detalhes da review com ID: ${reviewId}`);
    });
  }
  
  ngOnInit()
  {
    
  }
}
