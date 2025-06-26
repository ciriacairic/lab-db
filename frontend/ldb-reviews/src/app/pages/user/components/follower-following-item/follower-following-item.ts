import { Component, inject, input } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-follower-following-item',
  imports: [],
  templateUrl: './follower-following-item.html',
  styleUrl: './follower-following-item.scss'
})
export class FollowerFollowingItem {
  private _router = inject(Router);
  userInfo = input({id: ''});

  goToUserProfile()
  {
    this._router.navigate(['/user', this.userInfo().id]);
  }
}
