import { Component, input } from '@angular/core';

@Component({
  selector: 'app-comments',
  imports: [],
  standalone: true,
  templateUrl: './comments.html',
  styleUrl: './comments.scss'
})
export class Comments {
  comment = input(        {autor: 'Usuario1',
        data: '2023-10-01',
        conteudo: 'Comentário interessante sobre a review.'});
}
