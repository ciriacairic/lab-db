import { Component, inject, input } from '@angular/core';
import { Router } from '@angular/router';
@Component({
  selector: 'app-library-card',
  imports: [],
  templateUrl: './library-card.html',
  styleUrl: './library-card.scss'
})
export class LibraryCard {
  private _router = inject(Router);
  library = input<{ 
    id: number,
    name: string,
    description: string}
  >()

  onLibraryCardClick()
  {
    this._router.navigate(['/library', this.library()?.id]);
  }
}
