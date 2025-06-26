import { Component, input, signal } from '@angular/core';

@Component({
  selector: 'app-search',
  imports: [],
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
