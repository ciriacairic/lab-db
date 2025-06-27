import { Component, inject, signal } from '@angular/core';
import { Store } from '../../services/store';
import { Backend } from '../../services/backend';
import { ActivatedRoute, Router } from '@angular/router';
import { PostReviewPayload } from '../../interfaces/requests/postReviewPayload';
import { Scores } from '../../interfaces/requests/scores';
@Component({
  selector: 'app-review-write',
  imports: [],
  standalone: true,
  templateUrl: './review-write.html',
  styleUrl: './review-write.scss'
})
export class ReviewWrite {
  private _backendService = inject(Backend);
  private _route = inject(ActivatedRoute);
  private _router = inject(Router)
  private _store = inject(Store);
  reviewPayload = signal<PostReviewPayload>({} as PostReviewPayload);

  constructor()
  {
    this._store.getItem('current_user').subscribe({
      next: (userId) => {
        if (!userId)
          this._router.navigate(['/login']);
        else
          this.reviewPayload.set({...this.reviewPayload(), ['user_id']: Number(userId)});
      },
      error: (error) => {
        console.error('Error fetching current user:', error);
        this._router.navigate(['/login']);
      }
    });

    this._route.params.subscribe(params => {
      console.log('Route parameters:', params);
      const gameId = Number(params['gameId']);
      if (gameId)
        this.reviewPayload.set({...this.reviewPayload(), ['game_id']: Number(gameId)});
      else
      {
        console.error('Invalid game ID in route parameters');
        this._router.navigate(['/']);
      }
    });
  }

  onFieldInput(field: string, event: any)
  {
    this.reviewPayload.set(
      { ...this.reviewPayload(), [field]: event.target.value }
    );
  }

  onRatingInput(field: string, event: any)
  {
    let currentScores = this.reviewPayload().scores || {};
    currentScores ={ ...currentScores, [field]: Number(event.target.value)};
    this.reviewPayload.set(
      { ...this.reviewPayload(), scores: currentScores }
    );
  }

  onReviewWriteClick()
  {
    console.log('Review payload before submission:', this.reviewPayload());
    this._backendService.postReview(this.reviewPayload()).subscribe({
      next: (data) => {
        console.log('Review posted successfully:', data);
        this._router.navigate(['/review', data.review_id]);
      },
      error: (error) => {
        console.error('Error posting review:', error);
      }
    });
  }
}
