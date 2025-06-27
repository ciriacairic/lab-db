import { ChangeDetectorRef, Component, inject, signal } from '@angular/core';
import { ReviewCard } from "./components/review-card/review-card.component";
import { ActivatedRoute, Router } from '@angular/router';
import { Backend } from '../../services/backend';
import { GetGameResponse } from '../../interfaces/responses/getGameResponse';
import { Store } from '../../services/store';
import { Spinner } from "../../components/spinner/spinner";
import { GetReview } from '../../interfaces/responses/getReview';

@Component({
  selector: 'app-game',
  imports: [ReviewCard, Spinner],
  standalone: true,
  templateUrl: './game.html',
  styleUrl: './game.scss'
})
export class Game {
  private _route = inject(ActivatedRoute);
  private _router = inject(Router);
  private _backendService = inject(Backend);
  private _store = inject(Store);
  private _changeDetectionRef = inject(ChangeDetectorRef);

  gameId = signal<number>(0);
  gameInfo = signal<GetGameResponse>({} as GetGameResponse);
  gameReviews = signal([] as GetReview[]);
  userId = signal<number>(0);
  libraries = signal<any[]>([]);
  isLoggedIn = signal<boolean>(false);
  showNoReviewsMessage = signal<boolean>(false);
  showNoResultsLibraryMessage = signal<boolean>(false);
  loadingImage = signal<boolean>(true);
  loadingReviews = signal<boolean>(true);
  loadingGameInfo = signal<boolean>(true);
  loadingLibraries = signal<boolean>(true);
  showSelectLibraryModal = signal<boolean>(false);

  constructor()
  {
    this._route.params.subscribe(params => {
      console.log('Route parameters:', params);
      const gameId = Number(params['gameId']);
      this.gameId.set(gameId);
    });
    this._store.getItem('current_user').subscribe({
      next: (userId) => {
        if (userId) {
          this.isLoggedIn.set(true);
          this.userId.set(Number(userId));
          console.log('Current user ID:', userId);
        } else {
          this.isLoggedIn.set(false);
          console.warn('No current user found');
        }
      },
      error: (error) => {
        console.error('Error fetching current user:', error);
        this.isLoggedIn.set(false);
      }
    });
  }

  ngOnInit() 
  {
    this._backendService.getGame(this.gameId()).subscribe({
      next: (data) => {
        console.log('Game info:', data);
        this.gameInfo.set(data);
        this.loadingGameInfo.set(false);
        this.loadingImage.set(false);
      },
      error: (error) => {
        console.error('Error fetching game info:', error);
      }
    });

    this._backendService.getGameReviews(this.gameId()).subscribe({
      next: (data) => {
        console.log('Game reviews:', data);
        this.gameReviews.set(data);
        this.loadingReviews.set(false);
      },
      error: (error) => {
        this.showNoReviewsMessage.set(true);
        this.loadingReviews.set(false);
        console.error('Error fetching game reviews:', error);
      }
    });
    this._changeDetectionRef.detectChanges();
  }

  onWriteReviewClick()
  {
    this._router.navigate(['/review-write', this.gameId()]);
  }

  openSelectLibrary()
  {
    if (this.isLoggedIn())
      this.showSelectLibraryModal.set(true);

    if(this.libraries().length === 0)
    {
      this._backendService.getUserLibraries(this.userId()).subscribe({
        next: (data) => {
          console.log('User libraries:', data);
          if(data.length === 0)
            this.showNoResultsLibraryMessage.set(true);
          else
            this.libraries.set(data);
          this.loadingLibraries.set(false);
        },
        error: (error) => {
          console.error('Error fetching user libraries:', error);
          this.loadingLibraries.set(false);
        }
      });
    }
  }

  closeSelectLibrary()
  {
    this.showSelectLibraryModal.set(false);
  }

  onAddLibraryClick(libraryId: number)
  {
    if (this.isLoggedIn())
    {
      this._backendService.postAddGameLibrary(libraryId, this.gameId()).subscribe({
        next: (data) => {
          console.log('Game added to library:', data);
          this._router.navigate(['/library', libraryId]);
        },
        error: (error) => {
          console.error('Error adding game to library:', error);
        }
      });
    }
  }
}
