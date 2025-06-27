import { Component, inject, input } from '@angular/core';
import { Router } from '@angular/router';
@Component({
  selector: 'app-game-card',
  imports: [],
  standalone: true,
  templateUrl: './game-card.html',
  styleUrl: './game-card.scss'
})
export class GameCard {
  private _router = inject(Router);
  game = input<{ 
    id: number,
    name: string, 
    capsule_image: string}
  >()

  onGameCardClick()
  {
    this._router.navigate(['/game', this.game()?.id]);
  }
}
