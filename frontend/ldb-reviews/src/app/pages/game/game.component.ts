import { ChangeDetectorRef, Component, inject, signal } from '@angular/core';
import { ReviewCard } from "./components/review-card/review-card.component";
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-game',
  imports: [ReviewCard],
  standalone: true,
  templateUrl: './game.html',
  styleUrl: './game.scss'
})
export class Game {
  private _route = inject(ActivatedRoute);
  private _changeDetectionRef = inject(ChangeDetectorRef)
  ;
  gameId = signal<string>('');
  gameInfo = signal({
    nome: 'Elden Ring',
    descricao: 'Um jogo de ação e RPG desenvolvido pela FromSoftware, conhecido por seu mundo aberto e jogabilidade desafiadora.',
    genero: 'Ação/RPG',
    desenvolvedora: 'FromSoftware',
    publicadora: 'Bandai Namco Entertainment',
    dataLancamento: '25 de fevereiro de 2022',
    plataformas: ['PlayStation 4', 'PlayStation 5', 'Xbox One', 'Xbox Series X/S', 'PC'],
    imagem: 'https://pt.wikipedia.org/wiki/Ficheiro:Elden_Ring_capa.jpg',
    notaTecnica: 9.5,
    notaSubjetiva: 10,
    tags: ['Aventura', 'Mundo Aberto', 'Fantasia', 'Desafio'],
    classificacaoEtaria: 'M18',
    reviews: [
      {
        titulo: 'Uma obra-prima',
        conteudo: 'Elden Ring é um jogo incrível que redefine o gênero de ação/RPG. A história é envolvente e o mundo é vasto e cheio de segredos.',
        autor: 'Jogador123',
        data: '2022-03-01',
        notaTecnica: 9.5,
        notaSubjetiva: 10
      },
      {
        titulo: 'Desafiador e recompensador',
        conteudo: 'A jogabilidade é desafiadora, mas extremamente gratificante. Cada vitória se sente como uma conquista.',
        autor: 'Gamer456',
        data: '2022-03-05',
        notaTecnica: 9.5,
        notaSubjetiva: 10
      }
    ]
  });

  constructor()
  {
    this._route.params.subscribe(params => {
      const reviewId = params['reviewId'];
      this.gameId.set(`Detalhes da review com ID: ${reviewId}`);
    });
  }

  ngOnInit() {
    this._changeDetectionRef.detectChanges();
  }

}
