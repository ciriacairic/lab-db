import { Component, input } from '@angular/core';

@Component({
  selector: 'app-review-card',
  imports: [],
  standalone: true,
  templateUrl: './review-card.html',
  styleUrl: './review-card.scss'
})
export class ReviewCard {
  review = input(        {titulo: 'Uma obra-prima',
        conteudo: 'Elden Ring é um jogo incrível que redefine o gênero de ação/RPG. A história é envolvente e o mundo é vasto e cheio de segredos.',
        autor: 'Jogador123',
        data: '2022-03-01',
        notaTecnica: 9.5,
        notaSubjetiva: 10}
      );

  onReviewClick(){
    
  }
}
