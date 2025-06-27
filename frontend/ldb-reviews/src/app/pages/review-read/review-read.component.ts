import { Component, inject, signal } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Comments } from "./components/comments/comments.component";
import { Backend } from '../../services/backend';
import { MarkdownComponent } from 'ngx-markdown';
import { GetReview } from '../../interfaces/responses/getReview';

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
  reviewInfo = signal<GetReview>({} as GetReview);

  constructor()
  {
    this._route.params.subscribe(params => {
      const reviewId = params['reviewId'];
      this.reviewId.set(`Detalhes da review com ID: ${reviewId}`);
    });
  }
  
  ngOnInit()
  {
    this._backendService.getReview(this.reviewId()).subscribe({
      next: (data) => {
        console.log('Review data:', data);
        this.reviewInfo.set(data);
      }
      , error: (error) => {
        console.error('Error fetching review:', error);
      }
  })
  }
}
