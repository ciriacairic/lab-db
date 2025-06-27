import { Component, input } from '@angular/core';
import { GetComments } from '../../../../interfaces/responses/getComments';

@Component({
  selector: 'app-comment-card',
  imports: [],
  templateUrl: './comment-card.html',
  styleUrl: './comment-card.scss'
})
export class CommentCard {
  comment = input<GetComments>();
}
