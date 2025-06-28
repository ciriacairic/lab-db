import { Component, inject, signal } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Backend } from '../../services/backend';
import { MarkdownComponent } from 'ngx-markdown';
import { GetReview } from '../../interfaces/responses/getReview';
import { Spinner } from "../../components/spinner/spinner";
import { CommentCard } from "./components/comment-card/comment-card";
import { Store } from '../../services/store';
import { GetComments } from '../../interfaces/responses/getComments';
import { PostCommentPayload } from '../../interfaces/requests/postCommentPayload';

@Component({
  selector: 'app-review-read',
  imports: [MarkdownComponent, Spinner, CommentCard],
  standalone: true,
  templateUrl: './review-read.html',
  styleUrl: './review-read.scss'
})
export class ReviewRead {
  private _route = inject(ActivatedRoute);
  private _backendService = inject(Backend);
  private _store = inject(Store);

  reviewId = signal<string>('');
  reviewInfo = signal<GetReview>({} as GetReview);
  userId = signal<number>(0);
  loading = signal<boolean>(true);
  loadingComments = signal<boolean>(true);
  isLoggedIn = signal<boolean>(false);
  reviewComments = signal<GetComments[]>([]);
  showNoCommentsMessage = signal<boolean>(false);
  showWriteCommentModal = signal<boolean>(false);
  commentText = signal<PostCommentPayload>({} as PostCommentPayload);

  constructor()
  {
    this._route.params.subscribe(params => {
      const reviewId = params['reviewId'];
      this.reviewId.set(reviewId);
    });

    this._store.getItem('current_user').subscribe({
      next: (user) => {
        if (user && user !== '') {
          console.log('Current user:', user);
          this.userId.set(Number(user));
          this.isLoggedIn.set(true);
        }
        else {
          console.warn('No current user found in store');
        }
      },
      error: (error) => {
        console.error('Error fetching current user from store:', error);
      }
    });
  }
  
  ngOnInit()
  {
    this._backendService.getReview(this.reviewId()).subscribe({
      next: (data) => {
        console.log('Review data:', data);
        this.loading.set(false);
        this.reviewInfo.set(data);
      }
      , error: (error) => {
        this.loading.set(false);
        console.error('Error fetching review:', error);
      }
    })

    this._backendService.getComments(this.reviewId(), 'review').subscribe({
      next: (data) => {
        console.log('Comments data:', data);
        this.loadingComments.set(false);
        if (data.length === 0) {
          this.showNoCommentsMessage.set(true);
        }
        else
        {
          this.reviewComments.set(data.comments);
          this.showNoCommentsMessage.set(false);
        }
      },
      error: (error) => {
        this.loadingComments.set(false);
        console.error('Error fetching comments:', error);
      }
    });
  }

  openWriteCommentModal()
  { 
    this.showWriteCommentModal.set(true);
  }

  onWriteCommentClick()
  {
    this.commentText.set({ ...this.commentText(),
      user_id: this.userId(),
      parent_id: this.reviewId(),
      parent_type: 'review',
    });
    this.showWriteCommentModal.set(false);
    this._backendService.postComment(this.commentText()).subscribe({
      next: (response) => {
        console.log('Comment posted successfully:', response);
        this.reviewComments.update(comments => [...comments, response]);
        this.commentText.set({} as PostCommentPayload);
      },
      error: (error) => {
        console.error('Error posting comment:', error);
        alert('Failed to post comment. Please try again.');
      }
    });
  }

  onFieldInput(field: string, event: any)
  {
    this.commentText.set(
      { ...this.commentText(), [field]: event.target.value }
    );
  }
}
