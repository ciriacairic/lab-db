import { Component, input, signal } from '@angular/core';
import { GameCard } from "./components/game-card/game-card.component";

@Component({
  selector: 'app-search',
  imports: [GameCard],
  standalone: true,
  templateUrl: './search.html',
  styleUrl: './search.scss'
})
export class Search {

  searchQuery = input<string>('');
  searchResults = signal<any[]>([]);
  ngOnInit()
  {
    
  }
}
