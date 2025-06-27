import { Component, inject, input } from '@angular/core';
import { GetReview } from '../../../../interfaces/responses/getReview';
import { Router } from '@angular/router';

@Component({
  selector: 'app-review-card',
  imports: [],
  standalone: true,
  templateUrl: './review-card.html',
  styleUrl: './review-card.scss'
})
export class ReviewCard {
  private _router = inject(Router);

  review = input<GetReview>();
  onReviewClick()
  {
    this._router.navigate(['/review', this.review()?.id]);
  }
}
