import { Component, inject, input, signal } from '@angular/core';
import { GameCard } from "./components/game-card/game-card.component";
import { Backend } from '../../services/backend';
import { ActivatedRoute } from '@angular/router';
import { Spinner } from "../../components/spinner/spinner";

@Component({
  selector: 'app-search',
  imports: [GameCard, Spinner],
  standalone: true,
  templateUrl: './search.html',
  styleUrl: './search.scss'
})
export class Search {
  private _backendService = inject(Backend)
  private _route = inject(ActivatedRoute);
  searchQuery = signal<string>('');
  searchResults = signal<any[]>([]);
  loading = signal<boolean>(true);
  showNoResultsMessage = signal<boolean>(false);

  constructor()
  {
    this._route.queryParams.subscribe(params => {
      const query = params['q'];
      if (query) 
      {
        this.searchQuery.set(query);
        console.log('Search query set to:', this.searchQuery());
      } else
        console.warn('No search query provided in route parameters');
    });
  }

  ngOnInit()
  {
    console.log('Search component initialized with query:', this.searchQuery());
    this._backendService.getGameSearch(this.searchQuery()).subscribe({
      next: (data) => {
        console.log('Search results:', data);
        if(data.length === 0)
          this.showNoResultsMessage.set(true);
        else
          this.searchResults.set(data);
        this.loading.set(false);
      },
      error: (error) => {
        console.error('Error fetching search results:', error);
      }
    });
  }
}
