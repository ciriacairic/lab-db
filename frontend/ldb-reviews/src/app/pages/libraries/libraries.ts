import { Component, inject, signal } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-libraries',
  imports: [],
  templateUrl: './libraries.html',
  styleUrl: './libraries.scss'
})
export class Libraries {
  private _route = inject(ActivatedRoute);
  libraries = signal([{name: '', id: ''}]);
  userId = signal<string>('');

  onLibraryClick() {
    
  }
  constructor()
  {
    this._route.params.subscribe(params => {
      const userId = params['userId'];
      console.log(`User ID: ${userId}`);
      this.userId.set(userId);
    });
  }

  ngOnInit()
  {

  }
}
