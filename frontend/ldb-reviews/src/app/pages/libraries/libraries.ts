import { Component, inject, signal } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Spinner } from "../../components/spinner/spinner";
import { GameCard } from "../search/components/game-card/game-card.component";
import { Backend } from '../../services/backend';
import { LibraryCard } from "./components/library-card/library-card";

@Component({
  selector: 'app-libraries',
  imports: [Spinner, LibraryCard],
  templateUrl: './libraries.html',
  styleUrl: './libraries.scss'
})
export class Libraries {
  private _backendService = inject(Backend)
  private _route = inject(ActivatedRoute);
  userId = signal<number>(0);
  libraries = signal<any[]>([]);
  loading = signal<boolean>(true);
  showNoResultsMessage = signal<boolean>(false);

  constructor()
  {
    this._route.params.subscribe(params => {
      const userId = params['userId'];
      if (userId) 
      {
        this.userId.set(Number(userId));
        console.log('User ID set to:', this.userId());
      } else
        console.warn('No user ID provided in route parameters');
    });
  }

  ngOnInit()
  {
    this._backendService.getUserLibraries(this.userId()).subscribe({
      next: (data) => {
        console.log('Libraries results:', data);
        if(data.length === 0)
          this.showNoResultsMessage.set(true);
        else
          this.libraries.set(data);
        this.loading.set(false);
      },
      error: (error) => {
        console.error('Error fetching search results:', error);
      }
    });
  }
}
