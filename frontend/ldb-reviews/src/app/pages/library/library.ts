import { Component, inject, signal } from '@angular/core';
import { Backend } from '../../services/backend';
import { ActivatedRoute } from '@angular/router';
import { Spinner } from "../../components/spinner/spinner";
import { GameCard } from "../search/components/game-card/game-card.component";
@Component({
  selector: 'app-library',
  imports: [Spinner, GameCard],
  templateUrl: './library.html',
  styleUrl: './library.scss'
})
export class Library {
  private _backendService = inject(Backend)
  private _route = inject(ActivatedRoute);
  libraryId = signal<number>(0);
  library = signal<any[]>([]);
  loading = signal<boolean>(true);
  showNoResultsMessage = signal<boolean>(false);

  constructor()
  {
    this._route.params.subscribe(params => {
      const libraryId = params['libraryId'];
      if (libraryId) 
      {
        this.libraryId.set(Number(libraryId));
        console.log('User ID set to:', this.libraryId());
      } else
        console.warn('No user ID provided in route parameters');
    });
  }

  ngOnInit()
  {
    this._backendService.getLibrary(this.libraryId()).subscribe({
      next: (data) => {
        console.log('Library results:', data);
        if(data.length === 0)
          this.showNoResultsMessage.set(true);
        else
          this.library.set(data);
        this.loading.set(false);
      },
      error: (error) => {
        console.error('Error fetching search results:', error);
      }
    });
  }
}
