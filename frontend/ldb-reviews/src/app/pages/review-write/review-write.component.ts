import { Component } from '@angular/core';

@Component({
  selector: 'app-review-write',
  imports: [],
  standalone: true,
  templateUrl: './review-write.html',
  styleUrl: './review-write.scss'
})
export class ReviewWrite {

  onFieldInput(field: string, event: any)
  {
    switch (field) {
      case 'title':
        break;
      case 'content':
        break;
      default:
        console.warn(`Unknown field: ${field}`);
        break;
    }
  }

  onReviewWriteClick()
  {
    let payload = {
      title: '',
      content: '' 
    };
  }
}
